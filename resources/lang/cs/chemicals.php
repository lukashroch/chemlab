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
        'recent' => 'Nově přidané chemikálie',
        'recent.info' => ' (za posledních 30 dní)',
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

    'header.save' => 'Nejdříve uložte hlavičku pro vložení položek k chemikálii.',

    'structure' => [
        '_' => 'Chemická struktura',
        'edit' => 'Upravit strukturu',
        'draw' => 'Vložit strukturu',
        'inchikey' => 'InChI Key',
        'inchi' => 'InChI',
        'sdf' => 'SDF',
        'smiles' => 'Smiles'
    ],

    'data' => [
        '_' => 'Stáhnout data',
        'all' => 'Stáhnout vše (SA + Cactus)',
        'sigma' => 'Stáhnout Sigma Aldrich data',
        'cactus' => [
            '_' => 'Stáhnout Cactus NCI data',
            'select' => 'Jednotlivě vybrat z Cactus NCI',
            'cas' => 'Stáhnout CAS',
            'chemspider' => 'Stáhnout ChemSpider ID',
            'formula' => 'Stáhnout sum. vzorec',
            'iupac' => 'Stáhnout IUPAC název',
            'mw' => 'Stáhnout mol. hmotnost',
            'structure' => 'Stáhnout strukturu'
        ]
    ]
];
