@extends('layouts.public')

@section('content')
<div class="space-y-32">
    <!-- HERO SECTION WITH HYBRID THREE.JS (LATTICE + ORBITAL) -->
    <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden pt-12 pb-20">
        <!-- Three.js Canvas Container -->
        <div class="absolute inset-0 z-0 pointer-events-auto" id="hero-three-container">
            <!-- Quality & FPS Controller (Discreet HUD) -->
            <div class="absolute bottom-6 start-6 z-20 flex items-center gap-2 bg-surface-base/60 backdrop-blur-md px-3 py-1.5 rounded-full border border-border-subtle/40 text-[11px] font-mono text-content-tertiary">
                <span class="w-2 h-2 rounded-full bg-success animate-pulse"></span>
                <span id="hero-fps-counter">60 FPS</span>
                <span class="opacity-30">|</span>
                <span class="text-content-secondary uppercase text-[10px] font-bold">Hybrid Core</span>
            </div>
        </div>

        <!-- Hero Content Overlay -->
        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pointer-events-none">
            <!-- Availability Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-card/80 border border-border-subtle backdrop-blur-xl mb-8 pointer-events-auto shadow-sm">
                <span class="w-2 h-2 rounded-full bg-brand animate-ping"></span>
                <span class="text-xs font-medium text-content-secondary">
                    {{ $locale === 'fa' ? 'آماده همکاری در پروژه‌های سطح بالا و مشاوره فنی' : 'Available for High-Impact Projects & Consulting' }}
                </span>
            </div>

            <!-- Main Headline -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-content-primary leading-[1.15] mb-6">
                {{ $locale === 'fa' ? 'طراحی و معماری نرم‌افزار' : 'Designing & Engineering' }}
                <br />
                <span class="bg-gradient-to-r from-brand via-brand-glow to-accent bg-clip-text text-transparent">
                    {{ $locale === 'fa' ? 'در مقیاس واقعی و کارایی حداکثری' : 'Scalable High-Throughput Systems' }}
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="max-w-2xl mx-auto text-base sm:text-lg text-content-secondary leading-relaxed mb-10 pointer-events-auto">
                {{ $locale === 'fa' 
                    ? 'من امیرمحمد بحرلو هستم؛ توسعه‌دهنده ارشد فول‌استک و معمار سیستم با تمرکز بر پایداری، سرعت و ساخت محصولات دیجیتال استاندارد.' 
                    : 'I am AmirMohammad Baharlou; Senior Full-Stack Engineer and Software Architect crafting reliable web architectures and bespoke digital products.' 
                }}
            </p>

            <!-- Hero CTAs -->
            <div class="flex flex-wrap items-center justify-center gap-4 pointer-events-auto">
                <a 
                    href="{{ route('contact.index', ['locale' => $locale]) }}"
                    class="px-7 py-3.5 rounded-2xl bg-gradient-to-r from-brand to-brand-glow text-white font-semibold text-sm shadow-glow hover:opacity-95 active:scale-95 transition-all flex items-center gap-2.5"
                >
                    <x-ui.icon name="sparkles" class="w-4 h-4" />
                    <span>{{ $locale === 'fa' ? 'شروع گفت‌وگو و ثبت سفارش' : 'Start a Project' }}</span>
                </a>

                <a 
                    href="{{ route('portfolio.index', ['locale' => $locale]) }}"
                    class="px-7 py-3.5 rounded-2xl bg-surface-card/80 hover:bg-surface-subtle border border-border-subtle text-content-primary font-semibold text-sm backdrop-blur-md transition-all flex items-center gap-2"
                >
                    <x-ui.icon name="folder" class="w-4 h-4 text-content-secondary" />
                    <span>{{ $locale === 'fa' ? 'مشاهده پروژه‌ها' : 'Explore Portfolio' }}</span>
                </a>
            </div>
        </div>

        <!-- Bottom Ambient Fade -->
        <div class="absolute bottom-0 inset-x-0 h-32 bg-gradient-to-t from-surface-canvas to-transparent pointer-events-none"></div>
    </section>

    <!-- METRICS & KEY HIGHLIGHTS -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 p-8 rounded-3xl bg-surface-card/60 border border-border-subtle/80 backdrop-blur-xl">
            <div class="text-center md:text-start space-y-1">
                <div class="text-3xl lg:text-4xl font-extrabold text-brand font-mono">۷+</div>
                <div class="text-xs font-medium text-content-secondary">سال تجربه توسعه تخصصی</div>
            </div>
            <div class="text-center md:text-start space-y-1">
                <div class="text-3xl lg:text-4xl font-extrabold text-accent font-mono">۴۰+</div>
                <div class="text-xs font-medium text-content-secondary">پروژه موفق وب و سامانه</div>
            </div>
            <div class="text-center md:text-start space-y-1">
                <div class="text-3xl lg:text-4xl font-extrabold text-brand-glow font-mono">۹۹.۹٪</div>
                <div class="text-xs font-medium text-content-secondary">پایداری و آپتایم سرویس‌ها</div>
            </div>
            <div class="text-center md:text-start space-y-1">
                <div class="text-3xl lg:text-4xl font-extrabold text-success font-mono">۱۰۰٪</div>
                <div class="text-xs font-medium text-content-secondary">رضایت کارفرمایان و تیم‌ها</div>
            </div>
        </div>
    </section>

    <!-- FEATURED PROJECTS SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div>
                <span class="text-xs font-bold text-brand uppercase tracking-wider">نمونه‌کارها</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-content-primary mt-1">
                    پروژه‌های برگزیده و کیس‌استادی‌ها
                </h2>
            </div>
            <a href="{{ route('portfolio.index', ['locale' => $locale]) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand hover:underline">
                <span>مشاهده آرشیو کامل نمونه‌کارها</span>
                <x-ui.icon name="arrow-left" class="w-3.5 h-3.5 rtl:block ltr:hidden" />
                <x-ui.icon name="arrow-right" class="w-3.5 h-3.5 ltr:block rtl:hidden" />
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse ($featuredProjects as $project)
                @php $trans = $project->translation($locale); @endphp
                <div data-motion="cardHover" class="group relative rounded-3xl bg-surface-card border border-border-subtle/80 overflow-hidden hover:border-brand/40 transition-all duration-300 shadow-sm flex flex-col will-change-transform">
                    <!-- Project Preview Card Header -->
                    <div class="h-60 bg-gradient-to-br from-surface-subtle via-surface-base to-brand/10 p-6 flex flex-col justify-between relative overflow-hidden">
                        <div class="flex items-center justify-between z-10">
                            @if ($project->is_demo)
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-warning/10 text-warning border border-warning/20">
                                    محتوای نمونه (Demo)
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-brand/10 text-brand border border-brand/20">
                                    کیس‌استادی زنده
                                </span>
                            @endif

                            <div class="w-8 h-8 rounded-full bg-surface-base/80 border border-border-subtle flex items-center justify-center text-content-secondary group-hover:text-brand transition-colors">
                                <x-ui.icon name="external-link" class="w-4 h-4" />
                            </div>
                        </div>

                        <!-- Graphical Abstract Pattern -->
                        <div class="absolute -end-10 -bottom-10 w-48 h-48 bg-brand/10 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-500"></div>

                        <div class="z-10">
                            <span class="text-[11px] font-mono text-content-tertiary uppercase">{{ $project->slug }}</span>
                            <h3 class="text-xl font-bold text-content-primary group-hover:text-brand transition-colors mt-0.5">
                                {{ $trans?->title ?? $project->slug }}
                            </h3>
                        </div>
                    </div>

                    <!-- Project Body -->
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <p class="text-xs text-content-secondary leading-relaxed line-clamp-2">
                            {{ $trans?->summary ?? 'شرح جامع توسعه سیستم مقیاس‌پذیر و دستاوردهای فنی پروژه.' }}
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-border-subtle/60">
                            <div class="flex items-center gap-1.5">
                                @foreach ($project->technologies->take(3) as $tech)
                                    <span class="px-2 py-0.5 rounded-md bg-surface-subtle text-[11px] font-mono text-content-secondary">
                                        {{ $tech->name }}
                                    </span>
                                @endforeach
                            </div>

                            <a href="{{ route('portfolio.show', ['locale' => $locale, 'slug' => $project->slug]) }}" class="text-xs font-semibold text-brand hover:underline">
                                جزئیات کیس‌استادی →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback Showcase Card -->
                <div class="col-span-full text-center py-12 text-content-tertiary text-sm">
                    پروژه‌ای در این بخش ثبت نشده است.
                </div>
            @endforelse
        </div>
    </section>

    <!-- CORE SPECIALIZATIONS & SERVICES PREVIEW -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold text-brand uppercase tracking-wider">مهارت‌ها و خدمات</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-content-primary mt-1">
                چه ارزش‌هایی برای کسب‌وکار شما خلق می‌کنم؟
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle/80 hover:border-brand/40 transition-colors shadow-sm space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-brand/10 text-brand flex items-center justify-center">
                    <x-ui.icon name="cpu" class="w-6 h-6" />
                </div>
                <h3 class="text-base font-bold text-content-primary">معماری سیستم‌های پربار (High-Load)</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    طراحی ساختار نرم‌افزارهای یکپارچه و مایکروسرویس، بهینه‌سازی دیتابیس، کش چندلایه و مدیریت صف‌های پردازشی با پاسخگویی میلی‌ثانیه‌ای.
                </p>
            </div>

            <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle/80 hover:border-brand/40 transition-colors shadow-sm space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-accent/10 text-accent flex items-center justify-center">
                    <x-ui.icon name="sparkles" class="w-6 h-6" />
                </div>
                <h3 class="text-base font-bold text-content-primary">رابط‌های تعاملی و Three.js</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    خلق تجربیات وب سه‌بعدی و گرافیک شتاب‌یافته سخت‌افزاری، انیمیشن‌های روان ۶۰ فریم با GSAP بدون هیچ‌گونه لگ یا نشت حافظه.
                </p>
            </div>

            <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle/80 hover:border-brand/40 transition-colors shadow-sm space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-brand-glow/10 text-brand-glow flex items-center justify-center">
                    <x-ui.icon name="shield" class="w-6 h-6" />
                </div>
                <h3 class="text-base font-bold text-content-primary">امنیت و استانداردهای سازمانی</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    کدنویسی تمیز بر پایه اصول SOLID، تست‌های خودکار یکپارچه، امنیت داده‌ها، هدرهای پیشرفته و آماده‌سازی برای میزبانی مطمئن.
                </p>
            </div>
        </div>
    </section>

    <!-- CALL TO ACTION BANNER -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand/20 via-surface-card to-accent/20 border border-border-subtle p-10 md:p-14 text-center md:text-start flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-xl space-y-2">
                <h3 class="text-2xl md:text-3xl font-extrabold text-content-primary">
                    ایده یا پروژه‌ای برای پیاده‌سازی دارید؟
                </h3>
                <p class="text-xs sm:text-sm text-content-secondary leading-relaxed">
                    بیایید با هم درباره مشخصات فنی، معماری بهینه و نحوه اجرای دقیق آن صحبت کنیم.
                </p>
            </div>

            <a 
                href="{{ route('contact.index', ['locale' => $locale]) }}"
                class="px-8 py-4 rounded-2xl bg-gradient-to-r from-brand to-brand-glow text-white font-bold text-sm shadow-glow hover:opacity-95 active:scale-95 transition-all flex items-center gap-2 whitespace-nowrap"
            >
                <x-ui.icon name="mail" class="w-4 h-4" />
                <span>ثبت درخواست مشاوره</span>
            </a>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('hero-three-container');
        const fpsCounter = document.getElementById('hero-fps-counter');

        if (window.initHeroHybrid && container) {
            window.initHeroHybrid(container, (fps) => {
                if (fpsCounter) fpsCounter.textContent = `${fps} FPS`;
            });
        }
    });
</script>
@endpush
