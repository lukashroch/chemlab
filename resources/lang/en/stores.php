<?php

return [
    'title' => 'Store',
    'index' => 'Stores',
    'all' => 'All stores',
    'show' => 'Store details',
    'new' => 'New store',
    'create' => 'Add store',
    'edit' => 'Edit store',
    'delete' => 'Delete store',
    'select' => 'Select a store',

    'name' => 'Name',
    'abbr_name' => 'Abbreviation',
    'tree_name' => 'Full name',
    'parent' => 'Parent store',
    'team' => 'Store\'s team',
    'children' => 'Child stores',
    'temp' => [
        '_' => 'Temperature',
        'int' => 'from :min to :max °C',
        'min' => 'Minimal',
        'max' => 'Maximal',
    ],
    'chemicals' => 'Stored chemicals',

    'msg' => [
        'has_items' => 'Store :name contains chemicals, firstly move or delete these chemicals.',
        'has_children' => 'Store :name contains children stores, firstly move those to different parent store.',
        'name' => 'Entered store name already exists within selected sub-store.',
        'is_child_or_self' => 'Store can\'t be moved into its child store.',
    ]
];
