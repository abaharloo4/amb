# AMB Personal Portfolio

وب‌سایت شخصی و پلتفرم برند AMB (AmirMohammad Baharlou) برای **abaharlou.ir**: پورتفولیو، خدمات، وبلاگ، فرم درخواست همکاری، تخمین هزینه، رزرو جلسه و پنل مدیریت اختصاصی. دوزبانه (فارسی RTL و انگلیسی LTR)، با تم روشن و تاریک، هویت بصری مبتنی بر Three.js و GSAP.

## وضعیت پروژه

**Phase 0 (بررسی و مستندات)** در حال اتمام است. هنوز کدی از اپلیکیشن ساخته نشده است؛ دستورهای نصب و اجرای زیر از Phase 1 و Phase 3 به بعد فعال می‌شوند. وضعیت زنده در `roadmap.md` است.

## استک

| لایه | فناوری |
|---|---|
| Backend | PHP و Laravel (نسخه طبق ADR 12 و نتیجه probe)، MySQL/MariaDB |
| Frontend | Blade (Server-rendered)، Tailwind CSS، Alpine.js، Vite |
| 3D و حرکت | Three.js، GSAP، ScrollTrigger |
| ویرایشگر | TipTap (با Sanitizer سمت سرور) |
| نقش‌ها | `spatie/laravel-permission` |
| پیامک | ملی‌پیامک از طریق Adapter قابل تعویض |
| هاست هدف | پارس‌پک cPanel، بدون SSH و بدون Node در Production، با Cron |

## اصول

- Modular Monolith؛ بدون Microservices.
- Component-First: هیچ بخشی از صفر نوشته نمی‌شود؛ کامپوننت‌های `x-ui.*` و هسته CRUD مشترک.
- بدون ایموجی؛ فقط SVG از طریق `x-ui.icon`.
- Three.js و GSAP یک سیستم مستقل با بودجه عملکرد، Fallback و reduced-motion هستند.
- هیچ داده، قیمت یا ادعای ساختگی؛ محتوای نمایشی با برچسب Demo.

## مستندات

| فایل | محتوا |
|---|---|
| `prd.md` | نیازمندی‌ها و محدوده محصول |
| `architecture.md` | معماری، ADRها، ریسک‌ها |
| `database.md` | ساختار کامل دیتابیس |
| `design.md` | پالت، توکن‌ها، تایپوگرافی، کنتراست، تم‌ها |
| `components.md` | کتابخانه کامپوننت |
| `icons.md` | سیستم آیکون SVG |
| `motion.md` | حرکت، Three.js، GSAP، بودجه عملکرد |
| `guidelines.md` | استانداردهای کد، تست، Git |
| `security.md` | الزامات و چک‌لیست امنیتی |
| `deployment.md` | استقرار، به‌روزرسانی، Backup، Rollback |
| `roadmap.md` | فازها و وضعیت |
| `debug_log.md` | خطاها و علت‌ها |
| `AMB_Master_Prompt.md`, `AMB_Phase_Prompt_v2.md` | پرامپت‌های اجرایی |
| `probe.php` | ابزار موقت تشخیص هاست (پس از استفاده حذف شود) |

## ساختار مخزن (هدف)

```
app/Modules/*  app/Support  app/Admin/Crud
resources/{views,js,css,icons}
public/            تنها پوشه در معرض وب
database/          Migration، Factory، Seeder
scripts/           release، Sprite آیکون‌ها، Lint سفارشی
tests/
docs/              فایل‌های مستندات بالا
```

## تشخیص هاست (اکنون قابل اجرا)

1. در `probe.php` مقدار `PROBE_TOKEN` را به یک مقدار تصادفی حداقل 16 نویسه‌ای تغییر بده.
2. فایل را در یک مسیر موقت روی دامنه آپلود کن.
3. آدرس `https://DOMAIN/probe.php?token=TOKEN` را باز کن (برای JSON: `&format=json`). در صورت نیاز تست اختیاری دیتابیس را اجرا کن.
4. نتیجه را در `deployment.md` بخش 1 ثبت کن.
5. فایل را با دکمه Delete همان صفحه یا File Manager **حذف کن**.

## راه‌اندازی توسعه (از Phase 3)

> این دستورها هنوز اجرایی نیستند و پس از ساخت اپلیکیشن به‌روز می‌شوند.

```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm ci
npm run dev
```

دستورهای کیفیت: `composer lint`, `composer test`, `npm run lint`, `npm run icons`.

## Build و استقرار (خلاصه)

1. روی سیستم توسعه: `npm run release` (نصب وابستگی‌های production، Build، تست‌ها، audit، ساخت zip به‌همراه checksum).
2. آپلود zip روی هاست، ساخت `.env`، اجرای `/_install` (نصب) یا `/_update` (به‌روزرسانی) با توکن.
3. تنظیم Cron، SSL، تست دودی.
4. جزئیات، Backup و Rollback در `deployment.md`.

## مشارکت

- Branchها: `feat/*`, `fix/*`, `chore/*`, `docs/*`؛ Commit به‌صورت Conventional و بدون ایموجی.
- هرگز `.env`، کلید یا Secret را Commit نکن.
- قبل از Merge: تست‌ها، Lint، Policy، RTL/LTR، دو تم، reduced-motion و تعریف «انجام‌شده» در `guidelines.md`.

## مجوز

مالک پروژه تعیین می‌کند (فعلاً: همه حقوق محفوظ برای AMB). مجوز دارایی‌های شخص ثالث (فونت‌ها، آیکون‌ها) در `design.md` و `icons.md` ثبت می‌شود.
