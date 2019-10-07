<?php

$GLOBALS['TL_DCA']['tl_module']['fields']['frontendEditRedirect'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['frontendEditRedirect'],
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => [
        'fieldType' => 'radio',
        'tl_class' => 'clr m12',
        'mandatory' => true
    ],
    'sql' => "int(10) unsigned NOT NULL default '0'",
    'relation' => [
        'type' => 'hasOne',
        'load' => 'eager'
    ]
];

$GLOBALS['TL_DCA']['tl_module']['fields']['frontendRedirect'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['frontendRedirect'],
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

$GLOBALS['TL_DCA']['tl_module']['fields']['frontendToggleRedirect'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_module']['frontendToggleRedirect'],
    'exclude' => true,
    'inputType' => 'pageTree',
    'foreignKey' => 'tl_page.title',
    'eval' => [
        'fieldType' => 'radio',
        'tl_class' => 'clr m12',
        'mandatory' => true
    ],
    'sql' => "int(10) unsigned NOT NULL default '0'",
    'relation' => [
        'type' => 'hasOne',
        'load' => 'eager'
    ]
];

$GLOBALS['TL_DCA']['tl_module']['palettes']['list_user_companies'] = '{title_legend},name, type;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['list_user_companies'] .= '{catalog_legend},frontendRedirect, frontendEditRedirect, frontendToggleRedirect;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['list_user_companies'] .= '{expert_legend:hide},cssID;';

$GLOBALS['TL_DCA']['tl_module']['palettes']['toggle_user_company'] = '{title_legend},name, type;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['toggle_user_company'] .= '{catalog_legend},jumpTo;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['toggle_user_company'] .= '{expert_legend:hide},cssID;';

$GLOBALS['TL_DCA']['tl_module']['palettes']['company_preview'] = '{title_legend},name, type;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['company_preview'] .= '{expert_legend:hide},cssID;';

$GLOBALS['TL_DCA']['tl_module']['palettes']['company_detail'] = '{title_legend},name, type;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['company_detail'] .= '{expert_legend:hide},cssID;';

$GLOBALS['TL_DCA']['tl_module']['palettes']['company_edit'] = '{title_legend},name, type;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['company_edit'] .= '{catalog_legend},jumpTo;';
$GLOBALS['TL_DCA']['tl_module']['palettes']['company_edit'] .= '{expert_legend:hide},cssID;';

/*\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addLegend('catalog_legend', 'title_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER, false)
        ->addLegend('expert_legend', 'catalog_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER, false)
        ->addField('frontendRedirect', 'catalog_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField('frontendEditRedirect', 'catalog_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField('frontendToggleRedirect', 'catalog_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField('cssID', 'expert_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('list_user_companies', 'tl_module');*/
