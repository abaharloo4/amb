<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\SeoMeta;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request, string $locale = 'fa')
    {
        $seo = new SeoMeta(
            title: $locale === 'fa' ? 'وبلاگ و یادداشت‌های فنی | امیرمحمد بحرلو' : 'Engineering Blog & Articles | AmirMohammad Baharlou',
            description: $locale === 'fa'
                ? 'مقاله‌های تخصصی در زمینه معماری نرم‌افزار، توسعه وب، کارایی دیتابیس و تجربیات عملی مهندسی.'
                : 'Articles and deep dives on software architecture, Laravel, performance optimization, and front-end engineering.'
        );

        $posts = Post::with('translations')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);

        return view('pages.blog.index', compact('seo', 'posts', 'locale'));
    }

    public function show(Request $request, string $locale, string $slug)
    {
        $post = Post::with(['translations', 'tags', 'author'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment views safely
        $post->increment('views_count');

        $trans = $post->translation($locale);

        $seo = new SeoMeta(
            title: ($trans?->title ?? $post->slug) . ' | وبلاگ امیرمحمد بحرلو',
            description: $trans?->summary ?? '',
            type: 'article',
            canonical: route('blog.show', ['locale' => $locale, 'slug' => $post->slug]),
            schemaData: [
                '@type' => 'BlogPosting',
                'headline' => $trans?->title ?? $post->slug,
                'description' => $trans?->summary ?? '',
                'datePublished' => $post->published_at?->toIso8601String(),
                'author' => [
                    '@type' => 'Person',
                    'name' => 'AmirMohammad Baharlou',
                ]
            ]
        );

        return view('pages.blog.show', compact('seo', 'post', 'trans', 'locale'));
    }
}
