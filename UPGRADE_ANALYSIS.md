# UPGRADE_ANALYSIS — Hospital Management System (Laravel 5.8 → Target Upgrade)

> تاريخ التحليل: 2026-09-23
> بيئة الجهاز: Windows 10 Pro (19045) / PHP 8.2.12 (XAMPP CLI) / Composer 2.10.2 / MySQL

---

## 1) الإصدارات الحالية

| العنصر | القيمة |
|---|---|
| Laravel | **v5.8.37** (من `composer.lock`) |
| PHP (المطلوب في composer.json) | `^7.1.3` (غير قابل للتثبيت على PHP 8.2) |
| PHP (الفعلي على الجهاز) | **8.2.12** |
| Composer | **2.10.2** |
| Vendor directory | غير موجود (لم يُثبَّت أبداً) |
| `.env` / `.env.example` | غير موجودان |
| Git repo | غير موجود |
| Node/node_modules | غير مستخدم (لا يعتمد التصميم على Mix — الأصول جاهزة في public/) |

---

## 2) جميع الـ Dependencies الحالية (من composer.lock)

### Production (86 حزمة)
الأساسية المعلنة في `composer.json`:

| الحزمة | المثبّتة |
|---|---|
| php | ^7.1.3 |
| barryvdh/laravel-dompdf | v0.8.5 |
| fideloper/proxy | 4.2.2 |
| guzzlehttp/guzzle | 6.5.2 |
| kriswallsmith/buzz | 1.0.1 |
| laravel/framework | v5.8.37 |
| laravel/telescope | v2.1.7 |
| laravel/tinker | v1.0.10 |
| laravelcollective/html | 5.8.x-dev |
| mailgun/mailgun-php | 3.0.0 |
| milon/barcode | 6.0.2 |
| nexmo/client | 2.0.0 (+ nexmo/client-core 2.1.0) |
| nyholm/psr7 | 1.2.1 |
| php-http/guzzle6-adapter | v2.0.1 |
| php-http/message | 1.8.0 |
| pyaesone17/active-state | 1.1.1 |
| sendgrid/sendgrid | 7.4.3 |
| spatie/laravel-activitylog | 3.2.2 |
| spatie/laravel-backup | 5.12.1 |

معتمدات نقلية ملحوظة: `swiftmailer/swiftmailer v6.2.3`, `symfony/* v4.4.4`, `dompdf/dompdf v0.8.5`, `php-http/*`, `zendframework/zend-diactoros 2.2.1`, `monolog/monolog 1.25.3`, `vlucas/phpdotenv v3.6.0`, `league/flysystem 1.0.64`, `nesbot/carbon 2.30.0`, `anahkiasen/underscore-php 2.0.0 (abandoned)`, `patchwork/utf8 v1.3.2`, `phpseclib/phpseclib 2.0.23` ...

### Dev (30 حزمة)
`beyondcode/laravel-dump-server 1.3.0`, `filp/whoops 2.7.1`, `fzaninotto/faker v1.9.1`, `mockery/mockery 1.3.1`, `nunomaduro/collision v3.0.1`, `phpunit/phpunit 7.5.20`, + phpunit ecosystem old.

---

## 3) الـ Dependencies القديمة / غير المدعومة / المراد استبدالها

| الحزمة | الحالة | التوافق مع PHP 8.2 | التوافق مع Laravel 10 | القرار | السبب |
|---|---|---|---|---|---|
| laravel/framework 5.8.37 | قديم جداً | ✗ | ✗ | **ترقية** | أساس الترقية |
| php ^7.1.3 | يمنع تثبيت أي حزمة حديثة | ✗ | ✗ | **تغيير الشرط** إلى ^8.1 |
| barryvdh/laravel-dompdf 0.8.5 | قديم (dompdf 0.8.5) | ✗ | ✗ | **ترقية** إلى ^2.0 | PDF generation (غير مستخدم في app لكن يُحتفظ للأمان) |
| fideloper/proxy 4.2.2 | **استُبدل في Laravel core** | جزئياً | تعارض | **حذف** | Laravel 9+ يوفّر `Illuminate\Http\Middleware\TrustProxies` |
| guzzlehttp/guzzle 6.5.2 | قديم | ✗ (يدعم <8) | جزئياً | **ترقية** إلى ^7.3 | مطلوب للـ HTTP client |
| kriswallsmith/buzz 1.0.1 | مهجور | ✗ | ✗ | **حذف** | **صفر استخدام** في كود التطبيق (لا `use Buzz`) |
| laravelcollective/html 5.8 | مهجور منذ Laravel 7 | ✗ | ✗ | **حذف** | **صفر استخدام** (`Form::`/`Html::` غير مستخدمين إطلاقاً في 47 view) + aliases في config/app.php تُزال |
| mailgun/mailgun-php 3.0.0 | قديم | ✗ | ✗ | **حذف** | **صفر استخدام** في الكود (فقط مُكوّنة في config/services.php) — Laravel mailgun transport مدمج في core |
| milon/barcode 6.0.2 | قديم | جزئياً | ✗ | **ترقية** إلى ^10.0 | مستخدمة فعلاً عبر `DNS1D::getBarcodePNGPath` في `patient_reg_card.blade.php:75` (v10 يدعم Laravel 10 + PHP 8) |
| nexmo/client 2.0.0 | **استُبدلت بـ vonage** | ✗ | ✗ | **حذف** | **صفر استخدام** (SMS يتم عبر `file()` لـ textit.biz في UserController) |
| nyholm/psr7 1.2.1 | معتمدة ضمني | جزئياً | ✗ | **حذف** | تبعية لـ buzz/nexmo المحذوفة |
| php-http/guzzle6-adapter | معتمدة ضمني | ✗ | ✗ | **حذف** | تبعية لـ buzz محذوفة |
| php-http/message | معتمدة ضمني | جزئياً | ✗ | **إعادة تقييم** | تبقى فقط إن لزمتها أي حزمة متبقية |
| pyaesone17/active-state 1.1.1 | مهجور (Laravel 5) | جزئياً | ✗ | **حذف** + استبدال | 26 استخدام `Active::checkRoute` في `template/main.blade.php` → تُستبدل بـ `request()->routeIs(...)` |
| sendgrid/sendgrid 7.4.3 | قديم | ✗ (يدعم <8) | ✗ | **ترقية** إلى ^8.0 | مستخدمة فعلاً في `UserController::email()` (`new SendGrid(env('SEND_KEY'))`) — v8 يدعم PHP 7.4–8.x |
| spatie/laravel-activitylog 3.2.2 | قديم (Laravel 5) | ✗ | ✗ | **ترقية** إلى ^4.7 | مستخدمة في 16 موضع (helper `activity()`) |
| spatie/laravel-backup 5.12.1 | قديم (Laravel 5) | ✗ | ✗ | **ترقية** إلى ^8.0 | مستخدمة في `Console/Kernel.php` (`backup:run`, `backup:clean`) |
| laravel/telescope 2.1.7 | قديم | ✗ | ✗ | **ترقية** إلى ^4.9 | حزمة مثبّتة لكن **صفر استخدام** (لا config, لا provider). الخيار: ترقية أو حذف |
| laravel/tinker 1.0.10 | قديم | ✗ | ✗ | **ترقية** إلى ^2.8 | |
| beyondcode/laravel-dump-server 1.3.0 | مهجور | ✗ | ✗ | **حذف** | مدمج في core منذ Laravel 6 |
| fzaninotto/faker v1.9.1 | **abandoned** | ✗ | ✗ | **حذف** → fakerphp/faker ^1.20 | |
| phpunit/phpunit 7.5.20 | قديم | ✗ | ✗ | **ترقية** إلى ^9.6 | PHP 8.2 + Laravel 10 يتطلبان PHPUnit 9.6+ |
| nunomaduro/collision v3.0.1 | قديم | ✗ | ✗ | **ترقية** إلى ^7.0 | خاص بـ Laravel 10 |
| mockery/mockery 1.3.1 | قديم | جزئياً | ✗ | **ترقية** إلى ^1.5 | |
| filp/whoops 2.7.1 | قديم | جزئياً | ✗ | **ترقية** إلى ^2.15 | |

---

## 4) مشاكل الكود المكتشفة (Breaking مع Laravel 10 / PHP 8.2)

### 4.1 PHP 8.2
1. **Dynamic property** — `app/Http/Controllers/PatientController.php:29` — `$this->wardList` تُنشأ دون إعلان → Deprecation على PHP 8.2. (تُضاف `protected $wardList;`).
2. **النماذج بخاصية `$incrementing=false`** — `app/Patients.php:14` — `Patients.id` يُدار يدوياً (رقم تسجيل 8 أرقام) → سليم، لا تغيير.

### 4.2 Laravel 10 (بنية framework)
1. **`database/seeds/*`** — كل seeders `extends Illuminate\Database\Seeder` (محذوف في L8+) → نقل إلى `database/seeders/` + `namespace Database\Seeders;` + `extends Seeder`.
2. **`database/factories/*`** — نمط `$factory->define()` (محذوف في L8+) → تحويل إلى class factories (`Database\Factories\*`) + trait `HasFactory` على `User`.
3. **`config/mail.php`** — مفتاح `MAIL_DRIVER` القديم → في L9+ يتم قراءة `MAIL_MAILER`/`config('mail.default')` → تحديث config إلى نسخة Laravel 10.
4. **`app/Http/Kernel.php`** — `middlewarePriority` يشير إلى كلاسات قديمة (`ShareErrorsFromSession`) — في Laravel 10 تحوّلت إلى ServiceProvider وهذا key حُذف → إزالة `middlewarePriority` (تعمل بدونها).
5. **`bootstrap/app.php`** — `header()` دستي CORS في bootstrap → نقل/إزالة (يُرسل headers حتى مع artisan).
6. **`app/Http/Middleware/TrustProxies.php`** — يعتمد `Fideloper\Proxy\TrustProxies` (محذوفة) → `Illuminate\Http\Middleware\TrustProxies`.
7. **`Test via phpunit 9.x`** — `phpunit.xml` خصائص PHPUnit7 قديمة + `MAIL_DRIVER` → تحديث.
8. **`composer.json`** — `classmap: [database/seeds, database/factories]` → PSR-4 seeders/factories.
9. **`RouteServiceProvider`** — `$namespace` لا يزال مدعوماً في Laravel 10 لكنه deprecated → encryption: الأفضل استخدام `->namespace()` (ما زال يعمل) وإزالة الـ namespace empty on update. لإبقاء التعديل الأدنى: يُبقي `protected $namespace` (للتوافق) لكن Laravel 10 يطبع Deprecation. يمكن تحويل الـ routes إلى closures/Controllers مؤهلة لاحقاً.
10. **`Exceptions/Handler.php`** — يرث `Illuminate\Foundation\Exceptions\Handler` — سليم، يُراجع فقط.
11. **`app/Console/Kernel.php:38`** — `$this->load(__DIR__.'/Commands')` لمجلد غير موجود → تُزال (لا Commands مخصصة).
12. **elcat `php artisan package:discover`** — `beyondcode/laravel-dump-server` و `laravelcollective/html` و `pyaesone17/active-state` من الـ providers → تُزال من `config/app.php` (providers 164, 178 + aliases 229–231).

### 4.3 Migrations — أخطاء موجودة يجب إصلاحها (ستفسد أي DB جديدة)
1. `2019_08_29_132950_create_patients_table.php` — `bigInteger('id')` غير auto-increment + `primary('id')` — **متصمَّم عمداً** (أرقام تسجيل يدوية) → يُحفظ كما هو.
2. `2019_09_07_050834_create_attendances_table.php:24` — `DB::unprepared('ALTER TABLE attendances ADD UNIQUE KEY...')` — يعمل على MySQL، يكسر SQLite tests → يُحوَّل إلى `$table->unique(['user_id','start'])` داخل create (لا يغيّر schema الناتج).
3. `2019_10_02_171521_create_prescriptions_table.php:23` — FK خاطئ: `appointment_id → patients` (يجب `appointments`) — **خطأ منطقي** → يُصحَّح عبر إضافة FK صحيح في migration appointments (بعد إنشاء الجدول) وإزالة الخاطئ من prescriptions.
4. `2019_10_15_035306_create_appointments_table.php:6` — `use phpDocumentor\Reflection\Types\Nullable;` غير مستخدم + قد يختفي بعد ترقية phpunit → حذف الـ import.
5. `2020_02_13_201718_create_clinics_table.php:21` — عمود `start-date` بشرطة — يعمل على MySQL، **لا يُغيَّر** (merging مع schema موجود) لتفادي كسر البيانات.
6. `2020_02_13_223635_clinic_patient.php:21` — FK خاطئ: `patients_id → patient` (`patient` غير موجود، الصحيح `patients`) → **يُصلح** (يفشل أي migrate جديد بدونه) + `DB::unprepared` UNIQUE → `$table->unique(['patients_id','clinic_id'])`.

> ملاحظة: كل إصلاحات الـ migrations تؤثر فقط على قواعد البيانات الجديدة (fresh) ولا تلمس DB موجودة فعلاً لأن أرقام الـ migrations نفسها تبقى والمهاجرات المسجّلة لا تعاد.

### 4.4 أخطاء برمجية قائمة (موجودة أصلاً — لا تسببها الترقية لكن يجب معالجتها أثناء الاختبار)
1. `app/Patients.php:20` — `history()` يرجع `App\Patient_History` غير موجود → **أي استخدام `$patient->history` يفشل**. لم يُستخدم في controllers حالياً. تُترك كما هي (لا حذف) ويُوثّق.
2. `app/Http/Controllers/PatientController.php:7` — `use App\Http\Controllers\Redirect;` غير موجود → استيراد ميت، يُحذف (يعمل الآن لأن غير مستخدم).
3. `app/Http/Controllers/LoginController.php:5` — `use App\Http\Controllers\Auth\Request;` غير موجود → يُحذف.
4. `app/Http/Controllers/UserController.php:10,15` — `Illuminate\Contracts\Validation` و `SebastianBergmann\Environment\Console` غير موجودة → تُحذف.
5. `app/Http/Controllers/NoticeboardController.php:10-11` — نفس النمط → تُحذف.
6. `app/Http/Controllers/AttendController.php:60` — `dd($ids)` سيتوقف عند التصفح (fatal for attendmore) → معالجة عند testing.
7. `app/Patients.php` & `Appointment.php` & `Prescription_Medicine.php` — `whereRaw` بمدخلات مباشرة (SQL injection موجودة أصلاً) — **لا تُعدَّل бизнес القاعدة بدون طلب** (توثيق فقط).
8. `app/clinic.php` — اسم ملف PSR-4 بحالة أحرف صغيرة `clinic.php` (class `Clinic`) → يعمل على Windows/Laravel autoload PSP-4? PSR-4 case-insensitive على Windows، على Linux قد يفشل. تجنّب إعادة التأمين، يُترك (مشروع على Windows). توثيق.
9. `PatientController.php:546` — `view('register_in_patient_view')` (قبلها النمط الصحيح في `:441`) — فالـ get_ward_list سيخلق خطأ عند الاستخدام → يعالج أثناء الاختبار.

### 4.5 Blade
- `Active::checkRoute(...)` في 26 سطر بـ `template/main.blade.php` → استبدال بـ `request()->routeIs(...)` (تعامل مع نفس أسماء الـ routes المقصودة).
- لا `Form::`/`Html::` → نزيل `laravelcollective/html` + aliases بأمان.
- `DNS1D::getBarcodePNGPath(...)` في `patient_reg_card.blade.php:75` → تبقى (مع milon/barcode ^10 تواصل الـ alias `DNS1D` تلقائياً).
- 4 ملفات auth (`register/verify/passwords.email/passwords.reset`) تستدعي `layouts.app` (مفقود) → إصلاح الـ layout (توجيه إلى `template.auth` أو إنشاء layout بسيط).
- `@php` كثيف في الـ views يعمل في Laravel 10 — لا تعديل إجباري (أقل تغيير).

---

## 5) خطة الترقية المقترحة

### اختيار الهدف
**Laravel 10.x (وَلِيس الأحدث 11/12)** — الأسباب:

| المقارنة | Laravel 10 | Laravel 11 / 12 |
|---|---|---|
| PHP المطلوب | ^8.1 ✓ (يعمل على 8.2.12) | ^8.2 (لكن 11/12) |
| بنية الهيكل | classic: `app/Http/Kernel.php`, `config/`, `Exceptions/Handler.php` | حتّغيّرت: `bootstrap/app.php`, بدون Http Kernel/Handler — إعادة هيكلة جذرية |
| تعقيد الترحيل من 5.8 | منخفض (نفس الهيكل) | مرتفع جداً (إعادة بناء هيكل الخدمات/الاستثناءات) |
| توافق الحزم | milon/barcode ^10, activitylog ^4, backup ^8, dompdf ^2, telescope ^4 — كلها متوفرة | بعض الحزم تحتاج v11/v12 |
| الدعم الحالي (2026) | منتهي رسمياً (EOL) لكن مستقر ومثبت للأنظمة القديمة | مدعوم |

**القرار: Laravel 10.0** (المتطلب: `laravel/framework: ^10.0`, php `^8.1`) — يوفّر التوافق الأمثل مع PHP 8.2 وأقل تغييرات مع الحفاظ على الهيكل الكلاسيكي الذي لا يحتاج إعادة كتابة.

### مسار الترقية (انطلاقاً بعد تأكيد المستخدم)
نظراً لعدم وجود vendor، لا يوجد لـ composer.lock معنى تشغيلي فعلي — سيُبنى من جديد. تُطبَّق تغييرات الكود وفق إرشادات الترقية التراكمية 5.8 → 6 → 7 → 8 → 9 → 10 (جمع التغييرات المطلوبة في جلسة واحدة موثّقة، وليس تثبيت فعلي لكل إصدار — لأن كل Major Upgrade لا يتطلب سوى تحديث الكومبوزر + تعديلات كود محددة). هذا هو نفس الأسلوب الذي تستخدمه أدوات مثل Laravel Shift.

الخطوات:
1. **Backup**: إنشاء نسخة احتياطية كاملة خارج المشروع (D:\OpenCodeTemp\... ) + (اختياري) `git init` و commit مرجعي.
2. **composer.json**: تحديث الـ requires/requires-dev + autoload (PSR-4 seeders/factories) + حذف الحزم المحذوفة/المستبدلة.
3. **composer update** على PHP 8.2 (بدون ignore-platform-reqs) → إنشاء composer.lock جديد + vendor.
4. **config/app.php**: إزالة providers/aliases للـ `laravelcollective/html` و `pyaesone17/active-state`.
5. **config/mail.php** + kernel + bootstrap + middleware + app-service providers: تحديثات Laravel 10.
6. **Migrate seeders/factories** + إصلاح migrations (الأخطاء الأربعة + raw SQL).
7. **PHP 8.2 code fixes**: dynamic property + imports الميتة + `TrustProxies`.
8. **Views**: إصلاح `Active::checkRoute` (26 موقعاً) + layout المفقود (4 ملفات auth) + باريكود DNS1D تُحفظ.
9. **.env.example** جديد + `.env` للتشغيل المحلي (بدون أسرار حقيقية) + قاعدة بيانات MySQL للاختبار (إنشاء DB تجريبية محلياً `hms_test`).
10. **Tests**: تحديث phpunit.xml + ExampleTests.
11. **Validation**: `composer validate` → `php artisan --version` → `php artisan about` → `php artisan route:list` → `php artisan migrate` على DB تجريبية → `php artisan db:seed` → `php artisan serve` واختبار الصفحات الأساسية (login, dashboard, patients, barcode, reports, activity log).
12. توثيق في UPGRADE_PROGRESS.md أثناء كل مرحلة + UPGRADE_REPORT.md في النهاية.

---

## 6) المخاطر

1. **منتهية الدعم** — Laravel 10 رسمياً EOL، لكنها مستقرة؛ قيمة المشروع أنّ تحويله لـ 11/12 يستغرق جهداً أكبر بلا ميزة وظيفية.
2. **`whereRaw`/SQL injection قائمة** — لا تُلامس الآن (خارج نطاق الترقية) لكنها خطر مستقبلي.
3. **`patients.id` يدوي** — التعامل مع Primary Key يدوي في مصمّمي النماذج حساس؛ لا تغييرات هنا.
4. **migrations** — إصلاحها يؤثر على fresh DB فقط؛ DB موجودة لا تتأثر.
5. **مجهولات البيئة** — لا `.env` (لا يوجد APP_KEY ولا بيانات DB) → يجب إنشاء `.env` محلي وDB للاختبار.
6. **sendgrid/mail/SMS** — تتطلب مفاتيح حقيقية؛ ستعمل بلا مفاتيح في local (تخصصات أُوُلوية لعدم الكسر).
7. **`laravel-backup` على Windows** — يصنع أرشيفات zip؛ قد يحتاج الإعدادات. تُعبّأ للـ local فقط وتُوثّق.

---

## 7) خطة الاختبار (بعد كل مرحلة)

- `composer validate`
- `php artisan --version`
- `php artisan about`
- `php artisan route:list`
- `php artisan config:clear` / `cache:clear` / `view:clear`
- `php artisan migrate` (على DB تجريبية جديدة MySQL)
- `php artisan db:seed`
- `vendor/bin/phpunit` (أو `php artisan test`)
- `php artisan serve` + سيناريوهات: login (admin/doctor/pharmacist/general بـ 12345678)، dash, patients CRUD, appointment, prescription, medicine issue, wards, reports, barcode regcard, activity log, attendance, notices.