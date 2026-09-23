<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'يجب قبول حقل :attribute.',
    'active_url' => 'حقل :attribute ليس عنوان URL صالحاً.',
    'after' => 'يجب أن يكون تاريخ :attribute بعد تاريخ :date.',
    'after_or_equal' => 'يجب أن يكون تاريخ :attribute بعد تاريخ :date أو مساوياً له.',
    'alpha' => 'قد يحتوي حقل :attribute على أحرف فقط.',
    'alpha_dash' => 'قد يحتوي حقل :attribute على أحرف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num' => 'قد يحتوي حقل :attribute على أحرف وأرقام فقط.',
    'array' => 'يجب أن يكون حقل :attribute مصفوفة.',
    'before' => 'يجب أن يكون تاريخ :attribute قبل تاريخ :date.',
    'before_or_equal' => 'يجب أن يكون تاريخ :attribute قبل تاريخ :date أو مساوياً له.',
    'between' => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم ملف :attribute بين :min و :max كيلوبايت.',
        'string' => 'يجب أن يكون عدد أحرف :attribute بين :min و :max.',
        'array' => 'يجب أن يحتوي حقل :attribute على عناصر بين :min و :max.',
    ],
    'boolean' => 'يجب أن يكون حقل :attribute إما true أو false.',
    'confirmed' => 'تأكيد :attribute غير مطابق.',
    'date' => 'حقل :attribute ليس تاريخاً صالحاً.',
    'date_equals' => 'يجب أن يكون تاريخ :attribute مساوياً لتاريخ :date.',
    'date_format' => 'حقل :attribute لا يطابق الصيغة :format.',
    'different' => 'يجب أن يختلف حقل :attribute عن حقل :other.',
    'digits' => 'يجب أن يتكون حقل :attribute من :digits أرقام.',
    'digits_between' => 'يجب أن يتكون حقل :attribute بين :min و :max أرقام.',
    'dimensions' => 'حقل :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'يحتوي حقل :attribute على قيمة مكررة.',
    'email' => 'يجب أن يكون حقل :attribute عنوان بريد إلكتروني صالحاً.',
    'ends_with' => 'يجب أن ينتهي حقل :attribute بأحد القيم التالية: :values',
    'exists' => 'قيمة :attribute المحددة غير صالحة.',
    'file' => 'يجب أن يكون حقل :attribute ملفاً.',
    'filled' => 'يجب أن يحتوي حقل :attribute على قيمة.',
    'gt' => [
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من :value.',
        'file' => 'يجب أن يكون حجم ملف :attribute أكبر من :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد أحرف :attribute أكبر من :value.',
        'array' => 'يجب أن يحتوي حقل :attribute على أكثر من :value عنصراً.',
    ],
    'gte' => [
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من أو تساوي :value.',
        'file' => 'يجب أن يكون حجم ملف :attribute أكبر من أو يساوي :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد أحرف :attribute أكبر من أو يساوي :value.',
        'array' => 'يجب أن يحتوي حقل :attribute على :value عناصر أو أكثر.',
    ],
    'image' => 'يجب أن يكون حقل :attribute صورة.',
    'in' => 'قيمة :attribute المحددة غير صالحة.',
    'in_array' => 'حقل :attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون حقل :attribute عدداً صحيحاً.',
    'ip' => 'يجب أن يكون حقل :attribute عنوان IP صالحاً.',
    'ipv4' => 'يجب أن يكون حقل :attribute عنوان IPv4 صالحاً.',
    'ipv6' => 'يجب أن يكون حقل :attribute عنوان IPv6 صالحاً.',
    'json' => 'يجب أن يكون حقل :attribute سلسلة JSON صالحة.',
    'lt' => [
        'numeric' => 'يجب أن تكون قيمة :attribute أقل من :value.',
        'file' => 'يجب أن يكون حجم ملف :attribute أقل من :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد أحرف :attribute أقل من :value.',
        'array' => 'يجب أن يحتوي حقل :attribute على أقل من :value عناصر.',
    ],
    'lte' => [
        'numeric' => 'يجب أن تكون قيمة :attribute أقل من أو تساوي :value.',
        'file' => 'يجب أن يكون حجم ملف :attribute أقل من أو يساوي :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد أحرف :attribute أقل من أو يساوي :value.',
        'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :value عناصر.',
    ],
    'max' => [
        'numeric' => 'يجب ألا تكون قيمة :attribute أكبر من :max.',
        'file' => 'يجب ألا يكون حجم ملف :attribute أكبر من :max كيلوبايت.',
        'string' => 'يجب ألا يكون عدد أحرف :attribute أكبر من :max.',
        'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max عنصراً.',
    ],
    'mimes' => 'يجب أن يكون حقل :attribute ملفاً من النوع: :values.',
    'mimetypes' => 'يجب أن يكون حقل :attribute ملفاً من النوع: :values.',
    'min' => [
        'numeric' => 'يجب أن تكون قيمة :attribute على الأقل :min.',
        'file' => 'يجب أن يكون حجم ملف :attribute على الأقل :min كيلوبايت.',
        'string' => 'يجب أن يكون عدد أحرف :attribute على الأقل :min.',
        'array' => 'يجب أن يحتوي حقل :attribute على الأقل :min عنصراً.',
    ],
    'not_in' => 'قيمة :attribute المحددة غير صالحة.',
    'not_regex' => 'صيغة حقل :attribute غير صالحة.',
    'numeric' => 'يجب أن يكون حقل :attribute رقماً.',
    'present' => 'يجب أن يكون حقل :attribute موجوداً.',
    'regex' => 'صيغة حقل :attribute غير صالحة.',
    'required' => 'حقل :attribute مطلوب.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_unless' => 'حقل :attribute مطلوب ما لم يكن :other موجوداً في :values.',
    'required_with' => 'حقل :attribute مطلوب عندما يكون :values موجوداً.',
    'required_with_all' => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_without' => 'حقل :attribute مطلوب عندما لا يكون :values موجوداً.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا تكون أي من :values موجودة.',
    'same' => 'يجب أن يتطابق حقل :attribute مع حقل :other.',
    'size' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية :size.',
        'file' => 'يجب أن يكون حجم ملف :attribute مساوياً :size كيلوبايت.',
        'string' => 'يجب أن يكون عدد أحرف :attribute مساوياً :size.',
        'array' => 'يجب أن يحتوي حقل :attribute على :size عناصر.',
    ],
    'starts_with' => 'يجب أن يبدأ حقل :attribute بأحد القيم التالية: :values',
    'string' => 'يجب أن يكون حقل :attribute نصاً.',
    'timezone' => 'يجب أن يكون حقل :attribute منطقة زمنية صالحة.',
    'unique' => 'قيمة :attribute مستخدمة بالفعل.',
    'uploaded' => 'فشل في رفع حقل :attribute.',
    'url' => 'صيغة حقل :attribute غير صالحة.',
    'uuid' => 'يجب أن يكون حقل :attribute UUID صالحاً.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'name' => 'الاسم',
        'reg_pname' => 'اسم المريض',
        'reg_pic' => 'رقم البطاقة الوطنية',
        'reg_paddress' => 'عنوان المريض',
        'reg_ptel' => 'هاتف المريض',
        'reg_poccupation' => 'مهنة المريض',
        'reg_psex' => 'الجنس',
        'reg_pbd' => 'تاريخ الميلاد',
        'reg_ppic' => 'صورة المريض',
        'year' => 'السنة',
        'newcontactnum' => 'رقم الاتصال الجديد',
        'newemail' => 'البريد الإلكتروني الجديد',
        'currentpassword' => 'كلمة المرور الحالية',
        'newpassword' => 'كلمة المرور الجديدة',
        'newpasswordagain' => 'تأكيد كلمة المرور الجديدة',
        'pername' => 'اسم الموعد',
        'number' => 'الرقم',
        'keyword' => 'كلمة البحث',
    ],

];