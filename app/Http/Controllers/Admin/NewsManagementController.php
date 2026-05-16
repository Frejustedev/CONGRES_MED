<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class NewsManagementController extends Controller
{
    public function index(): Response
    {
        $articles = NewsArticle::with('author')
            ->latest()
            ->paginate(20)
            ->through(fn ($a) => [
                'id' => $a->id,
                'slug' => $a->slug,
                'title' => $a->title,
                'category' => $a->category,
                'is_published' => $a->is_published,
                'is_featured' => $a->is_featured,
                'is_pinned' => $a->is_pinned,
                'published_at' => $a->published_at?->toIso8601String(),
                'view_count' => $a->view_count,
                'author' => $a->author?->name ?? $a->author_display_name,
            ]);

        return Inertia::render('Admin/News/Index', ['articles' => $articles]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/News/Edit', ['article' => $this->emptyForm()]);
    }

    public function edit(int $id): Response
    {
        $article = NewsArticle::findOrFail($id);
        return Inertia::render('Admin/News/Edit', [
            'article' => array_merge($this->emptyForm(), [
                'id' => $article->id,
                'slug' => $article->slug,
                'title' => $article->title,
                'subtitle' => $article->subtitle,
                'excerpt' => $article->excerpt,
                'body' => $article->body,
                'category' => $article->category,
                'cover_image_path' => $article->cover_image_path,
                'cover_caption' => $article->cover_caption,
                'tags' => $article->tags ?? [],
                'author_display_name' => $article->author_display_name,
                'is_published' => $article->is_published,
                'is_featured' => $article->is_featured,
                'is_pinned' => $article->is_pinned,
                'allow_comments' => $article->allow_comments,
                'published_at' => $article->published_at?->format('Y-m-d\TH:i'),
                'locale' => $article->locale,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $data['slug'] ?? (Str::slug($data['title']).'-'.Str::lower(Str::random(4)));
        $data['author_user_id'] = $request->user()->id;

        $article = NewsArticle::create($data);
        $article->update(['reading_time' => $article->calculateReadingTime()]);

        return redirect()->route('admin.news.index')->with('success', 'Article créé.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $article = NewsArticle::findOrFail($id);
        $data = $this->validateData($request);

        $article->update($data);
        $article->update(['reading_time' => $article->calculateReadingTime()]);

        return back()->with('success', 'Article mis à jour.');
    }

    public function destroy(int $id): RedirectResponse
    {
        NewsArticle::findOrFail($id)->delete();
        return redirect()->route('admin.news.index')->with('success', 'Article supprimé.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:300'],
            'slug' => ['nullable', 'string', 'max:300'],
            'subtitle' => ['nullable', 'string', 'max:300'],
            'excerpt' => ['nullable', 'string', 'max:600'],
            'body' => ['required', 'string'],
            'category' => ['required', 'in:announcement,congress,scientific,press,social,sponsor'],
            'cover_image_path' => ['nullable', 'string'],
            'cover_caption' => ['nullable', 'string', 'max:300'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:64'],
            'author_display_name' => ['nullable', 'string', 'max:120'],
            'is_published' => ['boolean'],
            'is_featured' => ['boolean'],
            'is_pinned' => ['boolean'],
            'allow_comments' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'locale' => ['nullable', 'in:fr,en'],
        ]);
    }

    protected function emptyForm(): array
    {
        return [
            'id' => null,
            'slug' => '',
            'title' => '',
            'subtitle' => '',
            'excerpt' => '',
            'body' => '',
            'category' => 'announcement',
            'cover_image_path' => '',
            'cover_caption' => '',
            'tags' => [],
            'author_display_name' => '',
            'is_published' => false,
            'is_featured' => false,
            'is_pinned' => false,
            'allow_comments' => false,
            'published_at' => '',
            'locale' => 'fr',
        ];
    }
}
