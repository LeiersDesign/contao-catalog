<?php

namespace LeiersDesign\ContaoCatalog\Modules;

use LeiersDesign\ContaoCatalog\Classes\FrontendHelper;
use Contao\FrontendUser;
use Contao\FrontendTemplate;
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
class ListUserCompanies extends \Module {

    protected $strTemplate = 'mod_list_user_companies';

    public function generate() {
        if (TL_MODE === 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['MSC']['catalog']['modules']['list_user_companies'] . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    public function compile() {
        $objUser = FrontendUser::getInstance();
        $userID = $objUser->id;
        
        $objTemplate = new FrontendTemplate('user_company_entry');
        $objUserCompanies = $this->Database->prepare("SELECT * FROM tl_firmen WHERE benutzer='$userID'")->execute();

        $arrCompanies = array();
        while ($objUserCompanies->next()) {
            $arrCompanies[] = $objUserCompanies->row();
        }

        $total = count($arrCompanies);

        for ($i = 0; $i < $total; $i++) {
            $item = $arrCompanies[$i];

            $item['plz_ort'] = FrontendHelper::getPlzOrt($item['plz_ort']);
            $item['branchen'] = FrontendHelper::getBranchen($item['branchen']);
            $item['kategorien'] = FrontendHelper::getKategorien($item['kategorien']);

            $item['logo'] = FrontendHelper::generateImage($item['logo']);

            $item['detailLink'] = Controller::generateFrontendUrl(PageModel::findByPk($this->frontendRedirect)->row(), '/' . $item['alias']);
            $item['editLink'] = Controller::generateFrontendUrl(PageModel::findByPk($this->frontendEditRedirect)->row(), '/' . $item['alias']);
            $item['toggleLink'] = Controller::generateFrontendUrl(PageModel::findByPk($this->frontendToggleRedirect)->row(), '/' . $item['alias']);
            
            $item['togglePublish'] = FrontendHelper::getPublishIcon($item['id']);
            
            $item['socials'] = [
                'facebook' => ($item['facebook'] ? ['link' => $item['facebook'], 'icon' => 'facebook', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['facebook']] : NULL),
                'twitter' => ($item['twitter'] ? ['link' => $item['twitter'], 'icon' => 'twitter', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['twitter']] : NULL),
                'instagram' => ($item['instagram'] ? ['link' => $item['instagram'], 'icon' => 'instagram', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['instagram']] : NULL),
                'xing' => ($item['xing'] ? ['link' => $item['xing'], 'icon' => 'xing', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['xing']] : NULL),
                'gplus' => ($item['gplus'] ? ['link' => $item['gplus'], 'icon' => 'google-plus', 'name' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['gplus']] : NULL),
            ];
            
            $item['socials'] = array_filter($item['socials']);
            
            $item['alerts'] = FrontendHelper::getAlerts($item['id']);

            $objTemplate->setData($item);
            $strResults .= $objTemplate->parse();
        }

        $this->Template->results = ($total < 1 ? '' : $strResults);
    }

}
