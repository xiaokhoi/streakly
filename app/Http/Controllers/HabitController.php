<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Services\StreakService;
use Illuminate\Http\Request;

class HabitController extends Controller
{
        public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
        ]);

        $request->user()->habits()->create([
            'name'        => $request->name,
            'category_id' => $request->category_id,
        ]);

        return back();
    }

    public function toggle(Habit $habit)
    {
        abort_unless($habit->user_id === auth()->id(), 403);

        $milestone = StreakService::checkIn(auth()->user(), null, $habit->id);

                return redirect()->route('dashboard')->with('milestone', $milestone);
    }

    public function destroy(Habit $habit)
    {
        abort_unless($habit->user_id === auth()->id(), 403);

        $habit->delete();

        return redirect()->route('dashboard')->with('deleted', $habit->name);
    }
}