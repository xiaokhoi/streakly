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

        return view('graves.index', [
            'graves'   => $graves,
            'longest'  => $request->user()->longest_streak,
        ]);
    }
}