<?php

namespace LeiersDesign\ContaoCatalog\Elements;

use LeiersDesign\ContaoCatalog\Classes\FrontendHelper;
use Contao\Controller;
use Contao\PageModel;

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
class ListSingleCompany extends \ContentElement {

    protected $strTemplate = 'ce_list_single_company';

    public function generate() {
        if (TL_MODE === 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . sprintf($GLOBALS['TL_LANG']['MSC']['catalog']['modules']['list_single_company'], '123') . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    public function compile() {

        $companyID = $this->company_select;

        $objDBResult = $this->Database->prepare("SELECT logo, name, alias, zusatz, strasse, hsnr, plz_ort, stadtteil, gewerbegebiet, telefon, telefax, mail, web, facebook, twitter, instagram, xing, gplus FROM tl_firmen WHERE id = '$companyID' and published = '1'")->execute();
        $arrCompany = $objDBResult->row();

        if (empty($arrCompany)) {
            return;
        }

        $company = (object) $arrCompany;

        $this->Template->logo = FrontendHelper::generateImage($company->logo);
        $this->Template->name = $company->name;
        $this->Template->zusatz = $company->zusatz;
        $this->Template->strasse = $company->strasse;
        $this->Template->hsnr = $company->hsnr;
        $this->Template->plz_ort = FrontendHelper::getPlzOrt($company->plz_ort);
        $this->Template->telefon = $company->telefon;
        $this->Template->telefax = $company->telefax;
        $this->Template->mail = $company->mail;
        $this->Template->web = $company->web;
        $this->Template->socials = array_filter(
                [
                    'facebook' => ($company->facebook ? ['link' => $company->facebook, 'icon' => 'facebook', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['facebook']] : NULL),
                    'twitter' => ($company->twitter ? ['link' => $company->twitter, 'icon' => 'twitter', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['twitter']] : NULL),
                    'instagram' => ($company->instagram ? ['link' => $company->instagram, 'icon' => 'instagram', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['instagram']] : NULL),
                    'xing' => ($company->xing ? ['link' => $company->xing, 'icon' => 'xing', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['xing']] : NULL),
                    'gplus' => ($company->gplus ? ['link' => $company->gplus, 'icon' => 'google-plus', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['gplus']] : NULL),
                ]
        );
        $this->Template->detailLink = sprintf($GLOBALS['TL_LANG']['MSC']['catalog']['FE']['labels']['detailLink'], Controller::generateFrontendUrl(PageModel::findByPk($this->frontendRedirect)->row(), '/' . $company->alias), $company->name);
    }

}
