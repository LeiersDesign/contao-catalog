<?php

/**
 * Table tl_staedte
 */
$GLOBALS['TL_DCA']['tl_staedte'] = 
    [
    // Config
    'config' => 
        [
        'dataContainer' => 'Table',
        'ctable' => ['tl_stadtteile', 'tl_gewerbegebiete'],
        'sql' => 
            [
            'keys' => 
                [
                'id' => 'primary'
            ]
        ],
        'onsubmit_callback' => [
            ['tl_staedte', 'generateAlias'],
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
            'fields' => ['name', 'plz'],
            'format' => '%s <i style="font-size: 0.75rem">(%s)</i>',
            'label_callback' => ['tl_staedte', 'labelCallback'],
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
                'label' => &$GLOBALS['TL_LANG']['tl_staedte']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg'
            ],
            'delete' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_staedte']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            'copy' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_staedte']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ],
            'show' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_staedte']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif',
            ],
            'edit_districts' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_staedte']['edit_districts'],
                'href' => 'table=tl_stadtteile',
                'icon' => 'bundles/contaocatalog/img/icon_stadt.svg',
            ],
            'edit_commercial_areas' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_staedte']['edit_commercial_areas'],
                'href' => 'table=tl_gewerbegebiete',
                'icon' => 'bundles/contaocatalog/img/icon_gewerbegebiet.svg',
            ],
        ]
    ],
    // Palettes
    'palettes' => 
        [
        'default' => 'name, alias,plz;'
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
            'label' => &$GLOBALS['TL_LANG']['tl_staedte']['name'],
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
        'plz' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_staedte']['plz'],
            'inputType' => 'text',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => true,
            'eval' => [
                'mandatory' => true,
                'maxlength' => 6,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(6) NOT NULL default ''"
        ],
        'alias' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_staedte']['alias'],
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
 * Class tl_staedte
 */
class tl_staedte extends Backend {

    function generateAlias(DataContainer $dc) {

        $id = $dc->id;
        $varValue = $dc->activeRecord->alias;

        if ($varValue != NULL) {
            return;
        }
        
        $string = $dc->activeRecord->plz . '-' . $dc->activeRecord->name;
        $varValue = StringUtil::generateAlias($this->replaceSpecialChars($string));

        $objAlias = $this->Database->prepare("SELECT id FROM tl_staedte WHERE alias=? AND id != '?'")
                ->execute($varValue, $dc->id);

        if ($objAlias->numRows > 0) {
            $varValue .= '-' . $dc->id;
        }

        $sql = "UPDATE tl_staedte SET alias = '$varValue' WHERE id = '$id'";

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
    
    /**
     * 
     * @param array $row
     * @param string $label
     * @return string
     */
    public function labelCallback($row, $label){
        $id = $row['id'];
        
        /**
         * Stadtteile
         */
        $sql = "SELECT id FROM tl_stadtteile WHERE pid = '$id'";
        $objDBResult = $this->Database->prepare($sql)->execute();
        
        /**
         * Gewerbegebiete
         */
        $sqlG = "SELECT id FROM tl_gewerbegebiete WHERE pid = '$id'";
        $objDBResultG = $this->Database->prepare($sqlG)->execute();
        
        return $label . ' | <i>' . $objDBResult->count() . $GLOBALS['TL_LANG']['MSC']['tl_stadte_label']['staedte'] . $objDBResultG->count() . $GLOBALS['TL_LANG']['MSC']['tl_stadte_label']['gewerbegebiete'] . '</i>';
    }

}
