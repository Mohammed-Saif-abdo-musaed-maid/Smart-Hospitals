<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    /**
     * Arabic demo-dataset seeder for "مستشفى الشفاء".
     *
     * Safe to run multiple times: every insert is guarded
     * (updateOrCreate / firstOrNew / insertOrIgnore) so it never
     * duplicates, deletes or overwrites existing real data.
     */
    public function run()
    {
        $this->command->info('==> DemoDataSeeder start');

        $this->seedUsers();
        $this->seedMedicines();
        $this->seedPatients();
        $this->seedAppointments();
        $this->seedPrescriptions();
        $this->seedInpatients();
        $this->seedAttendances();
        $this->seedClinics();
        $this->seedNotices();

        $this->command->info('==> DemoDataSeeder done');
    }

    /* ------------------------------------------------------------------ */

    protected function seedUsers()
    {
        $users = [
            [
                'email' => 'admin@shifa-hospital.com',
                'name' => 'أحمد المخلافي',
                'password' => 'Admin@12345',
                'user_type' => 'admin',
                'contactnumber' => 771234567,
                'education' => 'الماجستير في الإدارة الصحية',
                'location' => 'صنعاء',
                'skills' => 'إدارة المستشفيات',
            ],
            [
                'email' => 'dr.khaled@shifa-hospital.com',
                'name' => 'خالد الحكيمي',
                'password' => 'Doctor@12345',
                'user_type' => 'doctor',
                'contactnumber' => 772345678,
                'education' => 'بكالوريوس الطب والجراحة - جامعة صنعاء',
                'location' => 'صنعاء',
                'skills' => 'طب باطني',
            ],
            [
                'email' => 'dr.amal@shifa-hospital.com',
                'name' => 'أمل المقبلي',
                'password' => 'Doctor@12345',
                'user_type' => 'doctor',
                'contactnumber' => 773456789,
                'education' => 'بكالوريوس الطب والجراحة - جامعة عدن',
                'location' => 'عدن',
                'skills' => 'أطفال',
            ],
            [
                'email' => 'pharmacist@shifa-hospital.com',
                'name' => 'محمد الصبري',
                'password' => 'Pharmacist@12345',
                'user_type' => 'pharmacist',
                'contactnumber' => 774567890,
                'education' => 'بكالوريوس صيدلة',
                'location' => 'صنعاء',
                'skills' => 'صرف وتجهيز الأدوية',
            ],
            [
                'email' => 'reception@shifa-hospital.com',
                'name' => 'منى العنسي',
                'password' => 'Reception@12345',
                'user_type' => 'general',
                'contactnumber' => 775678901,
                'education' => 'دبلوم إدارة مكاتب',
                'location' => 'صنعاء',
                'skills' => 'استقبال المرضى وتنظيم الحجوزات',
            ],
            [
                'email' => 'staff@shifa-hospital.com',
                'name' => 'فاطمة العريقي',
                'password' => 'Staff@12345',
                'user_type' => 'general',
                'contactnumber' => 776789012,
                'education' => 'دبلوم تسجيل طبي',
                'location' => 'تعز',
                'skills' => 'التسجيل الطبي',
            ],
        ];

        foreach ($users as $u) {
            \App\User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make($u['password']),
                    'user_type' => $u['user_type'],
                    'contactnumber' => $u['contactnumber'],
                    'education' => $u['education'],
                    'location' => $u['location'],
                    'skills' => $u['skills'],
                    'notes' => 'حساب تجريبي',
                    'img_path' => 'dist/img/avatar5.png',
                ]
            );
        }

        $this->command->info('    users6 (admin/doctor x2/pharmacist/general x2) ready');
    }

    /* ------------------------------------------------------------------ */

    protected function seedMedicines()
    {
        $meds = [
            ['name' => 'باراسيتامول 500 ملغ', 'type' => 'أقراص', 'qty' => 120],
            ['name' => 'إيبوبروفين 400 ملغ', 'type' => 'أقراص', 'qty' => 80],
            ['name' => 'أموكسيسيلين 500 ملغ', 'type' => 'كبسولات', 'qty' => 60],
            ['name' => 'فيتامين د 50000 وحدة', 'type' => 'أقراص', 'qty' => 90],
            ['name' => 'سيبروفلوكساسين 500 ملغ', 'type' => 'أقراص', 'qty' => 50],
            ['name' => 'أوميبرازول 20 ملغ', 'type' => 'كبسولات', 'qty' => 100],
            ['name' => 'لوراتادين 10 ملغ', 'type' => 'أقراص', 'qty' => 70],
            ['name' => 'ميتفورمين 850 ملغ', 'type' => 'أقراص', 'qty' => 110],
        ];

        foreach ($meds as $m) {
            DB::table('medicines')->updateOrInsert(
                ['name_english' => $m['name']],
                [
                    'name_sinhala' => $m['name'],
                    'type_english' => $m['type'],
                    'type_sinhala' => $m['type'],
                    'qty' => $m['qty'],
                ]
            );
        }

        $this->command->info('    medicines8 (Arabic-named) ready');
    }

    /* ------------------------------------------------------------------ */

    protected function seedPatients()
    {
        $patients = [
            [
                'id' => '10001', 'name' => 'أحمد يحيى العمراني', 'sex' => 'Male', 'bod' => '1985-03-12',
                'occupation' => 'معلم', 'address' => 'صنعاء - حدة - شارع الخمسين', 'telephone' => '+967771234567', 'contactnumber' => '771234567', 'created_at' => '2026-07-02 09:00:00',
            ],
            [
                'id' => '10002', 'name' => 'سامية عبدالرحمن الحمادي', 'sex' => 'Female', 'bod' => '1990-07-25',
                'occupation' => 'موظفة حكومية', 'address' => 'عدن - المنصورة - شارع التعاون', 'telephone' => '+967772345678', 'contactnumber' => '772345678', 'created_at' => '2026-07-05 09:15:00',
            ],
            [
                'id' => '10003', 'name' => 'خالد سعيد المقطري', 'sex' => 'Male', 'bod' => '1978-11-02',
                'occupation' => 'تاجر', 'address' => 'تعز - المظفر - حارة السوق', 'telephone' => '+967773456789', 'contactnumber' => '773456789', 'created_at' => '2026-07-09 08:50:00',
            ],
            [
                'id' => '10004', 'name' => 'فاطمة محمد الزبيدي', 'sex' => 'Female', 'bod' => '1996-04-18',
                'occupation' => 'طالبة', 'address' => 'الحديدة - الحوك - شارع الشهداء', 'telephone' => '+967774567890', 'contactnumber' => '774567890', 'created_at' => '2026-07-14 10:05:00',
            ],
            [
                'id' => '10005', 'name' => 'عمر علي السماوي', 'sex' => 'Male', 'bod' => '1968-09-30',
                'occupation' => 'متقاعد', 'address' => 'إب - القاعدة - حي الجبل', 'telephone' => '+967775678901', 'contactnumber' => '775678901', 'created_at' => '2026-07-19 09:30:00',
            ],
            [
                'id' => '10006', 'name' => 'آمنة حسن المطري', 'sex' => 'Female', 'bod' => '1982-12-05',
                'occupation' => 'ربة منزل', 'address' => 'ذمار - معبر - شارع الجامع', 'telephone' => '+967776789012', 'contactnumber' => '776789012', 'created_at' => '2026-07-26 11:00:00',
            ],
            [
                'id' => '10007', 'name' => 'نبيل قاسم الحضرمي', 'sex' => 'Male', 'bod' => '2000-01-22',
                'occupation' => 'طالب', 'address' => 'حضرموت - المكلا - فوه', 'telephone' => '+967777890123', 'contactnumber' => '777890123', 'created_at' => '2026-08-02 08:40:00',
            ],
            [
                'id' => '10008', 'name' => 'شيماء عبدالله الحداد', 'sex' => 'Female', 'bod' => '1993-06-14',
                'occupation' => 'صيدلانية', 'address' => 'صعدة - سحار - حي الوسع', 'telephone' => '+967778901234', 'contactnumber' => '778901234', 'created_at' => '2026-08-06 09:20:00',
            ],
            [
                'id' => '10009', 'name' => 'طه يحيى الريمي', 'sex' => 'Male', 'bod' => '1975-02-08',
                'occupation' => 'مهندس', 'address' => 'مأرب - المدينة - شارع الملعب', 'telephone' => '+967779012345', 'contactnumber' => '779012345', 'created_at' => '2026-08-11 10:10:00',
            ],
            [
                'id' => '10010', 'name' => 'رباب أحمد العواضي', 'sex' => 'Female', 'bod' => '1988-10-17',
                'occupation' => 'مهندسة معمارية', 'address' => 'البيضاء - رداع - شارع الأمل', 'telephone' => '+967780123456', 'contactnumber' => '780123456', 'created_at' => '2026-08-15 08:55:00',
            ],
            [
                'id' => '10011', 'name' => 'عبدالوهاب صالح الضبياني', 'sex' => 'Male', 'bod' => '1959-05-27',
                'occupation' => 'مزارع', 'address' => 'لحج - الحوطة - حارة المزارع', 'telephone' => '+967781234567', 'contactnumber' => '781234567', 'created_at' => '2026-08-20 09:45:00',
            ],
            [
                'id' => '10012', 'name' => 'نورة حسن البكري', 'sex' => 'Female', 'bod' => '1999-08-03',
                'occupation' => 'خريجة', 'address' => 'أبين - زنجبار - شارع الكورنيش', 'telephone' => '+967782345678', 'contactnumber' => '782345678', 'created_at' => '2026-08-25 09:05:00',
            ],
            [
                'id' => '10013', 'name' => 'وليد عبدالرحمن بن سويلم', 'sex' => 'Male', 'bod' => '1990-03-09',
                'occupation' => 'ضابط', 'address' => 'شبوة - عتق - حي النصر', 'telephone' => '+967783456789', 'contactnumber' => '783456789', 'created_at' => '2026-08-30 10:30:00',
            ],
            [
                'id' => '10014', 'name' => 'إيمان قائد الذماري', 'sex' => 'Female', 'bod' => '1986-07-21',
                'occupation' => 'محاسبة', 'address' => 'المحويت - شبام كوكبان - شارع الحصن', 'telephone' => '+967784567890', 'contactnumber' => '784567890', 'created_at' => '2026-09-03 08:35:00',
            ],
            [
                'id' => '10015', 'name' => 'سالم ناصر المنصوب', 'sex' => 'Male', 'bod' => '1994-02-14',
                'occupation' => 'سائق', 'address' => 'عمران - مديرية جبل إياس', 'telephone' => '+967785678901', 'contactnumber' => '785678901', 'created_at' => '2026-09-08 09:25:00',
            ],
            [
                'id' => '10016', 'name' => 'هدى علي الشيباني', 'sex' => 'Female', 'bod' => '2002-09-01',
                'occupation' => 'معلمة', 'address' => 'الجوف - الحزم - شارع المدرسة', 'telephone' => '+967786789012', 'contactnumber' => '786789012', 'created_at' => '2026-09-12 10:15:00',
            ],
        ];

        $extra = ['married', 'صنعاء', 'يمني', 'الإسلام', '250000', 'ولي الأمر', 'عنوان ولي الأمر'];

        $nicMap = [
            '10001' => '1203551001', '10002' => '1203551002', '10003' => '1203551003', '10004' => '1203551004',
            '10005' => '1203551005', '10006' => '1203551006', '10007' => '1203551007', '10008' => '1203551008',
            '10009' => '1203551009', '10010' => '1203551010', '10011' => '1203551011', '10012' => '1203551012',
            '10013' => '1203551013', '10014' => '1203551014', '10015' => '1203551015', '10016' => '1203551016',
        ];

        foreach ($patients as $p) {
            DB::table('patients')->updateOrInsert(
                ['id' => $p['id']],
                [
                    'name' => $p['name'],
                    'address' => $p['address'],
                    'contactnumber' => $p['contactnumber'],
                    'sex' => $p['sex'],
                    'bod' => $p['bod'],
                    'civil_status' => $extra[0],
                    'birth_place' => $extra[1],
                    'nationality' => $extra[2],
                    'religion' => $extra[3],
                    'income' => $extra[4],
                    'guardian' => $extra[5],
                    'guardian_address' => $extra[6],
                    'occupation' => $p['occupation'],
                    'nic' => $nicMap[$p['id']],
                    'telephone' => $p['telephone'],
                    'image' => 'dist/img/avatar.png',
                    'created_at' => $p['created_at'],
                    'updated_at' => $p['created_at'],
                ]
            );
        }

        $this->command->info('    patients16 (Arabic, Yemeni) ready');
    }

    /* ------------------------------------------------------------------ */

    protected function seedAppointments()
    {
        $doctors = [
            'khaled' => \App\User::where('email', 'dr.khaled@shifa-hospital.com')->value('id'),
            'amal' => \App\User::where('email', 'dr.amal@shifa-hospital.com')->value('id'),
        ];

        // Today's channel (2026-09-23) numbers 1..10
        $today = [
            // num, patient, doctor, admit, completed, time
            [1, '10009', 'khaled', 'YES', 'NO', '08:15:00'],
            [2, '10001', 'khaled', 'NO', 'NO', '08:30:00'],
            [3, '10002', 'amal', 'NO', 'NO', '08:45:00'],
            [4, '10003', 'amal', 'NO', 'YES', '09:00:00'],
            [5, '10004', 'khaled', 'NO', 'YES', '09:15:00'],
            [6, '10005', 'khaled', 'NO', 'NO', '09:30:00'],
            [7, '10006', 'amal', 'NO', 'YES', '09:45:00'],
            [8, '10007', 'amal', 'NO', 'NO', '10:00:00'],
            [9, '10008', 'khaled', 'NO', 'NO', '10:15:00'],
            [10, '10010', 'amal', 'NO', 'NO', '10:30:00'],
        ];

        foreach ($today as $app) {
            $ts = '2026-09-23 ' . $app[5];
            DB::table('appointments')->updateOrInsert(
                ['patient_id' => $app[1], 'created_at' => $ts],
                [
                    'number' => $app[0],
                    'doctor_id' => $doctors[$app[2]],
                    'admit' => $app[3],
                    'completed' => $app[4],
                    'updated_at' => $ts,
                ]
            );
        }

        // Historical appointments (last months) - all completed
        $history = [
            // patient, doctor, admit, time
            ['10011', 'amal', 'YES', '2026-09-05 09:00:00'],
            ['10012', 'khaled', 'NO', '2026-08-20 10:00:00'],
            ['10013', 'amal', 'NO', '2026-08-14 09:30:00'],
            ['10014', 'khaled', 'NO', '2026-07-22 09:00:00'],
            ['10015', 'amal', 'NO', '2026-07-10 10:30:00'],
            ['10016', 'khaled', 'NO', '2026-06-18 09:00:00'],
            ['10001', 'amal', 'NO', '2026-08-03 09:00:00'],
            ['10002', 'khaled', 'NO', '2026-07-15 11:00:00'],
            ['10003', 'amal', 'NO', '2026-06-09 09:45:00'],
            ['10010', 'khaled', 'NO', '2026-08-27 10:00:00'],
        ];

        $num = 100;
        foreach ($history as $app) {
            DB::table('appointments')->updateOrInsert(
                ['patient_id' => $app[0], 'created_at' => $app[3]],
                [
                    'number' => $num++,
                    'doctor_id' => $doctors[$app[1]],
                    'admit' => $app[2],
                    'completed' => 'YES',
                    'updated_at' => $app[3],
                ]
            );
        }

        $this->command->info('    appointments20 (10 today + 10 historical) ready');
    }

    /* ------------------------------------------------------------------ */

    protected function seedPrescriptions()
    {
        $medNames = ['باراسيتامول 500 ملغ', 'إيبوبروفين 400 ملغ', 'أموكسيسيلين 500 ملغ', 'فيتامين د 50000 وحدة', 'أوميبرازول 20 ملغ', 'لوراتادين 10 ملغ', 'ميتفورمين 850 ملغ'];

        $plans = [
            // patient created_at -> [medicine names + notes, bp, sugar, chol, medIssued, diagnosis]
            '10004|2026-09-23 09:15:00' => [
                [['باراسيتامول 500 ملغ', 'قرص بعد الأكل ثلاث مرات يومياً'], ['أوميبرازول 20 ملغ', 'كبسولة قبل الفطور']],
                '120/80', '95', '190', 'NO', 'صداع نصفي متكرر مع ارتفاع بسيط في الضغط، نصح بتغيير نمط الحياة.',
            ],
            '10003|2026-09-23 09:00:00' => [
                [['أموكسيسيلين 500 ملغ', 'كبسولة كل 8 ساعات لمدة أسبوع'], ['باراسيتامول 500 ملغ', 'عند الحاجة للألم']],
                '125/85', '110', '210', 'NO', 'التهاب في الجهاز التنفسي العلوي مع حرارة، يوصى بالراحة والسوائل.',
            ],
            '10006|2026-09-23 09:45:00' => [
                [['ميتفورمين 850 ملغ', 'قرص بعد الإفطار يومياً'], ['فيتامين د 50000 وحدة', 'كبسولة أسبوعياً']],
                '130/90', '160', '230', 'NO', 'سكري من النوع الثاني مع نقص فيتامين د، متابعة دورية وفحص مخبري.',
            ],
            '10011|2026-09-05 09:00:00' => [
                [['إيبوبروفين 400 ملغ', 'قرص عند الألم مرتين يومياً']],
                '135/90', '120', '240', 'YES', 'آلام المفاصل مع ارتفاع الضغط، مراقبة دورية أثناء التنويم.',
            ],
            '10012|2026-08-20 10:00:00' => [
                [['لوراتادين 10 ملغ', 'قرص مساءً لمدة أسبوعين']],
                '110/75', '90', '170', 'YES', 'حساسية موسمية واضحة، يوصى بتجنب مسببات الحساسية.',
            ],
            '10013|2026-08-14 09:30:00' => [
                [['باراسيتامول 500 ملغ', 'قرص عند الحاجة']],
                '118/78', '100', '185', 'YES', 'التهاب الحلق الفيروسي مع كحة بسيطة.',
            ],
            '10014|2026-07-22 09:00:00' => [
                [['أوميبرازول 20 ملغ', 'كبسولة قبل الفطور'], ['فيتامين د 50000 وحدة', 'كبسولة أسبوعياً']],
                '122/82', '96', '200', 'YES', 'حموضة معدية شديدة مع نقص فيتامين د.',
            ],
            '10016|2026-06-18 09:00:00' => [
                [['إيبوبروفين 400 ملغ', 'قرص مرتين يومياً بعد الأكل']],
                '115/70', '88', '165', 'YES', 'التهاب عضلي في الظهر ناتج عن حمل ثقيل.',
            ],
            '10001|2026-08-03 09:00:00' => [
                [['باراسيتامول 500 ملغ', 'قرص عند الألم'], ['لوراتادين 10 ملغ', 'قرص مساءً']],
                '124/84', '102', '198', 'YES', 'زكام ربيعي مع صداع خفيف.',
            ],
            '10002|2026-07-15 11:00:00' => [
                [['فيتامين د 50000 وحدة', 'كبسولة أسبوعياً']],
                '112/74', '92', '178', 'YES', 'نقص فيتامين د مع إرهاق عام.',
            ],
            '10010|2026-08-27 10:00:00' => [
                [['سيبروفلوكساسين 500 ملغ', 'قرص كل 12 ساعة لمدة 5 أيام']],
                '128/86', '108', '220', 'YES', 'التهاب في المسالك البولية مع ارتفاع طفيف في الضغط.',
            ],
        ];

        $doctorIds = [
            'khaled' => \App\User::where('email', 'dr.khaled@shifa-hospital.com')->value('id'),
            'amal' => \App\User::where('email', 'dr.amal@shifa-hospital.com')->value('id'),
        ];

        // map patient+created_at -> appointment doctor key
        $apptDoctor = [
            '10004|2026-09-23 09:15:00' => 'khaled',
            '10003|2026-09-23 09:00:00' => 'amal',
            '10006|2026-09-23 09:45:00' => 'amal',
            '10011|2026-09-05 09:00:00' => 'amal',
            '10012|2026-08-20 10:00:00' => 'khaled',
            '10013|2026-08-14 09:30:00' => 'amal',
            '10014|2026-07-22 09:00:00' => 'khaled',
            '10016|2026-06-18 09:00:00' => 'khaled',
            '10001|2026-08-03 09:00:00' => 'amal',
            '10002|2026-07-15 11:00:00' => 'khaled',
            '10010|2026-08-27 10:00:00' => 'khaled',
        ];

        $byPres = DB::table('prescriptions')->count();

        foreach ($plans as $key => $plan) {
            [$pKey, $ts] = explode('|', $key);
            $appointment = DB::table('appointments')
                ->where('patient_id', $pKey)
                ->where('created_at', $ts)
                ->first();
            if (!$appointment) {
                $this->command->warn("      skip prescription for missing appointment {$pKey} @ {$ts}");
                continue;
            }

            $medsJson = json_encode($this->medicinesToJson($plan[0]), JSON_UNESCAPED_UNICODE);
            $bp = json_encode(['value' => $plan[1], 'updated' => $ts], JSON_UNESCAPED_UNICODE);
            $sugar = json_encode(['value' => $plan[2], 'updated' => $ts], JSON_UNESCAPED_UNICODE);
            $chol = json_encode(['value' => $plan[3], 'updated' => $ts], JSON_UNESCAPED_UNICODE);

            DB::table('prescriptions')->updateOrInsert(
                ['appointment_id' => $appointment->id],
                [
                    'doctor_id' => $doctorIds[$apptDoctor[$key]],
                    'patient_id' => $pKey,
                    'diagnosis' => $plan[5],
                    'medicines' => $medsJson,
                    'bp' => $bp,
                    'blood_sugar' => $sugar,
                    'cholestrol' => $chol,
                    'medicine_issued' => $plan[4],
                    'created_at' => $ts,
                    'updated_at' => $ts,
                ]
            );

            $presId = DB::table('prescriptions')->where('appointment_id', $appointment->id)->value('id');

            foreach ($plan[0] as [$medName, $note]) {
                $medId = DB::table('medicines')->where('name_english', $medName)->value('id');
                DB::table('medicine_prescription')->updateOrInsert(
                    ['prescription_id' => $presId, 'medicine_id' => $medId],
                    ['note' => $note, 'issued' => $plan[4] === 'NO' ? 'NO' : 'YES']
                );
            }
        }

        $this->command->info('    prescriptions' . (DB::table('prescriptions')->count() - $byPres) . ' new (11 total demo) ready');
    }

    protected function medicinesToJson(array $rows)
    {
        $out = [];
        foreach ($rows as [$name, $note]) {
            $out[] = ['name' => $name, 'note' => $note];
        }
        return $out;
    }

    /* ------------------------------------------------------------------ */

    protected function seedInpatients()
    {
        $ward03 = DB::table('wards')->where('ward_no', '03')->first();
        $ward06 = DB::table('wards')->where('ward_no', '06')->first();

        // Active inpatient for patient 10009 (admitted today) - used for the discharge demo
        $existed = DB::table('inpatients')->where('patient_id', '10009')->exists();
        DB::table('inpatients')->updateOrInsert(
            ['patient_id' => '10009'],
            [
                'ward_id' => $ward03->id,
                'discharged' => 'NO',
                'patient_inventory' => 'هاتف، ملابس، وثائق شخصية',
                'house_doctor' => 'خالد الحكيمي',
                'approved_doctor' => 'خالد الحكيمي',
                'disease' => 'ارتفاع ضغط الدم المزمن',
                'duration' => 5,
                'condition' => 'مستقر',
                'certified_officer' => 'محمد الصبري',
                'created_at' => '2026-09-23 08:20:00',
                'updated_at' => '2026-09-23 08:20:00',
            ]
        );
        if (!$existed && $ward03) {
            DB::table('wards')->where('id', $ward03->id)->decrement('free_beds');
        }

        // Discharged inpatient for patient 10011 (admitted this month)
        $existed2 = DB::table('inpatients')->where('patient_id', '10011')->exists();
        DB::table('inpatients')->updateOrInsert(
            ['patient_id' => '10011'],
            [
                'ward_id' => $ward06->id,
                'discharged' => 'YES',
                'discharged_date' => '2026-09-12 11:30:00',
                'description' => 'تحسن ملحوظ، خرج بحالة جيدة مع تعليمات المتابعة.',
                'discharged_officer' => 'أمل المقبلي',
                'patient_inventory' => 'أدوية، ملابس',
                'house_doctor' => 'أمل المقبلي',
                'approved_doctor' => 'أمل المقبلي',
                'disease' => 'التهاب رئوي حاد',
                'duration' => 7,
                'condition' => 'تحسن وخرج بعد استقرار الحالة',
                'certified_officer' => 'علي محمد',
                'created_at' => '2026-09-05 09:10:00',
                'updated_at' => '2026-09-12 11:30:00',
            ]
        );
        if (!$existed2 && $ward06) {
            DB::table('wards')->where('id', $ward06->id)->decrement('free_beds');
            if (DB::table('inpatients')->where('patient_id', '10011')->value('discharged') === 'YES') {
                DB::table('wards')->where('id', $ward06->id)->increment('free_beds');
            }
        }

        $this->command->info('    inpatients2 (1 active + 1 discharged) ready');
    }

    /* ------------------------------------------------------------------ */

    protected function seedAttendances()
    {
        $userIds = DB::table('users')->orderBy('id')->pluck('id')->all();

        $rows = [];
        $counter = 0;

        foreach ($userIds as $uid) {
            $date = Carbon::parse('2026-06-01');
            while ($date->lte(Carbon::parse('2026-09-22'))) {
                if ($date->dayOfWeek !== Carbon::SATURDAY && $date->dayOfWeek !== Carbon::SUNDAY) {
                    $counter++;
                    // occasional skip for realism
                    if (($counter + $uid) % 11 === 0) {
                        $date->addDay();
                        continue;
                    }
                    $startMin = 8 * 60 + (($uid * 7 + $counter) % 30);
                    $start = $date->format('Y-m-d') . ' ' . gmdate('H:i:s', $startMin * 60);
                    // short day for some records so "short leave" appears in reports
                    $isShort = ($uid % 4 === 0 && ($counter + $uid) % 9 === 0);
                    $endMin = $isShort ? $startMin + 240 : 16 * 60 + ((($uid * 3) + $counter) % 60);
                    $end = $date->format('Y-m-d') . ' ' . gmdate('H:i:s', $endMin * 60);
                    $til = $date->format('Y-m-d H:i:s');
                    $rows[] = [
                        'user_id' => $uid,
                        'start' => $start,
                        'end' => $end,
                        'created_at' => $til,
                        'updated_at' => $end,
                    ];
                    if (count($rows) >= 400) {
                        DB::table('attendances')->insertOrIgnore($rows);
                        $rows = [];
                    }
                }
                $date->addDay();
            }
        }

        // a few earlier records for admin + first doctor (for year = 2026 views)
        foreach ([1, 2] as $uid) {
            $date = Carbon::parse('2026-01-05');
            while ($date->lte(Carbon::parse('2026-05-29'))) {
                if ($date->dayOfWeek !== Carbon::SATURDAY && $date->dayOfWeek !== Carbon::SUNDAY) {
                    $start = $date->format('Y-m-d') . ' 08:' . str_pad((string) (($uid * 3) % 60), 2, '0', STR_PAD_LEFT) . ':00';
                    $end = $date->format('Y-m-d') . ' 16:30:00';
                    $rows[] = [
                        'user_id' => $uid,
                        'start' => $start,
                        'end' => $end,
                        'created_at' => $start,
                        'updated_at' => $end,
                    ];
                    if (count($rows) >= 400) {
                        DB::table('attendances')->insertOrIgnore($rows);
                        $rows = [];
                    }
                }
                $date->addDay();
            }
        }

        if (count($rows) > 0) {
            DB::table('attendances')->insertOrIgnore($rows);
        }

        $this->command->info('    attendances (2026 records for all users) ready');
    }

    /* ------------------------------------------------------------------ */

    protected function seedClinics()
    {
        $clinicIds = DB::table('clinics')->pluck('id')->all();
        $patientIds = DB::table('patients')->where('id', 'like', '100%')->pluck('id')->all();

        $rows = [];
        foreach ($patientIds as $pid) {
            $clinicId = $clinicIds[abs(crc32($pid)) % count($clinicIds)];
            $rows[] = ['patients_id' => $pid, 'clinic_id' => $clinicId];
        }
        DB::table('clinic_patient')->insertOrIgnore($rows);

        $this->command->info('    clinics assignments (' . count($rows) . ') ready');
    }

    /* ------------------------------------------------------------------ */

    protected function seedNotices()
    {
        $notices = [
            ['subject' => 'الاجتماع الأسبوعي للأطباء', 'description' => 'سيُعقد الاجتماع الأسبوعي غداً الساعة العاشرة صباحاً في قاعة الاجتماعات الرئيسية.', 'user' => 'reception@shifa-hospital.com', 'time' => '2026-09-22 09:00:00'],
            ['subject' => 'صيانة الصيدلية', 'description' => 'ستخضع الصيدلية لصيانة دورية يوم الخميس القادم، يرجى تجهيز طلبات الأدوية قبل الموعد.', 'user' => 'pharmacist@shifa-hospital.com', 'time' => '2026-09-20 13:00:00'],
            ['subject' => 'متابعة المرضى المنومين', 'description' => 'مطلوب من أطباء الأقسام تحديث سجلات المرضى المنومين قبل نهاية الأسبوع.', 'user' => 'dr.khaled@shifa-hospital.com', 'time' => '2026-09-19 10:30:00'],
        ];

        foreach ($notices as $n) {
            DB::table('noticeboards')->updateOrInsert(
                ['subject' => $n['subject']],
                [
                    'description' => $n['description'],
                    'user_id' => \App\User::where('email', $n['user'])->value('id'),
                    'time' => $n['time'],
                ]
            );
        }

        $this->command->info('    notices3 (Arabic) ready');
    }
}