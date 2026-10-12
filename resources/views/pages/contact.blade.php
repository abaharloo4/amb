@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    <!-- Header -->
    <div class="space-y-3" data-motion="scrollReveal">
        <x-ui.badge tone="brand" size="sm">ارتباط مستقیم و همکاری</x-ui.badge>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-heading tracking-tight">
            تماس و مشاوره فنی
        </h1>
        <p class="text-sm sm:text-base text-content-secondary leading-relaxed">
            جهت گفتگو درباره پروژه‌ها، مشاوره معماری یا بررسی امکان همکاری، فرم زیر را تکمیل کنید یا مستقیماً ایمیل ارسال نمایید.
        </p>
    </div>

    <!-- Contact Info Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" data-motion="scrollReveal">
        <x-ui.card class="p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-brand/10 text-brand flex items-center justify-center flex-shrink-0">
                <x-ui.icon name="mail" size="sm" />
            </div>
            <div class="overflow-hidden">
                <span class="text-[11px] text-content-secondary block">ایمیل مستقیم</span>
                <a href="mailto:admin@abaharlou.ir" class="text-xs font-bold text-content-heading hover:text-brand truncate block">admin@abaharlou.ir</a>
            </div>
        </x-ui.card>

        <x-ui.card class="p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-brand-accent/15 text-brand-accent flex items-center justify-center flex-shrink-0">
                <x-ui.icon name="github" size="sm" />
            </div>
            <div class="overflow-hidden">
                <span class="text-[11px] text-content-secondary block">گیت‌هاب</span>
                <a href="https://github.com/abaharloo4" target="_blank" rel="noopener noreferrer" class="text-xs font-bold text-content-heading hover:text-brand-accent truncate block">github.com/abaharloo4</a>
            </div>
        </x-ui.card>

        <x-ui.card class="p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-status-success/15 text-status-success flex items-center justify-center flex-shrink-0">
                <x-ui.icon name="clock" size="sm" />
            </div>
            <div>
                <span class="text-[11px] text-content-secondary block">زمان پاسخگویی</span>
                <span class="text-xs font-bold text-content-heading">کمتر از ۲۴ ساعت کاری</span>
            </div>
        </x-ui.card>
    </div>

    <!-- Contact Form Card -->
    <x-ui.card class="p-8 sm:p-10 shadow-sm" data-motion="scrollReveal">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-md bg-status-success/15 border border-status-success/30 text-status-success text-sm flex items-center gap-3">
                <x-ui.icon name="check-circle-2" size="sm" class="flex-shrink-0" />
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('contact.store', ['locale' => $locale]) }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-ui.field label="نام و نام خانوادگی" required="true" id="name">
                    <x-ui.input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required 
                        placeholder="مثال: علی رضایی"
                        iconLeading="users"
                    />
                </x-ui.field>

                <x-ui.field label="آدرس ایمیل" required="true" id="email">
                    <x-ui.input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        dir="ltr"
                        placeholder="name@company.com"
                        iconLeading="mail"
                    />
                </x-ui.field>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-ui.field label="شماره تماس (اختیاری)" id="phone">
                    <x-ui.input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        dir="ltr"
                        placeholder="0912..."
                        iconLeading="phone"
                    />
                </x-ui.field>

                <x-ui.field label="نوع همکاری مورد نظر" id="service_type">
                    <x-ui.select id="service_type" name="service_type">
                        <option value="custom_development">توسعه نرم‌افزار و وبسایت اختصاصی</option>
                        <option value="architecture_consulting">مشاوره معماری سیستم و دیتابیس</option>
                        <option value="threejs_creative">پیاده‌سازی Three.js و گرافیک تعاملی</option>
                        <option value="performance_optimization">بهینه‌سازی کارایی و امنیت</option>
                        <option value="other">سایر موارد</option>
                    </x-ui.select>
                </x-ui.field>
            </div>

            <x-ui.field label="موضوع پیام" required="true" id="subject">
                <x-ui.input 
                    type="text" 
                    id="subject" 
                    name="subject" 
                    required 
                    placeholder="عنوان خلاصه درخواست شما"
                    iconLeading="book-open"
                />
            </x-ui.field>

            <x-ui.field label="شرح درخواست و جزئیات پروژه" required="true" id="message">
                <textarea 
                    id="message" 
                    name="message" 
                    rows="6" 
                    required
                    placeholder="توضیحات مربوط به اهداف، نیازمندی‌ها یا ددلاین مدنظر خود را بنویسید..."
                    class="w-full bg-surface text-content-primary rounded-md p-3.5 text-sm border border-edge transition-all duration-fast placeholder:text-content-disabled focus:outline-none focus:ring-2 focus:ring-brand-accent/70 focus:border-brand-primary"
                ></textarea>
            </x-ui.field>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-edge">
                <span class="text-[11px] text-content-secondary flex items-center gap-1.5">
                    <x-ui.icon name="shield" size="xs" />
                    <span>اطلاعات شما کاملاً محرمانه نزد ما نگهداری می‌شود.</span>
                </span>

                <x-ui.button 
                    type="submit"
                    variant="accent"
                    size="lg"
                    iconTrailing="send"
                >
                    ارسال پیام و استعلام
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>
</div>
@endsection
