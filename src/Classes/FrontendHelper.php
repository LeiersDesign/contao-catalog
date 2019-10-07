<?php

namespace LeiersDesign\ContaoCatalog\Classes;

use Contao\Database;
use Contao\StringUtil;
use Contao\FilesModel;
use Contao\Image;
use Contao\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BackendHelper
 *
 * @author leiers//DESIGN
 */
class FrontendHelper {

    /**
     * 
     * @param binary $binUUID
     */
    public function generateImage($binUUID, $blnColorbox = true, $crop = false) {
        if ($binUUID != NULL) {
            if ($crop == true) {
                $imagePath = FilesModel::findByUuid($binUUID)->path;
                $strImage = Image::get($imagePath, 380, 250, 'crop');
            } else {
                $imagePath = FilesModel::findByUuid($binUUID)->path;
                $strImage = Image::get($imagePath, 380, 200, 'proportional');
            }

            return "<a href='$imagePath' class='cboxElement' data-lightbox>" . Controller::generateImage($strImage, 'Platzhalter Bild') . "</a>";
        }
        return NULL;
    }

    public function generateAlias() {
        $varValue = $dc->activeRecord->alias;
        $contactsHidden = ($dc->activeRecord->is_person == true && $dc->activeRecord->hide_contacts == true) ? true : false;

        if ($varValue != NULL) {
            return;
        }

        if ($contactsHidden) {
            $string = $dc->activeRecord->name;
            $varValue = StringUtil::generateAlias($this->replaceSpecialChars($string));
        } else {
            $string = $dc->activeRecord->name . "-" . $dc->activeRecord->strasse . "-" . $dc->activeRecord->hsnr . "-" . $dc->activeRecord->plz_ort;
            $varValue = StringUtil::generateAlias($this->replaceSpecialChars($string));
        }

        $objAlias = $this->Database->prepare("SELECT id FROM tl_firmen WHERE alias=? AND id != '?'")
                ->execute($varValue, $dc->id);

        if ($objAlias->numRows > 0) {
            $varValue .= '-' . $dc->id;
        }

        $sql = "UPDATE tl_firmen SET alias = '$varValue' WHERE id = '$id'";

        $this->Database->prepare($sql)->execute();
    }

    /**
     * 
     * @param string $aliasOrt
     * @return string
     */
    public function getPlzOrt($aliasOrt) {
        $sql = "SELECT name, plz FROM tl_staedte WHERE alias = '$aliasOrt'";
        $objResult = Database::getInstance()->prepare($sql)->execute();
        $arrReturn = $objResult->row();

        return $arrReturn['plz'] . " " . $arrReturn['name'];
    }

    public function getCities() {
        $objDBResult = Database::getInstance()->prepare("SELECT name, plz, alias FROM tl_staedte")->execute();
        $arrDBResult = array();

        while ($objDBResult->next()) {
            $arrDBResult['' . $objDBResult->row()['alias']] = $objDBResult->row()['plz'] . ' ' . $objDBResult->row()['name'];
        }

        return $arrDBResult;
    }

    public function getDistricts() {

        $sqlDistricts = "SELECT name, alias FROM tl_stadtteile";
        $objDistricts = Database::getInstance()->prepare($sqlDistricts)->execute();
        if ($objDistricts->count() < 1) {
            $arrDisctrics = [
                'none' => $GLOBALS['TL_LANG']['MSC']['no_district']
            ];
        } else {
            $arrDisctrics = array();
            $arrDisctrics['none'] = $GLOBALS['TL_LANG']['MSC']['no_district'];

            while ($objDistricts->next()) {
                $arrDisctrics[$objDistricts->row()['alias']] = $objDistricts->row()['name'];
            }
        }

        return $arrDisctrics;
    }

    public function getCommercialAreas() {
        $sqlCommercialArease = "SELECT name, alias FROM tl_gewerbegebiete ORDER BY name";
        $objCommercialAreas = Database::getInstance()->prepare($sqlCommercialArease)->execute();

        if ($objCommercialAreas->count() < 1) {
            $arrCommercialAreas = [
                'none' => $GLOBALS['TL_LANG']['MSC']['no_commercial_area']
            ];
        } else {
            $arrCommercialAreas = array();
            $arrCommercialAreas['none'] = $GLOBALS['TL_LANG']['MSC']['no_commercial_area'];

            while ($objCommercialAreas->next()) {
                $arrCommercialAreas[$objCommercialAreas->row()['alias']] = $objCommercialAreas->row()['name'];
            }
        }

        return $arrCommercialAreas;
    }

    /**
     * 
     * @param string $arrSerialized
     * @return array
     */
    public function getKategorien($arrSerialized) {
        $arrKategorien = StringUtil::deserialize($arrSerialized);

        if (empty($arrKategorien)) {
            return $GLOBALS['TL_LANG']['MSC']['version_diffs']['keine_kategorie'];
        }

        $arrReturn = array();

        foreach ($arrKategorien as $kategorie) {
            $sql = "SELECT name FROM tl_kategorien WHERE id = '$kategorie'";
            $arrReturn[] = Database::getInstance()->prepare($sql)->execute()->fetchAllAssoc()[0]['name'];
        }
        sort($arrReturn);

        return array('count' => count($arrReturn), 'items' => implode(", ", $arrReturn));
    }

    /**
     * 
     * @param string $arrSerialized
     * @return array
     */
    public function getBranchen($arrSerialized) {
        $arrBranchen = StringUtil::deserialize($arrSerialized);

        if (empty($arrBranchen)) {
            return $GLOBALS['TL_LANG']['MSC']['version_diffs']['keine_branche'];
        }

        $arrReturn = array();

        foreach ($arrBranchen as $branche) {
            $sql = "SELECT name FROM tl_branchen WHERE id = '$branche'";
            $arrReturn[] = Database::getInstance()->prepare($sql)->execute()->fetchAllAssoc()[0]['name'];
        }
        sort($arrReturn);

        return array('count' => count($arrReturn), 'items' => implode(", ", $arrReturn));
    }

    /**
     * 
     * @param string $arrSerialized
     * @return array
     */
    public function getLebenslagen($arrSerialized) {
        $arrLebenslagen = StringUtil::deserialize($arrSerialized);

        if (empty($arrLebenslagen)) {
            return $GLOBALS['TL_LANG']['MSC']['version_diffs']['keine_lebenslage'];
        }

        $arrReturn = array();

        foreach ($arrLebenslagen as $lebenslage) {
            $sql = "SELECT name FROM tl_lebenslagen WHERE id = '$lebenslage'";
            $arrReturn[] = Database::getInstance()->prepare($sql)->execute()->fetchAllAssoc()[0]['name'];
        }
        sort($arrReturn);

        return array('count' => count($arrReturn), 'items' => implode(", ", $arrReturn));
    }

    /**
     * 
     * @param string|int $companyID
     * @return array
     */
    public function getPublishIcon($companyID) {
        $sql = "SELECT published FROM tl_firmen WHERE id = '$companyID'";
        $published = Database::getInstance()->prepare($sql)->execute()->fetchAllAssoc()[0]['published'];

        if ($published == 1) {
            return ['icon' => 'fa-eye-slash', 'text' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['actions']['toggle'][1]];
        }

        return ['icon' => 'fa-eye', 'text' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['actions']['toggle'][0]];
    }

    /**
     * 
     * @param string|int $companyID
     * @return array
     */
    public function getAlerts($companyID) {
        $sqlCompany = "SELECT published, request_update, request_publish FROM tl_firmen WHERE id = '$companyID'";
        $arrCompany = Database::getInstance()->prepare($sqlCompany)->execute()->fetchAllAssoc()[0];

        $arrAlerts = [
            'published' => ($arrCompany['published'] == 1 ? ['status' => 'okay', 'icon' => 'check', 'text' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['published'][0]] : ['status' => 'error', 'icon' => 'times', 'text' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['published'][1]]),
            'request_publish' => ($arrCompany['request_publish'] != 1 ? NULL : ['status' => 'error', 'icon' => 'times', 'text' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['request_publish']])
        ];

        $sqlVersion = "SELECT id FROM tl_firmen_versions WHERE company_id = '$companyID'";
        $arrVersion = Database::getInstance()->prepare($sqlVersion)->execute()->fetchAllAssoc();

        if (count($arrVersion) == 0) {
            $arrAlerts['request_update'] = [
                'status' => 'okay',
                'icon' => 'check',
                'text' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['request_update'][0]];
        } else {
            $arrAlerts['request_update'] = [
                'status' => 'error',
                'icon' => 'times',
                'text' => $GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['request_update'][1]];
        }

        $arrReturn = array_filter($arrAlerts);

        return $arrReturn;
    }
    
    
    public function getGeoCoordinates($plz_ort, $strasse, $hsnr) {
        $arrAdresse = Database::getInstance()->prepare("SELECT name, plz FROM tl_staedte WHERE alias = '$plz_ort'")->execute()->fetchAllAssoc()[0];
        
        $plz = $arrAdresse['plz'];
        $ort = $arrAdresse['name'];
        
        $strasseHsnr = $hsnr . ',' . $strasse;

        $quersString = "https://nominatim.openstreetmap.org/search?street=$strasseHsnr&postalcode=$plz&city=$ort&format=json";

        // Create a stream
        $opts = array('http' => array('header' => "User-Agent: ContaoCatalog 1.0.0\r\n"));
        $context = stream_context_create($opts);

        // Open the file using the HTTP headers set above
        $jsonFile = file_get_contents($quersString, false, $context);

        $resp = json_decode($jsonFile, true);

        if (empty($resp)) {
            return;
        } else {
            $lat = $resp[0]['lat'];
            $lon = $resp[0]['lon'];
            $coordinates = "$lat,$lon";
        }
        
        return $coordinates;
    }

}
