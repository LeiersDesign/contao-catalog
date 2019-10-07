<?php

/*
 * Copyright 2019 leiers//DESIGN.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/* Palettes */
$GLOBALS['TL_DCA']['tl_content']['palettes']['list_single_company'] = '{type_legend},type,headline;'
        . '{company_legend},company_select;'
        . '{frontend_redirect_legend}, frontendRedirect;'
        . 'cssID;'
        . '{invisible_legend:hide},invisible,start,stop;';

$GLOBALS['TL_DCA']['tl_content']['palettes']['overview_map'] = '{type_legend},type,headline;'
        . 'map_center_address, map_center_coords;'
        . 'map_zoom, map_disable_mouse_wheel_zoom;'
        . 'map_size_width, map_size_height;'
        . 'map_layers;'
        . 'cssID;'
        . '{invisible_legend:hide},invisible,start,stop;';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['company_select'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['company_select'],
    'exclude' => true,
    'inputType' => 'select',
    'foreignKey' => "tl_firmen.name",
    'eval' => [
        'tl_class' => 'w50',
        'mandatory' => true
    ],
    'sql' => "int(10) NOT NULL default '0'"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['frontendRedirect'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['frontendRedirect'],
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => [
        'fieldType' => 'radio',
        'tl_class' => 'clr',
        'mandatory' => true
    ],
    'sql' => "int(10) unsigned NOT NULL default '0'",
    'relation' => [
        'type' => 'hasOne',
        'load' => 'eager'
    ]
];

$GLOBALS['TL_DCA']['tl_content']['fields']['map_center_address'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['map_center_address'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50'
    ],
    'sql' => "varchar(255) default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['map_center_coords'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['map_center_coords'],
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 64,
        'tl_class' => 'w50'
    ],
    'sql' => "varchar(64) default ''",
    'save_callback' => [
        ['LeiersDesign\ContaoCatalog\Classes\BackendHelper', 'geoCoordSaveCallback']
    ]
];

$GLOBALS['TL_DCA']['tl_content']['fields']['map_zoom'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['map_zoom'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18'],
    'default' => '10',
    'eval' => [
        'mandatory' => true,
        'tl_class' => 'w50'
    ],
    'sql' => "int(10) unsigned NOT NULL default '10'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['map_disable_mouse_wheel_zoom'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['map_disable_mouse_wheel_zoom'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12 clr',
        'submitOnChange' => false
    ],
    'sql' => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['map_size_width'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['map_size_width'],
    'exclude' => true,
    'inputType' => 'inputUnit',
    'options' => $GLOBALS['TL_CSS_UNITS'],
    'eval' => [
        'includeBlankOption' => false,
        'maxlength' => 20,
        'tl_class' => 'w50',
        'mandatory' => true
    ],
    'sql' => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['map_size_height'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['map_size_height'],
    'exclude' => true,
    'inputType' => 'inputUnit',
    'options' => $GLOBALS['TL_CSS_UNITS'],
    'eval' => [
        'includeBlankOption' => false,
        'maxlength' => 20,
        'tl_class' => 'w50',
        'mandatory' => true
    ],
    'sql' => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_content']['fields']['map_layers'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['map_layers'],
    'inputType' => 'fileTree',
    'exclude' => true,
    'sorting' => true,
    'flag' => 1,
    'search' => false,
    'eval' => [
        'mandatory' => false,
        'tl_class' => 'm12',
        'multiple' => true,
        'fieldType' => 'checkbox',
        'filesOnly' => true,
        'extensions' => 'gpx,kml'
    ],
    'sql' => "blob NULL"
];
