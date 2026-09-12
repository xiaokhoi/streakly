<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CommunityPost;
use App\Models\PostComment;
use App\Models\Report;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /** Feed global (Opsi A) — dengan sorting */
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'hot');

        $query = CommunityPost::with(['user.title', 'category'])
            ->withCount(['upvotes', 'downvotes', 'comments']);
        $query = $this->applySort($query, $sort);

        return view('community.index', [
            'posts' => $query->paginate(15)->withQueryString(),
            'sort'  => $sort,
        ]);
    }

    /** Feed per kategori — dengan sorting */
    public function show(Request $request, Category $category)
    {
        $sort = $request->query('sort', 'hot');

        $query = CommunityPost::where('category_id', $category->id)
            ->with(['user.title', 'category'])
            ->withCount(['upvotes', 'downvotes', 'comments']);
        $query = $this->applySort($query, $sort);

        return view('community.show', [
            'category' => $category,
            'posts'    => $query->paginate(15)->withQueryString(),
            'sort'     => $sort,
        ]);
    }

    /** Rumus sorting. Hot = skor ÷ umur (post baru ber-skor sama naik lebih tinggi) */
    private function applySort($query, string $sort)
    {
        return match ($sort) {
            'top' => $query->orderByDesc('upvotes_count')
                           ->orderByDesc('created_at'),
            'new' => $query->orderByDesc('created_at'),
            default => $query->orderByRaw(
                "(upvotes_count - downvotes_count + 1) / ((julianday('now') - julianday(community_posts.created_at)) + 2) desc"
            ),
        };
    }

    /** Detail post + komentar bersarang (tree dibangun di PHP) */
    public function detail(Request $request, CommunityPost $post)
    {
        $post->load(['user.title', 'category']);

        $all = $post->comments()->with('user.title')->orderBy('created_at')->get();

        $childrenByParent = $all->filter(fn ($c) => $c->parent_id !== null)->groupBy('parent_id');

        $roots = $all->whereNull('parent_id')->values();

        $attachChildren = function ($comment) use ($childrenByParent, &$attachChildren) {
            $comment->children = $childrenByParent->get($comment->id, collect())
                ->sortBy('created_at')
                ->values();
            $comment->children->each($attachChildren);
        };

        $roots->each($attachChildren);

        return view('community.detail', [
            'post'          => $post,
            'comments'      => $roots,
            'totalComments' => $all->count(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|min:5|max:120',
            'body'        => 'required|string|max:2000',
        ]);

        CommunityPost::create([
            'user_id'     => $request->user()->id,
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'body'        => $request->body,
        ]);

        return redirect()->route('community.index')->with('posted', true);
    }

    public function destroy(Request $request, CommunityPost $post)
    {
        abort_unless($post->user_id === $request->user()->id, 403);

        $post->delete();

        return back()->with('postDeleted', true);
    }

    public function vote(Request $request, CommunityPost $post)
    {
        $request->validate(['value' => 'required|in:1,-1']);

        $vote = $post->votes()->where('user_id', $request->user()->id)->first();

        if ($vote && (int) $vote->value === (int) $request->value) {
            $vote->delete();
        } elseif ($vote) {
            $vote->update(['value' => (int) $request->value]);
        } else {
            $post->votes()->create([
                'user_id' => $request->user()->id,
                'value'   => (int) $request->value,
            ]);
        }

        return back();
    }

    /** Komentar baru ATAU balasan — nesting unlimited, dibatasi depth 4 */
    public function comment(Request $request, CommunityPost $post)
    {
        $request->validate([
            'body'      => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:post_comments,id',
        ]);

        $parentId = null;

        if ($request->filled('parent_id')) {
            $parent = PostComment::where('post_id', $post->id)
                ->where('id', $request->parent_id)
                ->firstOrFail();

            // rantai dari root ke parent — buat hitung kedalaman
            $chain = collect([$parent]);
            $walker = $parent;
            while ($walker->parent_id !== null) {
                $walker = PostComment::find($walker->parent_id);
                $chain->prepend($walker);
            }

            // kalau balasan baru bakal lebih dalam dari level 4, nempel ke level 4
            $parentId = $chain->count() > 5 ? $chain[4]->id : $parent->id;
        }

        $post->comments()->create([
            'user_id'   => $request->user()->id,
            'parent_id' => $parentId,
            'body'      => $request->body,
        ]);

        return redirect()->route('community.detail', $post)->with('commented', true);
    }

    public function destroyComment(Request $request, PostComment $comment)
    {
        abort_unless($comment->user_id === $request->user()->id, 403);

        $comment->delete();

        return back()->with('commentDeleted', true);
    }

    public function fire(Request $request, PostComment $comment)
    {
        $reaction = $comment->reactions()->where('user_id', $request->user()->id)->first();

        if ($reaction) {
            $reaction->delete();
        } else {
            $comment->reactions()->create(['user_id' => $request->user()->id]);
        }

        return back();
    }

    public function report(Request $request)
    {
        $request->validate([
            'post_id'    => 'nullable|exists:community_posts,id',
            'comment_id' => 'nullable|exists:post_comments,id',
            'reason'     => 'required|string|max:200',
        ]);

        abort_if(!$request->post_id && !$request->comment_id, 422);

        Report::create([
            'user_id'    => $request->user()->id,
            'post_id'    => $request->post_id,
            'comment_id' => $request->comment_id,
            'reason'     => $request->reason,
        ]);

        return back()->with('reported', true);
    }
}