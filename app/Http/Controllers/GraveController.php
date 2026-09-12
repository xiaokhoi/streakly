<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraveController extends Controller
{
    public function index(Request $request)
    {
        $graves = $request->user()->streakGraves()
            ->orderByDesc('length')
            ->get();

                return view('memories.index', [
            'graves'   => $graves,
            'longest'  => $request->user()->longest_streak,
        ]);
    }

    public function memories(Request $request)
    {
        $memories = $request->user()->checkIns()
            ->whereNotNull('note')
            ->where('note', '!=', '')
            ->orderByDesc('checked_at')
            ->get()
            ->groupBy(fn ($m) => $m->checked_at->translatedFormat('F Y'));

        return view('graves.memories', [
            'memories' => $memories,
            'total'    => $request->user()->checkIns()->whereNotNull('note')->count(),
        ]);
    }
}