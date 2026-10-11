# Icon System — AMB

وضعیت: پیش‌نویس Phase 0 | نسخه: 0.1

## 1. قواعد

- ایموجی در هیچ‌جا استفاده نمی‌شود (UI، محتوا، Seeder، ایمیل، لاگ، Commit، مستندات).
- همه آیکون‌ها SVG هستند و فقط از طریق `<x-ui.icon name="..." />` رندر می‌شوند.
- Icon font و CDN ممنوع است؛ همه چیز محلی.
- سبک یکدست: گرید 24x24، ضخامت خط 1.5، `stroke="currentColor"`، `fill="none"`، سر و گوشه گرد، بدون تنوع سبک بین آیکون‌ها.
- رنگ آیکون از `currentColor` (و توکن‌های متن) می‌آید، نه HEX.

## 2. منبع آیکون‌ها

- ترجیح: مجموعه با مجوز آزاد و روشن (مثلاً ISC/MIT) برای آیکون‌های عمومی، به‌علاوه آیکون‌های اختصاصی AMB برای مفاهیم برند (سه‌بعدی، تایم‌لاین، تخمین هزینه، رزرو و غیره).
- مجوز هر منبع قبل از استفاده بررسی و در جدول بخش 8 ثبت می‌شود.
- آیکون‌های شبکه‌های اجتماعی و برندها (GitHub، LinkedIn، Telegram، Instagram و غیره): SVG محلی و رعایت راهنمای برند هر کدام.
- آیکون اختصاصی جدید باید با گرید و ضخامت سیستم هماهنگ باشد و بازبینی بصری شود.

## 3. خط لوله Build

```
resources/icons/*.svg   ->  اسکریپت Build (Node روی سیستم توسعه)
                        ->  بهینه‌سازی (حذف متادیتا، نرمال‌سازی viewBox/stroke)
                        ->  public/build/icons.svg  (Sprite با <symbol id="icon-...">)
```

- نام فایل = نام آیکون به‌صورت kebab-case (`arrow-right.svg` ← `arrow-right`).
- Sprite همراه Release ارسال می‌شود (بدون نیاز به Node در Production).
- رندر: `<svg><use href="/build/icons.svg#icon-name"/></svg>` یا Inline برای آیکون‌های حیاتی Above-the-fold (برای جلوگیری از درخواست اضافی و CLS).
- Build در صورت نبود آیکونی که در Viewها استفاده شده یا وجود آیکون بی‌استفاده هشدار/خطا می‌دهد.

## 4. کامپوننت `x-ui.icon`

| Prop | توضیح |
|---|---|
| `name` | الزامی؛ نام آیکون |
| `size` | xs 14، sm 16، md 20 (پیش‌فرض)، lg 24، xl 32 |
| `label` | اگر آیکون معنایی است؛ متن برای صفحه‌خوان |
| `mirrorRtl` | وارونه‌سازی افقی در RTL (برای آیکون‌های جهت‌دار؛ پیش‌فرض بر اساس فهرست پایین) |
| `class` | فقط برای استثنا |

- پیش‌فرض `aria-hidden="true"`؛ اگر `label` باشد `role="img"` و `aria-label`.
- دکمه فقط‌آیکون باید در `x-ui.button` با `aria-label` باشد، نه روی خود آیکون.
- `focusable="false"`.

## 5. آیکون‌های جهت‌دار (وارونه در RTL)

`arrow-right`, `arrow-left`, `chevron-right`, `chevron-left`, `chevrons-right`, `chevrons-left`, `arrow-up-right`, `corner-down-right`, `external-link`, `undo`, `redo`, `send`, `reply`, `list-indent`, `list-outdent`, `sidebar-open`, `sidebar-close`, `quote`.

آیکون‌های غیرجهت‌دار (جست‌وجو، تنظیمات، کاربر، ساعت، تقویم، ساعت‌شنی و غیره) هرگز وارونه نمی‌شوند.

## 6. فهرست اولیه (برای Phase 1)

- **عمومی:** menu, close, search, plus, minus, check, check-circle, x-circle, alert-triangle, info, help-circle, loader, external-link, copy, download, upload, link, filter, sort, grid, list, eye, eye-off, edit, trash, save, more-horizontal, more-vertical, calendar, clock, bell, settings, user, users, lock, unlock, home, globe, sun, moon, monitor
- **ناوبری:** arrow-right/left/up/down, arrow-up-right, chevron-right/left/up/down
- **مفاهیم برند:** code, terminal, layers, layout, pen-tool, rocket, gauge (سرعت)، search-check (سئو)، puzzle (افزونه)، palette, cpu, box (سه‌بعدی)، git-branch, github, mail, phone, message, map-pin, file-text, award, briefcase, graduation-cap, quote, star
- **پنل:** dashboard, folder, image, inbox, list-checks, shield, activity, tag, key, drag-handle, sidebar-open, sidebar-close
- **شبکه‌های اجتماعی:** github, linkedin, telegram, instagram, x (یا مشابه)، whatsapp (در صورت نیاز)، email

فهرست نهایی در Phase 1 با نیاز واقعی کامپوننت‌ها بسته می‌شود؛ آیکون بی‌استفاده وارد Sprite نمی‌شود.

## 7. دسترسی‌پذیری

- آیکون تزئینی: `aria-hidden="true"`.
- آیکون معنایی مستقل (مثلاً وضعیت): `role="img"` با `aria-label`.
- آیکون همراه متن: متن منتقل‌کننده معنا است؛ آیکون تزئینی.
- هیچ معنایی فقط با رنگ آیکون منتقل نمی‌شود.
- حداقل اندازه لمس دکمه آیکون 44x44 (ناحیه ضربه، نه الزاماً خود آیکون).

## 8. ثبت مجوز و منبع

| آیکون / مجموعه | منبع | مجوز | یادداشت | وضعیت |
|---|---|---|---|---|
| مجموعه عمومی | (در Phase 1 انتخاب و تأیید) | (بررسی شود) | | نامشخص |
| آیکون‌های اختصاصی AMB | طراحی داخلی | مالکیت AMB | | در انتظار |
| آیکون‌های برندها | وب‌سایت رسمی هر برند | طبق راهنمای برند | | در انتظار |

## 9. تست

- صفحه `/_ui/icons` همه آیکون‌ها را در اندازه‌ها، دو تم و RTL/LTR نشان می‌دهد.
- بررسی خودکار: هر `name` مصرف‌شده در Viewها در Sprite وجود دارد.
- بررسی خودکار: هیچ ایموجی (محدوده Unicode ایموجی) در `resources/`, `database/seeders/`, `lang/` و مستندات وجود ندارد.
