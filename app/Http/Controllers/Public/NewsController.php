<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(Request $request): Response
    {
        $category = $request->query('category');

        $query = NewsArticle::published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at');

        $featured = (clone $query)->where('is_featured', true)->limit(3)->get();
        $articles = $query->where('is_featured', false)->paginate(9);

        return Inertia::render('Public/News/Index', [
            'featured' => $featured->map(fn ($a) => $this->serializeArticle($a, false)),
            'articles' => $articles->through(fn ($a) => $this->serializeArticle($a, false)),
            'categories' => $this->categoryList(),
            'currentCategory' => $category,
        ]);
    }

    public function show(string $slug): Response
    {
        $article = NewsArticle::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $article->incrementViewCount();

        $related = NewsArticle::published()
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return Inertia::render('Public/News/Show', [
            'article' => $this->serializeArticle($article, true),
            'related' => $related->map(fn ($a) => $this->serializeArticle($a, false)),
        ]);
    }

    protected function serializeArticle(NewsArticle $a, bool $full): array
    {
        $data = [
            'id' => $a->id,
            'slug' => $a->slug,
            'title' => $a->title,
            'subtitle' => $a->subtitle,
            'excerpt' => $a->excerpt,
            'category' => $a->category,
            'category_label' => $this->categoryLabel($a->category),
            'cover_image_path' => $a->cover_image_path,
            'tags' => $a->tags,
            'author' => $a->author_display_name ?? $a->author?->name,
            'published_at' => $a->published_at?->toIso8601String(),
            'reading_time' => $a->reading_time,
            'view_count' => $a->view_count,
            'is_pinned' => $a->is_pinned,
        ];
        if ($full) {
            $data['body'] = $a->body;
            $data['cover_caption'] = $a->cover_caption;
        }
        return $data;
    }

    protected function categoryList(): array
    {
        return [
            ['key' => 'announcement', 'label' => 'Annonces'],
            ['key' => 'congress', 'label' => 'Vie du congrès'],
            ['key' => 'scientific', 'label' => 'Actualités scientifiques'],
            ['key' => 'press', 'label' => 'Presse'],
            ['key' => 'social', 'label' => 'Réseaux sociaux'],
            ['key' => 'sponsor', 'label' => 'Partenaires'],
        ];
    }

    protected function categoryLabel(string $key): string
    {
        return collect($this->categoryList())->firstWhere('key', $key)['label'] ?? ucfirst($key);
    }
}
