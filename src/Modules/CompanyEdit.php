<?php

namespace LeiersDesign\ContaoCatalog\Modules;

use LeiersDesign\ContaoCatalog\Classes\FrontendHelper;
use Contao\FrontendUser;
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
class CompanyEdit extends \Module {

    protected $strTemplate = 'mod_company_edit';

    public function generate() {
        if (TL_MODE === 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['MSC']['catalog']['modules']['company_edit'] . ' ###';
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
        if (!FE_USER_LOGGED_IN) {
            die();
        }

        $objUser = FrontendUser::getInstance();
        $userID = $objUser->id;

        $alias = Input::get('auto_item');

        $arrCompanyCheck = $this->Database->prepare("SELECT id, benutzer, strasse, hsnr, plz_ort, geo_coord FROM tl_firmen WHERE alias='$alias'")->execute()->fetchAllAssoc()[0];

        if ($arrCompanyCheck['benutzer'] !== $userID) {
            $this->Template->result = $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['no_rights'];
            return;
        }

        $companyID = $arrCompanyCheck['id'];
        
        $arrAddress = [
            'strasse' => $arrCompanyCheck['strasse'],
            'hsnr' => $arrCompanyCheck['hsnr'],
            'plz_ort' => $arrCompanyCheck['plz_ort'],
        ];
        
        $geo_coord = $arrCompanyCheck['geo_coord'];
        
        $arrVersionCheck = $this->Database->prepare("SELECT id FROM tl_firmen_versions WHERE company_id='$companyID'")->execute()->fetchAllAssoc()[0];

        if (!empty($arrVersionCheck)) {
            $versioned = true;
            $arrCompany = $this->Database->prepare("SELECT * FROM tl_firmen_versions WHERE company_id='$companyID'")->execute()->fetchAllAssoc()[0];
            $dataID = $arrCompany['company_id'];
        } else {
            $versioned = false;
            $arrCompany = $this->Database->prepare("SELECT * FROM tl_firmen WHERE id='$companyID'")->execute()->fetchAllAssoc()[0];
            $dataID = $arrCompany['id'];
        }

        $item = $arrCompany;

        \System::loadLanguageFile('tl_firmen');
        $arrFields = array(
            'name' => array
                (
                'name' => 'name',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['name'][0],
                'inputType' => 'text',
                'exclude' => true,
                'sorting' => true,
                'flag' => 1,
                'search' => true,
                'eval' => array(
                    'mandatory' => true,
                    'maxlength' => 255,
                    'tl_class' => 'w50',
                ),
                'value' => $item['name']
            ),
            'zusatz' => array
                (
                'name' => 'zusatz',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['zusatz'],
                'inputType' => 'text',
                'exclude' => true,
                'sorting' => false,
                'flag' => 1,
                'search' => false,
                'eval' => array(
                    'mandatory' => false,
                    'maxlength' => 255,
                    'tl_class' => 'clr',
                ),
                'value' => $item['zusatz']
            ),
            'strasse' => array
                (
                'name' => 'strasse',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['strasse'],
                'inputType' => 'text',
                'exclude' => true,
                'search' => true,
                'eval' => array(
                    'maxlength' => 50,
                    'tl_class' => 'w50',
                    'disabled' => false,
                    'doNotCopy' => true,
                    'mandatory' => true
                ),
                'value' => $item['strasse']
            ),
            'hsnr' => array
                (
                'name' => 'hsnr',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['hsnr'],
                'inputType' => 'text',
                'exclude' => true,
                'search' => false,
                'eval' => array(
                    'maxlength' => 5,
                    'tl_class' => 'w50',
                    'disabled' => false,
                    'doNotCopy' => true,
                    'mandatory' => true
                ),
                'value' => $item['hsnr']
            ),
            'plz_ort' => array
                (
                'name' => 'plz_ort',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['plz_ort'],
                'inputType' => 'select',
                'exclude' => true,
                'search' => false,
                'options_callback' => array('LeiersDesign\ContaoCatalog\Classes\FrontendHelper', 'getCities'),
                'eval' => array(
                    'tl_class' => 'w50',
                    'doNotCopy' => true,
                    'mandatory' => true,
                ),
                'value' => $item['plz_ort']
            ),
            'stadtteil' => array
                (
                'name' => 'stadtteil',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['stadtteil'],
                'inputType' => 'select',
                'exclude' => true,
                'search' => false,
                'options_callback' => array('LeiersDesign\ContaoCatalog\Classes\FrontendHelper', 'getDistricts'),
                'eval' => array(
                    'tl_class' => 'w50',
                    'doNotCopy' => true,
                    'mandatory' => true,
                ),
                'value' => $item['stadtteil']
            ),
            'gewerbegebiet' => array
                (
                'name' => 'gewerbegebiet',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['gewerbegebiet'],
                'inputType' => 'select',
                'exclude' => true,
                'search' => false,
                'options_callback' => array('LeiersDesign\ContaoCatalog\Classes\FrontendHelper', 'getCommercialAreas'),
                'eval' => array(
                    'tl_class' => 'w50',
                    'doNotCopy' => true,
                    'mandatory' => true,
                ),
                'value' => $item['gewerbegebiet']
            ),
            'telefon' => array
                (
                'name' => 'telefon',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['telefon'],
                'inputType' => 'text',
                'exclude' => true,
                'search' => false,
                'eval' => array(
                    'maxlength' => 25,
                    'tl_class' => 'w50',
                    'disabled' => false,
                    'doNotCopy' => true,
                    'rgxp' => 'phone'
                ),
                'value' => $item['telefon']
            ),
            'telefax' => array
                (
                'name' => 'telefax',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['telefax'],
                'inputType' => 'text',
                'exclude' => true,
                'search' => false,
                'eval' => array(
                    'maxlength' => 25,
                    'tl_class' => 'w50',
                    'disabled' => false,
                    'doNotCopy' => true,
                    'rgxp' => 'phone'
                ),
                'value' => $item['telefax']
            ),
            'web' => array
                (
                'name' => 'web',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['web'],
                'inputType' => 'text',
                'exclude' => true,
                'search' => false,
                'eval' => array(
                    'maxlength' => 50,
                    'tl_class' => 'w50',
                    'disabled' => false,
                    'doNotCopy' => true,
                    'rgxp' => 'url'
                ),
                'value' => $item['web']
            ),
            'mail' => array
                (
                'name' => 'mail',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['mail'],
                'inputType' => 'text',
                'exclude' => true,
                'search' => false,
                'eval' => array(
                    'maxlength' => 25,
                    'tl_class' => 'w50',
                    'disabled' => false,
                    'doNotCopy' => true,
                    'rgxp' => 'email'
                ),
                'value' => $item['mail']
            ),
            'facebook' => array
                (
                'name' => 'facebook',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['facebook'],
                'inputType' => 'text',
                'exclude' => true,
                'search' => false,
                'eval' => array(
                    'maxlength' => 100,
                    'tl_class' => 'clr',
                    'disabled' => false,
                    'doNotCopy' => true,
                    'rgxp' => 'url'
                ),
                'value' => $item['facebook']
            ),
            'twitter' => array
                (
                'name' => 'twitter',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['twitter'],
                'inputType' => 'text',
                'exclude' => true,
                'search' => false,
                'eval' => array(
                    'maxlength' => 100,
                    'tl_class' => 'clr',
                    'disabled' => false,
                    'doNotCopy' => true,
                    'rgxp' => 'url'
                ),
                'value' => $item['twitter']
            ),
            'instagram' => array
                (
                'name' => 'instagram',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['instagram'],
                'inputType' => 'text',
                'exclude' => true,
                'search' => false,
                'eval' => array(
                    'maxlength' => 100,
                    'tl_class' => 'clr',
                    'disabled' => false,
                    'doNotCopy' => true,
                    'rgxp' => 'url'
                ),
                'value' => $item['instagram']
            ),
            'xing' => array
                (
                'name' => 'xing',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['xing'],
                'inputType' => 'text',
                'exclude' => true,
                'search' => false,
                'eval' => array(
                    'maxlength' => 100,
                    'tl_class' => 'clr',
                    'disabled' => false,
                    'doNotCopy' => true,
                    'rgxp' => 'url'
                ),
                'value' => $item['xing']
            ),
            'gplus' => array
                (
                'name' => 'gplus',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['gplus'],
                'inputType' => 'text',
                'exclude' => true,
                'search' => false,
                'eval' => array(
                    'maxlength' => 100,
                    'tl_class' => 'clr',
                    'disabled' => false,
                    'doNotCopy' => true,
                    'rgxp' => 'url'
                ),
                'value' => $item['gplus']
            ),
            'beschreibung' => array
                (
                'name' => 'beschreibung',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['beschreibung'],
                'inputType' => 'textarea',
                'exclude' => true,
                'sorting' => true,
                'flag' => 1,
                'search' => false,
                'eval' => array(
                    'mandatory' => false,
                    'maxlength' => 2500,
                    'tl_class' => 'clr',
                    'rte' => 'tinyMCE'
                ),
                'value' => $item['beschreibung']
            ),
            'weg_beschreibung' => array
                (
                'name' => 'weg_beschreibung',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['weg_beschreibung'],
                'inputType' => 'textarea',
                'exclude' => true,
                'sorting' => true,
                'flag' => 1,
                'search' => false,
                'eval' => array(
                    'mandatory' => false,
                    'maxlength' => 1000,
                    'tl_class' => 'clr m12',
                    'rte' => 'tinyMCE',
                ),
                'value' => $item['weg_beschreibung']
            ),
            'branchen' => array
                (
                'name' => 'branchen',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['branchen'],
                'exclude' => true,
                'inputType' => 'checkbox',
                'foreignKey' => 'tl_branchen.name',
                'eval' => array(
                    'mandatory' => false,
                    'multiple' => true,
                    'tl_class' => 'clr'
                ),
                'value' => $item['branchen']
            ),
            'lebenslagen' => array
                (
                'name' => 'lebenslagen',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['lebenslagen'],
                'exclude' => true,
                'inputType' => 'checkbox',
                'foreignKey' => 'tl_lebenslagen.name',
                'eval' => array(
                    'mandatory' => false,
                    'multiple' => true,
                    'tl_class' => 'clr m12'
                ),
                'value' => $item['lebenslagen']
            ),
            'kategorien' => array
                (
                'name' => 'kategorien',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['kategorien'][0],
                'exclude' => true,
                'inputType' => 'select',
                'foreignKey' => 'tl_kategorien.name',
                'eval' => array(
                    'mandatory' => false,
                    'multiple' => true,
                    'chosen' => true,
                    'class' => 'tl_chosen'
                ),
                'value' => $item['kategorien']
            ),
            'is_person' => array
                (
                'name' => 'is_person',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['is_person'],
                'exclude' => true,
                'inputType' => 'checkbox',
                'eval' => array(
                    'mandatory' => false,
                    'multiple' => false,
                    'chosen' => true,
                    'class' => 'tl_chosen'
                ),
                'value' => $item['is_person']
            ),
            'hide_contacts' => array
                (
                'name' => 'hide_contacts',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['hide_contacts'],
                'exclude' => true,
                'inputType' => 'checkbox',
                'eval' => array(
                    'mandatory' => false,
                    'multiple' => false,
                    'chosen' => true,
                    'class' => 'tl_chosen'
                ),
                'value' => $item['hide_contacts']
            ),
            'published' => array
                (
                'name' => 'published',
                'label' => $GLOBALS['TL_LANG']['tl_firmen']['published'],
                'exclude' => true,
                'inputType' => 'checkbox',
                'eval' => array(
                    'mandatory' => false,
                    'multiple' => false,
                    'chosen' => true,
                    'class' => 'tl_chosen'
                ),
                'value' => $item['published']
            ),
        );

        $arrWidgets = array();

        // Initialize widgets
        foreach ($arrFields as $arrField) {
            // FFL = Form Field
            $strClass = $GLOBALS['TL_FFL'][$arrField['inputType']];

            $arrField['eval']['required'] = $arrField['eval']['mandatory'];

            $objWidget = new $strClass($this->prepareForWidget($arrField, $arrField['name'], $arrField['value']));

            $arrWidgets[] = $objWidget;
        }

        $this->Template->fields = (empty($item) ? '' : $arrWidgets);
        $this->Template->submit = $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['forms']['buttons']['form_submit'];
        $this->Template->save = $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['forms']['buttons']['form_save'];
        $this->Template->cancel = Controller::generateFrontendUrl(PageModel::findByPk($this->jumpTo)->row());

        if (\Input::post("FORM_SUBMIT") == "EDIT_COMPANY") {
            foreach ($arrWidgets as $widget) {
                if ($widget->type == 'upload') {
                    //$arrFiles[$widget->name] = $this->storeFile($widget, $widget->name);
                } else {
                    $widget->validate();
                }

                if (!empty($widget->getErrors())) {
                    $errors = true;
                }
            }

            $name = \Input::post('name');
            $zusatz = \Input::post('zusatz');
            $strasse = \Input::post('strasse');
            $hsnr = \Input::post('hsnr');
            $plz_ort = \Input::post('plz_ort');
            $stadtteil = \Input::post('stadtteil');
            $gewerbegebiet = \Input::post('gewerbegebiet');
            $telefon = \Input::post('telefon');
            $telefax = \Input::post('telefax');
            $web = \Input::post('web');
            $mail = \Input::post('mail');
            $facebook = \Input::post('facebook');
            $twitter = \Input::post('twitter');
            $instagram = \Input::post('instagram');
            $xing = \Input::post('xing');
            $gplus = \Input::post('gplus');
            
            //Bilder
            $logo = (\Input::post('logo') == NULL ? $item['logo'] : \Input::post('logo'));
            $bild_1 = (\Input::post('bild_1') == NULL ? $item['bild_1'] : \Input::post('bild_1'));
            $bild_2 = (\Input::post('bild_2') == NULL ? $item['bild_2'] : \Input::post('bild_2'));
            $bild_3 = (\Input::post('bild_3') == NULL ? $item['bild_3'] : \Input::post('bild_3'));
            $bild_4 = (\Input::post('bild_4') == NULL ? $item['bild_4'] : \Input::post('bild_4'));
            $bild_5 = (\Input::post('bild_5') == NULL ? $item['bild_5'] : \Input::post('bild_5'));
            $bild_6 = (\Input::post('bild_6') == NULL ? $item['bild_6'] : \Input::post('bild_6'));
            $bild_7 = (\Input::post('bild_7') == NULL ? $item['bild_7'] : \Input::post('bild_7'));
            $bild_8 = (\Input::post('bild_8') == NULL ? $item['bild_8'] : \Input::post('bild_8'));
            $bild_9 = (\Input::post('bild_9') == NULL ? $item['bild_9'] : \Input::post('bild_9'));
            
            $beschreibung = (\Input::post('beschreibung') == NULL ? NULL : html_entity_decode(\Input::post('beschreibung')));
            $weg_beschreibung = (\Input::post('weg_beschreibung') == NULL ? NULL : html_entity_decode(\Input::post('weg_beschreibung')));
            $branchen = (\Input::post('branchen') == NULL ? NULL : serialize(\Input::post('branchen')));
            $lebenslagen = (\Input::post('lebenslagen') == NULL ? NULL : serialize(\Input::post('lebenslagen')));
            $kategorien = (\Input::post('kategorien') == NULL ? NULL : serialize(\Input::post('kategorien')));
            $is_person = (\Input::post('is_person') == NULL ? NULL : \Input::post('is_person'));
            $hide_contacts = (\Input::post('hide_contacts') == NULL ? NULL : \Input::post('hide_contacts'));
            $published = (\Input::post('published') == NULL ? NULL : \Input::post('published'));
            
            $arrNewAddress = [
                'strasse' => $strasse,
                'hsnr' => $hsnr,
                'plz_ort' => $plz_ort,
            ];
            
            if(!empty(array_diff($arrAddress, $arrNewAddress))) {
                $geo_coord = FrontendHelper::getGeoCoordinates($arrNewAddress['plz_ort'], $arrNewAddress['strasse'], $arrNewAddress['hsnr']);
            }

            if (\Input::post('save_and_submit')) {
                $dbConnection = \Contao\System::getContainer()->get('database_connection');

                if (!$versioned) {
                    $dbConnection->insert('tl_firmen_versions', array(
                        'tstamp' => time(),
                        'name' => $name,
                        'zusatz' => $zusatz,
                        'alias' => $item['alias'],
                        'strasse' => $strasse,
                        'hsnr' => $hsnr,
                        'plz_ort' => $plz_ort,
                        'stadtteil' => $stadtteil,
                        'gewerbegebiet' => $gewerbegebiet,
                        'geo_coord' => $geo_coord,
                        'telefon' => $telefon,
                        'telefax' => $telefax,
                        'web' => $web,
                        'mail' => $mail,
                        'facebook' => $facebook,
                        'twitter' => $twitter,
                        'instagram' => $instagram,
                        'xing' => $xing,
                        'gplus' => $gplus,
                        'beschreibung' => $beschreibung,
                        'weg_beschreibung' => $weg_beschreibung,
                        'branchen' => $branchen,
                        'lebenslagen' => $lebenslagen,
                        'kategorien' => $kategorien,
                        'benutzer' => $item['benutzer'],
                        'is_person' => $is_person,
                        'hide_contacts' => $hide_contacts,
                        'published' => $published,
                        'company_id' => $dataID,
                        'logo' => $logo,
                        'bild_1' => $bild_1,
                        'bild_2' => $bild_2,
                        'bild_3' => $bild_3,
                        'bild_4' => $bild_4,
                        'bild_5' => $bild_5,
                        'bild_6' => $bild_6,
                        'bild_7' => $bild_7,
                        'bild_8' => $bild_8,
                        'bild_9' => $bild_9,
                    ));

                    $dbConnection->update('tl_firmen', array(
                        'request_update' => 1
                            ), array(
                        'id' => $dataID
                    ));
                } else {
                    $dbConnection->update('tl_firmen_versions', array(
                        'tstamp' => time(),
                        'name' => $name,
                        'zusatz' => $zusatz,
                        'alias' => $item['alias'],
                        'strasse' => $strasse,
                        'hsnr' => $hsnr,
                        'plz_ort' => $plz_ort,
                        'stadtteil' => $stadtteil,
                        'gewerbegebiet' => $gewerbegebiet,
                        'geo_coord' => $geo_coord,
                        'telefon' => $telefon,
                        'telefax' => $telefax,
                        'web' => $web,
                        'mail' => $mail,
                        'facebook' => $facebook,
                        'twitter' => $twitter,
                        'instagram' => $instagram,
                        'xing' => $xing,
                        'gplus' => $gplus,
                        'beschreibung' => $beschreibung,
                        'weg_beschreibung' => $weg_beschreibung,
                        'branchen' => $branchen,
                        'lebenslagen' => $lebenslagen,
                        'kategorien' => $kategorien,
                        'benutzer' => $item['benutzer'],
                        'is_person' => $is_person,
                        'hide_contacts' => $hide_contacts,
                        'published' => $published,
                        'logo' => $logo,
                        'bild_1' => $bild_1,
                        'bild_2' => $bild_2,
                        'bild_3' => $bild_3,
                        'bild_4' => $bild_4,
                        'bild_5' => $bild_5,
                        'bild_6' => $bild_6,
                        'bild_7' => $bild_7,
                        'bild_8' => $bild_8,
                        'bild_9' => $bild_9,
                            ), array(
                        'company_id' => $dataID
                    ));

                    $dbConnection->update('tl_firmen', array(
                        'request_update' => 1
                            ), array(
                        'id' => $dataID
                    ));
                }
            }
            die();
        }
    }

}
