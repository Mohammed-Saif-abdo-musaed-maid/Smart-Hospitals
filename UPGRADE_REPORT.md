# UPGRADE REPORT — Hospital Management System (Laravel 5.8 → 10)

> **التاريخ**: 2026-09-23
> **الهدف**: ترقية مشروع HMS القديم من Laravel 5.8 إلى Laravel 10 مع الحفاظ الكامل على الميزات والمنطق وقاعدة البيانات والـ routes والـ auth، والعمل على PHP 8.2.

---

## 1) نسخة Laravel
- **Laravel Framework 10.50.3** (confirmed: `php artisan --version`)
- ملاحظة هندسية: `laravel/framework` مُقفَل في `composer.lock` على مرجع `10.x-dev@74e222c` (فرع الإصدار الرئيسي للنسخة 10) — يُبلّغ داخلياً الإصدار 10.50.3. التثبيت قابل للتكرار تماماً لأنه مرجع محدد في الـ lock.

## 2) نسخة PHP
- **PHP 8.2.12 (CLI + Web, ZTS/VC++ x64)** — `php -v`
- الامتدادات اللازمة متوفرة في بيئة XAMPP (openssl, mbstring, pdo_mysql, gd).

## 3) تبعيات Composer
- **Composer 2.10.2** | تثبيت نظيف متحقق (`composer install`) بلا تغييرات ضد الـ lock.
- الحزم الرئيسية (حزم runtime):
  - `laravel/framework` 10.x-dev@74e222c (v10.50.3)
  - `laravel/ui` 4.6.3 — يوفّر الـ auth traits المفقودة من Laravel 10 core
  - `barryvdh/laravel-dompdf` 3.1.2 (مع `dompdf/dompdf` 3.1.6)
  - `milon/barcode` 10.0.1 — توليد الباركود
  - `sendgrid/sendgrid` 8.1.2 — البريد عبر SendGrid
  - `spatie/laravel-activitylog` 4.12.3 + `spatie/laravel-backup` 8.8.2
  - `guzzlehttp/guzzle` 7.15.5 | `nesbot/carbon` 2.73.0 | `laravel/tinker` 2.11.1
- الحزم التطويرية:
  - `phpunit/phpunit` 10.5.65 | `nunomaduro/collision` 7.12.0 | `mockery/mockery` 1.6.15 | `fakerphp/faker` 1.24.1
- ملاحظة: `barryvdh/laravel-dompdf` رُفع إلى `^3.0` لأن Composer يحجب dompdf 2.x (استشارات أمنية منتهية).

## 4) حالة قاعدة البيانات
- الخادم: **MariaDB 12.0.2** (XAMPP, port 3306) — المستخدم `root` (سلوك XAMPP المحلي).
- قاعدة البيانات المحلية للتحقق: **`hms_test`** (utf8mb4_unicode_ci) — أُنشئت خصيصاً للترقية؛ لا تُستخدم في الإنتاج.
- بيانات بعد الـ seeding (اختباري): 5 users، 72 سجلات حضور، 90 دواء، 2 أجنحة، + مرضى/عيادات/لوحات إعلانات.
- `migrate:status --database=mysql` → **15/15 migrations قيد التنفيذ (Ran)**.

## 5) حالة الـ Migrations
- **15/15 migrated ‏بنجاح** على `hms_test` (وُصلحت جميع تعارضات signed/unsigned بين FKs):
  - `users`, `password_resets`, `patients` (id signed bigint للمعرّفات اليدوية)، `attendances`، `sessions`، `activity_log`، `medicines`، `wards`، `prescriptions`، `appointments`، `inpatients`، `medicine_prescription`، `clinics`، `clinic_patient`، `noticeboards`.

## 6) نتائج الاختبارات
- **PHPUnit 10.5.65** — `php artisan test`:
  - `Tests\Unit\ExampleTest` ✓  (0.15s)
  - `Tests\Feature\ExampleTest` ✓ (0.10s؛ يعكس سلوك `/` الجديد: 302 ← login ثم `/login` 200)
  - **Total: 2 passed (4 assertions)** — صفر أخطاء.
- `php -l` على **كل** ملفات `app/`, `config/`, `routes/`, `database/` → **ALL PHP LINT OK**.
- `php artisan view:cache` → كل ملفات Blade تترجم بنجاح.

## 7) حالة الـ Routes
- `php artisan route:list` يعمل بلا استثناءات → **82 مساراً فعلياً** (الوصف + API + المصادقة + المسارات المُعاد توجيهها).
- فحص برمجي: **كل أهداف المسارات موجودة** (Controllers/Methods).
- المسارات الميتة في الأصل (كانت 500 في 5.8) أُصلحت بإعادة توجيه بدل حذف الميزة:
  - `/reportgeneration` → `/clinicreports`
  - `/emails` → `/createnoticeview`
  - `/outpreport` → `/attendancereport` (العرض `reports/out_patient_report` لم يوجد أبداً؛ لا في git ولا في backup)
  - تحقق حي: `/email`/`/reportgeneration`/`/outpreport` → **302** → صفحة الوجهة **200**.
- Smoke test حي عبر dev server (دخول admin `shakthisachintha@gmail.com`): POST login → 302 → `/dash` → 200؛ صفحات عديدة 200 (`/patient`, `/wards`, `/myattend`, `/stats`, `/newuser`, `/checkpatient`, `/issueMedicine`, `/in-reports`, `/attendancereport`, `/clinicreports`, `/monstatreport`, `/wardreport`, `/mobclinicreport`). `/attendance` → 302 **قصدية** (كشك البصمات بـ `guest` middleware).

## 8) المشاكل المتبقية / القضايا المفتوحة
1. **composer audit — 3 استشارات أمنية** على `laravel/framework` (التواقيع `<12.60`, `<12.61.1`, و`>=13`). التصحيحات متوفرة فقط في Laravel 12.60+/13.12+ — **غير متاحة لـ Laravel 10 (EOL)**. خطر مقبول محلياً؛ الحل الاختياري لاحقاً: ترقية تدريجية إلى Laravel 11/12 (PHP 8.2 يدعمها).
2. **إصلاحات `/emails` و`/outpreport`** ما تزال في `routes/web.php` **علاّقة بلا commit** (يُرفع commit عند طلب صريح فقط).
3. **تحذير PSR-4** معروف: `App\Clinic` ← `app/clinic.php` (حالة اسم الملف) — يعمل عبر resolution غير حساس للحالة؛ لم يُنقل لتجنب تغيير بنية المشروع.
4. **`RouteServiceProvider::$namespace`** نمط Laravel 11-deprecated لكنه **يعمل بكامل وظائفه على Laravel 10** — تُرك كما هو (تفادي تغيير المنطق).
5. **`mail`** مضبوط على `MAIL_MAILER=log` (تطوير)؛ لإرسال فعلي تحتاج مفاتيح SendGrid الحقيقية في `.env`.
6. قاعدة `hms_test` خاصة بالتحقق فقط؛ إنتاجية المشروع الأصلية لا توجد محلياً ولم تُلمس.
7. `users.fingerprint` عمود قائم في المخطط ويُستخدم من الـ controllers (متحقق منه).

---

## ملخص الـ Commits
| Commit | المحتوى |
|---|---|
| `d509298` | baseline: إعداد مشروع 5.8 القديم |
| `dd65ed8` | stage1: تبعيات Laravel 10 + إصلاحات bootstrap (Handler, Kernel, TrustProxies, config) |
| `1152d7f` | stage2: كود التطبيق + migrations + seeders + PHPUnit 10 + `/reportgeneration` |
| *(عالق)* | إصلاحات `/emails` و`/outpreport` في `routes/web.php` |

## تشغيل المشروع
```
composer install
php artisan key:generate        # إن لزم
php artisan migrate --seed      # على قاعدة فارغة
php artisan serve
```