<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExploreController extends Controller
{
        public function show(Category $category)
    {
        $popular = Habit::select('name', DB::raw('COUNT(DISTINCT user_id) as users_count'))
            ->where('category_id', $category->id)
            ->groupBy('name')
            ->orderByDesc('users_count')
            ->limit(20)
            ->get();

        // nama-nama habit dalam kategori ini yang SUDAH dimiliki user yang sedang login
        $ownedNames = auth()->user()->habits()
            ->where('category_id', $category->id)
            ->pluck('name')
            ->toArray();

        return view('explore.show', [
            'category'   => $category,
            'popular'    => $popular,
            'ownedNames' => $ownedNames,
        ]);
    }

        public function adopt(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
        ]);

        // cegah dobel: user gak boleh punya habit dengan nama sama di kategori sama
        $alreadyOwned = $request->user()->habits()
            ->where('name', $request->name)
            ->where('category_id', $request->category_id)
            ->exists();

        if ($alreadyOwned) {
            return redirect()->route('dashboard')->with('alreadyOwned', $request->name);
        }

        $request->user()->habits()->create([
            'name'        => $request->name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard')->with('adopted', $request->name);
    }
}