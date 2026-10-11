@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">
    <!-- Header -->
    <div class="space-y-3">
        <span class="text-xs font-bold text-brand uppercase tracking-wider">ارتباط و همکاری</span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-primary tracking-tight">
            تماس و مشاوره فنی
        </h1>
        <p class="text-sm sm:text-base text-content-secondary leading-relaxed">
            جهت گفتگو درباره پروژه‌ها، مشاوره معماری یا بررسی امکان همکاری، فرم زیر را تکمیل کنید یا مستقیماً ایمیل ارسال نمایید.
        </p>
    </div>

    <!-- Contact Info Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-5 rounded-2xl bg-surface-card border border-border-subtle flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-brand/10 text-brand flex items-center justify-center flex-shrink-0">
                <x-ui.icon name="mail" class="w-5 h-5" />
            </div>
            <div class="overflow-hidden">
                <span class="text-[11px] text-content-tertiary block">ایمیل مستقیم</span>
                <a href="mailto:admin@abaharlou.ir" class="text-xs font-bold text-content-primary hover:text-brand truncate block">admin@abaharlou.ir</a>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-surface-card border border-border-subtle flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-accent/10 text-accent flex items-center justify-center flex-shrink-0">
                <x-ui.icon name="github" class="w-5 h-5" />
            </div>
            <div class="overflow-hidden">
                <span class="text-[11px] text-content-tertiary block">گیت‌هاب</span>
                <a href="https://github.com/abaharloo4" target="_blank" rel="noopener noreferrer" class="text-xs font-bold text-content-primary hover:text-accent truncate block">github.com/abaharloo4</a>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-surface-card border border-border-subtle flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-success/10 text-success flex items-center justify-center flex-shrink-0">
                <x-ui.icon name="clock" class="w-5 h-5" />
            </div>
            <div>
                <span class="text-[11px] text-content-tertiary block">زمان پاسخگویی</span>
                <span class="text-xs font-bold text-content-primary">کمتر از ۲۴ ساعت کاری</span>
            </div>
        </div>
    </div>

    <!-- Contact Form Card -->
    <div class="p-8 rounded-3xl bg-surface-card border border-border-subtle shadow-sm">
        @if (session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-success/10 border border-success/20 text-success text-sm flex items-center gap-3">
                <x-ui.icon name="check-circle" class="w-5 h-5 flex-shrink-0" />
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('contact.store', ['locale' => $locale]) }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-xs font-semibold text-content-secondary mb-1.5">
                        نام و نام خانوادگی <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required 
                        placeholder="مثال: علی رضایی"
                        class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-3 text-sm outline-none"
                    />
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-content-secondary mb-1.5">
                        آدرس ایمیل <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        dir="ltr"
                        placeholder="name@company.com"
                        class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-3 text-sm outline-none"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="phone" class="block text-xs font-semibold text-content-secondary mb-1.5">
                        شماره تماس (اختیاری)
                    </label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        dir="ltr"
                        placeholder="0912..."
                        class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-3 text-sm outline-none"
                    />
                </div>

                <div>
                    <label for="service_type" class="block text-xs font-semibold text-content-secondary mb-1.5">
                        نوع همکاری مورد نظر
                    </label>
                    <select 
                        id="service_type" 
                        name="service_type" 
                        class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-3 text-sm outline-none"
                    >
                        <option value="custom_development">توسعه نرم‌افزار و وبسایت اختصاصی</option>
                        <option value="architecture_consulting">مشاوره معماری سیستم و دیتابیس</option>
                        <option value="threejs_creative">پیاده‌سازی Three.js و گرافیک تعاملی</option>
                        <option value="performance_optimization">بهینه‌سازی کارایی و امنیت</option>
                        <option value="other">سایر موارد</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="subject" class="block text-xs font-semibold text-content-secondary mb-1.5">
                    موضوع پیام <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    id="subject" 
                    name="subject" 
                    required 
                    placeholder="عنوان خلاصه درخواست شما"
                    class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-3 text-sm outline-none"
                />
            </div>

            <div>
                <label for="message" class="block text-xs font-semibold text-content-secondary mb-1.5">
                    شرح درخواست و جزئیات پروژه <span class="text-danger">*</span>
                </label>
                <textarea 
                    id="message" 
                    name="message" 
                    rows="6" 
                    required
                    placeholder="توضیحات مربوط به اهداف، نیازمندی‌ها یا ددلاین مدنظر خود را بنویسید..."
                    class="w-full rounded-xl bg-surface-subtle border border-border-subtle focus:border-brand focus:ring-1 focus:ring-brand text-content-primary p-3 text-sm outline-none"
                ></textarea>
            </div>

            <div class="flex items-center justify-between pt-4">
                <span class="text-[11px] text-content-tertiary">
                    اطلاعات شما کاملاً محرمانه نزد ما نگهداری می‌شود.
                </span>

                <button 
                    type="submit"
                    class="px-8 py-3 rounded-xl bg-gradient-to-r from-brand to-brand-glow text-white font-semibold text-sm shadow-glow hover:opacity-95 active:scale-95 transition-all flex items-center gap-2"
                >
                    <x-ui.icon name="send" class="w-4 h-4" />
                    <span>ارسال پیام</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
