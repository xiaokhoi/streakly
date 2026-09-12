<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $letters = $request->user()->letters()->orderByDesc('written_at')->get();

        // ada surat terbuka yang belum pernah dibaca? -> auto tandai
        $readyToOpen = $letters->first(fn ($l) => $l->isLocked()
            && $request->user()->current_streak >= $l->unlock_at_streak);

        if ($readyToOpen) {
            $readyToOpen->update(['opened_at' => now()]);
            return redirect()->route('letters.show', $readyToOpen)
                ->with('letterOpened', true);
        }

        return view('letters.index', ['letters' => $letters]);
    }

    public function show(Request $request, Letter $letter)
    {
        abort_unless($letter->user_id === $request->user()->id, 403);

        return view('letters.show', ['letter' => $letter]);
    }

    public function store(Request $request)
    {
        // cuma boleh nulis 1 surat aktif terkunci per orang
        $hasLocked = $request->user()->letters()->whereNull('opened_at')->exists();

        if ($hasLocked) {
            return back()->with('letterExists', true);
        }

        $request->validate(['body' => 'required|string|max:1000']);

        Letter::create([
            'user_id'           => $request->user()->id,
            'body'              => $request->body,
            'unlock_at_streak'  => 30,
            'written_at'        => now(),
        ]);

        return redirect()->route('letters.index')->with('letterWritten', true);
    }
}