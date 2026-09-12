<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index(Request $request)
    {
        return view('social.index', $this->indexData($request));
    }

    public function search(Request $request)
    {
        $q = $request->validate(['q' => 'required|string|min:3|max:50'])['q'];

        $results = User::where('id', '!=', $request->user()->id)
            ->where(fn ($query) => $query
                ->where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->orWhere('username', 'like', "%{$q}%"))
            ->limit(5)
            ->get(['id', 'name', 'username', 'email']);

        return view('social.index', array_merge(
            $this->indexData($request),
            ['results' => $results, 'searched' => $q],
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'friend_id' => 'required|exists:users,id',
            'type'      => 'required|in:' . implode(',', array_keys(Friendship::TYPES())),
        ]);

        $friendId = (int) $data['friend_id'];

        abort_if($friendId === $request->user()->id, 422, 'Gak bisa nambahin diri sendiri 😅');

        $exists = Friendship::where(fn ($q) => $q
                ->where('user_id', $request->user()->id)->where('friend_id', $friendId)
                ->orWhere(fn ($qq) => $qq->where('user_id', $friendId)->where('friend_id', $request->user()->id)))
            ->exists();

        if ($exists) {
            return back()->with('alreadyFriend', true);
        }

        Friendship::create([
            'user_id'   => $request->user()->id,
            'friend_id' => $friendId,
            'type'      => $data['type'],
        ]);

        return back()->with('requestSent', true);
    }

    public function accept(Request $request, Friendship $friendship)
    {
        abort_unless($friendship->friend_id === $request->user()->id, 403);
        abort_unless($friendship->status === 'pending', 422);

        $friendship->update(['status' => 'accepted']);

        return redirect()->route('chat.show', $friendship);
    }

    public function reject(Request $request, Friendship $friendship)
    {
        abort_unless($friendship->friend_id === $request->user()->id, 403);

        $friendship->delete();

        return redirect()->route('social.index');
    }

    private function indexData(Request $request): array
    {
        $friendships = Friendship::query()
            ->where(fn ($q) => $q->where('user_id', $request->user()->id)
                ->orWhere('friend_id', $request->user()->id))
            ->where('status', 'accepted')
            ->with(['requester', 'partner'])
            ->withLastMessageFor($request->user())
            ->latest()
            ->get();

        $pendings = Friendship::query()
            ->where('friend_id', $request->user()->id)
            ->where('status', 'pending')
            ->with('requester')
            ->get();

        return [
            'friendships' => $friendships,
            'pendings'    => $pendings,
            'types'       => Friendship::TYPES(),
        ];
    }
}