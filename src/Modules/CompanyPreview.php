<?php

namespace LeiersDesign\ContaoCatalog\Modules;

use LeiersDesign\ContaoCatalog\Classes\FrontendHelper;
use Contao\FrontendUser;
use Contao\FrontendTemplate;
use Contao\Controller;
use Contao\PageModel;
use Contao\Input;
use Contao\Config;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ListUserCompanies
 *
 * @author User
 */
class CompanyPreview extends \Module {

    protected $strTemplate = 'mod_company_preview';

    public function generate() {
        if (TL_MODE === 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['MSC']['catalog']['modules']['company_preview'] . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        /**
         * Damit wir keine 404 Fehlermeldung bekommen, setzten wir den auto_item.
         */
        if (!isset($_GET['item']) && Config::get('useAutoItem') && isset($_GET['auto_item'])) {

            Input::setGet('item', Input::get('auto_item'));
        }

        return parent::generate();
    }

    public function compile() {
        $objUser = FrontendUser::getInstance();
        $userID = $objUser->id;

        $alias = Input::get('auto_item');

        $arrCompanyCheck = $this->Database->prepare("SELECT id, benutzer FROM tl_firmen WHERE alias='$alias'")->execute()->fetchAllAssoc()[0];

        if ($arrCompanyCheck['benutzer'] !== $userID) {
            $this->Template->result = $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['no_rights'];
            return;
        }

        $companyID = $arrCompanyCheck['id'];
        $arrVersionCheck = $this->Database->prepare("SELECT id FROM tl_firmen_versions WHERE company_id='$companyID'")->execute()->fetchAllAssoc()[0];

        if (!empty($arrVersionCheck)) {
            $versioned = true;
            $arrCompany = $this->Database->prepare("SELECT * FROM tl_firmen_versions WHERE company_id='$companyID'")->execute()->fetchAllAssoc()[0];
        } else {
            $versioned = false;
            $arrCompany = $this->Database->prepare("SELECT * FROM tl_firmen WHERE id='$companyID'")->execute()->fetchAllAssoc()[0];
        }
        
        $objTemplate = new FrontendTemplate('company_detail_preview');

        $item = $arrCompany;

        $item['versioned'] = $versioned;
        $item['plz_ort'] = FrontendHelper::getPlzOrt($item['plz_ort']);
        $item['branchen'] = FrontendHelper::getBranchen($item['branchen']);
        $item['kategorien'] = FrontendHelper::getKategorien($item['kategorien']);

        $item['logo'] = FrontendHelper::generateImage($item['logo']);
        $item['gallery'] = array(
            'bild_1' => FrontendHelper::generateImage($item['bild_1'], true, true),
            'bild_2' => FrontendHelper::generateImage($item['bild_2'], true, true),
            'bild_3' => FrontendHelper::generateImage($item['bild_3'], true, true),
            'bild_4' => FrontendHelper::generateImage($item['bild_4'], true, true),
            'bild_5' => FrontendHelper::generateImage($item['bild_5'], true, true),
            'bild_6' => FrontendHelper::generateImage($item['bild_6'], true, true),
            'bild_7' => FrontendHelper::generateImage($item['bild_7'], true, true),
            'bild_8' => FrontendHelper::generateImage($item['bild_8'], true, true),
            'bild_9' => FrontendHelper::generateImage($item['bild_9'], true, true)
        );
        
        $item['gallery'] = array_filter($item['gallery']);

        $item['socials'] = [
            'facebook' => ($item['facebook'] ? ['link' => $item['facebook'], 'icon' => 'facebook', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['facebook']] : NULL),
            'twitter' => ($item['twitter'] ? ['link' => $item['twitter'], 'icon' => 'twitter', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['twitter']] : NULL),
            'instagram' => ($item['instagram'] ? ['link' => $item['instagram'], 'icon' => 'instagram', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['instagram']] : NULL),
            'xing' => ($item['xing'] ? ['link' => $item['xing'], 'icon' => 'xing', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['xing']] : NULL),
            'gplus' => ($item['gplus'] ? ['link' => $item['gplus'], 'icon' => 'google-plus', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['gplus']] : NULL),
        ];

        $item['socials'] = array_filter($item['socials']);

        $objTemplate->setData($item);
        $strResults .= $objTemplate->parse();

        $this->Template->result = (empty($item) ? '' : $strResults);
    }

}
