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

    'accepted' => 'Pole :attribute musí být přijato.',
    'active_url' => 'Pole :attribute není platnou URL adresou.',
    'after' => 'Pole :attribute musí být datum po :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'Pole :attribute může obsahovat pouze písmena.',
    'alpha_dash' => 'Pole :attribute může obsahovat pouze písmena, číslice, pomlčky a podtržítka. České znaky (á, é, í, ó, ú, ů, ž, š, č, ř, ď, ť, ň) nejsou podporovány.',
    'alpha_num' => 'Pole :attribute může obsahovat pouze písmena a číslice.',
    'array' => 'Pole :attribute musí být pole.',
    'before' => 'Pole :attribute musí být datum před :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'Pole :attribute musí být hodnota mezi :min a :max.',
        'file' => 'Pole :attribute musí být větší než :min a menší než :max Kilobytů.',
        'string' => 'Pole :attribute musí být delší než :min a kratší než :max znaků.',
        'array' => 'Pole :attribute musí obsahovat nejméně :min a nesmí obsahovat více než :max prvků.',
    ],
    'boolean' => 'Pole :attribute musí být true (ano) nebo false (ne).',
    'confirmed' => 'Pole :attribute se neshoduje / nebylo odsouhlaseno.',
    'date' => 'Pole :attribute musí být platné datum.',
    'date_format' => 'Pole :attribute není platný formát data podle :format.',
    'different' => 'Pole :attribute a :other se musí lišit.',
    'digits' => 'Pole :attribute musí být :digits pozic dlouhé.',
    'digits_between' => 'Pole :attribute musí být dlouhé nejméně :min a nejvíce :max pozic.',
    'dimensions' => 'Pole :attribute má neplatné rozměry.',
    'distinct' => 'Pole :attribute má duplicitní hodnotu.',
    'email' => 'Pole :attribute není platný formát.',
    'ends_with' => 'Pole :attribute musí končit jedním z následujích řetězeců znaků: :values',
    'exists' => 'Zvolená hodnota pro :attribute není platná.',
    'file' => 'Pole :attribute musí být soubor.',
    'filled' => 'Pole :attribute musí být vyplněno.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'Pole :attribute musí být obrázek.',
    'in' => 'Zvolená hodnota pro :attribute je neplatná.',
    'in_array' => 'Pole :attribute není obsažen v :other.',
    'integer' => 'Pole :attribute musí být celé číslo.',
    'ip' => 'Pole :attribute musí být platnou IP adresou.',
    'ipv4' => 'Pole :attribute musí být platnou IPv4 adresou.',
    'ipv6' => 'Pole :attribute musí být platnou IPv6 adresou.',
    'json' => 'Pole :attribute musí být platný JSON řetězec.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'Pole :attribute musí být nižší než :max.',
        'file' => 'Pole :attribute musí být menší než :max Kilobytů.',
        'string' => 'Pole :attribute musí být kratší než :max znaků.',
        'array' => 'Pole :attribute nesmí obsahovat více než :max prvků.',
    ],
    'mimes' => 'Pole :attribute musí být jeden z následujících datových typů :values.',
    'mimetypes' => 'Pole :attribute musí být jeden z následujících datových typů :values.',
    'min' => [
        'numeric' => 'Pole :attribute musí být větší než :min.',
        'file' => 'Pole :attribute musí být větší než :min Kilobytů.',
        'string' => 'Pole :attribute musí být delší než :min znaků.',
        'array' => 'Pole :attribute musí obsahovat více než :min prvků.',
    ],
    'not_in' => 'Zvolená hodnota pro :attribute je neplatná.',
    'not_regex' => 'Formát pole :attribute není platný.',
    'numeric' => 'Pole :attribute musí být číslo (pro desetinné číslo použijte tečku jako oddělovač).',
    'password' => 'Heslo není správně zadáno.',
    'phone' => 'Pole :attribute není platné telefonní číslo.',
    'present' => 'Pole :attribute musí být vyplněno.',
    'regex' => 'Pole :attribute nemá správný formát.',
    'required' => 'Pole :attribute musí být vyplněno.',
    'required_if' => 'Pole :attribute musí být vyplněno pokud :other je :value.',
    'required_unless' => 'Pole :attribute musí být vyplněno dokud :other je v :values.',
    'required_with' => 'Pole :attribute musí být vyplněno pokud :values je vyplněno.',
    'required_with_all' => 'Pole :attribute musí být vyplněno pokud :values je zvoleno.',
    'required_without' => 'Pole :attribute musí být vyplněno pokud :values není vyplněno.',
    'required_without_all' => 'Pole :attribute musí být vyplněno pokud není žádné z :values zvoleno.',
    'same' => 'Pole :attribute a :other se musí shodovat.',
    'size' => [
        'numeric' => 'Pole :attribute musí být přesně :size.',
        'file' => 'Pole :attribute musí mít přesně :size Kilobytů.',
        'string' => 'Pole :attribute musí být přesně :size znaků dlouhý.',
        'array' => 'Pole :attribute musí obsahovat právě :size prvků.',
    ],
    'starts_with' => 'Pole :attribute musí začínat jedním z následujích řetězeců znaků: :values',
    'string' => 'Pole :attribute musí být řetězec znaků.',
    'timezone' => 'Pole :attribute musí být platná časová zóna.',
    'unique' => 'Pole :attribute musí být unikátní.',
    'uploaded' => 'Nahrávání :attribute se nezdařilo.',
    'url' => 'Formát :attribute je neplatný.',
    'uuid' => 'Pole :attribute musí být platné UUID.',

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
        'recaptcha' => [
            'required' => 'ReCaptcha nebyla správně vyplněna.'
        ],
        'password' => [
            'allowed' => 'Heslo obsahuje nepovolené výrazy: :attribute.'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'jméno',
        'surname' => 'přijmení',
        'password' => 'heslo',
        'password_current' => 'současné heslo',
        'email' => 'email',
        'phone' => 'telefon'
    ]
];
