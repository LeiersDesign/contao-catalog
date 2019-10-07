<?php

/**
 * Table tl_firmen
 */
$GLOBALS['TL_DCA']['tl_firmen_versions'] = 
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
            'version_diffs' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen']['version_diffs'],
                'href' => 'key=versionDiffs',
                'icon' => 'bundles/contaocatalog/img/show_version_differences.png',
            ],
        ]
    ],
    // Palettes
    'palettes' => 
        [
        '__selector__' => ['is_person'],
        'default' => 'name, alias, zusatz;'
        . 'strasse, hsnr, plz_ort, stadtteil, gewerbegebiet; geo_coord;'
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
            'sql' => "int(10) unsigned NULL"
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
            'sql' => "varchar(255) NULL"
        ],
        'zusatz' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['zusatz'],
            'inputType' => 'text',
            'exclude' => true,
            'sorting' => false,
            'flag' => 1,
            'search' => true,
            'eval' => [
                'mandatory' => false,
                'maxlength' => 255,
                'tl_class' => 'clr',
            ],
            'sql' => "varchar(255) NULL"
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
            'sql' => "varchar(128) NULL"
        ],
        'strasse' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['strasse'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'maxlength' => 50,
                'tl_class' => 'w50',
                'disabled' => false,
                'doNotCopy' => true,
                'mandatory' => true
            ],
            'sql' => "varchar(50) NULL"
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
            'sql' => "varchar(5) NULL"
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
            'sql' => "varchar(25) NULL"
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
            'sql' => "varchar(25) NULL"
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
            'sql' => "varchar(25) NULL"
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
            'sql' => "varchar(100) NULL"
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
            'sql' => "char(1) NULL"
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
            'sql' => "varchar(25) NULL"
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
            'sql' => "varchar(25) NULL"
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
            'sql' => "varchar(50) NULL"
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
            'sql' => "varchar(50) NULL"
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
            'sql' => "varchar(100) NULL"
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
            'sql' => "varchar(100) NULL"
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
            'sql' => "varchar(100) NULL"
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
            'sql' => "varchar(100) NULL"
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
            'sql' => "varchar(100) NULL"
        ],
        'beschreibung' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['beschreibung'],
            'inputType' => 'textarea',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => true,
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
            'search' => true,
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
            'sql' => "varchar(250) NULL"
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
            'sql' => "char(1) NULL"
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
            'sql' => "char(1) NULL"
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
            'sql' => "char(1) NULL"
        ],
        'request_update' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen']['request_update'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'submitOnChange' => false,
                'tl_class' => 'clr m12'
            ],
            'sql' => "char(1) NULL"
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
            'sql' => "char(1) NULL"
        ],
        'company_id' => 
            [
            'sql' => "int(10) unsigned NOT NULL default '0'"
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