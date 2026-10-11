<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\SeoMeta;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request, string $locale = 'fa')
    {
        $seo = new SeoMeta(
            title: $locale === 'fa' ? 'نمونه‌کارها و پروژه‌ها | امیرمحمد بحرلو' : 'Portfolio & Case Studies | AmirMohammad Baharlou',
            description: $locale === 'fa' 
                ? 'مجموعه نمونه‌کارهای اجرا شده، پروژه‌های سازمانی و راهکارهای نرم‌افزاری توسط امیرمحمد بحرلو.'
                : 'Selected portfolio projects, enterprise systems, and case studies developed by AmirMohammad Baharlou.'
        );

        $projects = Project::with(['translations', 'technologies'])
            ->orderBy('sort_order')
            ->paginate(9);

        return view('pages.portfolio.index', compact('seo', 'projects', 'locale'));
    }

    public function show(Request $request, string $locale, string $slug)
    {
        $project = Project::with(['translations', 'technologies', 'media'])
            ->whereHas('translations', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->firstOrFail();

        $trans = $project->translation($locale);

        $seo = new SeoMeta(
            title: ($trans?->title ?? $project->slug) . ' | ' . ($locale === 'fa' ? 'امیرمحمد بحرلو' : 'AmirMohammad Baharlou'),
            description: $trans?->summary ?? '',
            canonical: route('portfolio.show', ['locale' => $locale, 'slug' => $project->slug]),
            schemaData: [
                '@type' => 'CreativeWork',
                'name' => $trans?->title ?? $project->slug,
                'description' => $trans?->summary ?? '',
                'author' => [
                    '@type' => 'Person',
                    'name' => 'AmirMohammad Baharlou',
                ]
            ]
        );

        return view('pages.portfolio.show', compact('seo', 'project', 'trans', 'locale'));
    }
}
