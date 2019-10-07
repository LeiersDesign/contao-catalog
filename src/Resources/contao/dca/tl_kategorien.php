<?php

/**
 * Table tl_kategorien
 */
$GLOBALS['TL_DCA']['tl_kategorien'] = 
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
            ['tl_kategorien', 'generateAlias'],
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
            'format' => '%s'
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
            'edit' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_kategorien']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg'
            ],
            'delete' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_kategorien']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            'copy' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_kategorien']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ],
            'show' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_kategorien']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif',
            ],
        ]
    ],
    // Palettes
    'palettes' => 
        [
        'default' => 'name, alias;'
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
            'label' => &$GLOBALS['TL_LANG']['tl_kategorien']['name'],
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
        'alias' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_kategorien']['alias'],
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
    ]
];

/**
 * Class tl_kategorien
 */
class tl_kategorien extends Backend {

    function generateAlias(DataContainer $dc) {

        $id = $dc->id;
        $varValue = $dc->activeRecord->alias;

        if ($varValue != NULL) {
            return;
        }

        $string = $dc->activeRecord->name;
        $varValue = StringUtil::generateAlias($this->replaceSpecialChars($string));

        $objAlias = $this->Database->prepare("SELECT id FROM tl_kategorien WHERE alias=? AND id != '?'")
                ->execute($varValue, $dc->id);

        if ($objAlias->numRows > 0) {
            $varValue .= '-' . $dc->id;
        }

        $sql = "UPDATE tl_kategorien SET alias = '$varValue' WHERE id = '$id'";

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

}
