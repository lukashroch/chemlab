<?php

return [
    'title' => 'Store',
    'index' => 'Stores',
    'show' => 'Store details',
    'new' => 'New store',
    'create' => 'Add store',
    'edit' => 'Edit store',
    'delete' => 'Delete store',
    'select' => 'Select a store',

    'name' => 'Name',
    'abbr_name' => 'Abbreviation',
    'parent' => 'Parent store',
    'parent.none' => 'None',
    'temp' => 'Store temperature',
    'temp.int' => 'from :min to :max °C',
    'temp.min' => 'Minimal',
    'temp.max' => 'Maximal',
    'description' => 'Description',
    'chemicals' => 'Stored chemicals',

    'msg.inserted' => 'Store :name has been inserted.',
    'msg.updated' => 'Store :name has been updated.',
    'msg.deleted' => 'Store :name has been deleted.',
    'msg.has_items' => 'Store :name contains chemicals, firstly move or delete these chemicals.',
    'msg.has_children' => 'Store :name contains children stores, firstly move those to different parent store.',
    'msg.name' => 'Entered store name already exists within selected sub-store.',
    'msg.is_child_or_self' => 'Store can\'t be moved into its child store.',
];
