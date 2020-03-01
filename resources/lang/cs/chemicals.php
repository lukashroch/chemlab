<?php

return [
    'title' => 'Chemikálie',
    'index' => 'Chemikálie',
    'show' => 'Detail chemikálie',
    'new' => 'Nová chemikálie',
    'create' => 'Přidat chemikálii',
    'edit' => 'Upravit chemikálii',
    'delete' => 'Odstranit chemikálii',

    'search' => [
        'group' => 'Seskupit položky podle výrobce',
        'recent' => 'Nově přidané chemikálie'
    ],

    'name' => 'Název',
    'synonym' => 'Synonyma',
    'iupac' => 'IUPAC',
    'brand' => [
        '_' => 'Výrobce',
        'id' => 'ID výrobce',
        'error' => 'Chemikálie se stejným ID výrobce již existuje.'
    ],
    'cas' => 'CAS',
    'mw' => 'Mol. hmotnost',
    'formula' => 'Sumární vzorec',
    'pubchem' => [
        '_' => 'PubChem',
        'url' => 'https://pubchem.ncbi.nlm.nih.gov/substance/:id'
    ],
    'chemspider' => [
        '_' => 'ChemSpider',
        'url' => 'https://www.chemspider.com/Chemical-Structure.:id.html'
    ],
    'amount' => 'Množství',
    'unit' => 'ks',
    'owner' => 'Majitel',

    'header.save' => 'Nejdříve uložte hlavičku pro vložení položek k chemikálii.',

    'structure' => [
        '_' => 'Chemická struktura',
        'edit' => 'Upravit strukturu',
        'draw' => 'Vložit strukturu',
        'inchikey' => 'InChI Key',
        'inchi' => 'InChI',
        'sdf' => 'SDF',
        'smiles' => 'Smiles',
        'not' => [
            'entered' => 'Žádná chemická struktura nebyla vložena.',
            'resolved' => 'Chemická struktura nebyla rozpoznána.',
        ]
    ],

    'data' => [
        '_' => 'Stáhnout data',
        'source' => 'Zdroj',
        'id' => 'Identifikátor',
        'results' => 'Výsledky hledání',
        'all' => 'Stáhnout vše (SA + Cactus)',
        'cactus' => [
            '_' => 'Cactus NCI data',
            'hint' => 'Použijte identifikátor (CAS, název, IUPAC, PubChem) pro stažení dat ze služby Cactus NCI service.',
            'not-found' => '\':label\' nenalezeno pro \':search\'.'
        ],
        'sigma' => [
            '_' => 'Sigma Aldrich data',
            'hint' => 'Použijte kód produktu pro stažení dat od výrobce.',
            'not-found' => 'Produkt nenalezen pro \':search\'.'
        ],
        'vendor' => [
            '_' => 'Vendor data',
            'hint' => 'Použijte kód produktu pro stažení dat od výrobce.',
            'not-found' => 'Produkt nenalezen pro \':search\'.'
        ],
    ],

    'items' => [
        '_' => 'Položka chemikálie',
        'index' => 'Skladové zásoby',
        'none' => 'Žádná položka chemikálie není skladem',
        'create' => 'Přidat chemikálii',

        'move' => [
             '_' => 'Přesunout vybrané',
            'title' => 'Přesunout vybrané položky do skladu',
            'number' => 'Množství vybraných položek k přesunu:',
        ],

        'msg.moved' => 'Vybrané položky byly přesunuty.'
    ],

    'errors' => [
        'store' => 'Nemáte dostatečná oprávnění k modifikaci položek v tomto skladu.'
    ],
];
