<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMB Component Library — Catalog (/_ui)</title>

    <!-- Zero-Flash Theme Script -->
    <script>
        (function() {
            const stored = localStorage.getItem('amb_theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = stored || (prefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-primary text-content-primary antialiased transition-colors duration-normal">
    <!-- Global SVG Sprite -->
    <x-ui.sprite />

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 bg-surface/80 backdrop-blur-md border-b border-edge transition-colors duration-normal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <x-ui.logotype size="md" />
                <span class="text-xs px-2 py-0.5 rounded-full bg-brand/10 text-brand font-medium">Design System v1.0</span>
            </div>

            <div class="flex items-center gap-3">
                <x-ui.lang-toggle />
                <x-ui.theme-toggle />
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">

        <!-- Intro -->
        <section class="space-y-4" data-motion="reveal">
            <div class="inline-flex items-center gap-2">
                <x-ui.badge tone="accent" size="sm">Phase 1 Delivery</x-ui.badge>
                <x-ui.badge tone="brand" size="sm">Component-First Architecture</x-ui.badge>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-content-heading">کاتالوگ کامپوننت‌های اختصاصی AMB</h1>
            <p class="text-base text-content-secondary max-w-3xl leading-relaxed">
                این صفحه برای بازبینی زنده تمام کامپوننت‌های پایه (Primitives)، توکن‌های طراحی، کنتراست رنگی، پشتیبانی هم‌زمان از تم تاریک/روشن و هر دو جهت RTL (فارسی) و LTR (انگلیسی) ایجاد شده است.
            </p>
        </section>

        <!-- Section 1: Color Tokens -->
        <section class="space-y-6" data-motion="reveal">
            <div class="border-b border-edge pb-3">
                <h2 class="text-xl font-bold text-content-heading">۱. پالت رسمی برند و توکن‌های معنایی</h2>
                <p class="text-xs text-content-secondary mt-1">ترکیب رنگی Deep Teal، Stormy Teal، Golden Orange و سطوح تم تاریک و روشن</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="p-4 rounded-lg bg-[#18424E] text-white shadow-sm flex flex-col justify-between h-28">
                    <span class="text-xs font-semibold">Deep Teal</span>
                    <span class="font-mono text-[11px] opacity-80">#18424E (Brand Primary)</span>
                </div>
                <div class="p-4 rounded-lg bg-[#29665F] text-white shadow-sm flex flex-col justify-between h-28">
                    <span class="text-xs font-semibold">Stormy Teal</span>
                    <span class="font-mono text-[11px] opacity-80">#29665F (Secondary)</span>
                </div>
                <div class="p-4 rounded-lg bg-[#F49D07] text-[#1F1F1F] shadow-sm flex flex-col justify-between h-28">
                    <span class="text-xs font-bold">Golden Orange</span>
                    <span class="font-mono text-[11px] font-semibold">#F49D07 (Accent Signature)</span>
                </div>
                <div class="p-4 rounded-lg bg-[#1F1F1F] text-white border border-edge shadow-sm flex flex-col justify-between h-28">
                    <span class="text-xs font-semibold">Carbon Black</span>
                    <span class="font-mono text-[11px] opacity-80">#1F1F1F (Dark Surface)</span>
                </div>
                <div class="p-4 rounded-lg bg-[#F4F7F6] text-[#1F1F1F] border border-edge shadow-sm flex flex-col justify-between h-28">
                    <span class="text-xs font-semibold">Mist White</span>
                    <span class="font-mono text-[11px] opacity-80">#F4F7F6 (Light Surface)</span>
                </div>
                <div class="p-4 rounded-lg bg-[#BABABA] text-[#1F1F1F] shadow-sm flex flex-col justify-between h-28">
                    <span class="text-xs font-semibold">Silver</span>
                    <span class="font-mono text-[11px] opacity-80">#BABABA (Neutral)</span>
                </div>
            </div>

            <!-- Status Colors -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-2">
                <div class="p-3 rounded-md bg-status-success/15 border border-status-success/30 text-status-success text-xs font-semibold flex items-center gap-2">
                    <x-ui.icon name="check-circle-2" size="sm" />
                    <span>Success State</span>
                </div>
                <div class="p-3 rounded-md bg-status-warning/15 border border-status-warning/30 text-status-warning text-xs font-semibold flex items-center gap-2">
                    <x-ui.icon name="alert-triangle" size="sm" />
                    <span>Warning State</span>
                </div>
                <div class="p-3 rounded-md bg-status-error/15 border border-status-error/30 text-status-error text-xs font-semibold flex items-center gap-2">
                    <x-ui.icon name="x-circle" size="sm" />
                    <span>Error State</span>
                </div>
                <div class="p-3 rounded-md bg-status-info/15 border border-status-info/30 text-status-info text-xs font-semibold flex items-center gap-2">
                    <x-ui.icon name="info" size="sm" />
                    <span>Info State</span>
                </div>
            </div>
        </section>

        <!-- Section 2: Buttons -->
        <section class="space-y-6" data-motion="reveal">
            <div class="border-b border-edge pb-3">
                <h2 class="text-xl font-bold text-content-heading">۲. دکمه‌ها (Button Primitives)</h2>
                <p class="text-xs text-content-secondary mt-1">انواع variant، اندازه و حالت‌های تعاملی بدون تکرار کد مارکاپ</p>
            </div>

            <x-ui.card class="p-6 space-y-6">
                <!-- Variants -->
                <div class="space-y-2">
                    <span class="text-xs font-semibold text-content-secondary uppercase tracking-wider block">Variants</span>
                    <div class="flex flex-wrap items-center gap-3">
                        <x-ui.button variant="primary">دکمه اصلی (Primary)</x-ui.button>
                        <x-ui.button variant="accent" iconTrailing="arrow-right">امضای برند (Accent)</x-ui.button>
                        <x-ui.button variant="secondary">دکمه ثانویه (Secondary)</x-ui.button>
                        <x-ui.button variant="outline">خطی (Outline)</x-ui.button>
                        <x-ui.button variant="ghost">شفاف (Ghost)</x-ui.button>
                        <x-ui.button variant="danger" iconLeading="trash-2">حذف (Danger)</x-ui.button>
                    </div>
                </div>

                <!-- Sizes -->
                <div class="space-y-2 pt-2 border-t border-edge">
                    <span class="text-xs font-semibold text-content-secondary uppercase tracking-wider block">Sizes</span>
                    <div class="flex flex-wrap items-center gap-3">
                        <x-ui.button variant="primary" size="sm">کوچک (sm)</x-ui.button>
                        <x-ui.button variant="primary" size="md">استاندارد (md)</x-ui.button>
                        <x-ui.button variant="primary" size="lg">بزرگ (lg)</x-ui.button>
                    </div>
                </div>

                <!-- States -->
                <div class="space-y-2 pt-2 border-t border-edge">
                    <span class="text-xs font-semibold text-content-secondary uppercase tracking-wider block">States</span>
                    <div class="flex flex-wrap items-center gap-3">
                        <x-ui.button variant="primary" loading="true">در حال بارگذاری</x-ui.button>
                        <x-ui.button variant="accent" loading="true">در حال ارسال</x-ui.button>
                        <x-ui.button variant="primary" disabled="true">غیرفعال (Disabled)</x-ui.button>
                        <x-ui.button variant="outline" disabled="true">غیرفعال (Disabled)</x-ui.button>
                    </div>
                </div>
            </x-ui.card>
        </section>

        <!-- Section 3: Badges & Chips -->
        <section class="space-y-6" data-motion="reveal">
            <div class="border-b border-edge pb-3">
                <h2 class="text-xl font-bold text-content-heading">۳. بج‌ها و برچسب‌ها (Badges & Chips)</h2>
                <p class="text-xs text-content-secondary mt-1">جهت دسته‌بندی‌ها، تگ‌های تکنولوژی و وضعیت‌ها</p>
            </div>

            <x-ui.card class="p-6">
                <div class="flex flex-wrap items-center gap-3">
                    <x-ui.badge tone="neutral">خنثی (Neutral)</x-ui.badge>
                    <x-ui.badge tone="brand" icon="layers">هویت برند (Brand)</x-ui.badge>
                    <x-ui.badge tone="accent" icon="star">برجسته (Accent)</x-ui.badge>
                    <x-ui.badge tone="success" icon="check-circle-2">تأیید شده (Success)</x-ui.badge>
                    <x-ui.badge tone="warning" icon="alert-triangle">در انتظار (Warning)</x-ui.badge>
                    <x-ui.badge tone="error" icon="x-circle">رد شده (Error)</x-ui.badge>
                    <x-ui.badge tone="info" icon="info">اطلاعیه (Info)</x-ui.badge>
                </div>
            </x-ui.card>
        </section>

        <!-- Section 4: Cards & Surfaces -->
        <section class="space-y-6" data-motion="reveal">
            <div class="border-b border-edge pb-3">
                <h2 class="text-xl font-bold text-content-heading">۴. کارت‌ها و سطوح (Cards)</h2>
                <p class="text-xs text-content-secondary mt-1">سطوح استاندارد با عمق و تعامل هاور بهینه</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-ui.card variant="default" class="p-6 space-y-3">
                    <x-ui.badge tone="brand" size="sm">کارت پایه (Default)</x-ui.badge>
                    <h3 class="text-lg font-bold text-content-heading">سطح پیش‌فرض</h3>
                    <p class="text-sm text-content-secondary">مناسب برای نمایش اطلاعات پایدار، مقالات و آیتم‌های استاندارد وبلاگ و داشبورد.</p>
                </x-ui.card>

                <x-ui.card variant="elevated" class="p-6 space-y-3">
                    <x-ui.badge tone="accent" size="sm">کارت شناور (Elevated)</x-ui.badge>
                    <h3 class="text-lg font-bold text-content-heading">سطح متمایز</h3>
                    <p class="text-sm text-content-secondary">دارای سایه و کادر تقویت‌شده برای بخش‌های کلیدی، پیشنهادات ویژه و فرم‌ها.</p>
                </x-ui.card>

                <x-ui.card variant="default" interactive="true" class="p-6 space-y-3">
                    <x-ui.badge tone="success" size="sm">تعاملی (Interactive)</x-ui.badge>
                    <h3 class="text-lg font-bold text-content-heading">کارت تعاملی با هاور</h3>
                    <p class="text-sm text-content-secondary">دارای افکت حرکت ملایم عمودی و تقویت کادر با نشانگر ماوس، ایده‌آل برای نمونه‌کارها.</p>
                </x-ui.card>
            </div>
        </section>

        <!-- Section 5: Form Fields -->
        <section class="space-y-6" data-motion="reveal">
            <div class="border-b border-edge pb-3">
                <h2 class="text-xl font-bold text-content-heading">۵. فیلدهای ورودی فرم (Form Inputs)</h2>
                <p class="text-xs text-content-secondary mt-1">فیلدها با پشتیبانی از آیکون شروع/پایان، راهنما و وضعیت خطا</p>
            </div>

            <x-ui.card class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-ui.field label="نام و نام خانوادگی" required="true" hint="نام کامل خود را وارد کنید">
                        <x-ui.input placeholder="امیرمحمد بهارلو" iconLeading="user" />
                    </x-ui.field>

                    <x-ui.field label="آدرس ایمیل" required="true">
                        <x-ui.input type="email" placeholder="mail@example.com" iconLeading="mail" />
                    </x-ui.field>

                    <x-ui.field label="فیلد با وضعیت خطا" error="فرمت شماره تماس نامعتبر است">
                        <x-ui.input value="0912000" invalid="true" iconLeading="phone" />
                    </x-ui.field>

                    <x-ui.field label="انتخاب نوع خدمت">
                        <x-ui.select>
                            <option>توسعه وب فول‌استک اختصاصی</option>
                            <option>معماری نرم‌افزار و بازطراحی</option>
                            <option>رابط کاربری تعاملی سه‌بعدی</option>
                        </x-ui.select>
                    </x-ui.field>
                </div>
            </x-ui.card>
        </section>

        <!-- Section 6: Overlays & Modals -->
        <section class="space-y-6" data-motion="reveal">
            <div class="border-b border-edge pb-3">
                <h2 class="text-xl font-bold text-content-heading">۶. دیالوگ و پوشش‌ها (Modal & Skeleton)</h2>
                <p class="text-xs text-content-secondary mt-1">پوشش‌های قابل دسترسی با قفل فوکوس و بستن با کلید Escape</p>
            </div>

            <x-ui.card class="p-6 flex flex-wrap items-center justify-between gap-6">
                <div class="space-y-2">
                    <h3 class="text-base font-bold text-content-heading">تست مودال تعاملی</h3>
                    <p class="text-xs text-content-secondary">بر روی دکمه کلیک کنید تا عملکرد دیالوگ را بررسی نمایید.</p>
                </div>

                <div x-data>
                    <x-ui.button variant="accent" x-on:click="$dispatch('open-modal', 'demo-modal')">
                        باز کردن مودال آزمایشی
                    </x-ui.button>
                </div>

                <!-- Modal Instance -->
                <x-ui.modal name="demo-modal" title="تأییدیه عملیات">
                    <div class="space-y-4">
                        <p class="text-sm text-content-secondary leading-relaxed">
                            این یک مودال استاندارد مبتنی بر کتابخانه کامپوننت AMB است. این کامپوننت کلید Escape را شنود می‌کند، فوکوس را محبوس می‌نماید و با پس‌زمینه محو شیشه‌ای هماهنگ است.
                        </p>
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-edge" x-data>
                            <x-ui.button variant="ghost" x-on:click="$dispatch('close-modal', 'demo-modal')">انصراف</x-ui.button>
                            <x-ui.button variant="primary" x-on:click="$dispatch('close-modal', 'demo-modal')">تأیید و ذخیره</x-ui.button>
                        </div>
                    </div>
                </x-ui.modal>
            </x-ui.card>

            <!-- Skeleton loading states -->
            <x-ui.card class="p-6 space-y-4">
                <span class="text-xs font-semibold text-content-secondary uppercase tracking-wider block">حالت‌های اسکلتون لودینگ (Skeleton)</span>
                <div class="space-y-3">
                    <x-ui.skeleton shape="heading" />
                    <x-ui.skeleton shape="text" class="w-full" />
                    <x-ui.skeleton shape="text" class="w-4/5" />
                    <div class="flex items-center gap-3 pt-2">
                        <x-ui.skeleton shape="avatar" />
                        <div class="space-y-1.5 flex-1">
                            <x-ui.skeleton shape="text" class="w-1/3" />
                            <x-ui.skeleton shape="text" class="w-1/4" />
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </section>

        <!-- Section 7: Motion Presets (GSAP) -->
        <section class="space-y-6">
            <div class="border-b border-edge pb-3">
                <h2 class="text-xl font-bold text-content-heading">۷. زیربنای انیمیشن و موشن (GSAP Presets)</h2>
                <p class="text-xs text-content-secondary mt-1">تست انیمیشن‌های خودکار شمارنده، ظهور با افکت و هماهنگی RTL</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <x-ui.card class="p-6 text-center space-y-2">
                    <div class="text-3xl font-extrabold text-brand-accent font-mono" data-motion="counter" data-counter-target="100">0</div>
                    <span class="text-xs text-content-secondary font-medium">پروژه موفق پیاده‌سازی‌شده</span>
                </x-ui.card>

                <x-ui.card class="p-6 text-center space-y-2">
                    <div class="text-3xl font-extrabold text-brand-primary dark:text-brand-accent font-mono" data-motion="counter" data-counter-target="12">0</div>
                    <span class="text-xs text-content-secondary font-medium">سال تجربه مهندسی نرم‌افزار</span>
                </x-ui.card>

                <x-ui.card class="p-6 text-center space-y-2">
                    <div class="text-3xl font-extrabold text-brand-secondary dark:text-brand-accent font-mono" data-motion="counter" data-counter-target="99">0</div>
                    <span class="text-xs text-content-secondary font-medium">درصد رضایت و پایداری عملکرد</span>
                </x-ui.card>
            </div>
        </section>

        <!-- Section 8: Icon System Preview -->
        <section class="space-y-6" data-motion="reveal">
            <div class="border-b border-edge pb-3">
                <h2 class="text-xl font-bold text-content-heading">۸. سیستم آیکون‌های SVG (بدون ایموجی)</h2>
                <p class="text-xs text-content-secondary mt-1">رندر شده از طریق SVG Sprite محلی، با گرید ۲۴ و وارونه‌سازی خودکار در RTL</p>
            </div>

            <x-ui.card class="p-6">
                <div class="grid grid-cols-4 sm:grid-cols-8 md:grid-cols-12 gap-4 text-center">
                    @foreach (['home', 'code', 'layers', 'cpu', 'box', 'rocket', 'shield', 'activity', 'award', 'briefcase', 'calendar', 'clock', 'mail', 'phone', 'globe', 'star', 'pencil', 'trash-2', 'save', 'filter', 'check-circle-2', 'alert-triangle', 'github', 'linkedin', 'telegram', 'instagram', 'arrow-right', 'arrow-up-right'] as $iconName)
                        <div class="p-3 rounded-lg border border-edge hover:bg-action-hover transition-colors flex flex-col items-center gap-2">
                            <x-ui.icon :name="$iconName" size="md" class="text-brand-accent" />
                            <span class="text-[10px] text-content-secondary font-mono truncate w-full">{{ $iconName }}</span>
                        </div>
                    @endforeach
                </div>
            </x-ui.card>
        </section>

        <!-- Section 9: Phase 2 Three.js Hero Laboratory -->
        <section class="space-y-6" x-data="heroLab">
            <div class="border-b border-edge pb-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 mb-1">
                        <span class="inline-block w-2 h-2 rounded-full bg-status-success animate-ping"></span>
                        <x-ui.badge tone="accent" size="sm">Phase 2 Three.js Lab</x-ui.badge>
                    </div>
                    <h2 class="text-xl font-bold text-content-heading">۹. آزمایشگاه Three.js و جهت‌های بصری Hero</h2>
                    <p class="text-xs text-content-secondary mt-1">تست تعاملی سه جهت پیشنهادی (A، B، C)، سطوح کیفیت سخت‌افزاری و مانیتورینگ زنده فریم‌ریت (FPS)</p>
                </div>

                <!-- Live Performance HUD -->
                <div class="flex items-center gap-3 bg-surface border border-edge px-3.5 py-1.5 rounded-lg shadow-sm">
                    <div class="flex items-center gap-1.5 font-mono text-xs">
                        <span class="text-content-secondary">FPS:</span>
                        <span class="font-bold" :class="fps >= 50 ? 'text-status-success' : (fps >= 30 ? 'text-status-warning' : 'text-status-error')" x-text="fps">60</span>
                    </div>
                    <span class="text-edge">|</span>
                    <div class="text-[11px] font-mono text-content-secondary">
                        <span x-text="'Direction ' + direction"></span> &bull;
                        <span x-text="tier.toUpperCase()"></span>
                    </div>
                </div>
            </div>

            <!-- Controls Toolbar -->
            <div class="flex flex-wrap items-center justify-between gap-4 bg-surface p-4 rounded-lg border border-edge">
                <!-- Direction Buttons -->
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-semibold text-content-secondary ms-1">جهت بصری:</span>
                    <button
                        type="button"
                        x-on:click="setDirection('Hybrid')"
                        :class="direction === 'Hybrid' ? 'bg-brand-accent text-[#1F1F1F] font-bold shadow-sm ring-2 ring-brand-accent/50' : 'bg-action-hover text-content-primary hover:bg-edge'"
                        class="px-3 py-1.5 rounded-md text-xs transition-all cursor-pointer"
                    >
                        ترکیبی: Signal Lattice + Orbital Core (پیشنهاد معمار)
                    </button>
                    <button
                        type="button"
                        x-on:click="setDirection('A')"
                        :class="direction === 'A' ? 'bg-brand-accent text-[#1F1F1F] font-bold shadow-sm' : 'bg-action-hover text-content-primary hover:bg-edge'"
                        class="px-3 py-1.5 rounded-md text-xs transition-all cursor-pointer"
                    >
                        جهت A: Lattice
                    </button>
                    <button
                        type="button"
                        x-on:click="setDirection('B')"
                        :class="direction === 'B' ? 'bg-brand-accent text-[#1F1F1F] font-bold shadow-sm' : 'bg-action-hover text-content-primary hover:bg-edge'"
                        class="px-3 py-1.5 rounded-md text-xs transition-all cursor-pointer"
                    >
                        جهت B: Orbital
                    </button>
                    <button
                        type="button"
                        x-on:click="setDirection('C')"
                        :class="direction === 'C' ? 'bg-brand-accent text-[#1F1F1F] font-bold shadow-sm' : 'bg-action-hover text-content-primary hover:bg-edge'"
                        class="px-3 py-1.5 rounded-md text-xs transition-all cursor-pointer"
                    >
                        جهت C: Terrain
                    </button>
                </div>

                <!-- Quality Tiers -->
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-content-secondary">سطح کیفیت:</span>
                    <button
                        type="button"
                        x-on:click="setTier('high')"
                        :class="tier === 'high' ? 'bg-brand text-white font-semibold' : 'text-content-secondary hover:text-content-primary'"
                        class="px-2.5 py-1 rounded text-xs transition-all cursor-pointer"
                    >
                        High
                    </button>
                    <button
                        type="button"
                        x-on:click="setTier('medium')"
                        :class="tier === 'medium' ? 'bg-brand text-white font-semibold' : 'text-content-secondary hover:text-content-primary'"
                        class="px-2.5 py-1 rounded text-xs transition-all cursor-pointer"
                    >
                        Medium
                    </button>
                    <button
                        type="button"
                        x-on:click="setTier('low')"
                        :class="tier === 'low' ? 'bg-brand text-white font-semibold' : 'text-content-secondary hover:text-content-primary'"
                        class="px-2.5 py-1 rounded text-xs transition-all cursor-pointer"
                    >
                        Low
                    </button>
                    <button
                        type="button"
                        x-on:click="setTier('static')"
                        :class="tier === 'static' ? 'bg-brand text-white font-semibold' : 'text-content-secondary hover:text-content-primary'"
                        class="px-2.5 py-1 rounded text-xs transition-all cursor-pointer"
                    >
                        Static Fallback
                    </button>
                </div>
            </div>

            <!-- Interactive 3D Canvas Showcase with HTML Overlay -->
            <div class="relative w-full h-[520px] rounded-xl overflow-hidden border border-edge bg-[#1F1F1F] shadow-2xl">
                <!-- Three.js Canvas Container -->
                <div x-ref="canvasContainer" class="absolute inset-0 w-full h-full"></div>

                <!-- Realistic HTML Hero Overlay (To test typography readability over 3D scenes) -->
                <div class="absolute inset-0 pointer-events-none flex flex-col justify-center items-center text-center p-6 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                    <div class="pointer-events-auto space-y-4 max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand/30 border border-brand-accent/40 backdrop-blur-md text-white text-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-accent animate-ping"></span>
                            <span>خلاقیت بصری و مهندسی سیستم‌ها</span>
                        </div>

                        <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight drop-shadow-md">
                            امیرمحمد بهارلو
                        </h2>

                        <p class="text-sm sm:text-base text-gray-200 drop-shadow leading-relaxed">
                            توسعه‌دهنده فول‌استک و معمار نرم‌افزار؛ خلق پلتفرم‌های مقیاس‌پذیر و تجربیات وب سه‌بعدی و تعاملی
                        </p>

                        <div class="flex items-center justify-center gap-3 pt-2">
                            <x-ui.button variant="accent" iconTrailing="arrow-right">
                                شروع همکاری
                            </x-ui.button>
                            <x-ui.button variant="outline" class="text-white border-white/30 hover:bg-white/10 backdrop-blur-md">
                                مشاهده نمونه‌کارها
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="mt-20 border-t border-edge py-8 bg-surface transition-colors duration-normal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <x-ui.logotype size="sm" />
            <span class="text-xs text-content-secondary font-mono">AMB Personal Platform &bull; Phase 1 Verified</span>
        </div>
    </footer>
</body>
</html>
