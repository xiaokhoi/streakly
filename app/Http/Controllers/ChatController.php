<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use App\Services\ChatStreakService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function show(Request $request, Friendship $friendship)
    {
        abort_unless($this->involved($request, $friendship), 403);
        abort_unless($friendship->status === 'accepted', 422);

        // orderBy id = urutan selalu bener (id naik = waktu naik), gak bisa dobel
        $messages = $friendship->messages()
            ->orderBy('id')
            ->take(100)
            ->get();

        return view('social.chat', [
            'friendship' => $friendship,
            'partner'    => $this->partner($request, $friendship),
            'messages'   => $messages,
            'types'      => Friendship::TYPES(),
        ]);
    }

    public function store(Request $request, Friendship $friendship)
    {
        abort_unless($this->involved($request, $friendship), 403);
        abort_unless($friendship->status === 'accepted', 422);

        $data = $request->validate(['body' => 'required|string|max:1000']);

        $friendship->messages()->create([
            'sender_id' => $request->user()->id,
            'body'      => $data['body'],
            'sent_at'   => now(),
        ]);

        ChatStreakService::onMessage($friendship);

        return redirect()->route('chat.show', $friendship);
    }

    private function involved(Request $request, Friendship $friendship): bool
    {
        return in_array($request->user()->id, [$friendship->user_id, $friendship->friend_id]);
    }

    private function partner(Request $request, Friendship $friendship): User
    {
        return $friendship->user_id === $request->user()->id
            ? $friendship->partner
            : $friendship->requester;
    }
}