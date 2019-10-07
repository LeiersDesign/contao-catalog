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
class CompanyDetail extends \Module {

    protected $strTemplate = 'mod_company_detail';

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
        global $objPage;
        $alias = Input::get('auto_item');

        $objCompanyResult = $this->Database->prepare("SELECT * FROM tl_firmen WHERE alias='$alias'")->execute();
        $arrCompanyResult = $objCompanyResult->row();

        if (empty($arrCompanyResult)) {
            return;
        }


        $objTemplate = new FrontendTemplate('company_detail');

        $company = (object) $arrCompanyResult;

        /**
         * Include JS & CSS for leaflet if geo coords are set and leaflet isn't loaded by bundle leiersdesign/contao-leaflet-maps
         */
        if (empty($GLOBALS['TL_JAVASCRIPT']['leaflet'])) {
            $GLOBALS['TL_JAVASCRIPT']['leaflet'] = 'bundles/contaocatalog/leaflet/leaflet.js|static';
        }

        if (empty($GLOBALS['TL_CSS']['leaflet'])) {
            $GLOBALS['TL_CSS']['leaflet'] = 'bundles/contaocatalog/leaflet/leaflet.css|static';
        }

        $company->plz_ort = FrontendHelper::getPlzOrt($company->plz_ort);
        $company->branchen = FrontendHelper::getBranchen($company->branchen);
        $company->kategorien = FrontendHelper::getKategorien($company->kategorien);

        $company->logo = FrontendHelper::generateImage($company->logo);
        $company->gallery = array(
            'bild_1' => FrontendHelper::generateImage($company->bild_1, true, true),
            'bild_2' => FrontendHelper::generateImage($company->bild_2, true, true),
            'bild_3' => FrontendHelper::generateImage($company->bild_3, true, true),
            'bild_4' => FrontendHelper::generateImage($company->bild_4, true, true),
            'bild_5' => FrontendHelper::generateImage($company->bild_5, true, true),
            'bild_6' => FrontendHelper::generateImage($company->bild_6, true, true),
            'bild_7' => FrontendHelper::generateImage($company->bild_7, true, true),
            'bild_8' => FrontendHelper::generateImage($company->bild_8, true, true),
            'bild_9' => FrontendHelper::generateImage($company->bild_9, true, true)
        );

        $company->gallery = array_filter($company->gallery);

        $company->socials = [
            'facebook' => ($company->facebook ? ['link' => $company->facebook, 'icon' => 'facebook', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['facebook']] : NULL),
            'twitter' => ($company->twitter ? ['link' => $company->twitter, 'icon' => 'twitter', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['twitter']] : NULL),
            'instagram' => ($company->instagram ? ['link' => $company->instagram, 'icon' => 'instagram', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['instagram']] : NULL),
            'xing' => ($company->xing ? ['link' => $company->xing, 'icon' => 'xing', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['xing']] : NULL),
            'gplus' => ($company->gplus ? ['link' => $company->gplus, 'icon' => 'google-plus', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['gplus']] : NULL),
        ];

        $company->socials = array_filter($company->socials);

        $company->routeLink = sprintf("https://www.google.de/maps/dir//%s+%s,%s",$company->strasse, $company->hsnr, urlencode($company->plz_ort));
        
        $objTemplate->setData((array) $company);
        $strResults .= $objTemplate->parse();

        $this->Template->result = (empty((array) $company) ? '' : $strResults);

        if (!empty($arrCompanyResult)) {
            $objPage->title = sprintf("Unternehmen %s im Detail", $company->name);
        }
    }

}
