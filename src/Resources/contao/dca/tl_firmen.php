<?php

/**
 * Table tl_firmen
 */
$GLOBALS['TL_DCA']['tl_firmen'] = 
    [
    // Config
    'config' => 
        [
        'dataContainer' => 'Table',
        'sql' => 
            [
            'keys' => 
                [
                'id' => 'primary'
            ]
        ],
        'onsubmit_callback' => [
            ['tl_firmen', 'generateAlias'],
            ['LeiersDesign\ContaoCatalog\Classes\BackendHelper', 'getGeoCoordinates'],
        ],
        'ondelete_callback' => [
            ['LeiersDesign\ContaoCatalog\Classes\VersionManager', 'deleteVersion']
        ]
    ],
    // List
    'list' => 
        [
        'sorting' => 
            [
            'mode' => 1,
            'fields' => ['name'],
            'flag' => 1,
            'panelLayout' => 'search, limit; filter;'
        ],
        'label' => 
            [
            'fields' => ['name'],
            'format' => '%s',
            'label_callback' => ['tl_firmen', 'firmenLabelCallback']
        ],
        'global_operations' => 
            [
            'all' => 
                [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ]
        ],
        'operations' => 
            [
            'edit_events' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen']['edit_events'],
                'href' => 'table=tl_firmen_events',
                'icon' => 'bundles/contaocatalog/img/icon_events.svg',
            ],
            'edit' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg'
            ],
            'delete' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            'copy' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ],
            'toggle' => [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen']['toggle'],
                'icon' => 'visible.gif',
                'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => ['tl_firmen', 'toggleIcon']
            ],
            'show' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif',
            ],
            'version_create' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen']['version_create'],
                'href' => 'key=versionCreate',
                'icon' => 'bundles/contaocatalog/img/create_version.png',
            ],
            'version_diffs' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen']['version_diffs'],
                'href' => 'key=versionDiffs',
                'icon' => 'bundles/contaocatalog/img/show_version_differences.png',
                'button_callback' => ['LeiersDesign\ContaoCatalog\Classes\VersionDifferences', 'checkForVersion']
            ],
            'switch_version' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen']['version_diffs'],
                'href' => 'key=versionSwitch',
                'icon' => 'bundles/contaocatalog/img/switch_version.png',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['version_diffs']['confirm_version_switch'] . '\'))return false;Backend.getScrollOffset()"',
                'button_callback' => ['LeiersDesign\ContaoCatalog\Classes\VersionDifferences', 'checkForVersion']
            ],
        ]
    ],
    // Palettes
    'palettes' => 
        [
        '__selector__' => ['is_person'],
        'default' => 'name, alias, zusatz;'
        . 'strasse, hsnr, plz_ort, stadtteil, gewerbegebiet;'
        . 'geo_coord, show_on_map;'
        . '{kontakt_legend}, telefon, telefax, web, mail;'
        . '{social_legend}, facebook, twitter, instagram, xing, gplus;'
        . '{beschreibungen_legend}, beschreibung, weg_beschreibung;'
        . '{kategorien_legend}, branchen, lebenslagen, kategorien;'
        . '{bilder_legend}, logo, bild_1, bild_2, bild_3, bild_4, bild_5, bild_6, bild_7, bild_8, bild_9;'
        . '{user_legend}, benutzer;'
        . '{admin_legend}, is_person, request_update, request_publish, published;',
    ],
    'subpalettes' => [
        'is_person' => 'hide_contacts'
    ],
    // Fields
    'fields' => 
        [
        'id' => 
            [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => 
            [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'name' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['name'],
            'inputType' => 'text',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => true,
            'eval' => [
                'mandatory' => true,
                'maxlength' => 255,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'zusatz' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['zusatz'],
            'inputType' => 'text',
            'exclude' => true,
            'sorting' => false,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'maxlength' => 255,
                'tl_class' => 'clr',
            ],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'alias' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['alias'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'unique' => true,
                'maxlength' => 128,
                'tl_class' => 'w50',
                'disabled' => false,
                'doNotCopy' => true
            ],
            'sql' => "varchar(128) NOT NULL default ''"
        ],
        'strasse' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['strasse'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => true,
            'eval' => [
                'maxlength' => 50,
                'tl_class' => 'w50',
                'disabled' => false,
                'doNotCopy' => true,
                'mandatory' => true
            ],
            'sql' => "varchar(50) NOT NULL default ''"
        ],
        'hsnr' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['hsnr'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 5,
                'tl_class' => 'w50',
                'disabled' => false,
                'doNotCopy' => true,
                'mandatory' => true
            ],
            'sql' => "varchar(5) NOT NULL default ''"
        ],
        'plz_ort' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['plz_ort'],
            'inputType' => 'select',
            'exclude' => true,
            'search' => false,
            'options_callback' => ['tl_firmen', 'getCities'],
            'eval' => [
                'tl_class' => 'w50',
                'doNotCopy' => true,
                'mandatory' => true,
                'submitOnChange' => true,
            ],
            'sql' => "varchar(25) NOT NULL default ''"
        ],
        'stadtteil' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['stadtteil'],
            'inputType' => 'select',
            'exclude' => true,
            'search' => false,
            'options_callback' => ['tl_firmen', 'getDistricts'],
            'eval' => [
                'tl_class' => 'w50',
                'doNotCopy' => true,
                'mandatory' => true,
            ],
            'sql' => "varchar(25) NOT NULL default ''"
        ],
        'gewerbegebiet' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['gewerbegebiet'],
            'inputType' => 'select',
            'exclude' => true,
            'search' => false,
            'options_callback' => ['tl_firmen', 'getCommercialAreas'],
            'eval' => [
                'tl_class' => 'w50',
                'doNotCopy' => true,
                'mandatory' => true,
            ],
            'sql' => "varchar(25) NOT NULL default ''"
        ],
        'geo_coord' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['geo_coord'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 100,
                'tl_class' => 'clr',
                'disabled' => false,
                'doNotCopy' => true
            ],
            'sql' => "varchar(100) NOT NULL default ''"
        ],
        'show_on_map' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['show_on_map'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'submitOnChange' => false,
                'tl_class' => 'clr m12'
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'telefon' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['telefon'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 25,
                'tl_class' => 'w50',
                'disabled' => false,
                'doNotCopy' => true,
                'rgxp' => 'phone'
            ],
            'sql' => "varchar(25) NOT NULL default ''"
        ],
        'telefax' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['telefax'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 25,
                'tl_class' => 'w50',
                'disabled' => false,
                'doNotCopy' => true,
                'rgxp' => 'phone'
            ],
            'sql' => "varchar(25) NOT NULL default ''"
        ],
        'web' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['web'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 50,
                'tl_class' => 'w50',
                'disabled' => false,
                'doNotCopy' => true,
                'rgxp' => 'url'
            ],
            'save_callback' => [['LeiersDesign\ContaoCatalog\Classes\BackendHelper', 'formatUrl']],
            'sql' => "varchar(50) NOT NULL default ''"
        ],
        'mail' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['mail'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 50,
                'tl_class' => 'w50',
                'disabled' => false,
                'doNotCopy' => true,
                'rgxp' => 'email'
            ],
            'sql' => "varchar(50) NOT NULL default ''"
        ],
        'facebook' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['facebook'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 100,
                'tl_class' => 'clr',
                'disabled' => false,
                'doNotCopy' => true,
                'rgxp' => 'url'
            ],
            'save_callback' => [['LeiersDesign\ContaoCatalog\Classes\BackendHelper', 'formatUrl']],
            'sql' => "varchar(100) NOT NULL default ''"
        ],
        'twitter' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['twitter'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 100,
                'tl_class' => 'clr',
                'disabled' => false,
                'doNotCopy' => true,
                'rgxp' => 'url'
            ],
            'save_callback' => [['LeiersDesign\ContaoCatalog\Classes\BackendHelper', 'formatUrl']],
            'sql' => "varchar(100) NOT NULL default ''"
        ],
        'instagram' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['instagram'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 100,
                'tl_class' => 'clr',
                'disabled' => false,
                'doNotCopy' => true,
                'rgxp' => 'url'
            ],
            'save_callback' => [['LeiersDesign\ContaoCatalog\Classes\BackendHelper', 'formatUrl']],
            'sql' => "varchar(100) NOT NULL default ''"
        ],
        'xing' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['xing'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 100,
                'tl_class' => 'clr',
                'disabled' => false,
                'doNotCopy' => true,
                'rgxp' => 'url'
            ],
            'save_callback' => [['LeiersDesign\ContaoCatalog\Classes\BackendHelper', 'formatUrl']],
            'sql' => "varchar(100) NOT NULL default ''"
        ],
        'gplus' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['gplus'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 100,
                'tl_class' => 'clr',
                'disabled' => false,
                'doNotCopy' => true,
                'rgxp' => 'url'
            ],
            'save_callback' => [['LeiersDesign\ContaoCatalog\Classes\BackendHelper', 'formatUrl']],
            'sql' => "varchar(100) NOT NULL default ''"
        ],
        'beschreibung' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['beschreibung'],
            'inputType' => 'textarea',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'maxlength' => 2500,
                'tl_class' => 'clr',
                'rte' => 'tinyMCE'
            ],
            'sql' => "TEXT NULL"
        ],
        'weg_beschreibung' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['weg_beschreibung'],
            'inputType' => 'textarea',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'maxlength' => 1000,
                'tl_class' => 'clr m12',
                'rte' => 'tinyMCE',
            ],
            'sql' => "TEXT NULL"
        ],
        'branchen' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['branchen'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'foreignKey' => 'tl_branchen.name',
            'eval' => [
                'mandatory' => false,
                'multiple' => true,
                'tl_class' => 'clr'
            ],
            'sql' => "blob NULL"
        ],
        'lebenslagen' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['lebenslagen'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'foreignKey' => 'tl_lebenslagen.name',
            'eval' => [
                'mandatory' => false,
                'multiple' => true,
                'tl_class' => 'clr m12'
            ],
            'sql' => "blob NULL"
        ],
        'kategorien' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['kategorien'],
            'exclude' => true,
            'inputType' => 'select',
            'foreignKey' => 'tl_kategorien.name',
            'eval' => [
                'mandatory' => false,
                'multiple' => true,
                'chosen' => true,
                'tl_class' => 'clr m12'
            ],
            'sql' => "blob NULL"
        ],
        'logo' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['logo'],
            'inputType' => 'fileTree',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'tl_class' => 'clr logo',
                'multiple' => false,
                'fieldType' => 'radio',
                'filesOnly' => true,
                'isGallery' => false,
                'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']
            ],
            'sql' => "blob NULL"
        ],
        'bild_1' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['bild_1'],
            'inputType' => 'fileTree',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'tl_class' => 'm12 zusatzbild',
                'multiple' => false,
                'fieldType' => 'radio',
                'filesOnly' => true,
                'isGallery' => false,
                'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']
            ],
            'sql' => "blob NULL"
        ],
        'bild_2' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['bild_2'],
            'inputType' => 'fileTree',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'tl_class' => 'm12 zusatzbild',
                'multiple' => false,
                'fieldType' => 'radio',
                'filesOnly' => true,
                'isGallery' => false,
                'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']
            ],
            'sql' => "blob NULL"
        ],
        'bild_3' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['bild_3'],
            'inputType' => 'fileTree',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'tl_class' => 'm12 zusatzbild',
                'multiple' => false,
                'fieldType' => 'radio',
                'filesOnly' => true,
                'isGallery' => false,
                'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']
            ],
            'sql' => "blob NULL"
        ],
        'bild_4' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['bild_4'],
            'inputType' => 'fileTree',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'tl_class' => 'm12 zusatzbild',
                'multiple' => false,
                'fieldType' => 'radio',
                'filesOnly' => true,
                'isGallery' => false,
                'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']
            ],
            'sql' => "blob NULL"
        ],
        'bild_5' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['bild_5'],
            'inputType' => 'fileTree',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'tl_class' => 'm12 zusatzbild',
                'multiple' => false,
                'fieldType' => 'radio',
                'filesOnly' => true,
                'isGallery' => false,
                'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']
            ],
            'sql' => "blob NULL"
        ],
        'bild_6' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['bild_6'],
            'inputType' => 'fileTree',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'tl_class' => 'm12 zusatzbild',
                'multiple' => false,
                'fieldType' => 'radio',
                'filesOnly' => true,
                'isGallery' => false,
                'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']
            ],
            'sql' => "blob NULL"
        ],
        'bild_7' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['bild_7'],
            'inputType' => 'fileTree',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'tl_class' => 'm12 zusatzbild',
                'multiple' => false,
                'fieldType' => 'radio',
                'filesOnly' => true,
                'isGallery' => false,
                'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']
            ],
            'sql' => "blob NULL"
        ],
        'bild_8' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['bild_8'],
            'inputType' => 'fileTree',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'tl_class' => 'm12 zusatzbild',
                'multiple' => false,
                'fieldType' => 'radio',
                'filesOnly' => true,
                'isGallery' => false,
                'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']
            ],
            'sql' => "blob NULL"
        ],
        'bild_9' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['bild_9'],
            'inputType' => 'fileTree',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => false,
                'tl_class' => 'm12 zusatzbild',
                'multiple' => false,
                'fieldType' => 'radio',
                'filesOnly' => true,
                'isGallery' => false,
                'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']
            ],
            'sql' => "blob NULL"
        ],
        'benutzer' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['benutzer'],
            'inputType' => 'select',
            'exclude' => true,
            'search' => false,
            'options_callback' => ['tl_firmen', 'getUsers'],
            'eval' => [
                'tl_class' => 'w50',
                'doNotCopy' => true,
                'mandatory' => false,
                'includeBlankOption' => true
            ],
            'sql' => "varchar(250) NOT NULL default ''"
        ],
        'is_person' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['is_person'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'submitOnChange' => true,
                'tl_class' => 'clr m12'
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'hide_contacts' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['hide_contacts'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'submitOnChange' => false,
                'tl_class' => 'clr'
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'published' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['published'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'submitOnChange' => false,
                'tl_class' => 'clr m12'
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'request_update' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['request_update'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'search' => true,
            'eval' => [
                'submitOnChange' => false,
                'tl_class' => 'clr m12'
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'request_publish' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['request_publish'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'submitOnChange' => false,
                'tl_class' => 'clr m12'
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
    /* 'images' => array
      (
      'label' => &$GLOBALS['TL_LANG']['tl_firmen']['images'],
      'inputType' => 'fileTree',
      'exclude' => true,
      'sorting' => true,
      'flag' => 1,
      'search' => false,
      'eval' => array(
      'mandatory' => false,
      'tl_class' => 'w50',
      'multiple' => true,
      'fieldType' => 'checkbox',
      'filesOnly' => true,
      'isGallery' => true,
      'extensions' => $GLOBALS['TL_CONFIG']['validImageTypes']
      ),
      'sql' => "blob NULL"
      ), */
    ]
];

/**
 * Class tl_firmen
 */
class tl_firmen extends Backend {

    function generateAlias(DataContainer $dc) {

        $id = $dc->id;
        $varValue = $dc->activeRecord->alias;
        $contactsHidden = ($dc->activeRecord->is_person == true && $dc->activeRecord->hide_contacts == true) ? true : false;

        if ($varValue != NULL) {
            return;
        }

        if ($contactsHidden) {
            $string = $dc->activeRecord->name;
            $varValue = StringUtil::generateAlias($this->replaceSpecialChars($string));
        } else {
            $string = $dc->activeRecord->name . "-" . $dc->activeRecord->strasse . "-" . $dc->activeRecord->hsnr . "-" . $dc->activeRecord->plz_ort;
            $varValue = StringUtil::generateAlias($this->replaceSpecialChars($string));
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_firmen WHERE alias=? AND id != '?'")
                ->execute($varValue, $dc->id);

        if ($objAlias->numRows > 0) {
            $varValue .= '-' . $dc->id;
        }

        $sql = "UPDATE tl_firmen SET alias = '$varValue' WHERE id = '$id'";

        $this->Database->prepare($sql)->execute();
    }

    /**
     * 
     * @param string $strValue
     * @return string
     */
    private function replaceSpecialChars($strValue) {
        $arrSearch = ["Ä", "Ö", "Ü", "ä", "ö", "ü", "ß", "´"];
        $arrReplace = ["Ae", "Oe", "Ue", "ae", "oe", "ue", "ss", ""];

        return str_replace($arrSearch, $arrReplace, $strValue);
    }

    public function getCities(DataContainer $dc) {
        $sql = "SELECT name, plz, alias FROM tl_staedte";
        $objDBResult = $this->Database->prepare($sql)->execute();
        $arrDBResult = [];

        while ($objDBResult->next()) {
            $arrDBResult['' . $objDBResult->row()['alias']] = $objDBResult->row()['plz'] . ' ' . $objDBResult->row()['name'];
        }

        return $arrDBResult;
    }

    public function firmenLabelCallback($row, $label) {
        $alias = $row['plz_ort'];
        $sqlPlzOrt = "SELECT name, plz FROM tl_staedte WHERE alias = '$alias'";
        $arrPlzOrt = $this->Database->prepare($sqlPlzOrt)->execute()->fetchAllAssoc()[0];
        
        $labelAppend = sprintf(" | <i>%s %s - %s %s</i>", $row['strasse'], $row['hsnr'], $arrPlzOrt['plz'], $arrPlzOrt['name']);
        
        if($row['request_update']) {
            $strAppend = $GLOBALS['TL_LANG']['MSC']['catalog']['BE']['firmen_label']['request_update'];
            $labelAppend .= " | <i><b style='color: red;'>$strAppend</b></i>";
        }
        
        $newLabel = $label . $labelAppend;
        
        
        return $newLabel;
    }

    public function getDistricts(DataContainer $dc) {

        $selectedCity = $dc->activeRecord->plz_ort;

        if ($selectedCity == NULL) {
            $sql = "SELECT id FROM tl_staedte";
            $objDBResult = $this->Database->prepare($sql)->execute();

            $selectedCityId = $objDBResult->row()['id'];
        } else {
            $sql = "SELECT id FROM tl_staedte WHERE alias = '$selectedCity'";
            $objDBResult = $this->Database->prepare($sql)->execute();

            /**
             * Wenn mehrere Ergebnisse dann Fehler
             */
            if ($objDBResult->count() != 1) {
                throw new Exception('Fehler bei der Abfrage der Städte.');
            }

            $selectedCityId = $objDBResult->row()['id'];
        }

        $sqlDistricts = "SELECT name, alias FROM tl_stadtteile WHERE pid = '$selectedCityId'";
        $objDistricts = $this->Database->prepare($sqlDistricts)->execute();

        if ($objDistricts->count() < 1) {
            $arrDisctrics = [
                'none' => $GLOBALS['TL_LANG']['MSC']['no_district']
            ];
        } else {
            $arrDisctrics = [];
            $arrDisctrics['none'] = $GLOBALS['TL_LANG']['MSC']['no_district'];

            while ($objDistricts->next()) {
                $arrDisctrics[$objDistricts->row()['alias']] = $objDistricts->row()['name'];
            }
        }

        return $arrDisctrics;
    }

    public function getCommercialAreas(DataContainer $dc) {
        $selectedCity = $dc->activeRecord->plz_ort;

        if ($selectedCity == NULL) {
            $sql = "SELECT id FROM tl_staedte";
            $objDBResult = $this->Database->prepare($sql)->execute();

            $selectedCityId = $objDBResult->row()['id'];
        } else {
            $sql = "SELECT id FROM tl_staedte WHERE alias = '$selectedCity'";
            $objDBResult = $this->Database->prepare($sql)->execute();

            if ($objDBResult->count() != 1) {
                throw new Exception('Fehler bei der Abfrage der Gewerbegebiete.');
            }

            $selectedCityId = $objDBResult->row()['id'];
        }
        $sqlCommercialArease = "SELECT name, alias FROM tl_gewerbegebiete WHERE pid = '$selectedCityId' ORDER BY name";
        $objCommercialAreas = $this->Database->prepare($sqlCommercialArease)->execute();

        if ($objCommercialAreas->count() < 1) {
            $arrCommercialAreas = [
                'none' => $GLOBALS['TL_LANG']['MSC']['no_commercial_area']
            ];
        } else {
            $arrCommercialAreas = [];
            $arrCommercialAreas['none'] = $GLOBALS['TL_LANG']['MSC']['no_commercial_area'];

            while ($objCommercialAreas->next()) {
                $arrCommercialAreas[$objCommercialAreas->row()['alias']] = $objCommercialAreas->row()['name'];
            }
        }

        return $arrCommercialAreas;
    }

    public function getUsers(DataContainer $dc) {
        $sql = "SELECT id, username, company FROM tl_member ORDER BY username";
        $objDBResult = $this->Database->prepare($sql)->execute();

        $arrDBResult = [];

        while ($objDBResult->next()) {
            $arrDBResult[$objDBResult->row()['id']] = ($objDBResult->row()['company'] ? $objDBResult->row()['username'] . ' (' . $objDBResult->row()['company'] . ')' : $objDBResult->row()['username']);
        }

        return $arrDBResult;
    }

    public function deleteVersion(DataContainer $dc) {
        
    }

    /**
     * Ändert das Aussehen des Toggle-Buttons.
     * @param $row
     * @param $href
     * @param $label
     * @param $title
     * @param $icon
     * @param $attributes
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes) {
        $this->import('BackendUser', 'User');

        if (strlen($this->Input->get('tid'))) {
            $this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 0));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_firmen::published', 'alexf')) {
            return '';
        }

        $href .= '&amp;id=' . $this->Input->get('id') . '&amp;tid=' . $row['id'] . '&amp;state=' . $row[''];

        if (!$row['published']) {
            $icon = 'invisible.gif';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
    }

    public function toggleVisibility($intId, $blnPublished) {
        // Check permissions to publish
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_firmen::published', 'alexf')) {
            $this->log('Not enough permissions to show/hide record ID "' . $intId . '"', 'tl_firmen toggleVisibility', TL_ERROR);
            $this->redirect('contao/main.php?act=error');
        }

        $this->createInitialVersion('tl_firmen', $intId);

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_firmen']['fields']['published']['save_callback'])) {
            foreach ($GLOBALS['TL_DCA']['tl_firmen']['fields']['published']['save_callback'] as $callback) {
                $this->import($callback[0]);
                $blnPublished = $this->$callback[0]->$callback[1]($blnPublished, $this);
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_firmen SET tstamp=" . time() . ", published='" . ($blnPublished ? '' : '1') . "' WHERE id=?")
                ->execute($intId);
    }

}
