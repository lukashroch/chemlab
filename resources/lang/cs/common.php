<?php

return [
    'index' => 'ChemLab',
    'chemlab' => 'ChemLab',
    'home' => 'Hlavní stránka',
    'register' => 'Registrace',
    'login' => 'Přihlásit se',
    'login_with' => 'Přihlásit se přes :provider',
    'logout' => 'Odhlásit se',
    'profile' => 'Profil',
    'other' => 'Jiné',
    'top' => 'Nahoru',

    'link' => [
        '_' => 'Odkaz',
        'public' => ' Veřejný odkaz',
        'external' => 'Externí odkaz',
    ],

    'social' => [
        'facebook' => 'Facebook',
        'linkedin' => 'LinkedIn',
        'rss' => 'RSS',
        'twitter' => 'Twitter',
        'youtube' => 'Youtube',
    ],

    'admin' => 'Správa',
    'lab' => 'Laboratoř',
    'acl' => 'Správa přístupů',
    'advanced' => 'Pokročilé nastavení',

    'misc' => 'Různé',
    'info' => 'Informace',
    'options' => 'Možnosti',
    'type' => 'Druh',
    'category' => 'Kategorie',

    'all' => 'Vše',
    'none' => 'Žádný',
    'select' => [
        '_' => 'Vybrat',
        'all' => 'Vybrat vše',
        'none' => 'Odznačit vše',
    ],
    'not' => [
        'assigned' => 'Nepřiřazeno',
        'available' => 'Není k dispozici',
        'defined' => 'Nedefinováno',
        'selected' => 'Nevybráno',
        'entered' => 'Nezadáno',
        'limited' => 'Neomezeno',
        'restricted' => 'Neomezeno',
    ],

    'error' => 'Something went wrong!',
    'error.not-allowed' => 'Nepovolená akce!',
    'yes' => 'Ano',
    'true' => 'Ano',
    'no' => 'Ne',
    'false' => 'Ne',
    'add' => 'Přidat',
    'cancel' => 'Zrušit',
    'close' => 'Zavřít',
    'open' => 'Otevřít',
    'remove' => 'Odebrat',
    'submit' => 'Potvrdit',
    'save' => 'Uložit',
    'upload' => 'Nahrát',
    'send' => 'Odeslat',

    'search' => [
        'title' => 'Hledat',
        'filter' => 'Filter',
        'clear' => 'Vymazat',
        'advanced' => 'Pokročilé vyhledávání',
        'trashed' => 'Zahrnout smazané záznamy',
    ],

    'filter' => [
        'role' => 'Role',
        'store' => 'Sklad',
    ],

    'action' => [
        '_' => 'Akce',
        'audit' => 'Audit',
        'back' => 'Zpět',
        'clear' => 'Vyčistit',
        'create' => 'Přidat',
        'detail' => 'Detail',
        'download' => 'Stáhnout',
        'export' => 'Export',
        'insert' => 'Vložit',
        'load' => 'Načíst',
        'show' => 'Info',
        'structure' => 'Struktura',
        'submit' => 'Vyhledat',
        'transfer' => 'Přesunout',
        'print' => 'Tisk',
        'edit' => 'Upravit',
        'delete' => 'Odstranit',
        'restore' => 'Obnovit',
        'destroy' => 'Trvale odstranit',
        'multi' => [
            'delete' => 'Smazat vybrané položky',
            'restore' => 'Obnovit vybrané položky',
        ],
        'confirm' => [
            'delete' => 'Opravdu chcete odstranit: :name?',
            'restore' => 'Opravdu chcete obnovit :name?',
            'multi' => [
                'delete' => 'Vybrané položky položky budou smazány: :count',
                'restore' => 'Vybrané položky položky budou obnoveny: :count',
            ],
        ],
    ],

    'exports' => [
        'print' => 'Tisk',
        'csv' => 'CSV',
        'excel' => 'Excel',
        //'pdf' => 'PDF',
    ],




    'record' => [
        'title' => 'Záznam',
        'type' => 'Typ záznamu',
        'name' => 'Název záznamu',
    ],
    'records' => [
        'count' => 'Počet záznamů',
        'selected' => 'Počet vybraných záznamů',
    ],

    'name' => 'Jméno',
    'surname' => 'Přijmení',
    'id' => 'ID',
    'title' => 'Název',
    'title_internal' => 'Interní název',
    'email' => 'Email',
    'subject' => 'Předmět',
    'content' => 'Obsah',
    'message' => 'Sdělení',
    'text' => 'Obsah',
    'description' => 'Popis',
    'notes' => 'Poznámky',
    'size' => 'Velikost',
    'count' => 'Počet',
    'date' => 'Datum',
    'available_at' => 'Dostupný',
    'expires_at' => 'Datum expirace',
    'expired_at' => 'Platnost vyprší',
    'created_at' => 'Vytvořeno',
    'updated_at' => 'Upraveno',
    'deleted_at' => 'Smazáno',
    'year' => 'Rok',

    'terms' => [
        'consent' => 'Souhlasím se zpracováním',
        'privacy' => 'osobních údajů.',
    ],

    'oauth2' => [
        'missing_email' => 'Pro příhlášení je potřeba poskytnout platnou emailovou adresu.'
    ],

    'msg' => [
        'stored' => 'Záznam (:name) byl vytvořen.',
        'updated' => 'Záznam (:name) byl upraven.',
        'deleted' => 'Záznam (:name) byl odstraněn.',
        'restored' => 'Záznam (:name) byl obnoven.',
        'destroyed' => 'Záznam (:name) byl trvale odstraněn.',
        'transferred' => 'Záznam (:name) byl přesunut.',
        'multi' => [
            'deleted' => 'Vybrané položky byly smazány.',
            'restored' => 'Vybrané položky byly obnoveny.'
        ],

        'registered' => 'Právě jste byl uspěšně registrován. Na email jsme Vám poslali instrukce jak plně aktivovat Váš účet.',
    ],
];
