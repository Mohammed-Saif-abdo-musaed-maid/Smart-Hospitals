# UPGRADE PROGRESS — HMS (Laravel 5.8 -> 10)

> أحدث تحديث يظهر أولاً

## المرحلة 2 — الترقية الشاملة للكود والـ DB (COMPLETED ✅) + التحقق النهائي
- **تاريخ**: 2026-09-23
- **المدخلات**: Laravel 10.50.3 | PHPUnit 10.5.65 | MariaDB 12.0.2

### إصلاحات إضافية — جلسة التحقق النهائي
- **`/reportgeneration`** (ميتة 500) — بإذن المستخدم: `Route::redirect('/reportgeneration', '/clinicreports')->middleware('auth')` → تحقق حي 302 → /clinicreports. **مُرفقة في commit 1152d7f**.
- **`/emails`** (ميتة؛ `UserController@email($data,$emaillist)` بلا Request → 500 عند الزيارة المباشرة، لا رابط فيها) — `Route::redirect('/emails', '/createnoticeview')->middleware('auth')`.
- **`/outpreport`** (ميتة؛ العرض `reports/out_patient_report` غير موجود أبداً — لا في git ولا في backup، route غير موصولة بأي رابط) — `Route::redirect('/outpreport', '/attendancereport')->middleware('auth')` → **تحقق حي 302 → /attendancereport → 200**.
- **تم تثبيت laravel/framework على 10.x-dev@74e222c** مُقفَل في composer.lock (يُبلّغ version 10.50.3 عبر `artisan --version`) — تثبيت قابل للتكرار تماماً (مرجع محدد في lock).

### فحص البطارية النهائي (كلها ناجحة)
- `composer install` ✓ (بلا تغييرات ضد lock) | `php -l` على كل ملفات app/config/routes/database ✓ (ALL PHP LINT OK) | لا `${var}` interpolation deprecated ✓
- `optimize:clear` + `config:clear` + `route:clear` + `view:clear` ✓ | `view:cache` ✓
- `migrate:status --database=mysql` → **15/15 Ran** (Batch 1-3) ✓
- `php artisan test` → **2 passed (4 assertions)** ✓
- `php artisan route:list` → **82 مسار فعلي**، كلها موجودة ✓ | `/reportgeneration`+`/emails`+`/outpreport` تظهر كـ RedirectController
- Smoke حي: 21+ صفحة 200 (عبر الدخول بـ admin)، `/attendance`→302 قصدية، `/wardreport`/`/mobclinicreport`/`/clinicreports`/`/monstatreport`/`/attendancereport`/`/in-reports` كلها 200 ✓

### المنجز (من الجلسة السابقة)
1. **`.env.example` + `.env` + `key:generate`** — `APP_NAME="Hospital Management System"` (مقتبس للمسافات)، `DB_DATABASE=hms_test`، `DB_USERNAME=root`، `DB_PASSWORD=123456`، `SESSION_DRIVER=database`، `MAIL_MAILER=log`.
2. **Auth traits** — لم تعد في Laravel 10 core → `laravel/ui:^4.6.3` (يعرّف PSR-4 `Illuminate\Foundation\Auth\` فيوفر AuthenticatesUsers/RegistersUsers/SendsPasswordResetEmails/ResetsPasswords/VerifiesEmails). بدون تشغيل `php artisan ui`.
3. **Controllers** — إصلاحات خلال هذا الجلسة:
   - `PatientController.php`: حذف `use App\Http\Controllers\Redirect;` الميت، إعلان `protected $wardList;` (كان dynamic property على PHP 8.2)، إصلاح `view('register_in_patient_view')` → `view('patient.register_in_patient_view', ['data'=>$data, 'title'=>..., 'wardList'=>$wardList])` في `get_ward_list()`.
   - `LoginController.php`: حذف `use App\Http\Controllers\Auth\Request;` الميت.
   - `UserController.php`: حذف 3 استيرادات ميتة (`ValidationException`, `Contracts\Validation`, `SebastianBergmann\Environment\Console`).
   - `NoticeboardController.php`: حذف استيرادين ميتين.
   - `AttendController.php`: إزالة `dd($ids)` من `attendmore()`.
4. **Middleware** — فحص: `Authenticate`, `RedirectIfAuthenticated`, `Admin/Doctor/Staff/Pharma/SetLanguage` كلها متوافقة مع Laravel 10. **إصلاح `TrustProxies.php`**: `Request::HEADER_X_FORWARDED_ALL` محذوف في Symfony 6 → استُبدل بـ `X_FORWARDED_FOR | HOST | PORT | PROTO` (هذا كان سبب 500 الأول في `/login`).
5. **Factory + Seeder + RouteServiceProvider + Kernel** — مراجعة وتبقّي كما هي (متوافقة).
6. **`Active::checkRoute` (26× في `main.blade.php`)** — أنشأ `app/Helpers/Active.php` (class `Active` مع `checkRoute()`) وسُجّل كـ alias `'Active'` في `config/app.php` — يعمل داخل Blade.
7. **`config/mail.php`** — إعادة بناء لبنية Laravel 9+/10 (`default` + `mailers`) بدل `driver` القديم؛ أبقى env keys القديمة.
8. **`resources/views/layouts/app.blade.php`** — أنشئ (كان مفقوداً) للـ auth views الأربعة (`register`, `verify`, `passwords/email`, `passwords/reset`).
9. **Migrations — إصلاح FKs (عدم تطابق signed/unsigned)**:
   - `attendances.user_id` → `unsignedBigInteger` (users.id unsigned bigint).
   - `prescriptions.doctor_id` → unsigned، `patient_id` → signed bigInteger (يتوافق مع `patients.id` signed)، `appointment_id` → unsigned.
   - `appointments.doctor_id` → `unsignedBigInteger`.
   - `inpatients.ward_id` → `unsignedBigInteger`.
   - `medicine_prescription.prescription_id`/`medicine_id` → `unsignedBigInteger`.
   - `clinic_patient.clinic_id` → `unsignedBigInteger`.
   - **migrate كامل نجح (15/15 migration) على `hms_test`**.
10. **Seeders** — ترتيب `DatabaseSeeder`: **Users أولاً** ثم Attendances/Medicines/Patients/Wards/Clinics/Noticeboards (Attendances تحتاج users id 1-5 موجودة مسبقاً). **db:seed نجح بالكامل**: 5 users، 72 attendance، 2 wards، 90 medicines، patients+clinics+noticeboards.
11. **اختبار حي (Laravel Dev Server)**:
    - GET `/login` → 200.
    - POST login (admin `shakthisachintha@gmail.com` / `12345678`) → **302 → `/dash` → 200**، القالب (مع 26 `Active::checkRoute`) يترجم بلا أخطاء.
    - 21 صفحة رئيسية أُجريت عليها smoke test: كلها 200 ما عدا `/attendance` → 302 (قصدية: route لكشك البصمات بـ `guest` middleware) و`/reportgeneration` → 500 (**كسر موروث**: `UserController@reportgen` غير موجود ولا أي view يرتبط به — موثّق أدناه، دون تعديل).
12. **PHPUnit** — `collision` 7 يتطلب PHPUnit ≥10 لكن كان مثبت `^9.6` → ترقية إلى `phpunit ^10.1` (10.5.65) + إعادة كتابة `phpunit.xml` لشيفا PHPUnit 10 (`<source>` بدل `<filter>`، `<env MAIL_MAILER>`). تحديث `tests/Feature/ExampleTest` ليعكس سلوك `/` (302 ← login للمستخدم الزائر ثم `/login` 200). **`php artisan test` → 2 passed**.
13. **`php artisan view:cache`** — كل ملفات Blade تترجم بنجاح (فحص شامل للصياغة).

### القضايا المعروفة (مؤجلة/موروثة)
- **`/reportgeneration`** → `UserController@reportgen` (method غير موجود) → 500. لا يوجد رابط في أي view؛ كان مكسوراً في الأصل أيضاً (5.8). قُرر تغيير المسار بحاجة موافقة المستخدم إن أراد إصلاحه.
- **`/emails`** → `UserController@email($data, $emaillist)` signature بلا Request → يُحل غير صحيح إن وصلته زيارة مباشرة. موروث.
- **composer audit**: 3 advisories على `laravel/framework` (تواقيع 12/13، تصحيحاتها فقط في 12.60+/13.12+ — غير متاح لـ Laravel 10 EOL). خطر مقبول محلياً، مع خيار لاحق للانتقال إلى L11/L12 (PHP 8.2 يدعمها).
- **`User::where('fingerprint',...)`** في `AttendController`/`PatientController::validateAppNum` — عمود `users.fingerprint` موجود في الميجريشن؛ تم التحقق من المخطط.

### الملفات المعدّلة/الجديدة
- جديد: `app/Helpers/Active.php`, `resources/views/layouts/app.blade.php`
- معدّل: `config/app.php` (alias Active), `config/mail.php` (بنية L10), `app/Http/Middleware/TrustProxies.php`, `app/Http/Controllers/{PatientController,LoginController,UserController,NoticeboardController,AttendController}.php`, 6 ملفات migrations, `database/seeders/DatabaseSeeder.php` (الترتيب), `composer.json` (phpunit ^10.1), `phpunit.xml`, `tests/Feature/ExampleTest.php`

### commit
- *(مُرفع كـ `1152d7f` — بعد موافقة المستخدم على إصلاح `/reportgeneration`)*

---

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
- `d509298` baseline
- `dd65ed8` stage1: laravel 10 deps + bootstrap fixes
- `1152d7f` stage2: app code, migrations, seeders, phpunit10 (شمل `/reportgeneration` redirect)
- *ملاحظة: توجيهات `/emails` و`/outpreport` في `routes/web.php` عالقة بلا commit — بانتظار طلب المستخدم*

---

## المراحل القادمة
- [ ] **المرحلة 3** — `UPGRADE_REPORT.md` النهائي مكتوب ✅ (انظر الملف) + commit للتغييرات العالقة إن طُلب (لا يُرفع إلا بطلب صريح).
- [ ] (اختياري) الانتقال لاحقاً إلى Laravel 11/12 إن رغب (PHP 8.2 يدعم؛ يزيل 3 advisories security غير المتاحة لـ Laravel 10 EOL).