@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Header -->
    <div class="max-w-2xl space-y-3">
        <span class="text-xs font-bold text-brand uppercase tracking-wider">وبلاگ مهندسی</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-content-primary">
            یادداشت‌ها و مقالات تخصصی
        </h1>
        <p class="text-xs sm:text-sm text-content-secondary leading-relaxed">
            نوشته‌هایی درباره چالش‌های واقعی توسعه، تجربیات معماری نرم‌افزار، بهینه‌سازی دیتابیس و فرانت‌اند مدرن.
        </p>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($posts as $post)
            @php $trans = $post->translation($locale); @endphp
            <article class="rounded-3xl bg-surface-card border border-border-subtle/80 overflow-hidden hover:border-brand/40 transition-all shadow-sm flex flex-col group">
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-[11px] text-content-tertiary">
                            <span>{{ $post->published_at ? \App\Support\Jalali::fromDateTime($post->published_at) : 'به‌زودی' }}</span>
                            <span>{{ $post->reading_time_minutes ?? 5 }} دقیقه مطالعه</span>
                        </div>

                        <h2 class="text-lg font-bold text-content-primary group-hover:text-brand transition-colors">
                            <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $post->slug]) }}">
                                {{ $trans?->title ?? $post->slug }}
                            </a>
                        </h2>

                        <p class="text-xs text-content-secondary leading-relaxed line-clamp-3">
                            {{ $trans?->summary ?? 'خلاصه مقاله تخصصی مهندسی و نکات کلیدی.' }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-border-subtle flex items-center justify-between">
                        <span class="text-[11px] font-mono text-content-tertiary">
                            {{ $post->views_count }} بازدید
                        </span>

                        <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $post->slug]) }}" class="text-xs font-semibold text-brand hover:underline">
                            مطالعه کامل →
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full py-16 text-center text-sm text-content-tertiary">
                هنوز مقاله‌ای منتشر نشده است.
            </div>
        @endforelse
    </div>

    @if ($posts->hasPages())
        <div class="pt-8">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
