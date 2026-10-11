# Component Library — AMB

وضعیت: پیش‌نویس Phase 0 | نسخه: 0.1
هدف: هیچ بخشی از صفر کدنویسی نشود؛ بخش‌های مشابه در سایت و پنل ظاهر و رفتار یکسان داشته باشند.

## 1. قراردادها

- Blade Anonymous Components در `resources/views/components/ui/*`؛ فراخوانی: `<x-ui.button variant="accent" size="md">`.
- تغییر ظاهر فقط با props: `variant`, `size`, `tone`, `state`, `as`، و `class` برای ادغام استثنایی (ادغام امن کلاس‌ها).
- هیچ رنگ، فاصله یا `style=""` hardcode نیست؛ فقط توکن‌ها (`design.md`).
- آیکون فقط با `<x-ui.icon>` (`icons.md`).
- حرکت با قلاب‌های `data-motion` (`motion.md`)؛ کامپوننت‌ها خودشان GSAP را مستقیم صدا نمی‌زنند.
- رفتار تعاملی با Alpine Data modules مشترک (`dropdown`, `modal`, `tabs`, `disclosure`, `multiStepForm`, `filterBar`, `tooltip` و غیره) نه کد تکراری.
- هر کامپوننت: props مستند، حالت‌ها، دسترسی‌پذیری، رفتار RTL، رفتار تم، قلاب حرکتی.
- سایت عمومی و پنل از همان Primitives استفاده می‌کنند؛ فقط Patterns مخصوص پنل جدا هستند.
- پیش از ساخت هر المان جدید، این فهرست و کاتالوگ `/_ui` بررسی شود؛ اگر مشابه هست، گسترش داده شود.

## 2. لایه Primitives

| کامپوننت | Variant / Props کلیدی | نکات |
|---|---|---|
| `button` | variant: primary، accent، secondary، ghost، danger؛ size: sm، md، lg؛ loading، disabled، iconOnly، as=a | روی accent متن Carbon؛ فقط‌آیکون نیازمند `aria-label` |
| `link` | variant: inline، nav، subtle؛ external | آیکون خارجی خودکار، `rel` امن |
| `icon` | name، size، label (اختیاری)، mirrorRtl | `aria-hidden` پیش‌فرض |
| `badge` | tone: neutral، brand، accent، success، warning، error، info | همیشه متن و در صورت لزوم آیکون |
| `tag` / `chip` | removable، selected | برای فناوری‌ها و فیلترها |
| `divider` | orientation، label | |
| `logo` | variant: full، mono، mark | لوگوتایپ موقت |
| `avatar` | size، fallback initials | |
| `skeleton` | shape، lines | برای Loading |
| `spinner` / `progress` | size، value | |
| `kbd` / `code` | | فقط‌برای مستندات/پنل |

## 3. فرم‌ها

| کامپوننت | توضیح |
|---|---|
| `field` | wrapper: label، hint، error، required، شناسه‌گذاری خودکار `aria-describedby` |
| `input`, `textarea`, `select` | حالت‌ها: default، focus، invalid، disabled، readonly؛ پیشوند/پسوند آیکون |
| `combobox` / `multi-select` | جست‌وجو، انتخاب چندگانه، کیبورد، RTL |
| `checkbox`, `radio`, `switch` | گروه‌بندی با `fieldset/legend` |
| `file-upload` | اعتبار نوع/حجم سمت کلاینت (کمکی)، پیش‌نمایش، پیشرفت؛ اعتبار اصلی سمت سرور |
| `date-picker` | تقویم شمسی/میلادی بر اساس زبان؛ ذخیره Gregorian/UTC |
| `range` | برای ابزار تخمین هزینه |
| `rich-editor` | wrapper TipTap؛ RTL/LTR، خروجی HTML پاک‌سازی‌شده سمت سرور |
| `stepper` | نمایش مرحله فعلی/باقی‌مانده برای فرم چندمرحله‌ای |
| `honeypot` | فیلد ضد اسپم نامرئی برای صفحه‌خوان |

## 4. بازخورد و پوشش‌ها (Overlay)

| کامپوننت | توضیح |
|---|---|
| `alert` | tone، آیکون، عملیات، `role` مناسب |
| `toast` | صف، `aria-live`، زمان‌بندی، توقف با Hover |
| `empty-state` | آیکون، عنوان، توضیح، عمل |
| `confirm-dialog` | برای عملیات حساس؛ متن صریح، دکمه خطر |
| `modal`, `drawer` | Focus trap، بستن با Esc، بازگردانی فوکوس، قفل اسکرول |
| `dropdown`, `popover`, `tooltip` | کیبورد، جایگیری هوشمند، RTL |
| `command-search` | جست‌وجوی سریع (پنل و سایت) |

## 5. ناوبری

| کامپوننت | توضیح |
|---|---|
| `navbar` | عمومی؛ شیشه‌ای هنگام اسکرول با Fallback؛ منوی موبایل، تغییر زبان، تغییر تم |
| `language-switcher` | مسیر معادل صفحه در زبان دیگر (از hreflang)، نه فقط صفحه اصلی |
| `theme-toggle` | سه حالت: سیستم، روشن، تاریک |
| `breadcrumb` | با Structured Data |
| `tabs` | ARIA کامل، کیبورد |
| `pagination` | سایت و پنل |
| `footer` | اطلاعات تماس و شبکه‌های اجتماعی قابل تنظیم از پنل |
| `skip-link` | |

## 6. داده و محتوا

| کامپوننت | توضیح |
|---|---|
| `card` | پایه با Variant: flat، outlined، elevated، interactive |
| `table` | مرتب‌سازی، انتخاب، Sticky header، موبایل: کارت‌شدن ردیف‌ها |
| `stat` | عدد + برچسب؛ قلاب `data-motion="counter"` |
| `accordion` / `disclosure` | FAQ و بخش‌های جمع‌شو |
| `timeline` | افقی/عمودی؛ قلاب Timeline GSAP |
| `filter-bar` + `search-box` | فیلتر دسته/برچسب/جست‌وجو برای نمونه‌کار و وبلاگ |
| `gallery` + `lightbox` | کیبورد، Swipe، lazy |
| `media` / `responsive-image` | `srcset`, `sizes`, ابعاد ثابت برای CLS، `alt` دوزبانه |
| `prose` | استایل محتوای TipTap (تیتر، لیست، کد، جدول، نقل‌قول) |

## 7. Patterns سایت عمومی

| Pattern | از چه ساخته می‌شود | قلاب حرکتی |
|---|---|---|
| `section-header` | overline، H2، توضیح، عمل | `reveal` |
| `hero-shell` | محتوای HTML واقعی + اسلات Canvas (`data-scene="hero"`) | Timeline ورود Hero |
| `service-card` | card، icon، badge، link | `stagger` |
| `project-card` | responsive-image، tag، link؛ Hover اختصاصی | `stagger` + hover |
| `post-card` | image، meta، زمان مطالعه | `stagger` |
| `testimonial-card` | quote، نویسنده، وضعیت تأیید | `reveal` |
| `stat-counter` | stat | `counter` |
| `process-steps` | stepper/timeline | Timeline اسکرولی |
| `tech-badges` / `skill-matrix` | tag، progress | `stagger` |
| `cta-band` | heading، text، button | `reveal` |
| `github-activity` | داده کش‌شده، Fallback | `reveal` |
| `faq` | accordion | |
| `contact-block` | field، button، آیکون‌های تماس | |
| `inquiry-wizard` | stepper، field، `multiStepForm` | انتقال بین مراحل |
| `estimator` | range، select، چکیده نتیجه | بروزرسانی نرم عدد |
| `booking-picker` | تقویم، زمان‌های آزاد | |

## 8. Patterns پنل مدیریت

| Pattern | توضیح |
|---|---|
| `admin-shell` | سایدبار، Topbar، جست‌وجوی سریع، اعلان، تم |
| `crud-index` | `table` + `filter-bar` + عملیات گروهی + Pagination + Empty State |
| `crud-form` | بخش‌بندی فیلدها، تب ترجمه، جعبه انتشار، جعبه SEO |
| `translation-tabs` | تب فارسی/انگلیسی با نشانگر «ناقص/کامل» برای هر زبان |
| `publish-box` | Draft، زمان‌بندی، انتشار، پیش‌نمایش |
| `seo-box` | عنوان، توضیح، canonical، OG، پیش‌نمایش نتیجه جست‌وجو |
| `media-picker` | انتخاب/آپلود از کتابخانه رسانه |
| `status-badge` | وضعیت‌های انتشار، درخواست، جلسه |
| `section-sorter` | ترتیب‌دهی بخش‌های صفحه اصلی (کشیدن و رها کردن با کیبورد جایگزین) |
| `audit-timeline` | نمایش رویدادها |
| `dashboard-widget` | آمار، نمودار ساده، لیست اخیر |
| `settings-form` | گروه‌بندی تنظیمات |
| `notification-bell` | اعلان‌های داخل پنل |

هسته `Admin/Crud` این Patterns را با پیکربندی هر منبع ترکیب می‌کند؛ هیچ صفحه CRUD از صفر نوشته نمی‌شود.

## 9. قالب مستندسازی هر کامپوننت

برای هر کامپوننت در کاتالوگ `/_ui` و این فایل:
1. هدف و کاربرد.
2. Props و Variantها.
3. حالت‌ها (hover، focus، active، disabled، loading، invalid).
4. دسترسی‌پذیری (نقش، کیبورد، برچسب).
5. رفتار RTL/LTR و دو تم.
6. قلاب حرکتی.
7. مثال استفاده.

## 10. چک‌لیست پذیرش هر کامپوننت

- در 4 ترکیب (روشن/تاریک × RTL/LTR) بررسی شده است.
- همه حالت‌ها نمایش داده شده‌اند.
- کیبورد و Focus ring درست است.
- کنتراست تأیید شده است.
- reduced-motion نسخه جایگزین دارد.
- هیچ رنگ، فاصله یا مارکاپ تکراری ندارد.
- در کاتالوگ `/_ui` ثبت شده است.

## 11. ترتیب ساخت در Phase 1

1. توکن‌ها، تم، `icon`، `button`، `link`، `badge`، `tag`، `card`.
2. فرم‌ها: `field`، `input`، `select`، `checkbox`، `switch` و بقیه.
3. بازخورد و Overlay: `alert`، `toast`، `modal`، `dropdown`، `tooltip`.
4. ناوبری: `navbar`، `footer`، `tabs`، `breadcrumb`، `pagination`.
5. داده: `table`، `accordion`، `timeline`، `filter-bar`، `gallery`.
6. Patterns عمومی با قلاب‌های حرکتی.
7. Patterns پنل (پوسته و هسته CRUD در Phase 3 تکمیل می‌شود).
