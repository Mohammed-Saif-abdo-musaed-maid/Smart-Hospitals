# UPGRADE PROGRESS — HMS (Laravel 5.8 -> 10)

> أحدث تحديث يظهر أولاً

## المرحلة 1 — التثبيت ودمج الحزم (COMPLETED ✅)
- **تاريخ**: 2026-09-23
- **المدخلات**: PHP 8.2.12 | Composer 2.10.2 | MySQL (XAMPP) — Laravel 10.50.3

### المنجز
1. النسخ الاحتياطي الكامل إلى `D:\OpenCodeTemp\opencode\hms-backup-2026-09-23` (7760 ملف).
2. `git init` + baseline commit `d509298`.
3. كتابة `UPGRADE_ANALYSIS.md` (التحليل الكامل والقرارات والخطة والمخاطر وخطة الاختبار).
4. تحديث `composer.json` لهدف Laravel 10، ثم `composer update` ناجح من أول محاولة بعد رفع `barryvdh/laravel-dompdf` إلى `^3.0` (dompdf 2.x محجوب من Composer بسبب استشارات أمنية deprecated).
5. إصلاح `app/Exceptions/Handler.php` لتواقيع Laravel 10 (`register()` + `Throwable`) — كان السبب الوحيد لفشل `package:discover`.
6. `package:discover` ينجح لكل الحزم: barryvdh/laravel-dompdf, tinker, milon/barcode, carbon, collision, termwind, activitylog, backup, signal-aware-command.
7. `php artisan --version` → **Laravel Framework 10.50.3** | `php artisan about` يعمل.
8. `composer dump-autoload` ينجح (تحذير PSR-4 واحد معروف: `app/clinic.php` سنصلحه لاحقاً بنقل الموديلات).

### الحزم المثبتة (72 package + dev)
- laravel/framework 10.50.3, barryvdh/laravel-dompdf 3.1.x, milon/barcode 10.x, sendgrid/sendgrid 8.1.2, spatie/laravel-activitylog 4.12.3, spatie/laravel-backup 8.8.2, guzzlehttp/guzzle 7.x, laravel/tinker 2.x, fakerphp/faker 1.x, phpunit 9.6.37, nunomaduro/collision 7.x, mockery 1.x

### الملفات المعدّلة
- `composer.json` (إعادة هدف Laravel 10 + dompdf ^3.0)
- `composer.lock` (جديد)
- `config/app.php` (حذف providers/aliases القديمة)
- `bootstrap/app.php` (حذف header() CORS)
- `app/Http/Middleware/TrustProxies.php` (Illuminate\Http\Middleware\TrustProxies)
- `app/Http/Kernel.php` (حذف middlewarePriority)
- `app/Console/Kernel.php` (حذف load Commands)
- `app/Exceptions/Handler.php` (نمط Laravel 10)

### commit
- `d509298` baseline (سابق)
- *(المرحلة الجارية سيُرفع commit بعد اكتمال خطواتها)*

---

## المراحل القادمة
- [ ] **المرحلة 2** — Bootstrap أساس: `.env.example` + `.env` + `key:generate`، وإصلاحات كود PHP 8 (مُدخلات، موديلات، controllers، middleware صغير إن وُجد).
- [ ] **المرحلة 3** — Seeders/Factories/Migrations: نقل `database/seeds` → `database/seeders`، factories class-based، إصلاح FKs والـ raw SQL في الميجر-شن.
- [ ] **المرحلة 4** — Blade: استبدال `Active::checkRoute` بـ `request()->routeIs`، إصلاح layouts المفقودة.
- [ ] **المرحلة 5** — Configs: `config/mail.php`، إعدادات production-in-`.env`، حفظ config/تمهيد التخزين `storage` links إن تطلب (spatie/backup، activitylog).
- [ ] **المرحلة 6** — تحقق نهائي: `route:list`، `vendor:publish` المطلوبة، إنشاء DB تجريبية `hms_test`، `migrate` + `db:seed`، `php artisan serve`، اختبار السيناريوهات في التحليل، `php artisan test`.
- [ ] **المرحلة 7** — `UPGRADE_REPORT.md` + commit نهائي + تعليمات التشغيل.