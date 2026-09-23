# مستشفى الشفاء — نظام إدارة المستشفيات (Smart Hospitals – Hospital Management System)

> **التوثيق الشامل للمشروع** — مبني على الكود الحقيقي الموجود في هذا المستودع
> (فحص فعلي لملفات `routes` و `app` و `database` و `resources` و `tests` و `composer.json` و `.env`).

---

## 1. نبذة عن المشروع

**مستشفى الشفاء** هو **نظام إدارة مستشفيات متكامل** مبني بلغة `PHP` باستخدام إطار العمل
`Laravel`. اسم المشروع الرسمي/الظاهر في الملفات هو:
**"Smart Hospitals (Hospital Management System)"** (كما في `README` القديم)، واسم
المنشأة المعروض حالياً في الواجهة هو **"مستشفى الشفاء"**.

النظام يدير دورة العمل الطبية كاملة داخل المستشفى:

- تسجيل المرضى (مرضى خارجيين `Out-Patients` ومرضى رقود `In-Patients`).
- إنشاء المواعيد (الحجوزات) اليومية.
- فحص المريض وتدوين التشخيص والقياسات الحيوية (ضغط، سكر، كولسترول).
- وصف الأدوية وصرفها من الصيدلية.
- متابعة الأجنحة/العنابر والقدرة السريرية.
- تسجيل حضور الموظفين.
- إعلانات اللوحة الداخلية (Notices).
- التقارير والإحصائيات.
- دعم التعدد اللغوي (العربية/الإنجليزية/السنهالية).

> ملاحظة مصدرية: `/README.md` القديم كان يُعرّف المشروع بأنه "a complete hospital
> management system written in php (Laravel)" مع لائحة مزايا — تم التحقق من كل ميزة
> منها في الكود ودمجها في هذا التوثيق.

---

## 2. وظيفة المشروع

معنى النظام بعبارة بسيطة جداً:

- **المشفى** يحتاج مكاناً رقمياً يدير فيه: من يسجّل، مَن يُفحص، ما الذي وُصف له، وما الذي
  صُرف له، ومن حضر ومتى، وما الذي يحدث كل يوم.
- **هذا النظام** يقوم بهذا كله عبر صفحة ويب واحدة لكل موظف حسب وظيفته.

قبل النظام كانت هذه البيانات تُدون على ورق (سجلات، ملفات مرضى، دفاتر حضور) مما يُضيع
الوقت ويصعّب إيجاد سجل مريض وصف أدوية قديمة له. النظام يخزّن كل شيء في **قاعدة بيانات
MySQL** ويسترجعه فوراً (بحث بالاسم أو الرقم الوطني أو الهاتف) ويربط المريض بمواعيده
وتشخيصاته وأدويتهم، ويصدر **تقارير** جاهزة للطباعة.

---

## 3. أهداف المشروع

1. أتمتة تسجيل المرضى (خارجي/رقود) وإصدار بطاقة تعريف تحمل **باركود**.
2. تنظيم **المواعيد اليومية** مع ترقيم تسلسلي لكل يوم.
3. تسجيل **الفحص الطبي**: التشخيص، ضغط الدم، السكر، الكولسترول، الأدوية الموصوفة.
4. إدارة **صرف الأدوية** من الصيدلية وتتبع ما صُرف فعلاً.
5. إدارة **الأجنحة** (سعة، أسرة متاحة) ورصد **المرضى المنوّمين** وخروجهم.
6. تسجيل **حضور وانصراف الموظفين** بالبصمة أو يدوياً.
7. إصدار **تقارير** الحضور والمرضى والعيادات والأجنحة مع معاينة للطباعة.
8. **إحصائيات** شهرية/سنوية برسوم بيانية.
9. تعدد **اللغات** و **الصلاحيات** حسب الدور الوظيفي.

---

## 4. المستخدمون المستهدفون

| الدور | من هو؟ |
|---|---|
| `Admin` (مدير النظام) | مدير المستشفى/مسؤول النظام — كل الصلاحيات |
| `Doctor` (طبيب) | يفحص المرضى، يدوّن التشخيص والوصفات، يعاين السجلات |
| `Pharmacist` (صيدلي) | يصرف الأدوية حسب الوصفات |
| `General` (موظف عام/استقبال) | تسجيل المرضى، الحجوزات، النوافذ العامة |

> الأدوار المذكورة هي ما خُزّن فعلياً في عمود `user_type` بجدول `users` وإعداده كقيم
> الافتراضية. لا يوجد دور "nurse" أو "reception" منفصل في قاعدة البيانات؛ موظف
> الاستقبال يُسجّل بدور `general`.

---

## 5. التقنيات المستخدمة (تم التحقق منها من الملفات)

| التقنية | الاستخدام | الإصدار |
|---|---|---|
| PHP | لغة البرمجة الخادمية | مطلوب `^8.1` — المُثبَّت فعلياً **8.2.12** |
| Laravel | إطار العمل (Framework) | المطلوب `^10.10` — المُثبَّت فعلياً **10.50.3** |
| MySQL | قاعدة البيانات (`DB_CONNECTION=mysql`) | يُستخدم محلياً (`hms_test`) — مثال الإعداد `laravel` |
| Eloquent ORM | التعامل مع قاعدة البيانات | مدمج مع Laravel |
| Blade | نظام القوالب (Templates) | مدمج مع Laravel |
| AdminLTE | قالب لوحة التحكم (Sidebar/Header/Boxes) | **2.4.12** (`public/dist/css/AdminLTE.min.css`) |
| Bootstrap | مكتبة التنسيق (CSS/JS) | **3.4.1** (في `public/bower_components/bootstrap`) |
| jQuery | مكتبة JavaScript | `^3.2` (package.json) والبوريجد في assets |
| Font Awesome / Ionicons | الأيقونات | bundled |
| Chart.js | الرسوم البيانية للإحصائيات | bundled (`bower_components/chart.js`) |
| Google Charts | تقويم الحضور Calendar | عبر CDN (`gstatic.com/charts`) |
| DataTables | جداول عرض البيانات (بحث/ترتيب/تقسيم صفحات) | bundled (`bower_components/datatables.net`) |
| typeahead.js / Bloodhound | اقتراحات البحث أثناء الكتابة (الأدوية) | bundled (`public/js/typeahead`) |
| bootstrap-datepicker | اختيار التاريخ | bundled |
| milon/barcode | توليد **الباركود** على بطاقة المريض | `^10.0` |
| spatie/laravel-activitylog | سجل النشاطات (`activity_log`) | `^4.7` |
| spatie/laravel-backup | النسخ الاحتياطي المجدول | `^8.1` |
| barryvdh/laravel-dompdf | توليد PDF (حزمة مثبّتة) | `^3.0` |
| sendgrid/sendgrid | إرسال الإشعارات بريدياً | `^8.0` |
| guzzlehttp/guzzle | HTTP client | `^7.5` |
| laravel/tinker | أوامر تفاعلية | `^2.8` |
| laravel/ui | أدوات المصادقة UI | `^4.0` |
| phpunit (+fakerphp, mockery, collision) | أدوات الاختبار (dev) | phpunit `^10.1` |

---

## 6. Frameworks

- **Backend:** Laravel 10 (MVC) — يعمل بنمط Request → Route → Middleware → Controller → Model/DB → View/Response.
- **Frontend:** AdminLTE 2.4.12 فوق Bootstrap 3.4.1 + jQuery + Chart.js + DataTables.

---

## 7. لغات البرمجة

- **PHP** (الخلفية): الـ Controllers و الـ Models و الـ Migrations و الـ Middleware.
- **HTML / CSS / JavaScript / jQuery** (الواجهة): داخل قوالب `Blade` + ملفات `public/`.
- تستخدم القوالب أيضاً `Blade` directives و `@php` blocks داخل الصفحات.
- **SQL** (استعلامات مباشرة): عبر `DB::table()->...` و `DB::raw(...)` في عدة مواضع.

---

## 8. بنية النظام (لمحة معمارية بسيطة)

```
المستخدم (Admin/Doctor/Pharmacist/General)
        │
        ▼
     المتصفح (Browser)
        │  HTTP request (GET/POST)
        ▼
     Laravel Public index.php (public/index.php)
        │
        ▼
     Routes  →  routes/web.php
        │  يطابق الرابط مع المسار المسمّى
        ▼
     Middleware (auth, admin/doctor/staff/pharmacist, lang, CSRF...)
        │  يتحقق هل المستخدم صالح ام لا؟
        ▼
     Controller (app/Http/Controllers/...)
        │  يقرأ/يكتب من قاعدة البيانات
        ▼
     Model / Eloquent  ←── الجداول
        │
        ▼
     Blade View (resources/views/...)
        │
        ▼
     HTML Response  ←  يعرضها المتصفح
```

---

## 9. كيف يعمل النظام (مثال حقيقي بالملفات)

سنتبع مثالاً حقيقياً: **إنشاء موعد (حجز)** من صفحة الويب إلى قاعدة البيانات والعكس.

```
GET /createchannel
   Route (routes/web.php:47) "create_channel_view"
   → middleware(auth, staff, lang)
   → PatientController@create_channel_view
       → يقرأ مواعيد اليوم: DB::table('appointments')
           ->join('patients', ...) (routes web 47... الكود في app/Http/Controllers/PatientController.php:410)
   → يعرض view('patient.create_channel_view', ...)

بعدها المستخدم يدخل رقم تسجيل المريض:
POST /channel
   Route "makechannel" (web.php:45)
   → PatientController@getPatientData (PatientController.php:610)
       → Patients::find($regNum) → returns JSON {exist,name,sex,...,appNum}

POST /appoint
   Route "makeappoint" (web.php:46)
   → PatientController@addChannel (PatientController.php:636)
       → $app = new Appointment; $app->number = (عدد مواعيد اليوم)+1; $app->patient_id = $pid; $app->save();
   → إرجاع JSON باسم المريض ورقم الموعد الجديد
```

وكذلك **تسجيل مريض**:

```
POST /patientregister
   Route "patient_register" (web.php:52) → middleware(auth, staff)
   → PatientController@registerPatient (PatientController.php:135)
       → يحسب رقم التسجيل YYMMDD+seq (مثال: 26+09+23+1 = 2609231)
       → $patient->id = $reg_num; $patient->save();
       → يحفظ صورة المصورة base64 في storage/app/public/{id}.png
       → activity()->log('Patient Registration Success')
```

---

## 10. Architecture (المسار الكامل للطلب)

```
Request
   ↓
routes/web.php (التعريف والربط والميدل وير)
   ↓
app/Http/Kernel.php (تحميل الـ middleware groups والـ route middleware)
   ↓
https://middleware الأمن: Authenticate → Admin|Doctor|Staff|Pharma → SetLanguage
   ↓
Controller (logic)
   ↓
Model (Eloquent / DB facade) ↔ Database (MySQL)
   ↓
Blade View ← template/main.blade.php (القالب الأساسي)
   ↓
Response HTML
```

لا توجد خدمة API قائمة بذاتها: `routes/api.php` يحتوي مساراً واحداً تجريبياً فقط
(`GET /api/user` بـ `auth:api` التقليدية التي لا تُستخدم في أي ميزة قائمة).

---

## 11. Authentication (تسجيل الدخول)

- **Controller:** `app\Http\Controllers\Auth\LoginController.php` (يستخدم trait `AuthenticatesUsers`).
- **المسارات:** `GET /login` لعرض الصفحة، `POST /login` لتنفيذ الدخول، `POST /logout` للخروج.
- **الحقول المطلوبة:** `email` + `password` (المصادقة بالبريد الإلكتروني).
- **المصادقة:** `Auth::attempt()` مع التحقق من **كلمة مرور مشفّرة** `bcrypt` (`Hash::check`).
- **بعد الدخول:** توجيه إلى `redirectTo = '/dash'` (الشاشة الرئيسية).
- **الحماية:** ميدل وير `auth` يُطلب في كل المسارات تقريباً؛ ميدل وير `guest`
  (RedirectIfAuthenticated) يُعيد المسجّل دخولاً إلى `/dash`.
- نسيان كلمة المرور: مسارات قياسية (`password/email`, `password/reset`) عبر
  `Auth\ForgotPasswordController` و `Auth\ResetPasswordController`.

### حسابات موجودة فعلياً (من Seeders)

| البريد (email) | كلمة المرور | الدور |
|---|---|---|
| `shakthisachintha@gmail.com` | `12345678` | admin (من `UsersTableSeeder`) |
| `ssakunchamikara@gmail.com` | `12345678` | doctor (من `UsersTableSeeder`) |
| `sachinthaindu95@gmail.com` | `12345678` | pharmacist (من `UsersTableSeeder`) |
| `sanduniiresha1029@gmail.com` | `12345678` | general (من `UsersTableSeeder`) |
| `hasikadilshani@gmail.com` | `12345678` | general (من `UsersTableSeeder`) |
| `admin@shifa-hospital.com` | `Admin@12345` | admin (من `DemoDataSeeder`) |
| `dr.khaled@shifa-hospital.com` | `Doctor@12345` | doctor (من `DemoDataSeeder`) |
| `dr.amal@shifa-hospital.com` | `Doctor@12345` | doctor (من `DemoDataSeeder`) |
| `pharmacist@shifa-hospital.com` | `Pharmacist@12345` | pharmacist (من `DemoDataSeeder`) |
| `reception@shifa-hospital.com` | `Reception@12345` | general (من `DemoDataSeeder`) |
| `staff@shifa-hospital.com` | `Staff@12345` | general (من `DemoDataSeeder`) |

> كلمات المرور أعلاه من كود الـ Seeders نفسها (تم التحقق منها حرفياً). حساب نسيان
> كلمة المرور يعيدها إلى `12345678` (يُنفَّذ في `UserController::resetUser`).

---

## 12. Roles & Permissions (الصلاحيات الفعلية)

الصلاحيات تُنفَّذ عبر **ميدل وير مخصص** يقرأ عمود `user_type`:

| الميدل وير | يمنح الوصول لمن | الملف |
|---|---|---|
| `admin` | `user_type == 'admin'` فقط | `app/Http/Middleware/Admin.php` |
| `doctor` | `doctor` أو `admin` | `app/Http/Middleware/Doctor.php` |
| `staff` | `general` أو `doctor` أو `admin` | `app/Http/Middleware/Staff.php` |
| `pharmacist` | `pharmacist` أو `admin` | `app/Http/Middleware/Pharma.php` |
| `lang` | الجميع (يضبط اللغة من الجلسة) | `app/Http/Middleware/SetLanguage.php` |

### جدول الوظائف حسب الدور

| الوظيفة | Admin | Doctor | Pharmacist | General |
|---|---|---|---|---|
| لوحة المعلومات (Dashboard) | ✔ | ✔ | ✔ | ✔ |
| تسجيل مريض خارجي / بحث / ملف / بطاقة | ✔ | ✔ | — | ✔ |
| تسجيل مريض منوّم (رقود) | ✔ | ✔ | — | ✔ |
| إنشاء موعد (حجز) | ✔ | ✔ | — | ✔ |
| فحص المريض (تشخيص + وصفة) | ✔ | ✔ | — | — |
| تعديل/حذف ملف مريض | ✔ | ✔ | — | — |
| صرف الأدوية (الصيدلية) | ✔ | — | ✔ | — |
| حضور الموظفين و"المزيد" | ✔ | سجلّ فقط* | سجلّ فقط* | سجلّ فقط* |
| إدارة المستخدمين (جديد/بصمة/إعادة ضبط) | ✔ | — | — | — |
| الإشعارات (create/send/delete) | ✔ | — | — | — |
| الإحصائيات | ✔ | — | — | — |
| التقارير (عيادة/شهرية/حضور/جناح) | ✔ | ✔ | ✔ | ✔ |
| الأجنحة (عرض وإضافة) | ✔ | ✔ | — | ✔ |

\* رغم أن "My Attendance" يظهر للجميع، فالعنصر "More..." في القائمة الجانبية شرطُه في
الكود `user_type=='Admssin'` (خطأ إملائي في الـ Blade) وبالتالي لا يظهر لأي دور عملياً.
الروابط الـ 4 كلها قد حُدّدت من `resources/views/template/main.blade.php` (القائمة الجانبية)
ومن تعريفات `routes/web.php`.

---

## 13. Dashboard (لوحة المعلومات `/dash`)

- **Route:** `'dash'` (`GET /dash`) → `HomeController@index` (middleware: `auth, lang`).
- المنطق في `app/Http/Controllers/HomeController.php:26`:
  - عدّ الأطباء (`user_type='doctor'`)، الموظفين العامين (`general`)، الصيادلة (`pharmacist`).
  - عدّ المرضى المنوّمين الحاليين (`inpatients` حيث `discharged='NO'`).
  - آخر الإشعارات (join `noticeboards` مع `users` لاسم المُرسل ودوره).

### عناصر القائمة الجانبية (Sidebar) — من `template/main.blade.php`

| العنصر | ماذا يفعل؟ | لمن يظهر؟ |
|---|---|---|
| **Dashboard** | يعرض الإحصائيات السريعة + الإعلانات | الجميع |
| **Patient** (شجرة) | Register New / Search / Profile / Register In-Patient | غير `pharmacist` |
| ↳ Discharge In-Patient | خروج مريض منوم وزيادة الأسرة المتاحة | `doctor` أو `admin` |
| **Create Appoinment** | صفحة إنشاء حجز اليوم | غير `pharmacist` |
| **Check Patient** | فحص مريض: تشخيص + وصفة + قياسات | `admin` أو `doctor` |
| **Issue Medicine** | صرف الدواء للوصفة | `pharmacist` أو `admin` |
| **Attendance** | My Attendance (+ More مخصص متعطّل كما ورد) | الجميع |
| **Users** (شجرة) | New User / Register Fingerprint / Reset User | `admin` فقط |
| **Profile** | ملف المستخدم وتعديل بياناته | الجميع |
| **Wards** | عرض الأجنحة وإضافة جناح | غير `pharmacist` |
| **Notices** | إنشاء وإرسال وحذف الإعلانات | `admin` فقط |
| **Statistics** | صفحة الإحصائيات والرسوم | `admin` فقط (المسار يتطلب doctor+admin ⇒ فعلياً admin) |
| **Report Generation** (شجرة) | Clinic / Monthly Statistic / In-Patient Stats / Attendance Report | الجميع (بدون صلاحيات فرعية حسب الدور) |

> ملاحظة توثيقية: كانت هناك عقدة "**Template**" في القائمة الجانبية تشير إلى رابط خارجي
> تجريبي لقالب AdminLTE (`https://adminlte.io/...`) وليست ميزة نظام حقيقية (لا يخصها
> route ولا controller)، وقد أُزيلت من القائمة في تحديث سابق. (انظر قسم Optional Features).

---

## 14. Patients (المرضى)

### 14.1 تسجيل مريض خارجي

- **Route:** `POST /patientregister` (`patient_register`) → `PatientController@registerPatient`.
- **View:** `patient/register_patient.blade.php`.
- **المدخلات:** الاسم، العنوان، المهنة، الجنس (ذكر/أنثى)، تاريخ الميلاد، الهاتف، الرقم
  الوطني NIC، صورة من الكاميرا (webcam).
- **كيف يُحفظ؟**
  - رقم التسجيل يُولَّد تلقائياً: `YEAR%100 + month + day + تسلسل اليوم`
    (مثال في 23/09/2026 أول مريض = `2609231`).
  - `$patient->id = $reg_num` (المفتاح الأساسي **يدوي** وليس تلقائياً — `$incrementing=false`).
  - الصورة تُحفظ `base64 → storage/app/public/{id}.png`.
- **النتيجة:** رسالة نجاح + رقم مريض + سجل Activity.
- **البطاقة:** `GET /patientregcard/{pid}` → `patient/patient_reg_card.blade.php` يعرض بطاقة
  بها **باركود** (`DNS1D::getBarcodePNGPath(..., "C39+")`) وصورة المريض.

### 14.2 البحث

- **Route:** `GET /searchpatient` + `GET /search` (`searchPatient` / `searchData`).
- **الفلاتر:** بالاسم `name` أو الرقم الوطني `nic` أو الهاتف `telephone` (بحث `LIKE`).
- `PatientController::patientData` → يعيد النتائج مع `withTrashed()` (يُظهر المحذوفين ناعماً).

### 14.3 تعديل / حذف / استعادة

- تعديل: `POST /editpatient` (نموذج) ثم `POST /updatepatientdetails` — للـ `doctor`/`admin`.
- حذف ناعم/استعادة: `GET /patient-delete/{id}/{action}` (delete/restore) — `SoftDeletes`.

### 14.4 ملف المريض والتاريخ العلاجي

- `patientProfile($id)` → `patient/profile/profile.blade.php` (البيانات + الحالة + آخر زيارة).
- `patientHistory($id)` → `patient/history/index.blade.php` يعرض **الوصفات السابقة** مرتبة.
- **العلاقة بالوصفات:** `Patient → Prescription (patient_id)`.

### 14.5 مثال عملي ببيانات تجريبية (موجودة فعلاً في DemoDataSeeder)

| الحقل | القيمة |
|---|---|
| رقم التسجيل | `10001` |
| الاسم | أحمد يحيى العمراني |
| الجنس | ذكر |
| تاريخ الميلاد | 1985-03-12 |
| المهنة | معلم |
| العنوان | صنعاء - حدة - شارع الخمسين |
| الهاتف | +967771234567 |

---

## 15. Doctors (الأطباء)

- **الطبيب هو مستخدم عادي في جدول `users`** بدور `user_type='doctor'`.
- **لا يوجد جدول منفصل باسم doctors** (لم يُعثر على مثل هذا الجدول أو Migration).
- كيف يرتبط الطبيب بالمريض؟
  - في **الموعد**: عمود `appointments.doctor_id` (يُحدَّد عند الفحص أو عند تحويل المريض لمنوّم).
  - في **الوصفة**: عمود `prescriptions.doctor_id` = الطبيب الذي دوّن الوصفة.
  - في **الجناح**: عمود `wards.doctor_id` = الطبيب المسؤول عن الجناح.
  - في **العيادات**: عمود `clinics.doctor_id`.
- صلاحيات الطبيب: فحص المرضى، الوصفات، تعديل/حذف ملفات المرضى، تقارير العيادات
  والشهرية، خروج المرضى المنوّمين.

---

## 16. Appointments (المواعيد / "Create Appointment")

- **Route GET:** `/createchannel` (`create_channel_view`) → `PatientController@create_channel_view`.
- **المنطق:** تعرض مواعيد اليوم الحالي (join مع `patients`).
- **التدفق:**
  1. يدخل الموظف رقم تسجيل المريض → `POST /channel` (`getPatientData`) يعيد بياناته.
  2. `POST /appoint` (`addChannel`) ينشئ سطر `appointments` جديداً:
     - `number =` عدد مواعيد اليوم السابقة + 1 **(رقم تسلسلي يومي)**.
     - `patient_id` = رقم المريض.
     - `admit = 'NO'` افتراضياً (مرضى خارجي).
     - `completed = 'NO'` افتراضياً.
     - `doctor_id = null` (يُملأ لاحقاً عند الفحص).
  3. لا يوجد عمود تاريخ/وقت مستقل للـ Appointment؛ **التاريخ هو `created_at`**
     (اليوم الذي أُنشئ فيه) و**الوقت غير منفصل** — البحث عن مواعيد اليوم يتم عبر
     `date(created_at)=CURDATE()`.

### دورة الموعد

```
create_channel_view  →  getPatientData (تحقق من مريض)  →  addChannel (number يزداد)
     → check_patient_view: validateAppNum (بحث بالرقم أو رقم التسجيل)
     → checkPatientSave: completed='YES' + doctor_id = الطبيب الحالي
     → (اختياري) markInPatient: admit='YES'  →  register In-Patient
```

---

## 17. Check Patient (فحص المريض)

- **Route GET:** `/checkpatient` (`check_patient_view`) — للـ `doctor`/`admin`.
- **Route POST:** `validateAppNum` (تأكيد وجود موعد اليوم)، `checkPatient` (تحميل الصفحة)،
  `checkSave` (حفظ الفحص)، `addToClinic` (إضافة لعيادات المريض).
- **ماذا يحدث؟**
  1. الطبيب يدخل رقم الموعد (أو رقم تسجيل المريض) → يعيد النظام اسم المريض.
  2. `checkPatient` يجلب آخر الوصفات لعرض قياسات سابقة (ضغط/سكر/كولسترول) وبيانات المريض.
  3. الطبيب يدخل: **التشخيص** `diagnosis`، **ضغط الدم**، **سكر الدم**، **الكولسترول**،
     قائمة **أدوية** من الاقتراحات (typeahead).
  4. `checkPatientSave`:
     - ينشئ `prescriptions` (كل القياسات تُحفظ بصيغة JSON).
     - يحدّث الموعد: `completed='YES'` و `doctor_id` الحالي.
     - ينشئ سجلات `medicine_prescription` لكل دواء (مع `note`).
- **أين تُحفظ؟** `prescriptions` (المحور) + `medicine_prescription` (الأدوية).
- **العلاقات:** Prescription ← Appointment (أوبالموعد) ← Patient؛ Prescription ← User (الطبيب).

---

## 18. Medicines / Pharmacy (الأدوية وصرفها)

- **الجدول:** `medicines` (id, name_sinhala متنوعة, name_english, type_sinhala, type_english, qty).
- **Issue Medicine (الصيدلية):**
  - `GET /issueMedicine/` (`issueMedicineView`) → نموذج إدخال رقم موعد أو رقم مريض.
  - `POST /issuemed-validate` (`issueMedicineValid`) → يبحث عن موعد **اليوم** ووصفته.
  - `GET /issue/{presid}` → صفحة الأدوية الخاصة بالوصفة (`patient/show.blade.php`).
  - `POST /issuemark` (`markIssued`) → لكل دواء: `medicine_prescription.issued='YES'`
    **و** تزيد `medicines.qty` (سلوك فعلي: qty تُستخدم كعداد صرف هنا).
  - `GET /med-issue-save` (`medIssueSave`) → `prescriptions.medicine_issued='YES'` ويعرض
    **إيصال الصرف** (`medicine/receipt.blade.php`).
- **وصفة للعلاقات:** `Prescription` ↔ `Medicine` عبر pivot `medicine_prescription`
  (belongsToMany ذهابا وإيابا). `Prescription_Medicine` model يستخدم الجدول `medicine_prescription`.
- لا يوجد جدول مخزون (Inventory) منفصل أو جدول Pharmacy؛ المخزون مُمثَّل بجدول
  `medicines` وحده (مع تحفظ: `qty` تُزايد عند الصرف وليس تنقص — انظر Known Issues).

---

## 19. Attendance (الحضور)

- **الجدول:** `attendances` (id, user_id, start, end, unique[user_id,start]).
- **التسجيل:**
  - `markAttendance` (في `AttendController`) ينتظر `finger` (رقم بصمة من `users.fingerprint`)
    و `time`:
    - إن وُجد سجل اليوم بدون `end` → يملأ `end` (خروج).
    - وإلا → ينشئ سطراً جديداً بـ `start` (دخول).
    - يستخدم `activity()` لتسجيل كل عملية.
  - ⚠️ ملاحظة مُوثّقة: مسار الويب `GET /attendance` مُعرّف إلى `AttendController@markattendance`
    بينما اسم الدالة الفعلي هو `markAttendance` (لا يوجد `markattendance`) → طلب `/attendance`
    يُنتج خطأ "method does not exist" ولا توجد Route POST تربط الجهاز. (راجع Known Issues).
- **العرض:**
  - `GET /myattend` → عرض يومي (تاريخ + مدة العمل بساعات + تفاصيل) + **تقويم Google Charts**.
  - `GET /attendmore` → كل المستخدمين (صفحة "More Attendance") — route تحمل ميدل وير `admin`.
  - `POST /getyearattendance` و `POST /getattendancebyid` للتصفية بالعام.

---

## 20. Notices (الإعلانات / اللوحة)

- **الجدول:** `noticeboards` (subject, description, user_id, time).
- **الإنشاء/الحذف:** `NoticeboardController@addnotice` / `@deletenotice`
  (routes `addnotice` / `deletenotice` بحماية `auth`؛ الواجهة تُظهرها للمدير فقط).
- **الإرسال:** `UserController@send_notice` (`POST /sendnotice`) يرسل الرسالة **بريداً**
  (SendGrid عبر `env('SEND_KEY')`) **و/أو SMS** (خدمة textit.biz برابط URL) إلى مجموعات
  حسب `user_type` (admin/doctor/pharmacist/general).
- **العرض:** تظهر في **لوحة المعلومات** (Dashboard Noticeboard) مع اسم المُرسل ودوره
  (join مع `users`).

---

## 21. Statistics (الإحصائيات)

- **Route:** `GET /stats` (`stats`) و `POST /stats-old` → `AnalyticsController@index`
  (middleware: `doctor`, `admin` ⇒ فعلياً للمدير فقط؛ لن يُمرّ الطبيب من `admin`).
- **البيانات:**
  - مرضى خارجيون هذا الشهر (`appointments` completed=YES + admit=NO).
  - مرضى رقود هذا الشهر (`admit=YES`).
  - تسجيلات مرضى جديدة هذا الشهر (`patients.created_at`).
  - إجمالي الفحوصات هذا الشهر (جميع `appointments`).
  - أعلى 10 أدوية صرفاً (`medicines.qty` DESC).
  - الأدوية الأكثر وصفاً `thisMonthTrends(...)` — انتبه: `$month=2` **مثبتة يدوياً**
    في الكود (راجع Known Issues).
- **الرسوم:** Chart.js — أعمدة شهرية (ذكور/إناث/الكل) لمرضى خارجي/رقود/تسجيلات +
  رسوم Doughnut للأدوية. اختيار عام مختلف متاح 2018–2020 فقط.

---

## 22. Reports (التقارير)

| التقرير | المسار | Controller | النتيجة |
|---|---|---|---|
| Clinic Report | `GET /clinicreports` | `ReportController@viewclinicreport` | نموذج اختيار عيادة + صفحات |
| Print Clinic | `POST /printclinicreports` | `printclinicreport` | نموذج طباعة |
| Mobile Clinic | `GET /mobclinicreport` | `view_mobile_clinic_report` | نموذج |
| Monthly Statistic | `GET /monstatreport` | `view_monthly_static_report` | أرقام شهرية (موظفين، مرضى، أسرة، منوّمين...) |
| In-Patient Stats | `GET /in-reports` + `/reports-data` | `PatientController@inPatientReport` / `inPatientReportData` | جدول المنوّمين بتاريخ محدد |
| Ward Report | `GET /wardreport` | `view_ward_report` | نموذج تقرير جناح |
| Attendance Report | `GET /attendancereport` | `view_attendance_report` | نموذج (start/end/type) |
| Generate | `POST /generatereports` | `gen_att_reports` | جدول الحضور حسب النوع |
| Preview/Print | `GET /allprintpreview` | `all_print_preview` | صفحة معاينة للطباعة |

### كيف يعمل تقرير الحضور؟
1. صفحة `attendance_reports.blade.php` تدخل **تواريخ** (`start`, `end`) و**نوع** التقرير:
   - `All` (الكل)، `My Attendance` (حضوري)، `Doctors` (الأطباء)، `General Staff` (الموظفون).
2. `gen_att_reports` يبني الاستعلام (join attendances+users) ويحسب لكل موظف:
   `attended` (أيام العمل > 7 ساعات) و `shortleave` (أيام < 5 ساعات).
3. النتيجة تعرض في `reports/attendance-reports/all_attendance_report.blade.php`.
4. `all_print_preview` يعرض نسخة طباعة (نوع "المعالجة" مسبوقاً بالمعلومات نفسها).
5. أزرار الطباعة/PDF متوفرة في القالب. (البيانات تُطبع عبر jsPDF/print ورقة العروض.)

> التقرير الشهري `view_monthly_static_report` يحسب `noemp` (موظفون حضروا)، `avgpatient`
> (متوسط مرضى/يوم)، `wardcnt`, `bedcnt` (أسرة), `inpcnt` (منوّمون), `dispcnt` (مُخرجون),
> `admindaycnt`, `doctordaycnt`, `fa` (مرضى أول مرة), `sa` (عودة), `total` (إجمالي المواعيد).

---

## 23. Template (قسم القوالب في الواجهة)

- ما يظهر في الـ Sidebar باسم "Template" في الأصل كان **رابطاً ثابتاً خارجياً**
  إلى صفحة معاينة قالب AdminLTE (`https://adminlte.io/themes/AdminLTE/index2.html`)
  — لا يخصه **أي Route** ولا **أي Controller** في هذا المشروع.
- أُزيل هذا الرابط من القائمة الجانبية في تحديث سابق (لا يُستدعى من أي شيء).
- لا تخلط بينه وبين مجلد القوالب `resources/views/template/` الذي يحتوي **الطبقات
  الأساسية للنظام**: `main.blade.php` (اللوحة)، `plain.blade.php` (صفحات بسيطة)،
  `auth.blade.php` (صفحة تسجيل الدخول) — هذه **جوهر النظام ولا تُحذف**.
- بالتالي: قسم "Template" = **ميزة اختيارية/إزالة** (Optional / Removed), وليس وظيفة قائمة.

---

## 24. Database (قاعدة البيانات)

- **الاسم:** الإعداد الفعلي المحلي `hms_test` (من `.env` الحالي) — بينما `.env.example`
  يذكر `laravel` كقيمة نموذجية.
- **النوع:** MySQL (`DB_CONNECTION=mysql`).
- تُنشأ الجداول بالكامل عبر **Migrations** (في `database/migrations/`).

## 25. Database Tables (بنية الجداول)

| الجدول | الغرض | أهم الأعمدة |
|---|---|---|
| `users` | المستخدمون/الموظفون | id, name, email(unique), password, user_type, contactnumber, fingerprint, img_path, education, location, skills, notes |
| `patients` | المرضى (رقم يدوي) | id(PK يدوي YYMMDD+seq), name, address, sex, bod, nic, telephone, occupation, civil_status, guardian..., `deleted_at` (SoftDeletes) |
| `appointments` | المواعيد اليومية | id, patient_id(FK), number, doctor_id(FK nullable), admit, completed |
| `prescriptions` | الوصفات/الفحص | id, doctor_id(FK), patient_id(FK), appointment_id(FK), diagnosis, bp(json), cholestrol(json), blood_sugar(json), medicines(json), medicine_issued |
| `medicines` | الأدوية | id, name_sinhala(unique), name_english(unique), type_sinhala, type_english, qty |
| `medicine_prescription` | pivot (وصفة↔دواء) | id, prescription_id(FK), medicine_id(FK), note, issued |
| `attendances` | الحضور | id, user_id(FK), start, end, unique(user_id,start) |
| `wards` | الأجنحة | id, ward_no(unique), beds, free_beds, doctor_id |
| `inpatients` | المرضى المنوّمون | id, patient_id, ward_id(FK), discharged, discharged_date, house_doctor, approved_doctor, disease, duration, condition, certified_officer, patient_inventory |
| `clinics` | العيادات | id, name_eng, name_sin, recuring, start-date, doctor_id |
| `clinic_patient` | pivot (مريض↔عيادة) | patients_id(FK), clinic_id(FK), unique(patients_id,clinic_id) |
| `noticeboards` | الإعلانات | id, subject, description, user_id, time |
| `activity_log` | سجل النشاط (spatie) | id, log_name, description, subject_type, subject_id, causer_type, causer_id, properties, batch_uuid |
| `sessions` | الجلسات | (Laravel default) |
| `password_resets` | إعادة تعيين كلمة المرور | email, token, created_at |
| `migrations` | سجل الـ migrations | (Laravel default) |

## 26. Relationships (العلاقات المعرَّفة في الكود)

| العلاقة | النوع | الملف |
|---|---|---|
| User ←hasMany→ Attendance | hasMany | `app/User.php:41` |
| Patient ←hasMany→ (Patient_History — غير موجود!) | hasMany | `app/Patients.php:18` |
| Patient ←belongsToMany→ Clinic (via clinic_patient) | belongsToMany | `app/Patients.php:28` |
| Appointment ←belongsTo→ Patient | belongsTo | `app/Appointment.php:12` |
| Prescription ←belongsTo→ Appointment / User / Patient | belongsTo | `app/Prescription.php` |
| Prescription ←belongsToMany→ Medicine (via medicine_prescription) | belongsToMany | `app/Prescription.php:16` |
| Medicine ←belongsToMany→ Prescription | belongsToMany | `app/Medicine.php:17` |
| Clinic ←belongsToMany→ Patient / belongsTo User(doctor) / addPatientToClinic | belongsToMany/hasOne | `app/clinic.php` |

## 27. ERD نصي مبسط (علاقات حقيقية فقط)

```
users
 ├── hasMany ────────────────► attendances
 ├── doctor_id (في) appointments / prescriptions / wards / clinics
 └── user_id (في) noticeboards

patients (id يدوي)
 ├── belongsToMany ◄───────── Clinic (عبر clinic_patient)
 ├── hasMany ────────────────► appointments (patient_id)
 ├── hasMany ────────────────► prescriptions (patient_id)
 └── hasOne/One-to-many ─────► inpatients (patient_id)

appointments
 ├── belongsTo ──────────────► patients
 ├── belongsTo ──────────────► users (doctor_id)
 └── hasOne ─────────────────► prescriptions (appointment_id)

prescriptions
 ├── belongsTo ──────────────► users (doctor_id)
 ├── belongsTo ──────────────► patients
 ├── belongsTo ──────────────► appointments
 └── belongsToMany ──────────► medicines (عبر medicine_prescription)

wards
 └── hasMany ────────────────► inpatients (ward_id)
```

---

## 28. Project Structure (هيكل المشروع)

```
Hospital-Management-System-Laravel-updated/
├── app/                          # منطق التطبيق (PHP)
│   ├── Http/
│   │   ├── Controllers/          # الـ Controllers (Home, Patient, Medicine, Attend,
│   │   │                         #   Report, User, Ward, Analytics, Noticeboard, Auth)
│   │   ├── Middleware/           # Admin, Doctor, Staff, Pharma, SetLanguage, ...
│   │   └── Kernel.php            # تسجيل الـ middleware
│   ├── Providers/                # AppServiceProvider, AuthServiceProvider, ...
│   ├── Helpers/Active.php        # دالة تحديد العنصر النشط في القائمة
│   ├── Mail/SendNotices.php      # كلاس بريد الإشعارات
│   └── Models في الجذر: User.php, Patients.php, Appointment.php, Prescription.php,
│       Medicine.php, Attendance.php, Ward.php, inpatient.php, clinic.php, noticeboard.php,
│       Prescription_Medicine.php
├── bootstrap/                    # بدء تشغيل الإطار
├── config/                       # إعدادات التطبيق (app, auth, database, mail, backup, ...)
├── database/
│   ├── migrations/               # تعريف الجداول
│   ├── seeders/                  # تعبئة البيانات (DatabaseSeeder + 9 Seeders)
│   └── factories/                # Factories: User, Medicine, Attendance
├── public/                       # الملفات العامة (أني للوصول)
│   ├── dist/                      # AdminLTE 2.4.12
│   ├── bower_components/          # Bootstrap 3.4.1, jQuery, Chart.js, DataTables, datepicker...
│   ├── js/                        # webcam, typeahead, jsPDF, jquery.printPage
│   ├── css/                       # app.css, rtl.css (RTL للعربية), theme.css, bsutility.css
│   └── images/                    # صور الرفع (لوحات المستخدمين)
├── resources/
│   ├── views/                     # قوالب Blade (auth, attendance, patient, reports, stat,
│   │                             #   users, ward, medicine, template/{main,plain,auth}, dash...)
│   └── lang/                      # en.json, si.json, ar.json + ملفات PHP للتحقق
├── routes/
│   ├── web.php                    # كل مسارات الويب (82 مساراً)
│   ├── api.php                    # مسار API تجريبي واحد
│   ├── console.php
│   └── channels.php
├── storage/                       # جلسات، سجلات، ملفات مرفوعة (بطاقات المرضى)
├── tests/                         # Feature + Unit (مثالان)
├── composer.json / composer.lock  # اعتماديات PHP
├── package.json / webpack.mix.js  # إعداد build لـ laravel-mix (اختياري — الأصول جاهزة)
└── .env.example                   # قالب إعدادات البيئة
```

---

## 29. Installation (دليل التثبيت)

> مطلوب: **PHP 8.1+** و **Composer** و **MySQL** (لا يحتاج Node.js للتشغيل لأن الأصول
> الجاهزة موجودة في `public/`؛ `npm` فقط لبناء Mix وليس إلزامياً للاستخدام العادي).

1. تثبيت **PHP** (يفضّل 8.2) وتأكد أنه في PATH.
2. تثبيت **Composer**.
3. (اختياري) تثبيت **Node.js** إن أردت تشغيل `npm run dev` لبناء الأصول — غير مطلوب.
4. أنشئ قاعدة بيانات MySQL (مثال: `hms_test`).
5. انسخ `.env.example` إلى `.env`:
   ```bash
   copy .env.example .env
   ```
6. عدّل `.env`:
   ```ini
   APP_NAME="Hospital Management System"
   APP_KEY=
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hms_test
   DB_USERNAME=root
   DB_PASSWORD=
   ```
7. ثبّت الاعتماديات:
   ```bash
   composer install
   ```
8. ولّد مفتاح التطبيق:
   ```bash
   php artisan key:generate
   ```
9. نفّذ الـ migrations (ينشئ الجداول):
   ```bash
   php artisan migrate
   ```
10. عبّئ قاعدة البيانات (اختياري لكنه مفيد للعرض):
    ```bash
    php artisan db:seed
    ```
11. ابدأ الخادم:
    ```bash
    php artisan serve
    ```
12. افتح `http://localhost:8000` وسجّل الدخول بأحد الحسابات من قسم Authentication.

> ⚠️ إن أردت بيانات العرض العربية (حسابات `@shifa-hospital.com` وغيرها) شغّل:
> `php artisan db:seed --class=DemoDataSeeder` (هذا الـ Seeder آمن ويعمل عدّة مرات).
> لا تُدخِل `db:seed` بشكل متكرر مسارات غير جاهزة للتكرار — انظر أدناه.

---

## 30. Configuration (الإعدادات)

| الملف | الوظيفة |
|---|---|
| `.env` | الاتصال بقاعدة البيانات، البريد، الجلسة، التخزين |
| `config/app.php` | اسم التطبيق، `env`, `debug`, `locale='en'`, `fallback_locale='en'` |
| `config/auth.php` | الحارس `web` (session) + `api` (token) |
| `config/database.php` | الاتصال الافتراضي `mysql` |
| `config/mail.php` | إعداد البريد |
| `config/backup.php` | إعداد النسخ الاحتياطي (spatie/laravel-backup) |
| `config/services.php` | مفاتيح خدمات خارجية (SendGrid من env) |
| `config/active.php` | إعدادات قديمة لرزنامة active (غير مستخدمة حاليًا) |

---

## 31. Running the Project (التشغيل)

```bash
php artisan serve          # http://localhost:8000
php artisan optimize:clear # مسح الكاش بعد تغيير الكود/الـ views
php artisan route:list     # استعراض كل المسارات
php artisan view:cache     # تجميع القوالب
```

---

## 32. Login (تسجيل الدخول)

1. افتح `/login`.
2. أدخل البريد الإلكتروني وكلمة المرور.
3. بعد النجاح تُنقل إلى `/dash`.
4. لتغيير اللغة: من قائمة اللغة أعلى الصفحة (`EN` / `සිං` / `ع`) → route `/lang/{en|si|ar}`.
5. تسجيل الخروج عبر button في قائمة المستخدم.

---

## 33. User Guide (دليل المستخدم)

### 33.1 إنشاء موعد (Create Appointment)

**الهدف:** حجز مريض ليومه برقم تسلسلي.

**طريقة الاستخدام:**
1. من القائمة الجانبية → `Create Appoinment`.
2. أدخل رقم تسجيل المريض في حقل البحث واضغط (بحث/أو Enter).
3. تأكد من ظهور اسم المريض ثم اضغط `Add Appointment` / تأكيد.
4. ستظهر رسالة برقم الموعد الجديد.

**المدخلات:** رقم تسجيل المريض فقط.

**النتيجة:** سطر جديد في `appointments` برقم اليوم المتسلسل وحالة `completed=NO`.

**ملاحظات:** الموعد مرتبط بتاريخ اليوم (`created_at`)؛ لا حقل ساعة منفصل.

### 33.2 تسجيل مريض

**الهدف:** إضافة مريض جديد للنظام.

**طريقة الاستخدام:**
1. القائمة → `Patient` → `Register New`.
2. املأ النموذج (الاسم، العنوان، الجنس، الميلاد، المهنة، الهاتف، NIC اختياري).
3. التقط صورة من الكاميرا إن تُركت (اختياري).
4. اضغط `Save` / `Register`.

**المدخلات:** الحقول أعلاه.

**النتيجة:** رقم تسجيل YYMMDD+seq + بطاقة بباركود + سجل.

**ملاحظات:** لا يمكن تكرار نفس اليوم بنفس التسلسل (خطأ 23000 يُعرض برسالة).

### 33.3 فحص مريض (Check Patient)

**الهدف:** تسجيل الفحص الطبي والوصفة.

**طريقة الاستخدام:**
1. القائمة → `Check Patient`.
2. أدخل رقم الموعد اليومي (آخر 4 أرقام) أو رقم تسجيل المريض.
3. راجع بيانات المريض وقياساته السابقة.
4. أدخل التشخيص والضغط والسكر والكولسترول، واختر الأدوية من الاقتراحات.
5. اضغط `Save`.

**المدخلات:** تشخيص + قياسات + أدوية (لا يلزم كلها).

**النتيجة:** Prescription جديدة + الموعد `completed=YES` + سجلات `medicine_prescription`.

### 33.4 صرف الدواء (Issue Medicine)

**الهدف:** صرف أدوية الوصفة من الصيدلية.

**طريقة الاستخدام:**
1. القائمة → `Issue Medicine`.
2. أدخل رقم موعد اليوم أو رقم المريض.
3. اختر من قائمة الأدوية غير المصروفة واضغط `Issue`.
4. (اختياري) `Save` لإنهاء الوصفة وعرض الإيصال للطبع.

**المدخلات:** رقم الموعد/المريض.

**النتيجة:** `issued=YES` لكل دواء + إيصال صرف.

### 33.5 الحضور

- لمراجعة حضورك: `Attendance → My Attendance` (جدول يومي + تقويم).
- المسؤول: `Attendance → More` — لكنه معطّل عملياً (انظر Known Issues).

### 33.6 الإشعارات

- المسؤول: `Notices` → إضافة إعلان (subject + description) يظهر في Dashboard، أو إرساله
  بريداً/SMS لمجموعة أدوار.

### 33.7 الأجنحة

- القائمة → `Wards`: عرض الأجنحة + إضافة جناح (رقم الجناح، الأسرة، الحرة، الطبيب المسؤول).

---

## 34. Complete Workflow (دورة العمل الكاملة)

```
1) تسجيل الدخول (أحد الحسابات حسب الدور)
2) Dashboard: استعراض الإحصائيات والإعلانات
3) استقبال المريض: تسجيله (Register New/In-Patient) → إنشاء موعد (Create Appointment)
4) الفحص الطبي: Check Patient (تشخيص + قياسات + وصفة)
5) الصرف: Issue Medicine (الصيدلي)
6) (للمنوّم) Register In-Patient → جناح ←→ Discharge عند الخروج
7) الحضور: My Attendance (day-to-day)
8) التقارير: Report Generation (عيادة / شهري / حضوري / جناح / منوّمين)
9) الإحصائيات: Statistics (رسوم سنوية)
10) الإدارة: Users (جديد/بصمة/إعادة ضبط)، Notices، Wards
```

---

## 35. Training Plan (خطة تعليم المستخدم)

| المستوى | الهدف | ماذا يتعلم | تمرين عملي | نتيجة التعلم |
|---|---|---|---|---|
| 1 | التعرف على النظام | ماهيته وأقسامه | تصفح Dashboard | صورة ذهنية عامة |
| 2 | تسجيل الدخول | الحقول + تسجيل الخروج + اللغات | دخول/خروج بحساب | التعامل مع الجلسة |
| 3 | Dashboard | بطاقات الإحصائيات + Quick Links + الإعلانات | النقر على كل Quick Link | فهم مركز السيطرة |
| 4 | Patients | تسجيل/بحث/بطاقة/تعديل | تسجيل مريض 10002 ثم البحث به | إتقان ملف المرضى |
| 5 | Appointments | إنشاء موعد ورقم اليوم | حجز لمريض 10001 | فهم الرقم التسلسلي |
| 6 | Doctors | الطبيب كمستخدم + doctor_id | مراجعة أعمدة المواعيد | فهم دورة العلاج |
| 7 | Check Patient | تشخيص + وصفة + قياسات | فحص الموعد رقم 1 | إتمام دورة الفحص |
| 8 | Medicine | صرف + pivot | صرف وصفة | فهم الصيدلية |
| 9 | Attendance | جدول الحضور والتقويم | فتح My Attendance | قراءة سجلات الحضور |
| 10 | Reports | أنواع التقارير + فلترة التاريخ | توليد تقرير All لعام 2026 | إنتاج تقارير |
| 11 | Users and Roles | إنشاء مستخدم + نوعه | إنشاء حساب تجريبي | إدارة الموظفين |
| 12 | Statistics | قراءة الرسوم والإحصائيات | فتح Statistics | تحليل البيانات |
| 13 | إدارة النظام | الأجنحة، الإشعارات، النسخ الاحتياطي | إضافة إعلان | صيانة النظام |
| 14 | فهم قاعدة البيانات | جداول وعلاقات | مراجعة جدول prescriptions | ربط الواجهة بالجداول |
| 15 | فهم الكود (للمطور) | Routes/Controllers/Models | تعديل دالة بسيطة | قابليتهم للتطوير |

---

## 36. Beginner Guide (للمستخدم الذي لا يعرف شيئاً)

عند فتح النظام تظهر **صفحة تسجيل الدخول**: حقلان (بريد إلكتروني + كلمة مرور).
أدخل بياناتك واضغط دخول — ستنتقل إلى **لوحة المعلومات** التي فيها مربعات ملونة تعرض
أرقاماً (عدد الأطباء، الموظفين، الصيادلة، المنوّمين) وقائمة جانبية يمين/يسار بعناوين
مفهومة.

- "**Patient**" (المريض): لتسجيل مريض جديد أو البحث عنه أو طباعة بطاقته.
- "**Create Appoinment**": لإنشاء حجز اليوم لمريض مسجّل.
- "**Check Patient**": صفحة الطبيب للفحص والوصف.
- "**Issue Medicine**": صفحة الصيدلي لصرف الأدوية.
- "**Attendance**": حضورك وظهورك.
- "**My Profile**": بياناتك وتعديلها وتغيير كلمة المرور.
- "**Users**": (للمدير) إضافة موظف أو ربط بصمة أو إعادة ضبط كلمة مرور.
- "**Notices**": (للمدير) كتابة إعلان يظهر باللوحة.
- "**Report Generation**" و "**Statistics**": تقارير وأرقام جاهزة.

اضغط على أي عنصر؛ كل صفحة لها نموذج بسيط. عادةً: **أملأ → Save → تظهر رسالة نجاح**.

---

## 37. Advanced User Guide (للمستخدم المتقدم)

- استخدم **نموذج الفحص** للاستفادة من القياسات السابقة المعروضة أعلى الصفحة.
- أضف المريض إلى **عيادات** من صفحة الفحص (Add to clinics) لعرض في تقارير العيادات.
- تحقق من حالة الموعد: `completed` و `admit` (خارجي/رقود).
- في تقرير الحضور اختر النطاق الزمني والنوع للطباعة/المعاينة.
- في Statistics يمكن تغيير العام من القائمة (2018–2020) ثم Fetch.
- أعد ضبط كلمات المرور للتهيئة عبر Users → Reset User (يعيد `12345678`).
- استخدم النسخ الاحتياطي المجدول يومياً 19:40/19:41 (spatie/laravel-backup).

---

## 38. Developer Guide (دليل المطور)

### كيف تجد ما تحتاجه؟
- **Route:** ابحث في `routes/web.php` باسم المسار (as) أو URL.
- **Controller:** المسار يحدد `Controller@method` — افتح `app/Http/Controllers/<X>.php`.
- **Model:** كلاس في جذر `app/` (مثل `App\Prescription`) أو ابحث عن `belongsTo`/`hasMany`.
- **Migration:** ملف في `database/migrations/` باسم `create_<table>_table.php`.
- **View:** `resources/views/<نفس اسم الـ module>/<page>.blade.php` — المسارات ترد في
  سطر `return view(...)` داخل الـ Controller.
- **العلاقات بين الجداول:** راجع دوال العلاقة داخل الـ Models و وثيقة Relationships أعلاه.

### كيف تضيف ميزة جديدة (خطوة بخطوة)
1. **Route:** أضف سطراً في `routes/web.php` باسم (as) و middleware المناسب.
2. **Controller method:** أضف دالة في الـ Controller المناسب (أو Controller جديد).
3. **Model/Migration:** إن كانت هناك حاجة لجدول جديد → أنشئ Migration
   (`php artisan make:migration`) + Model إن لزم.
4. **View:** أنشئ Blade داخل `resources/views/<module>/` و `@extends('template.main')`.
5. **Seeder:** أضف Seeder جديداً في `database/seeders` واستدعِه من `DatabaseSeeder`.
6. **Validation/الأمان:** استخدم `$this->validate()` و `@csrf` في كل POST.
7. جرّب: `php artisan route:list` ثم `php artisan optimize:clear`.

### مثال مضغوط لإضافة صفحة
```php
// routes/web.php
Route::get('/greet', ['as' => 'greet', 'uses' => 'HomeController@greet'])->middleware('auth');

// app/Http/Controllers/HomeController.php
public function greet()
{
    return view('greet', ['title' => 'Welcome']);
}

// resources/views/greet.blade.php
@extends('template.main')
@section('content_title', $title)
@section('main_content')
    <h1>Hello</h1>
@endsection
```

---

## 39. Testing (الاختبارات)

- **الملفات:** `tests/Feature/ExampleTest.php` (فحص `/` يوجّه إلى `/login` وأنّ `/login`
  يعود 200)، و `tests/Unit/ExampleTest.php` (assertTrue).
- **التشغيل:**
  ```bash
  php artisan test
  ```
- **النتيجة الحالية (مُعاد تنفيذها وقت التوثيق):** `Tests: 2 passed (4 assertions)`.
- ملاحظة: الاختبارات **أساسية (سموك)** فقط؛ لا توجد Suite شاملة للوظائف. لا يُقال إن
  المشروع "Tested بالكامل".

---

## 40. Known Issues (المشاكل الحالية المكتشفة فعلياً)

هذه ملاحظات حقيقية وُجدت أثناء قراءة الكود، ولا نُخفيها:

1. **`GET /attendance` معطوب** — route `attendance` يستدعي `AttendController@markattendance`
   بينما الدالة الفعلية اسمها `markAttendance`. أي طلب للمسار ينتج خطأ
   "method does not exist". ولا يوجد route POST يُوصل جهاز البصمة للدالة. (الحالة: مفتوحة)
2. **`Patients::history()` يشير لنموذج غير موجود** — `App\Patient_History` لا وجود له.
   الدالة لم تُستدعَ حالياً من أي Controller، لكن أي استخدام مستقبلي يفشل. (الحالة: كامنة)
3. **`PatientController::get_ward_list()`** يستدعي `view('register_in_patient_view')` باسم
   خاطئ والطريق `GET /wardlist` **بدون** مصرح auth — سيُنشئ خطأ ViewNotFound أو وصولاً
   غير محمي. (الحالة: مفتوحة)
4. **`ReportController::view_out_patient_report()`** يشير إلى view غير موجودة
   (`reports/out_patient_report`) — الدالة غير موصولة بأي Route. (الحالة: كامنة)
5. **`AnalyticsController`** يستخدم `$month = 2` **مثبتاً يدوياً** — رسم "الأكثر وصفاً"
   سيحسب شهر فبراير دائماً وليس الشهر الجاري. (الحالة: مفتوحة)
6. **معايير السنة في Statistics**: القائمة تسمح فقط 2018/2019/2020. (الحالة: مفتوحة)
7. **`medicines.qty` تُزايد عند الصرف** (في `markIssued`) وليس تنقص — القيمة تحتسب
   "عمليات صرف" وليس المخزون المتبقي. سلوك يجب معرفته قبل اعتماد الأرقام. (الحالة: ملاحظة)
8. **سدادات أمنية قائمة**: استعلامات `whereRaw` تُبنى من مدخلات مباشرة في عدة مواضع
   (خطر SQL Injection تاريخي — لا نقول أنه آمن). بيانات SMS تظهر في الكود
   (`UserController::sms`)، ومفتاح SendGrid يُقرأ من `env('SEND_KEY')`. (الحالة: ملاحظة)
9. **"More Attendance" معطّل** في القائمة الجانبية: الشرط `user_type=='Admssin'`
   (خطأ إملائي) لا يطابق أي مستخدم. (الحالة: مفتوحة)
10. **`layouts/app.blade.php`** موجود ويُستخدم في صفحات auth الثانوية
    (register/verify/passwords) بينما صفحة `login` تستخدم `template.auth` — تصميمان مختلفان.
11. **مؤشرات تاريخية أُصلحت فعلاً** (لم تعد مشاكل في النسخة الحالية):
    - `gen_att_reports` — مشكلة `Undefined variable $data` كانت موجودة سابقاً، وتمت
      معالجتها عبر إضافة `else { $data = collect(); }` والتفرع الصحيح
      (`All` / `My Attendance` / `Doctors` / `General Staff`). التحقق: جميع الأنواع تُعرض.
    - `all_print_preview` — تسمية الأنواع كانت `My`/`General` وهي الآن مطابقة
      (`My Attendance` / `General Staff`) وأسعار `value=` في الـ input أصبحت مُقتبسة.
    - Migrations: فريدة attendance، وFK الحق التشخيصي (appointments/prescriptions)،
      وFK clinic_patient (إلى `patients`).
    - Firebase/تسمية الرموز: تم ترقية الـ seeders و factories لبنية Laravel 10.
    - عقدة "Template" في القائمة الجانبية: أصبحت غير ظاهرة (كـ optional إزالته).

---

## 41. Security (الأمان)

ما هو **موجود فعلاً** في الكود:

- **Authentication:** حارس `web` (session) عبر `AuthenticatesUsers` + ميدل وير `auth`
  (طبقة `Authenticate`). كلمات المرور تُخزَّن **bcrypt** (`Hash::make`) وتُختبَر
  بـ `Hash::check()`، و`password`/`remember_token` مخفية في `$hidden`.
- **Authorization:** ميدل وير مخصص `admin`/`doctor`/`staff`/`pharmacist` على المسارات
  + إخفاء عناصر القائمة في الـ Blade حسب `user_type`.
- **CSRF:** `VerifyCsrfToken` ضمن مجموعة `web` — كل نماذج POST تستخدم `@csrf`.
- **Validation:** `$this->validate()`/`Validator` في: تسجيل المستخدم (RegisterController)،
  بصمة (fingerprint 1-60)، تغيير كلمة المرور، رفع الصورة، تغيير الرقم/البريد، تعديل
  الملف الشخصي، الإعلانات.
- **Session:** `SESSION_DRIVER=file` (في `.env`). مدة الجلسة `120` دقيقة.
- **Middleware queue:** تشمل أيضًا `EncryptCookies`, `TrimStrings`,
  `ConvertEmptyStringsToNull`, `TrustProxies`.
- **حدود ملاحظة (Non-claim):** لا يوجد Sanctum/Passport؛ مسار `/api/user` يستخدم
  `auth:api` (token) لكن لا تُستخدم فيه أي ميزة. لا يوجد `RateLimiter` مخصص على نماذج
  الويب؛ الاستعلامات `whereRaw` المذكورة تحمل مخاطرة SQL injection تاريخية.

---

## 42. Localization (اللغات)

- **اللغات المدعومة (من كود `SetLanguage`):** `en`، `si` (سنغالية)، `ar` (عربية).
- **الافتراضي:** `config/app.php` → `'locale' => 'en'` ، fallback `en`.
- **آلية التغيير:** `GET /lang/{lan}` → `HomeController@setLocale` يحفظ في `Session`
  (`locale`) → ميدل وير `SetLanguage` (مسجَّل في مجموعة `web` + باسم `lang`) يقرأ الجلسة
  ويضع `App::setLocale()`.
- **ملفات الترجمة:**
  - JSON: `resources/lang/en.json`, `resources/lang/si.json`, `resources/lang/ar.json`
    (تُستخدم بواسطة `__('key')`).
  - PHP: `resources/lang/{ar,en}/{auth,validation,passwords,pagination}.php`.
  - vendor backup lang: `resources/lang/vendor/backup/*`.
- **العربية RTL:** يوجد `public/css/rtl.css` ويُحمَّل في `template/main.blade.php` عندما
  يكون locale = `ar`، مع ضبط `dir="rtl"` وإضافة نصوص DataTables العربية.

---

## 43. Troubleshooting (حل المشاكل)

| المشكلة | السبب/الحل |
|---|---|
| الموقع لا يعمل/الصفحة فارغة | شغّل `php artisan serve`؛ تأكد من `php artisan key:generate` |
| `Composer ...` خطأ | PHP >= 8.1 مطلوب؛ شغّل `composer install` مجدداً |
| `SQLSTATE[HY000] [1045]` غير مصرح | تحقق من `DB_USERNAME/DB_PASSWORD` في `.env` |
| `Table not found` | نفّذ `php artisan migrate` |
| خطأ `View not found` | تأكد من الملف في `resources/views` واسم `view('...')` صحيح |
| `Undefined variable $data` | في النسخة الحالية معالجة؛ لو ظهر، فالـ type غير مدعوم (أرسل أحد الأنواع الأربعة) |
| `Method ... does not exist` | مثال `markattendance` — انظر Known Issues #1 |
| الصفحات تظهر إنجليزية فقط | change اللغة عبر أيقونة اللغة، أو `config:clear` إن كانت غير محسومة |
| تغييرات الـ Blade لا تظهر | `php artisan view:cache` ثم `php artisan optimize:clear` |
| خطأ مسار/رابط | نفّذ `php artisan route:list` وتأكد من اسم المسار |
| الجلسة/البريد | `SESSION_DRIVER=file`, `MAIL_MAILER=smtp` — اضبط من `.env` |
| مشاكل الصور/المرفوعات | تأكد من وجود `storage/app/public` ورابطها (`php artisan storage:link`) |
| تكرار التسجيل نفس اليوم | رقم تسجيل اليوم تكرار — أعد المحاولة غداً أو عدّل الرقم |

---

## 44. Frequently Asked Questions (أسئلة شائعة)

- **ماذا لو نسيت كلمة مرور؟** — للمدير: Users → Reset User، أو استخدم صفحة نسيت كلمة
  المرور (ترسل بريداً إن ضُبط SMTP).
- **هل الحضور يعمل بالبصمة؟** — البنية (جدول fingerprint + دالة markAttendance) موجودة،
  لكن الربط بالـ Route معطوب حالياً (Known Issues #1).
- **هل يمكن البحث في التقارير حسب التاريخ؟** — نعم، تقارير الحضور تعتمد فترة
  start/end وللمنوّمين بتحديد تاريخ.
- **كم لغة؟** — ثلاث: العربية، الإنجليزية، السنغالية.
- **هل الإخطارات تُرسل؟** — تُرسل عبر SendGrid/textit إذا كانت المفاتيح متوفرة في `.env`.

---

## 45. Doctor Discussion Questions (أسئلة المناقشة المتوقعة)

### أسئلة عامة
1. ما اسم المشروع وهدفه؟
2. ما المشكلة التي يحلها؟
3. من هم المستخدمون؟
4. ما أهم وظائفه؟

### أسئلة Laravel
5. لماذا Laravel؟ وما هو MVC؟
6. أين الـ Models و الـ Controllers و الـ Views؟
7. ما Route و Middleware و Migration و Seeder و Eloquent في هذا المشروع؟

### أسئلة قاعدة البيانات
8. ما الجداول الرئيسية وعلاقاتها؟
9. ما الـ Primary/ Foreign Key؟
10. كيف يرتبط Patient بـ Appointment؟

### أسئلة Authentication
11. كيف يعمل Login وكيف تُحفظ كلمة المرور؟
12. كيف تُمنع الصلاحيات غير المصرح بها؟

### أسئلة المشروع
13. كيف تُسجَّل مريض؟ كيف يُنشأ موعد؟ كيف يُسجَّل الفحص؟ كيف يُصرف الدواء؟
14. كيف تعمل التقارير والإحصائيات؟

### أسئلة أعمق
15. GET vs POST؟ ما CRUD؟ كيف يتم Validation؟ ما Session و CSRF؟

---

## 46. Answers for Discussion (إجابات جاهزة)

> السؤال: **لماذا Laravel؟**
> إجابة مختصرة: Framework PHP منظم جيداً (MVC) يوفر إدارة القواعد والمصادقة واللغات
> والأمان جاهزة.
> إجابة متوسطة: يحل لنا تسجيل الدخول، CSRF، EncryptCookies، Migrations، Seeders،
> بلغة Blade، مع دعم الحزم مثل (barcode, activitylog, backup).
> إجابة تفصيلية: في هذا المشروع نرى Laravel في كل طبقة: `routes/web.php` يوزع طلبات
> الويب، `app/Http/Kernel.php` يرتب الميدل وير، `app/Http/Controllers/*` المنطق،
> `app/User.php` وما يشبهه تمثيل الجداول عبر Eloquent، و`resources/views` تعرض
> النتائج. والتحقق من ذلك عملياً: أي طلب (مثل `POST /channel`) يمر عبر `auth`
> و`staff` و`lang` ثم `PatientController@getPatientData`.

> السؤال: **كيف تُحفظ كلمة المرور؟**
> إجابة مختصرة: bcrypt عبر `Hash::make` ولا تُطبع أبداً (`$hidden`).
> إجابة متوسطة: عند التسجيل `Hash::make($password)`، وعند الدخول `Hash::check`.
> إجابة تفصيلية: ابحث عن `User::$hidden => ['password']` و `bcrypt(...)` في
> `RegisterController::create` و `UserController::changeUserPassword`.

> السؤال: **كيف يرتبط Patient بـ Appointment؟**
> إجابة مختصرة: `appointments.patient_id` يشير إلى `patients.id`.
> إجابة متوسطة: بعلاقة `hasMany`/`belongsTo` — في `Appointment.php`
> `return $this->belongsTo('App\Patients');`.
> إجابة تفصيلية: عند إنشاء الموعد نتأكد من وجود المريض ثم `$app->patient_id = $pid`,
> وكل التقارير تنضم عبر `join appplate(أ) appointments ON patients.id = appointments.patient_id`.

> السؤال: **كيف يعمل الحضور؟**
> إجابة مختصرة: يسجّل `start` و `end` في `attendances` لكل مستخدم ويحسب المدة.
> إجابة متوسطة: الدالة `markAttendance` تجد موظفاً بالبصمة وتغلق سجل اليوم الأول ثم تفتح
> واحداً جديداً لليوم التالي.
> إجابة تفصيلية: (لاحظ مشكلة الربط بالـ Route — انظر Known Issues) والعرض عبر
> `myattend` مع تقويم Google Charts.

> السؤال: **كيف تُصرف الأدوية؟**
> إجابة مختصرة: من `Issue Medicine` والوصفة pivot `medicine_prescription`.
> إجابة متوسطة: `markIssued` يضع `issued=YES` و`medIssueSave` يغلق الوصفة ويطبع الإيصال.

> السؤال: **ما الفرق بين GET و POST؟**
> إجابة مختصرة: GET للقراءة (فظة في وصفة، تجاري) وPOST للتغيير (إنشاء/تحديث) مع CSRF.
> إجابة تفصيلية: في `routes/web.php` نرى `GET /patient` لعرض النموذج و `POST /patientregister`
> للحفظ، و `POST` مغطاة بـ `VerifyCsrfToken` في مجموعة `web`.

> السؤال: **ما CRUD؟** — عمليات الإنشاء والقراءة والتحديث والحذف. في المشروع مثال كامل
> على `patients`: `registerPatient` (Create)، `patientData` (Read)، `updatePatient` (Update)،
> `patientDelete` (Delete ناعم SoftDelete).

> السؤال: **ما Session و CSRF؟** — الجلسة: حالة تسجيل الدخول ومزود اللغة (file driver).
> CSRF: رمز تحقق من التزييف يُضمّن في كل نموذج POST ويفحصه `VerifyCsrfToken`.

---

## 47. شرح المشروع في 5 دقائق

**مستشفى الشفاء — نظام إدارة المستشفيات (Smart Hospitals)**
- **الهدف:** إدارة المستشفى رقمياً.
- **المشكلة:** السجلات الورقية تضيّع الوقت وتصعّب تتبع المرضى والأدوية والحضور.
- **الحل:** نظام ويب يربط المرضى بالمواعيد والفحوصات والوصفات وصرف الأدوية والأجنحة
  والحضور والتقارير.
- **التقنيات:** PHP 8.2 + Laravel 10.5 + MySQL + Blade + AdminLTE/Bootstrap + Chart.js + DataTables.
- **المستخدمون:** Admin، Doctor، Pharmacist، General.
- **قاعدة البيانات:** 16 جدولاً (users, patients, appointments, prescriptions, medicines,
  medicine_prescription, attendances, wards, inpatients, clinics, clinic_patient,
  noticeboards, activity_log, ...).
- **أهم الوظائف:** تسجيل مرضى + مواعيد + فحص + وصفات + صرف أدوية + رقود/خروج + حضور
  + إعلانات + تقارير + إحصائيات + تعدد لغات + صلاحيات.
- **طريقة العمل:** request → route → middleware → controller → eloquent → blade.
- **الخاتمة:** نظام شبه متكامل قابل للتوسع، وثائقه الكاملة في هذا الملف.

---

## 48. شرح المشروع في 10 دقائق

نفس المحتوى أعلاه، لكن بعمق أكبر، مروراً بـ:

1. الاسم والمصدر (README القديم + composer.json + .env).
2. جداول التفاصيل في "Database & Tables" (أعلاه) مع شرح `medicine_prescription` كنقطة
   تلاقي بين الوصفة والدواء، و`clinic_patient` بين المريض والعيادة، و`activity_log` للسجل.
3. سيناريو شبه كامل (من قسم 34 / 47): استقبال مريض → موعد → فحص → وصفة → صرف → تقرير.
4. الأمان: auth + middleware roles + CSRF + bcrypt + Validation + Session.
5. الواجهة: AdminLTE 2.4.12 + Bootstrap 3.4.1 + jQuery + Chart.js + DataTables + typeahead + barcode.
6. اللغات الثلاث وآلية RTL، وآلية النشر `php artisan serve`.
7. القيود الحقيقية (Known Issues) الصدق المطلوب منها في عرض المشروع.

---

## 49. Technical Terminology (قاموس المصطلحات)

| المصطلح | المعنى | استخدامه في المشروع |
|---|---|---|
| PHP | لغة برمجة خادمية | كل كود الـ backend |
| Laravel | إطار عمل PHP (MVC) | البنية الأساسية للنظام |
| MVC | Model-View-Controller | Models في app/، Views في resources/، Controllers في app/Http |
| Route | مسار URL مرتبط بمعالج | `routes/web.php` (82 مساراً) |
| Controller | فئة المنطق | `PatientController`, `ReportController` ... |
| Model | تمثيل الجدول في PHP | `App\Prescription` ↔ `prescriptions` |
| View | قالب العرض | `resources/views/patient/*` |
| Blade | محرك قوالب Laravel | `@extends('template.main')`, `@section`, `{{ }}` |
| Migration | تعريف بنية الجداول بالكود | `database/migrations/*` |
| Seeder | تعبئة البيانات الأولية | `database/seeders/*` (Users, DemoData...) |
| Factory | مولّد بيانات تجريبية | `UserFactory`, `MedicineFactory`, `AttendanceFactory` |
| Eloquent | ORM الخاص بـ Laravel | `App\User::find(1)`, علاقات belongsTo/hasMany |
| ORM | تعيين الكائنات على الجداول | Eloquent |
| Middleware | وسيط قبل/بعد الـ request | `auth`, `admin`, `doctor`, `staff`, `pharmacist`, `lang` |
| Authentication | المصادقة | `LoginController` + `Authenticate` middleware |
| Authorization | تفويض الصلاحيات | middleware حسب `user_type` |
| CRUD | إنشاء/قراءة/تحديث/حذف | عملية كاملة على `patients` |
| SQL | لغة الاستعلامات | استعلامات `DB::table()` و raw |
| MySQL | قاعدة البيانات العلائقية | DB الاتصال `hms_test` |
| Session | حالة عبر الطلبات | اللغة + تسجيل الدخول (driver file) |
| CSRF | حماية النماذج | `@csrf` + `VerifyCsrfToken` |
| Validation | التحقق من البيانات | `$this->validate()` في كل نموذج |
| API | واجهة برمجية | مسار تجريبي وحيد `GET /api/user` (غير مستخدم) |

---

## 50. Future Improvements (تطوير مستقبلي — مقترحات، ليست موجودة بعد)

- إصلاح الربط الفعلي لجهاز الحضور بالبصمة (إنهاء Known Issue #1).
- جدول أطباء مستقل وربطه بالمواعيد بتواريخ أوقات فعلية (date/time) بدل created_at/الرقم.
- جدول مخزون صيدلة حقيقي يتناقص عند الصرف مع تنبيه عند النقص.
- متابعة حقول الأدوية بجرعات ومدة علاج منفصلة (note حالياً نص حر).
- نظام معاينة/PDF حقيقي للتقارير عبر dompdf (الحزمة مثبّتة لكن غير مستخدمة في التقارير).
- واجهة إدارة عالية المستوى: أشهر، أقسام، محاسبة، فواتير، أشعة/مختبر.
- تحسينات أمنية: استبدال `whereRaw` بـ parameter binding، نقل مفاتيح SMS/SendGrid
  إلى env، RateLimiter على نماذج الدخول.
- توسيع الاختبارات التلقائية (Feature tests لكل module).
- دعم سنوات ديناميكية في الإحصائيات بدل قائمة 2018-2020 الثابتة.
- RTL أقوى للعربية وتوحيد صفحة login مع بقية صفحات auth.

---

## 51. Conclusion (الخاتمة)

النظام الحالي يحقق: تسجيل وإدارة المرضى، المواعيد، الفحص الطبي، الوصفات وصرفها،
الرقود والخروج، الحضور، الإعلانات، التقارير والإحصائيات، بتعدد لغات وصلاحيات. قيمته
الأساسية أنها قطعت العمل الورقي للمستشفى وربطت كل عمليات المريض في سجل واحد قابل
للبحث.

**التحسين المستقبلي** (المقترحات في القسم 50) يعتمد ما هو قائم ولا يضيف على الحقيقة.

---

<!-- footer -->
*استُخرج هذا التوثيق من تحليل فعلي لملفات المشروع بتاريخ 2026-09-23.*
*لم تُدَّعَ أي ميزة أو حزمة أو جدول أو صلاحية غير موجودة في الكود.*
*اكتب أي حقيقة جديدة في المشروع قبل تحديث هذا الملف.*