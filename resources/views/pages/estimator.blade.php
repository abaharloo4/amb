@extends('layouts.public')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12" x-data="estimator()">
    <!-- Header -->
    <div class="space-y-3" data-motion="scrollReveal">
        <x-ui.badge tone="accent" size="sm">ابزار تعاملی و محاسبه‌گر هوشمند</x-ui.badge>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-content-heading tracking-tight">
            برآورد هوشمند هزینه و مقیاس پروژه
        </h1>
        <p class="text-sm sm:text-base text-content-secondary leading-relaxed">
            مشخصات کلی پروژه و اهداف خود را انتخاب کنید تا محدوده برآورد بودجه و زمان‌بندی تخمینی را فوراً مشاهده نمایید.
        </p>
    </div>

    <!-- Estimator Interactive Form -->
    <x-ui.card class="p-8 sm:p-10 space-y-8" data-motion="scrollReveal">
        <!-- Step 1: Project Scope -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold text-content-heading flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-brand/10 text-brand flex items-center justify-center text-xs font-mono font-bold">۱</span>
                <span>نوع و دامنه محصول نرم‌افزاری</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label 
                    class="p-5 rounded-lg border cursor-pointer transition-all duration-fast flex items-start gap-3.5"
                    :class="projectType === 'mvp' ? 'border-brand bg-brand/10 shadow-sm ring-1 ring-brand' : 'border-edge bg-surface hover:bg-action-hover'"
                >
                    <input type="radio" name="project_type" value="mvp" x-model="projectType" class="mt-1 text-brand focus:ring-brand">
                    <div>
                        <span class="text-sm font-bold text-content-heading block">MVP / نسخه اولیه سریع</span>
                        <span class="text-xs text-content-secondary block mt-1 leading-relaxed">پیاده‌سازی هسته کلیدی محصول جهت ورود سریع به بازار و جذب سرمایه</span>
                    </div>
                </label>

                <label 
                    class="p-5 rounded-lg border cursor-pointer transition-all duration-fast flex items-start gap-3.5"
                    :class="projectType === 'full_system' ? 'border-brand bg-brand/10 shadow-sm ring-1 ring-brand' : 'border-edge bg-surface hover:bg-action-hover'"
                >
                    <input type="radio" name="project_type" value="full_system" x-model="projectType" class="mt-1 text-brand focus:ring-brand">
                    <div>
                        <span class="text-sm font-bold text-content-heading block">سامانه جامع تحت وب / پلتفرم مقیاس‌پذیر</span>
                        <span class="text-xs text-content-secondary block mt-1 leading-relaxed">معماری ماژولار، پنل مدیریت، درگاه‌ها، اتوماسیون داده و پایداری بالا</span>
                    </div>
                </label>

                <label 
                    class="p-5 rounded-lg border cursor-pointer transition-all duration-fast flex items-start gap-3.5"
                    :class="projectType === 'threejs_creative' ? 'border-brand bg-brand/10 shadow-sm ring-1 ring-brand' : 'border-edge bg-surface hover:bg-action-hover'"
                >
                    <input type="radio" name="project_type" value="threejs_creative" x-model="projectType" class="mt-1 text-brand focus:ring-brand">
                    <div>
                        <span class="text-sm font-bold text-content-heading block">رابط سه‌بعدی و تعاملی Three.js</span>
                        <span class="text-xs text-content-secondary block mt-1 leading-relaxed">طراحی صحنه‌های تعاملی سه‌بعدی شتاب‌یافته روی بستر وب و موبایل</span>
                    </div>
                </label>

                <label 
                    class="p-5 rounded-lg border cursor-pointer transition-all duration-fast flex items-start gap-3.5"
                    :class="projectType === 'performance_audit' ? 'border-brand bg-brand/10 shadow-sm ring-1 ring-brand' : 'border-edge bg-surface hover:bg-action-hover'"
                >
                    <input type="radio" name="project_type" value="performance_audit" x-model="projectType" class="mt-1 text-brand focus:ring-brand">
                    <div>
                        <span class="text-sm font-bold text-content-heading block">بهینه‌سازی کارایی و امنیت سیستم موجود</span>
                        <span class="text-xs text-content-secondary block mt-1 leading-relaxed">پروفایلینگ کد، بهینه‌سازی دیتابیس و کاهش هزینه‌های زیرساخت سرور</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- Step 2: Scale & Concurrency -->
        <div class="space-y-4 pt-4 border-t border-edge">
            <h3 class="text-sm font-bold text-content-heading flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-brand-secondary/20 text-brand-secondary flex items-center justify-center text-xs font-mono font-bold">۲</span>
                <span>مقیاس مخاطبان و حجم تراکنش</span>
            </h3>

            <div class="grid grid-cols-3 gap-3">
                <label 
                    class="p-4 rounded-md border text-center cursor-pointer transition-all duration-fast"
                    :class="scale === 'small' ? 'border-brand bg-brand/10 font-bold text-brand ring-1 ring-brand' : 'border-edge text-content-secondary hover:bg-action-hover'"
                >
                    <input type="radio" name="scale" value="small" x-model="scale" class="sr-only">
                    <span class="text-xs block font-bold">محدود / تا چند هزار کاربر</span>
                </label>

                <label 
                    class="p-4 rounded-md border text-center cursor-pointer transition-all duration-fast"
                    :class="scale === 'medium' ? 'border-brand bg-brand/10 font-bold text-brand ring-1 ring-brand' : 'border-edge text-content-secondary hover:bg-action-hover'"
                >
                    <input type="radio" name="scale" value="medium" x-model="scale" class="sr-only">
                    <span class="text-xs block font-bold">متوسط / تا ۵۰ هزار کاربر</span>
                </label>

                <label 
                    class="p-4 rounded-md border text-center cursor-pointer transition-all duration-fast"
                    :class="scale === 'enterprise' ? 'border-brand bg-brand/10 font-bold text-brand ring-1 ring-brand' : 'border-edge text-content-secondary hover:bg-action-hover'"
                >
                    <input type="radio" name="scale" value="enterprise" x-model="scale" class="sr-only">
                    <span class="text-xs block font-bold">سازمانی / بار ترافیکی بالا</span>
                </label>
            </div>
        </div>

        <!-- Step 3: Timeline Urgency -->
        <div class="space-y-4 pt-4 border-t border-edge">
            <h3 class="text-sm font-bold text-content-heading flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-brand-accent/20 text-brand-accent flex items-center justify-center text-xs font-mono font-bold">۳</span>
                <span>اولویت زمان‌بندی تحویل</span>
            </h3>

            <div class="grid grid-cols-3 gap-3">
                <label 
                    class="p-4 rounded-md border text-center cursor-pointer transition-all duration-fast"
                    :class="timeline === 'relaxed' ? 'border-brand bg-brand/10 font-bold text-brand ring-1 ring-brand' : 'border-edge text-content-secondary hover:bg-action-hover'"
                >
                    <input type="radio" name="timeline" value="relaxed" x-model="timeline" class="sr-only">
                    <span class="text-xs block font-bold">عادی و گام‌به‌گام</span>
                </label>

                <label 
                    class="p-4 rounded-md border text-center cursor-pointer transition-all duration-fast"
                    :class="timeline === 'standard' ? 'border-brand bg-brand/10 font-bold text-brand ring-1 ring-brand' : 'border-edge text-content-secondary hover:bg-action-hover'"
                >
                    <input type="radio" name="timeline" value="standard" x-model="timeline" class="sr-only">
                    <span class="text-xs block font-bold">استاندارد</span>
                </label>

                <label 
                    class="p-4 rounded-md border text-center cursor-pointer transition-all duration-fast"
                    :class="timeline === 'rush' ? 'border-brand bg-brand/10 font-bold text-brand ring-1 ring-brand' : 'border-edge text-content-secondary hover:bg-action-hover'"
                >
                    <input type="radio" name="timeline" value="rush" x-model="timeline" class="sr-only">
                    <span class="text-xs block font-bold">فوری / اسپرینت فشرده</span>
                </label>
            </div>
        </div>

        <!-- Estimate Result Box -->
        <div class="p-6 sm:p-8 rounded-lg bg-gradient-to-r from-brand/10 via-surface to-brand-secondary/15 border border-brand/30 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-1">
                <span class="text-xs font-semibold text-content-secondary block">برآورد بازه سرمایه‌گذاری مورد نیاز:</span>
                <div class="text-2xl sm:text-3xl font-extrabold text-content-heading font-mono flex items-baseline gap-2">
                    <span x-text="minPrice">۲۵</span>
                    <span class="text-content-secondary text-lg font-sans">تا</span>
                    <span x-text="maxPrice">۳۵</span>
                    <span class="text-sm font-sans text-brand font-bold">میلیون تومان</span>
                </div>
                <span class="text-[11px] text-content-secondary block">
                    * برآورد فوق تخمینی است و قیمت قطعی پس از جلسه بررسی نیازمندی‌ها نهایی می‌گردد.
                </span>
            </div>

            <x-ui.button 
                as="a" 
                href="{{ route('contact.index', ['locale' => $locale]) }}"
                variant="accent"
                size="lg"
                iconTrailing="arrow-left"
                class="whitespace-nowrap"
            >
                ثبت سفارش با این برآورد
            </x-ui.button>
        </div>
    </x-ui.card>
</div>
@endsection

@push('scripts')
<script>
    function estimator() {
        return {
            projectType: 'mvp',
            scale: 'small',
            timeline: 'standard',
            minPrice: 22,
            maxPrice: 30,

            init() {
                this.$watch('projectType', () => this.recalc());
                this.$watch('scale', () => this.recalc());
                this.$watch('timeline', () => this.recalc());
                this.recalc();
            },

            recalc() {
                const baseMap = { mvp: 25, full_system: 55, threejs_creative: 40, performance_audit: 15 };
                const scaleMap = { small: 1.0, medium: 1.5, enterprise: 2.3 };
                const timeMap = { relaxed: 0.9, standard: 1.0, rush: 1.3 };

                const base = baseMap[this.projectType] || 25;
                const total = base * (scaleMap[this.scale] || 1) * (timeMap[this.timeline] || 1);

                this.minPrice = Math.round(total * 0.9);
                this.maxPrice = Math.round(total * 1.2);
            }
        };
    }
</script>
@endpush
