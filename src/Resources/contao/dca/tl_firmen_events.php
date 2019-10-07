<?php

/**
 * Table tl_firmen_events
 */
$GLOBALS['TL_DCA']['tl_firmen_events'] = 
    [
    // Config
    'config' => 
        [
        'dataContainer' => 'Table',
        'ptable' => 'tl_firmen',
        'sql' => 
            [
            'keys' => 
                [
                'id' => 'primary'
            ]
        ],
        'onsubmit_callback' => [
            ['tl_firmen_events', 'generateAlias'],
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
                'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg'
            ],
            'delete' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            'copy' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ],
            'show' => 
                [
                'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif',
            ],
        ]
    ],
    // Palettes
    'palettes' => 
        [
        '__selector__' => ['event_type'],
        'default' => 'name, alias; event_type;',
        'event' => 'name, alias; event_type;'
        . 'startDate, endDate; startTime, endTime;'
        . 'address;'
        . 'beschreibung;'
        . 'bild;'
        . '{admin_legend}, published;',
        'news' => 'name, alias; event_type;'
        . 'bild;'
        . 'beschreibung;'
        . '{admin_legend}, published;'
    ],
    // Fields
    'fields' => 
        [
        'id' => 
            [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'pid' => 
            [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'tstamp' => 
            [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'name' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['name'],
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
            'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['alias'],
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
        'event_type' => [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['event_type'],
            'exclude' => true,
            'filter' => true,
            'sorting' => true,
            'inputType' => 'select',
            'options' => [
                'event' => $GLOBALS['TL_LANG']['MSC']['tl_firmen_events']['event'],
                'news' => $GLOBALS['TL_LANG']['MSC']['tl_firmen_events']['news']
            ],
            'eval' => [
                'includeBlankOption' => true,
                'tl_class' => 'w50',
                'submitOnChange' => true,
                'mandatory' => true
            ],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'startDate' => [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['startDate'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'rgxp' => 'date',
                'datepicker' => true,
                'tl_class' => 'w50 wizard',
                'mandatory' => true
            ],
            'sql' => "varchar(10) NOT NULL default ''"
        ],
        'endDate' => [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['endDate'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'rgxp' => 'date',
                'datepicker' => true,
                'tl_class' => 'w50 wizard',
                'mandatory' => false
            ],
            'sql' => "varchar(10) NOT NULL default ''"
        ],
        'startTime' => [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['startTime'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'rgxp' => 'time',
                'datepicker' => true,
                'tl_class' => 'w50 wizard',
                'mandatory' => true
            ],
            'sql' => "varchar(10) NOT NULL default ''"
        ],
        'endTime' => [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['endTime'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'rgxp' => 'time',
                'datepicker' => true,
                'tl_class' => 'w50 wizard',
                'mandatory' => false
            ],
            'sql' => "varchar(10) NOT NULL default ''"
        ],
        'address' => [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['address'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => [
                'tl_class' => 'clr',
                'mandatory' => true
            ],
            'sql' => "varchar(150) NOT NULL default ''"
        ],
        'beschreibung' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['beschreibung'],
            'inputType' => 'textarea',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => true,
            'eval' => [
                'mandatory' => true,
                'maxlength' => 1500,
                'tl_class' => 'clr m12',
                'rte' => 'tinyMCE',
            ],
            'sql' => "TEXT NULL"
        ],
        'bild' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['bild'],
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
        'published' => 
            [
            'label' => &$GLOBALS['TL_LANG']['tl_firmen_events']['published'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'submitOnChange' => false,
                'tl_class' => 'clr m12'
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
    ]
];

/**
 * Class tl_firmen_events
 */
class tl_firmen_events extends Backend {

    function generateAlias(DataContainer $dc) {

        $id = $dc->id;
        $varValue = $dc->activeRecord->alias;

        if ($varValue != NULL) {
            return;
        }

        $string = $dc->activeRecord->name;
        $varValue = StringUtil::generateAlias($this->replaceSpecialChars($string));

        $objAlias = $this->Database->prepare("SELECT id FROM tl_firmen_events WHERE alias=? AND id != '?'")
                ->execute($varValue, $dc->id);

        if ($objAlias->numRows > 0) {
            $varValue .= '-' . $dc->id;
        }

        $sql = "UPDATE tl_firmen_events SET alias = '$varValue' WHERE id = '$id'";

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
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_firmen_events::published', 'alexf')) {
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
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_firmen_events::published', 'alexf')) {
            $this->log('Not enough permissions to show/hide record ID "' . $intId . '"', 'tl_firmen_events toggleVisibility', TL_ERROR);
            $this->redirect('contao/main.php?act=error');
        }

        $this->createInitialVersion('tl_firmen', $intId);

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_firmen_events']['fields']['published']['save_callback'])) {
            foreach ($GLOBALS['TL_DCA']['tl_firmen_events']['fields']['published']['save_callback'] as $callback) {
                $this->import($callback[0]);
                $blnPublished = $this->$callback[0]->$callback[1]($blnPublished, $this);
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_firmen_events SET tstamp=" . time() . ", published='" . ($blnPublished ? '' : '1') . "' WHERE id=?")
                ->execute($intId);
    }

}
