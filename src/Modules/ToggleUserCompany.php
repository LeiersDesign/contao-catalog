<?php

namespace LeiersDesign\ContaoCatalog\Modules;

use Contao\FrontendUser;
use Contao\Config;
use Contao\Input;
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
class ToggleUserCompany extends \Module {

    protected $strTemplate = 'mod_toggle_user_company';

    public function generate() {
        if (TL_MODE === 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['MSC']['catalog']['modules']['toggle_user_company'] . ' ###';
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
        
        $objCompany = $this->Database->prepare("SELECT * FROM tl_firmen WHERE alias='$alias'")->execute();
        $arrCompany = $objCompany->row();
        
        if(count($arrCompany) > 0) {
            $companyUser = $arrCompany['benutzer'];
            if($companyUser !== $userID) {
                $this->Template->result = $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['no_rights'];
                $this->Template->back = sprintf($GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['back_link'], $backLink);
                return;
            }
            
            $backLink = Controller::generateFrontendUrl(PageModel::findByPk($this->jumpTo)->row());
            
            $companyPublished = ($arrCompany['published'] != 1 ? false : true);
            
            if($companyPublished == true) {
                $this->Database->prepare("UPDATE tl_firmen SET published = '' WHERE alias='$alias'")->execute();
                $this->Template->result = sprintf($GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['company_hidden'], $arrCompany['name']);
                $this->Template->back = sprintf($GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['back_link'], $backLink);
            } else {
                $this->Database->prepare("UPDATE tl_firmen SET published = '1' WHERE alias='$alias'")->execute();
                $this->Template->result = sprintf($GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['company_shown'], $arrCompany['name']);
                $this->Template->back = sprintf($GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['back_link'], $backLink);
            }
            
        } else {
            $this->Template->result = '<p class="catalog-error">'.$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['company_not_found'].'</p>';
        }
        
        //var_dump($arrCompany); die();

        //$this->Template->result = ($total < 1 ? '' : $strResults);
    }

}
