<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $seo->title ?? 'امیرمحمد بحرلو | Senior Full-Stack Engineer' }}</title>
    <meta name="description" content="{{ $seo->description ?? 'پرتفولیو و پلتفرم تخصصی امیرمحمد بحرلو؛ توسعه‌دهنده ارشد و معمار نرم‌افزار.' }}">
    <link rel="canonical" href="{{ $seo->canonical ?? url()->current() }}">

    <!-- Multilingual Hreflang Tags -->
    @php
        $currentPath = request()->path();
        $pathWithoutLocale = preg_replace('/^(fa|en)\/?/', '', $currentPath);
        $faUrl = url('fa/' . $pathWithoutLocale);
        $enUrl = url('en/' . $pathWithoutLocale);
    @endphp
    <link rel="alternate" hreflang="fa" href="{{ $faUrl }}">
    <link rel="alternate" hreflang="en" href="{{ $enUrl }}">
    <link rel="alternate" hreflang="x-default" href="{{ $faUrl }}">

    <!-- Open Graph & Twitter Cards -->
    <meta property="og:type" content="{{ $seo->type ?? 'website' }}">
    <meta property="og:title" content="{{ $seo->title ?? 'امیرمحمد بحرلو' }}">
    <meta property="og:description" content="{{ $seo->description ?? '' }}">
    <meta property="og:url" content="{{ $seo->canonical ?? url()->current() }}">
    <meta property="og:image" content="{{ $seo->ogImage ?? asset('images/og-cover.png') }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Schema.org JSON-LD -->
    @if (isset($seo) && method_exists($seo, 'generateStructuredData'))
        <script type="application/ld+json">
            {!! $seo->generateStructuredData() !!}
        </script>
    @endif

    <!-- Zero-Flash Theme Script -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('amb_theme') || 'dark';
            if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
            } else {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-surface-canvas text-content-primary antialiased min-h-screen flex flex-col font-sans selection:bg-brand selection:text-white" x-data="{ mobileNav: false }">
    <x-ui.sprite />

    <!-- Ambient Global Background Glows -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute -top-40 -end-40 w-96 h-96 bg-brand/10 rounded-full blur-[120px]"></div>
        <div class="absolute top-1/2 -start-40 w-96 h-96 bg-accent/10 rounded-full blur-[140px]"></div>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-40 w-full backdrop-blur-xl bg-surface-base/80 border-b border-border-subtle/50 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo with Authentic AMB Ribbon Monogram -->
            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="flex items-center gap-3.5 group">
                <x-ui.amb-logo size="sm" variant="gradient" class="transition-transform group-hover:scale-105" />
                <div class="flex flex-col">
                    <span class="font-bold text-sm tracking-tight text-content-primary group-hover:text-brand transition-colors">
                        {{ app()->getLocale() === 'fa' ? 'امیرمحمد بحرلو' : 'AmirMohammad Baharlou' }}
                    </span>
                    <span class="text-[10px] text-content-secondary uppercase tracking-widest font-mono">
                        Design &bull; Develop &bull; Create
                    </span>
                </div>
            </a>

            <!-- Desktop Nav Menu -->
            <nav class="hidden md:flex items-center gap-1 bg-surface-subtle/60 p-1.5 rounded-full border border-border-subtle/60 backdrop-blur-md">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="px-4 py-1.5 text-xs font-medium rounded-full transition-colors {{ request()->routeIs('home') ? 'bg-brand text-white shadow-sm' : 'text-content-secondary hover:text-content-primary' }}">
                    {{ app()->getLocale() === 'fa' ? 'صفحه اصلی' : 'Home' }}
                </a>
                <a href="{{ route('portfolio.index', ['locale' => app()->getLocale()]) }}" class="px-4 py-1.5 text-xs font-medium rounded-full transition-colors {{ request()->routeIs('portfolio.*') ? 'bg-brand text-white shadow-sm' : 'text-content-secondary hover:text-content-primary' }}">
                    {{ app()->getLocale() === 'fa' ? 'نمونه‌کارها' : 'Portfolio' }}
                </a>
                <a href="{{ route('services.index', ['locale' => app()->getLocale()]) }}" class="px-4 py-1.5 text-xs font-medium rounded-full transition-colors {{ request()->routeIs('services.*') ? 'bg-brand text-white shadow-sm' : 'text-content-secondary hover:text-content-primary' }}">
                    {{ app()->getLocale() === 'fa' ? 'خدمات' : 'Services' }}
                </a>
                <a href="{{ route('resume.index', ['locale' => app()->getLocale()]) }}" class="px-4 py-1.5 text-xs font-medium rounded-full transition-colors {{ request()->routeIs('resume.*') ? 'bg-brand text-white shadow-sm' : 'text-content-secondary hover:text-content-primary' }}">
                    {{ app()->getLocale() === 'fa' ? 'رزومه' : 'Resume' }}
                </a>
                <a href="{{ route('blog.index', ['locale' => app()->getLocale()]) }}" class="px-4 py-1.5 text-xs font-medium rounded-full transition-colors {{ request()->routeIs('blog.*') ? 'bg-brand text-white shadow-sm' : 'text-content-secondary hover:text-content-primary' }}">
                    {{ app()->getLocale() === 'fa' ? 'وبلاگ' : 'Blog' }}
                </a>
                <a href="{{ route('contact.index', ['locale' => app()->getLocale()]) }}" class="px-4 py-1.5 text-xs font-medium rounded-full transition-colors {{ request()->routeIs('contact.*') ? 'bg-brand text-white shadow-sm' : 'text-content-secondary hover:text-content-primary' }}">
                    {{ app()->getLocale() === 'fa' ? 'تماس و همکاری' : 'Contact' }}
                </a>
            </nav>

            <!-- Action Controls (Theme, Locale, CTA) -->
            <div class="hidden md:flex items-center gap-3">
                <x-ui.theme-toggle />
                
                <!-- Locale Switcher -->
                @if (app()->getLocale() === 'fa')
                    <a href="{{ url('en/' . $pathWithoutLocale) }}" class="p-2 rounded-xl border border-border-subtle bg-surface-card hover:bg-surface-subtle text-xs font-bold text-content-secondary transition-colors" title="Switch to English">
                        EN
                    </a>
                @else
                    <a href="{{ url('fa/' . $pathWithoutLocale) }}" class="p-2 rounded-xl border border-border-subtle bg-surface-card hover:bg-surface-subtle text-xs font-bold text-content-secondary transition-colors" title="تغییر به فارسی">
                        فا
                    </a>
                @endif

                <a 
                    href="{{ route('contact.index', ['locale' => app()->getLocale()]) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-brand to-brand-glow text-white text-xs font-semibold shadow-glow hover:opacity-95 active:scale-95 transition-all"
                >
                    <x-ui.icon name="sparkles" class="w-3.5 h-3.5" />
                    <span>{{ app()->getLocale() === 'fa' ? 'شروع پروژه' : 'Get In Touch' }}</span>
                </a>
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center gap-2 md:hidden">
                <x-ui.theme-toggle />
                <button 
                    @click="mobileNav = !mobileNav"
                    class="p-2.5 rounded-xl border border-border-subtle bg-surface-card text-content-secondary hover:text-content-primary"
                    aria-label="Toggle navigation"
                >
                    <x-ui.icon name="menu" class="w-5 h-5" x-show="!mobileNav" />
                    <x-ui.icon name="x" class="w-5 h-5" x-show="mobileNav" style="display: none;" />
                </button>
            </div>
        </div>

        <!-- Mobile Nav Drawer -->
        <div 
            x-show="mobileNav" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="md:hidden border-b border-border-subtle bg-surface-base/95 backdrop-blur-2xl p-6 space-y-4"
            style="display: none;"
        >
            <div class="grid grid-cols-2 gap-2 text-sm">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="p-3 rounded-xl bg-surface-subtle text-content-primary font-medium">صفحه اصلی</a>
                <a href="{{ route('portfolio.index', ['locale' => app()->getLocale()]) }}" class="p-3 rounded-xl bg-surface-subtle text-content-primary font-medium">نمونه‌کارها</a>
                <a href="{{ route('services.index', ['locale' => app()->getLocale()]) }}" class="p-3 rounded-xl bg-surface-subtle text-content-primary font-medium">خدمات</a>
                <a href="{{ route('resume.index', ['locale' => app()->getLocale()]) }}" class="p-3 rounded-xl bg-surface-subtle text-content-primary font-medium">رزومه</a>
                <a href="{{ route('blog.index', ['locale' => app()->getLocale()]) }}" class="p-3 rounded-xl bg-surface-subtle text-content-primary font-medium">وبلاگ</a>
                <a href="{{ route('contact.index', ['locale' => app()->getLocale()]) }}" class="p-3 rounded-xl bg-surface-subtle text-content-primary font-medium">تماس</a>
            </div>

            <div class="pt-4 border-t border-border-subtle flex items-center justify-between">
                <span class="text-xs text-content-tertiary">زبان سیستم:</span>
                @if (app()->getLocale() === 'fa')
                    <a href="{{ url('en/' . $pathWithoutLocale) }}" class="text-xs font-bold text-brand">English (EN)</a>
                @else
                    <a href="{{ url('fa/' . $pathWithoutLocale) }}" class="text-xs font-bold text-brand">فارسی (FA)</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main View Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="border-t border-border-subtle/60 bg-surface-base/50 backdrop-blur-md mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <x-ui.amb-logo size="sm" variant="gradient" />
                        <span class="font-bold text-base text-content-primary">امیرمحمد بحرلو</span>
                    </div>
                    <p class="text-xs text-content-secondary leading-relaxed max-w-md">
                        طراحی و مهندسی سیستم‌های نرم‌افزاری با تمرکز بر مقیاس‌پذیری، کارایی بالا و تجربه کاربری تمیز و بدون نقص. آماده همکاری در پروژه‌های سطح سازمانی و استارتاپ‌های پیشرو.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="https://github.com/abaharloo4" target="_blank" rel="noopener noreferrer" class="p-2 rounded-xl bg-surface-subtle border border-border-subtle text-content-secondary hover:text-content-primary hover:border-brand/40 transition-colors" title="GitHub">
                            <x-ui.icon name="github" class="w-4 h-4" />
                        </a>
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="p-2 rounded-xl bg-surface-subtle border border-border-subtle text-content-secondary hover:text-content-primary hover:border-brand/40 transition-colors" title="LinkedIn">
                            <x-ui.icon name="linkedin" class="w-4 h-4" />
                        </a>
                        <a href="mailto:admin@abaharlou.ir" class="p-2 rounded-xl bg-surface-subtle border border-border-subtle text-content-secondary hover:text-content-primary hover:border-brand/40 transition-colors" title="Email">
                            <x-ui.icon name="mail" class="w-4 h-4" />
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-semibold text-content-primary uppercase tracking-wider mb-4">بخش‌های سایت</h4>
                    <ul class="space-y-2 text-xs text-content-secondary">
                        <li><a href="{{ route('portfolio.index', ['locale' => app()->getLocale()]) }}" class="hover:text-brand transition-colors">نمونه‌کارها</a></li>
                        <li><a href="{{ route('services.index', ['locale' => app()->getLocale()]) }}" class="hover:text-brand transition-colors">خدمات تخصصی</a></li>
                        <li><a href="{{ route('resume.index', ['locale' => app()->getLocale()]) }}" class="hover:text-brand transition-colors">سوابق و مهارت‌ها</a></li>
                        <li><a href="{{ route('blog.index', ['locale' => app()->getLocale()]) }}" class="hover:text-brand transition-colors">مقالات و آموزش‌ها</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-semibold text-content-primary uppercase tracking-wider mb-4">ارتباط مستقیم</h4>
                    <p class="text-xs text-content-secondary leading-relaxed mb-3">
                        جهت مشاوره فنی یا سفارش پروژه اختصاصی از طریق بخش تماس یا ایمیل در ارتباط باشید.
                    </p>
                    <a href="{{ route('contact.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center gap-1.5 text-xs text-brand font-semibold hover:underline">
                        <span>ارسال پیام و استعلام</span>
                        <x-ui.icon name="arrow-left" class="w-3.5 h-3.5 rtl:block ltr:hidden" />
                        <x-ui.icon name="arrow-right" class="w-3.5 h-3.5 ltr:block rtl:hidden" />
                    </a>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-border-subtle/50 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-content-tertiary">
                <p>© {{ date('Y') }} امیرمحمد بحرلو (AMB). کلیه حقوق محفوظ است.</p>
                <p class="flex items-center gap-1 font-mono text-[11px]">
                    <span>Powered by Laravel 11 & Three.js</span>
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
