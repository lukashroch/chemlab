<?php

return [
    'title' => 'Chemical',
    'index' => 'Chemicals',
    'show' => 'Chemical details',
    'new' => 'New chemical',
    'create' => 'Add chemical',
    'edit' => 'Edit chemical',
    'delete' => 'Delete chemical',

    'search' => [
        'group' => 'Group by vendor',
        'recent' => 'Recently added chemicals',
    ],

    'name' => 'Name',
    'synonym' => 'Synonym',
    'iupac' => 'IUPAC',
    'brand' => [
        '_' => 'Brand',
        'id' => 'Brand ID',
        'error' => 'Chemical with Vendor ID already exists.',
    ],
    'cas' => 'CAS',
    'mw' => 'Molecular Weight',
    'formula' => 'Chemical Formula',
    'pubchem' => [
        '_' => 'PubChem',
        'url' => 'https://pubchem.ncbi.nlm.nih.gov/substance/:id'
    ],
    'chemspider' => [
        '_' => 'ChemSpider',
        'url' => 'https://www.chemspider.com/Chemical-Structure.:id.html'
    ],
    'amount' => 'Amount',
    'unit' => 'pcs',
    'owner' => 'Owner',

    'header.save' => 'Firstly, save the header information!',

    'structure' => [
        '_' => 'Chemical structure',
        'edit' => 'Edit structure',
        'draw' => 'Draw structure',
        'inchikey' => 'InChI Key',
        'inchi' => 'InChI',
        'sdf' => 'SDF',
        'smiles' => 'Smiles',
        'not' => [
            'entered' => 'No chemical structure entereted.',
            'resolved' => 'Chemical structure couldn\'t be resolved.',
        ]
    ],

    'data' => [
        '_' => 'Get data',
        'source' => 'Zdroj',
        'id' => 'Indetifier',
        'results' => 'Results',
        'all' => 'Get all data (SA + Cactus)',
        'cactus' => [
            '_' => 'Cactus NCI data',
            'hint' => 'Use chemical identifier (CAS, name, IUPAC, PubChem) to fetch data from Cactus NCI service.',
            'not-found' => '\':label\' not found for \':search\'.'
        ],
        'sigma' => [
            '_' => 'Sigma Aldrich data',
            'hint' => 'Use product code to fetch data from vendor source.',
            'not-found' => 'Product not found for \':search\'.'
        ],
        'vendor' => [
            '_' => 'Vendor data',
            'hint' => 'Use product code to fetch data from vendor source.',
            'not-found' => 'Product not found for \':search\'.'
        ]
    ],

    'items' => [
        '_' => 'Chemical Item',
        'index' => 'Chemicals items in stock',
        'none' => 'No chemical items in stock',
        'create' => 'Add Chemical Item',
        'move' => [
            '_' => 'Move selected',
            'title' => 'Move selected chemical item to store',
            'number' => 'Number of selected chemical items to relocate:',
        ],

        'msg.moved' => 'Selected chemicals have been moved.'
    ],

    'errors' => [
        'store' => 'You don\'t have permission to modify some of items in selected store.',
    ]
];
