@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Header -->
    <div class="max-w-2xl space-y-3" data-motion="scrollReveal">
        <x-ui.badge tone="brand" size="sm">وبلاگ و یادداشت‌های فنی</x-ui.badge>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-content-heading">
            یادداشت‌ها و مقالات تخصصی
        </h1>
        <p class="text-xs sm:text-sm text-content-secondary leading-relaxed">
            نوشته‌هایی درباره چالش‌های واقعی توسعه، تجربیات معماری نرم‌افزار، بهینه‌سازی دیتابیس و فرانت‌اند مدرن.
        </p>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-motion="scrollReveal">
        @forelse ($posts as $post)
            @php $trans = $post->translation($locale); @endphp
            <x-ui.card interactive="true" class="p-6 flex flex-col justify-between space-y-4 group" data-motion="cardHover">
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-[11px] text-content-secondary">
                        <span class="flex items-center gap-1">
                            <x-ui.icon name="calendar" size="xs" />
                            <span>{{ $post->published_at ? \App\Support\Jalali::fromDateTime($post->published_at) : 'به‌زودی' }}</span>
                        </span>
                        <x-ui.badge tone="neutral" size="sm">
                            {{ $post->reading_time_minutes ?? 5 }} دقیقه مطالعه
                        </x-ui.badge>
                    </div>

                    <h2 class="text-lg font-bold text-content-heading group-hover:text-brand transition-colors">
                        <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $post->slug]) }}">
                            {{ $trans?->title ?? $post->slug }}
                        </a>
                    </h2>

                    <p class="text-xs text-content-secondary leading-relaxed line-clamp-3">
                        {{ $trans?->summary ?? 'خلاصه مقاله تخصصی مهندسی و نکات کلیدی.' }}
                    </p>
                </div>

                <div class="pt-4 border-t border-edge flex items-center justify-between">
                    <span class="text-[11px] font-mono text-content-secondary flex items-center gap-1">
                        <x-ui.icon name="activity" size="xs" />
                        <span>{{ $post->views_count }} بازدید</span>
                    </span>

                    <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $post->slug]) }}" class="text-xs font-semibold text-brand hover:underline inline-flex items-center gap-1">
                        <span>مطالعه کامل</span>
                        <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                        <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                    </a>
                </div>
            </x-ui.card>
        @empty
            <div class="col-span-full py-16 text-center text-sm text-content-secondary">
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
