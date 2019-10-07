<?php

$GLOBALS['TL_DCA']['tl_member']['fields']['company']['eval']['mandatory'] = true;
$GLOBALS['TL_DCA']['tl_member']['fields']['street']['eval']['mandatory'] = true;
$GLOBALS['TL_DCA']['tl_member']['fields']['postal']['eval']['mandatory'] = true;
$GLOBALS['TL_DCA']['tl_member']['fields']['city']['eval']['mandatory'] = true;
$GLOBALS['TL_DCA']['tl_member']['fields']['country']['eval']['mandatory'] = true;

$GLOBALS['TL_DCA']['tl_member']['fields']['agb_akzeptiert'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_member']['agb_akzeptiert'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => false,
        'tl_class' => 'clr m12',
        'mandatory' => true,
        'feEditable'=>true,
        'feViewable'=>true
    ],
    'sql' => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_member']['fields']['datenschutz_akzeptiert'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_member']['datenschutz_akzeptiert'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => false,
        'tl_class' => 'clr m12',
        'mandatory' => true,
        'feEditable'=>true,
        'feViewable'=>true
    ],
    'sql' => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_member']['fields']['urheberrecht_bestaetigt'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_member']['urheberrecht_bestaetigt'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => false,
        'tl_class' => 'clr m12',
        'mandatory' => true,
        'feEditable'=>true,
        'feViewable'=>true
    ],
    'sql' => "char(1) NOT NULL default ''"
];

/**
 * Palette erweitern
 */
\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addLegend('agb_datenschutz_legend', 'newsletter_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER, false)
        ->addField('agb_akzeptiert', 'agb_datenschutz_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField('datenschutz_akzeptiert', 'agb_datenschutz_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField('urheberrecht_bestaetigt', 'agb_datenschutz_legend', \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('default', 'tl_member');
