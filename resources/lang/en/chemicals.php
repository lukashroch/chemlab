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
        'advanced' => 'Advanced',
        'group' => 'Group by vendor',
        'recent' => 'Recently added chemicals',
        'recent.info' => ' (last 30 days)',
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

    'header.save' => 'Firstly, save the header information!',

    'structure' => [
        '_' => 'Chemical structure',
        'edit' => 'Edit structure',
        'draw' => 'Draw structure',
        'inchikey' => 'InChI Key',
        'inchi' => 'InChI',
        'sdf' => 'SDF',
        'smiles' => 'Smiles'
    ],

    'data' => [
        '_' => 'Get data',
        'all' => 'Get all data (SA + Cactus)',
        'sigma' => 'Get Sigma Aldrich data',
        'cactus' => [
            '_' => 'Get Cactus NCI data',
            'select' => 'Select Cactus NCI',
            'cas' => 'Get CAS',
            'chemspider' => 'Get ChemSpider ID',
            'formula' => 'Get Chemical Formula',
            'iupac' => 'Get IUPAC Name',
            'mw' => 'Get Molecular Weight',
            'structure' => 'Get Structure'
        ]
    ]
];
