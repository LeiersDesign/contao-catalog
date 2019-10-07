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
