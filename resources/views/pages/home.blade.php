@extends('layouts.public')

@section('content')
<div class="space-y-24">
    <!-- 1. HERO SECTION (Aligned with design.md and reference composition) -->
    <section class="relative min-h-[92vh] flex items-center justify-center overflow-hidden pt-8 pb-16 bg-[#1F1F1F]">
        <!-- Three.js Canvas Container in Dark Theme Background -->
        <div class="absolute inset-0 z-0 pointer-events-auto opacity-75" id="hero-three-container">
            <!-- Quality & FPS Controller (Discreet HUD) -->
            <div class="absolute bottom-6 start-6 z-20 flex items-center gap-2 bg-[#171A1A]/80 backdrop-blur-md px-3 py-1.5 rounded-full border border-[#3A4442] text-[11px] font-mono text-[#BABABA]">
                <span class="w-2 h-2 rounded-full bg-[#65C99A] animate-pulse"></span>
                <span id="hero-fps-counter">60 FPS</span>
                <span class="opacity-30">|</span>
                <span class="text-[#79CCBB] uppercase text-[10px] font-bold">Hybrid Core</span>
            </div>
        </div>

        <!-- Ambient Teal & Orange Lighting Behind Hero -->
        <div class="absolute top-1/4 start-1/4 w-96 h-96 bg-[#18424E]/40 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute bottom-1/4 end-1/4 w-80 h-80 bg-[#F49D07]/15 rounded-full blur-[150px] pointer-events-none"></div>

        <!-- Hero Content Overlay -->
        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pointer-events-none space-y-8">
            
            <!-- Authentic AMB Ribbon Monogram Showcase (From Reference) -->
            <div class="flex flex-col items-center justify-center space-y-3 pointer-events-auto">
                <x-ui.amb-logo size="hero" variant="gradient" class="filter drop-shadow-[0_12px_24px_rgba(24,66,78,0.4)]" />
                
                <div class="space-y-1">
                    <span class="block text-xs sm:text-sm font-mono tracking-[0.3em] uppercase text-[#F4F7F6] font-semibold">
                        A M I R M O H A M M A D &nbsp; B A H A R L O U
                    </span>
                    <span class="block text-[11px] font-mono tracking-[0.25em] text-[#BABABA] uppercase">
                        Design &nbsp;&bull;&nbsp; Develop &nbsp;&bull;&nbsp; Create
                    </span>
                </div>
            </div>

            <!-- Headline: "Build Something Greater" (Reference Concept) -->
            <div class="space-y-4 max-w-3xl mx-auto pointer-events-auto">
                <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-[#F4F7F6] leading-[1.15]">
                    {{ $locale === 'fa' ? 'طراحی و ساخت تجربیات' : 'Build Something' }}
                    <span class="block text-[#79CCBB]">
                        {{ $locale === 'fa' ? 'فراتر از استانداردهای وب' : 'Greater' }}
                    </span>
                </h1>
                
                <p class="text-base sm:text-lg text-[#BABABA] max-w-2xl mx-auto leading-relaxed">
                    {{ $locale === 'fa'
                        ? 'توسعه‌دهنده ارشد و معمار نرم‌افزار؛ راهکارهای نوین مهندسی سیستم، پلتفرم‌های پرسرعت و رابط‌های کاربری تعاملی.'
                        : 'Modern solutions for a brighter future. Full-stack engineering, scalable architecture, and bespoke digital craftsmanship.'
                    }}
                </p>
            </div>

            <!-- CTA Buttons matching reference ("Get Started", "Explore Portfolio") -->
            <div class="flex flex-wrap items-center justify-center gap-4 pointer-events-auto pt-2">
                <x-ui.button 
                    as="a" 
                    href="{{ route('contact.index', ['locale' => $locale]) }}" 
                    variant="accent" 
                    size="lg" 
                    iconTrailing="arrow-right"
                    class="shadow-[0_4px_16px_rgba(244,157,7,0.3)] hover:shadow-[0_6px_20px_rgba(244,157,7,0.45)]"
                >
                    {{ $locale === 'fa' ? 'شروع پروژه و همکاری' : 'Get Started' }}
                </x-ui.button>

                <x-ui.button 
                    as="a" 
                    href="{{ route('portfolio.index', ['locale' => $locale]) }}" 
                    variant="outline" 
                    size="lg"
                    class="border-[#3A4442] text-[#F4F7F6] hover:bg-[#272C2B] backdrop-blur-md"
                >
                    {{ $locale === 'fa' ? 'مشاهده نمونه‌کارها' : 'Explore Portfolio' }}
                </x-ui.button>
            </div>

            <!-- Value Pillars Pills (Innovation, Security, Speed, Support) from reference -->
            <div class="pt-8 border-t border-[#3A4442]/60 grid grid-cols-2 sm:grid-cols-4 gap-4 pointer-events-auto max-w-3xl mx-auto">
                <div class="flex flex-col items-center gap-2 p-3 rounded-xl bg-[#272C2B]/60 border border-[#3A4442]">
                    <div class="w-10 h-10 rounded-full bg-[#18424E]/40 text-[#79CCBB] flex items-center justify-center">
                        <x-ui.icon name="box" size="sm" />
                    </div>
                    <span class="text-xs font-bold text-[#F4F7F6]">نوآوری و ساختار</span>
                    <span class="text-[10px] text-[#BABABA] font-mono">Innovation</span>
                </div>

                <div class="flex flex-col items-center gap-2 p-3 rounded-xl bg-[#272C2B]/60 border border-[#3A4442]">
                    <div class="w-10 h-10 rounded-full bg-[#29665F]/40 text-[#79CCBB] flex items-center justify-center">
                        <x-ui.icon name="shield" size="sm" />
                    </div>
                    <span class="text-xs font-bold text-[#F4F7F6]">امنیت و استاندارد</span>
                    <span class="text-[10px] text-[#BABABA] font-mono">Security</span>
                </div>

                <div class="flex flex-col items-center gap-2 p-3 rounded-xl bg-[#272C2B]/60 border border-[#3A4442]">
                    <div class="w-10 h-10 rounded-full bg-[#F49D07]/20 text-[#F49D07] flex items-center justify-center">
                        <x-ui.icon name="activity" size="sm" />
                    </div>
                    <span class="text-xs font-bold text-[#F4F7F6]">سرعت و کارایی</span>
                    <span class="text-[10px] text-[#BABABA] font-mono">Speed</span>
                </div>

                <div class="flex flex-col items-center gap-2 p-3 rounded-xl bg-[#272C2B]/60 border border-[#3A4442]">
                    <div class="w-10 h-10 rounded-full bg-[#18424E]/40 text-[#79CCBB] flex items-center justify-center">
                        <x-ui.icon name="users" size="sm" />
                    </div>
                    <span class="text-xs font-bold text-[#F4F7F6]">پشتیبانی متعهد</span>
                    <span class="text-[10px] text-[#BABABA] font-mono">Support</span>
                </div>
            </div>
        </div>

        <!-- Ambient bottom border -->
        <div class="absolute bottom-0 inset-x-0 h-12 bg-gradient-to-t from-primary to-transparent pointer-events-none"></div>
    </section>

    <!-- 2. METRICS & IMPACT COUNTERS (Using GSAP counter motion from catalog) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <x-ui.card class="p-6 text-center space-y-2">
                <div class="text-3xl lg:text-4xl font-black text-brand font-mono" data-motion="counter" data-counter-target="7">0</div>
                <span class="text-xs text-content-secondary font-medium">سال تجربه تخصصی توسعه نرم‌افزار</span>
            </x-ui.card>

            <x-ui.card class="p-6 text-center space-y-2">
                <div class="text-3xl lg:text-4xl font-black text-brand-accent font-mono" data-motion="counter" data-counter-target="40">0</div>
                <span class="text-xs text-content-secondary font-medium">پروژه موفق وب و سامانه عملیاتی</span>
            </x-ui.card>

            <x-ui.card class="p-6 text-center space-y-2">
                <div class="text-3xl lg:text-4xl font-black text-brand-secondary font-mono" data-motion="counter" data-counter-target="99">0</div>
                <span class="text-xs text-content-secondary font-medium">درصد رضایت و پایداری عملکرد</span>
            </x-ui.card>

            <x-ui.card class="p-6 text-center space-y-2">
                <div class="text-3xl lg:text-4xl font-black text-status-success font-mono" data-motion="counter" data-counter-target="100">0</div>
                <span class="text-xs text-content-secondary font-medium">تعهد به تحویل دقیق زمان‌بندی</span>
            </x-ui.card>
        </div>
    </section>

    <!-- 3. FEATURED WORK / PORTFOLIO -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8" data-motion="scrollReveal">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-edge pb-4">
            <div>
                <x-ui.badge tone="brand" size="sm" class="mb-2">نمونه‌کارها و پروژه‌ها</x-ui.badge>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-content-heading">
                    پروژه‌های شاخص و مطالعات موردی
                </h2>
            </div>
            
            <a href="{{ route('portfolio.index', ['locale' => $locale]) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-link hover:underline">
                <span>مشاهده تمام پروژه‌ها</span>
                <x-ui.icon name="arrow-left" size="sm" class="rtl:block ltr:hidden" />
                <x-ui.icon name="arrow-right" size="sm" class="ltr:block rtl:hidden" />
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse ($featuredProjects as $project)
                @php $trans = $project->translation($locale); @endphp
                <x-ui.card interactive="true" class="p-6 flex flex-col justify-between space-y-6" data-motion="cardHover">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-xs text-content-secondary uppercase">{{ $project->slug }}</span>
                            @if ($project->is_demo)
                                <x-ui.badge tone="warning" size="sm">محتوای نمونه (Demo)</x-ui.badge>
                            @else
                                <x-ui.badge tone="accent" size="sm">کیس‌استادی زنده</x-ui.badge>
                            @endif
                        </div>

                        <div class="space-y-2">
                            <h3 class="text-xl font-bold text-content-heading">
                                {{ $trans?->title ?? $project->slug }}
                            </h3>
                            <p class="text-xs text-content-secondary leading-relaxed line-clamp-3">
                                {{ $trans?->summary ?? 'شرح جامع توسعه سیستم مقیاس‌پذیر و دستاوردهای فنی پروژه.' }}
                            </p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-edge flex items-center justify-between">
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($project->technologies->take(3) as $tech)
                                <x-ui.badge tone="neutral" size="sm">{{ $tech->name }}</x-ui.badge>
                            @endforeach
                        </div>

                        <a href="{{ route('portfolio.show', ['locale' => $locale, 'slug' => $project->slug]) }}" class="text-xs font-semibold text-brand hover:underline flex items-center gap-1">
                            <span>مطالعه کیس‌استادی</span>
                            <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                            <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                        </a>
                    </div>
                </x-ui.card>
            @empty
                <div class="col-span-full text-center py-12 text-content-secondary text-sm">
                    پروژه‌ای در این بخش یافت نشد.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 4. SERVICES & VALUE PROPOSITION ("Grow Together" concept from reference) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8" data-motion="scrollReveal">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <x-ui.badge tone="accent" size="sm">همکاری و توسعه</x-ui.badge>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-content-heading">
                خدمات تخصصی مهندسی نرم‌افزار
            </h2>
            <p class="text-xs sm:text-sm text-content-secondary leading-relaxed">
                ارائه راه‌حل‌های پایدار و مهندسی‌شده با تمرکز بر عملکرد بی‌نقص، رابط کاربری متمایز و مقیاس‌پذیری زیرساخت.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Service 1 -->
            <x-ui.card class="p-6 space-y-4">
                <div class="w-12 h-12 rounded-xl bg-brand/10 text-brand flex items-center justify-center">
                    <x-ui.icon name="cpu" size="lg" />
                </div>
                <h3 class="text-base font-bold text-content-heading">معماری سیستم و توسعه بک‌اند</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    طراحی ساختار نرم‌افزارهای مدرن با PHP 8.x و Laravel 11، بهینه‌سازی دیتابیس MySQL/Redis، کش چندلایه و مدیریت صف‌های پردازشی سریع.
                </p>
                <div class="pt-2">
                    <a href="{{ route('services.index', ['locale' => $locale]) }}" class="text-xs font-semibold text-link hover:underline inline-flex items-center gap-1">
                        <span>اطلاعات بیشتر</span>
                        <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                        <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                    </a>
                </div>
            </x-ui.card>

            <!-- Service 2 -->
            <x-ui.card class="p-6 space-y-4">
                <div class="w-12 h-12 rounded-xl bg-brand-secondary/15 text-brand-secondary flex items-center justify-center">
                    <x-ui.icon name="layers" size="lg" />
                </div>
                <h3 class="text-base font-bold text-content-heading">رابط‌های تعاملی و وب سه‌بعدی</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    توسعه رابط‌های کاربری چشم‌نواز با Three.js، گرافیک برداری، انیمیشن‌های دقیق GSAP و هماهنگی کامل با حالت‌های دارک و لایت.
                </p>
                <div class="pt-2">
                    <a href="{{ route('services.index', ['locale' => $locale]) }}" class="text-xs font-semibold text-link hover:underline inline-flex items-center gap-1">
                        <span>اطلاعات بیشتر</span>
                        <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                        <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                    </a>
                </div>
            </x-ui.card>

            <!-- Service 3 -->
            <x-ui.card class="p-6 space-y-4">
                <div class="w-12 h-12 rounded-xl bg-brand-accent/15 text-brand-accent flex items-center justify-center">
                    <x-ui.icon name="rocket" size="lg" />
                </div>
                <h3 class="text-base font-bold text-content-heading">بهینه‌سازی کارایی و سئو فنی</h3>
                <p class="text-xs text-content-secondary leading-relaxed">
                    کاهش زمان لودینگ، رعایت کامل Core Web Vitals، ساختار داده‌های استاندارد Schema.org و تحویل پروژه‌های آماده استقرار بدون وابستگی اضافی.
                </p>
                <div class="pt-2">
                    <a href="{{ route('services.index', ['locale' => $locale]) }}" class="text-xs font-semibold text-link hover:underline inline-flex items-center gap-1">
                        <span>اطلاعات بیشتر</span>
                        <x-ui.icon name="arrow-left" size="xs" class="rtl:block ltr:hidden" />
                        <x-ui.icon name="arrow-right" size="xs" class="ltr:block rtl:hidden" />
                    </a>
                </div>
            </x-ui.card>
        </div>
    </section>

    <!-- 5. ESTIMATOR & LEAD ACTION TEASER -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-ui.card variant="elevated" class="p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 bg-gradient-to-r from-brand/10 via-surface to-brand-accent/10">
            <div class="space-y-2 max-w-xl text-center md:text-start">
                <x-ui.badge tone="accent" size="sm">تخمین آنلاین و آنی</x-ui.badge>
                <h3 class="text-xl sm:text-2xl font-extrabold text-content-heading">
                    می‌خواهید برآورد هزینه و زمان اجرای پروژه خود را بدانید؟
                </h3>
                <p class="text-xs sm:text-sm text-content-secondary leading-relaxed">
                    با استفاده از محاسبه‌گر هوشمند، در کمتر از ۱ دقیقه ویژگی‌های پروژه را انتخاب کرده و برآورد دقیق را دریافت کنید.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <x-ui.button as="a" href="{{ route('estimator.index', ['locale' => $locale]) }}" variant="accent" iconTrailing="arrow-right">
                    محاسبه آنلاین هزینه پروژه
                </x-ui.button>
                <x-ui.button as="a" href="{{ route('booking.index', ['locale' => $locale]) }}" variant="outline">
                    رزرو وقت مشاوره آنلاین
                </x-ui.button>
            </div>
        </x-ui.card>
    </section>

    <!-- 6. FINAL CLOSING CTA -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-xl bg-[#18424E] text-white p-10 md:p-16 text-center md:text-start flex flex-col md:flex-row items-center justify-between gap-8 shadow-lg">
            <div class="max-w-xl space-y-3 z-10">
                <span class="text-xs font-mono tracking-widest text-[#79CCBB] uppercase font-bold">START A COLLABORATION</span>
                <h3 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    آماده خلق محصول دیجیتال بعدی خود هستید؟
                </h3>
                <p class="text-xs sm:text-sm text-[#BABABA] leading-relaxed">
                    برای دریافت مشاوره، پیاده‌سازی سامانه اختصاصی یا بازطراحی سیستم‌های خود، از طریق فرم تماس در ارتباط باشید.
                </p>
            </div>

            <div class="z-10 flex-shrink-0">
                <x-ui.button 
                    as="a" 
                    href="{{ route('contact.index', ['locale' => $locale]) }}" 
                    variant="accent" 
                    size="lg" 
                    iconLeading="mail"
                    class="shadow-[0_4px_16px_rgba(244,157,7,0.35)]"
                >
                    ارسال پیام و استعلام همکاری
                </x-ui.button>
            </div>

            <!-- Background decorative ribbon arch -->
            <div class="absolute -end-20 -bottom-20 w-80 h-80 bg-[#29665F]/40 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -start-10 -top-10 w-64 h-64 bg-[#F49D07]/10 rounded-full blur-2xl pointer-events-none"></div>
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
