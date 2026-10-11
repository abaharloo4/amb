<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Post;
use App\Support\SeoMeta;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request, string $locale = 'fa')
    {
        $seo = new SeoMeta(
            title: $locale === 'fa' 
                ? 'امیرمحمد بحرلو | Senior Full-Stack Engineer & Architect' 
                : 'AmirMohammad Baharlou | Senior Full-Stack Engineer & Architect',
            description: $locale === 'fa'
                ? 'پلتفرم تخصصی و پرتفولیو امیرمحمد بحرلو؛ توسعه‌دهنده ارشد و معمار نرم‌افزارهای مقیاس‌پذیر بر پایه لاراول، Vue/React، Three.js و معماری مدرن.'
                : 'Personal platform & portfolio of AmirMohammad Baharlou; Senior Software Architect specializing in Laravel, high-throughput systems, Three.js and cloud solutions.'
        );

        $featuredProjects = Project::with(['translations', 'technologies'])
            ->where('featured', true)
            ->orderBy('order')
            ->take(4)
            ->get();

        $latestPosts = Post::with('translations')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.home', compact('seo', 'featuredProjects', 'latestPosts', 'locale'));
    }
}
