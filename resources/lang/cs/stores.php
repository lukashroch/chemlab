<?php

return [
    'title' => 'Sklad',
    'index' => 'Sklady',
    'all' => 'Všechny sklady',
    'show' => 'Detail skladu',
    'new' => 'Nový sklad',
    'create' => 'Přidat sklad',
    'edit' => 'Upravit sklad',
    'delete' => 'Odstranit sklad',
    'select' => 'Vyber sklad',

    'name' => 'Název',
    'abbr_name' => 'Zkratka',
    'tree_name' => 'Celý název',
    'parent' => 'Nadřazený sklad',
    'team' => 'Tým skladu',
    'children' => 'Obsahuje sklady',
    'temp' => [
        '_' => 'Teplota',
        'int' => 'od :min do :max °C',
        'min' => 'Minimální',
        'max' => 'Maximální',
    ],
    'chemicals' => 'Uložené chemikálie',

    'msg' => [
        'has_items' => 'Sklad :name obsahuje chemikálie, nejprve je přesuňte nebo odstraňte.',
        'has_children' => 'Sklad :name obsahuje další sklady pod sebou, nejprve přesuňte tyto sklady mimo daný sklad.',
        'name' => 'Sklad s daným jménem již existuje v dané podskupině skladů.',
        'is_child_or_self' => 'Sklad nemůže být přesunut do vlastního dceřinného skladu.',
    ]
];
