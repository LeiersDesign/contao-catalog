<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace LeiersDesign\ContaoCatalog\Classes;

use Contao\DataContainer;
use Contao\FilesModel;
use Contao\Controller;
use Contao\Image;
use Contao\BackendUser;
use Contao\StringUtil;

/**
 * Description of VersionDifferences
 *
 * @author User
 */
class VersionDifferences {

    private $dbConnection;

    public function __construct() {
        $this->dbConnection = \Contao\System::getContainer()->get('database_connection');
    }

    public function checkForVersion($row, $href, $label, $title, $icon, $attributes) {
        $isAdmin = BackendUser::getInstance()->isAdmin;

        $versionExistant = $this->dbConnection->fetchAssoc("SELECT * FROM tl_firmen_versions WHERE company_id = ?", array($row['id']));

        if (!$versionExistant) {
            return '';
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$isAdmin) {
            return '';
        }

        $href .= '&amp;id=' . $row['id'] . '&amp;rt=' . REQUEST_TOKEN;

        return '<a href="' . Controller::addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . Controller::generateImage($icon, $label) . '</a> ';
    }

    public function showVersionDifferences(DataContainer $dc) {
        $arrActual = $this->dbConnection->fetchAssoc("SELECT * FROM tl_firmen WHERE id = ?", array($dc->id));
        $arrActualMod = array();

        foreach ($arrActual as $key => $value) {

            $arrActualMod[$key] = array(
                'text' => $this->getKeyText($key),
                'value' => $value
            );
        }

        $arrVersion = $this->dbConnection->fetchAssoc("SELECT * FROM tl_firmen_versions WHERE company_id = ?", array($dc->id));
        $arrVersion['id'] = $arrVersion['company_id'];

        $returnString = "<div class='version-differences'>";
        foreach ($arrActualMod as $key => $value) {
            
            $difference = false;
            if (strpos($key, 'logo') !== false || strpos($key, 'bild_') !== false) {
                
                $fileActual = bin2hex($value['value']);
                $fileVersion = bin2hex($arrVersion[$key]);

                if ($fileActual !== $fileVersion) {
                    $difference = true;
                }

                $value['value'] = ($value['value'] !== NULL ? $this->generateImage($value['value']) : $GLOBALS['TL_LANG']['MSC']['version_diffs']['kein_bild']);
                $arrVersion[$key] = ($arrVersion[$key] !== NULL ? $this->generateImage($arrVersion[$key]) : $GLOBALS['TL_LANG']['MSC']['version_diffs']['kein_bild']);
            }
            
            if (strpos($key, 'tstamp') !== false) {
                $value['value'] = date("d.m.Y H:i", $value['value']);
                $arrVersion[$key] = date("d.m.Y H:i", $arrVersion[$key]);
            }
            
            if (strpos($key, 'plz_ort') !== false) {
                $value['value'] = $this->getPlzOrt($value['value']);
                $arrVersion[$key] = $this->getPlzOrt($arrVersion[$key]);
            }
            
            if (strpos($key, 'stadtteil') !== false) {
                $value['value'] = $this->getStadtteil($value['value']);
                $arrVersion[$key] = $this->getStadtteil($arrVersion[$key]);
            }
            
            if (strpos($key, 'gewerbegebiet') !== false) {
                $value['value'] = $this->getGewerbegebiet($value['value']);
                $arrVersion[$key] = $this->getGewerbegebiet($arrVersion[$key]);
            }

            if (strpos($key, 'kategorien') !== false) {
                $value['value'] = $this->getKategorien($value['value']);
                $arrVersion[$key] = $this->getKategorien($arrVersion[$key]);
            }

            if (strpos($key, 'branchen') !== false) {
                $value['value'] = $this->getBranchen($value['value']);
                $arrVersion[$key] = $this->getBranchen($arrVersion[$key]);
            }
            
            if (strpos($key, 'lebenslagen') !== false) {
                $value['value'] = $this->getLebenslagen($value['value']);
                $arrVersion[$key] = $this->getLebenslagen($arrVersion[$key]);
            }
            
            if (strpos($key, 'benutzer') !== false) {
                $value['value'] = $this->getBenutzer($value['value']);
                $arrVersion[$key] = $this->getBenutzer($arrVersion[$key]);
            }
            
            if (strpos($key, 'is_person') !== false) {
                $value['value'] = ($value['value'] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
                $arrVersion[$key] = ($arrVersion[$key] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
            }
            
            if (strpos($key, 'show_on_map') !== false) {
                $value['value'] = ($value['value'] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
                $arrVersion[$key] = ($arrVersion[$key] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
            }
            
            if (strpos($key, 'hide_contacts') !== false) {
                $value['value'] = ($value['value'] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
                $arrVersion[$key] = ($arrVersion[$key] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
            }
            
            if (strpos($key, 'published') !== false) {
                $value['value'] = ($value['value'] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
                $arrVersion[$key] = ($arrVersion[$key] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
            }
            
            if (strpos($key, 'request_update') !== false) {
                $value['value'] = ($value['value'] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
                $arrVersion[$key] = ($arrVersion[$key] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
            }
            
            if (strpos($key, 'request_publish') !== false) {
                $value['value'] = ($value['value'] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
                $arrVersion[$key] = ($arrVersion[$key] == 1 ? $GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] : $GLOBALS['TL_LANG']['MSC']['version_diffs']['no']);
            }

            if ($value['value'] !== $arrVersion[$key]) {
                $difference = true;
            }

            $returnString .= $this->writeLine($value['text'], $value['value'], $arrVersion[$key], $key, $difference);
        }
        $returnString .= "</div>";

        return $returnString;
    }

    /**
     * 
     * @param binary $binUUID
     */
    private function generateImage($binUUID, $blnColorbox = true) {
        if ($binUUID != NULL) {
            $imagePath = FilesModel::findByUuid($binUUID)->path;
            $strImage = Image::get($imagePath, 320, 200, 'proportional');

            return "<a href='$imagePath' class='cboxElement'>" . Controller::generateImage($strImage, 'Platzhalter Bild') . "</a>";
        }
        return NULL;
    }

    /**
     * 
     * @param string $strText
     * @return string
     */
    private function writeLine($strName, $strActual, $strOld, $strClass = NULL, $difference = false) {
        if (!$difference) {
            $strReturn = "<div" . ($strClass != NULL ? " class='row firma-$strClass'>" : ' class="row">') . "<div class='col-name'>$strName</div><div>$strActual</div><div>$strOld</div></div>";
        } else {
            $strReturn = "<div" . ($strClass != NULL ? " class='row firma-$strClass difference'>" : ' class="row difference">') . "<div class='col-name'>$strName</div><div>$strActual</div><div>$strOld</div></div>";
        }

        return $strReturn;
    }

    /**
     * 
     * @param string $arrSerialized
     */
    private function getKategorien($arrSerialized) {
        $arrKategorien = StringUtil::deserialize($arrSerialized);

        if (empty($arrKategorien)) {
            return $GLOBALS['TL_LANG']['MSC']['version_diffs']['keine_kategorie'];
        }

        $arrReturn = array();

        foreach ($arrKategorien as $kat) {
            $arrReturn[] = $this->dbConnection->fetchAssoc('SELECT name FROM tl_kategorien WHERE id = ?', array($kat))['name'];
        }

        sort($arrReturn);
        return implode(", ", $arrReturn);
    }

    /**
     * 
     * @param string $arrSerialized
     */
    private function getBranchen($arrSerialized) {
        $arrBranchen = StringUtil::deserialize($arrSerialized);

        if (empty($arrBranchen)) {
            return $GLOBALS['TL_LANG']['MSC']['version_diffs']['keine_branche'];
        }

        $arrReturn = array();

        foreach ($arrBranchen as $branche) {
            $arrReturn[] = $this->dbConnection->fetchAssoc('SELECT name FROM tl_branchen WHERE id = ?', array($branche))['name'];
        }

        sort($arrReturn);
        return implode(", ", $arrReturn);
    }

    /**
     * 
     * @param string $arrSerialized
     */
    private function getLebenslagen($arrSerialized) {        
        $arrLebenslagen = StringUtil::deserialize($arrSerialized);

        if (empty($arrLebenslagen) || count($arrLebenslagen) < 1) {
            return $GLOBALS['TL_LANG']['MSC']['version_diffs']['keine_lebenslage'];
        }

        $arrReturn = array();

        foreach ($arrLebenslagen as $lebenslage) {
            $arrReturn[] = $this->dbConnection->fetchAssoc('SELECT name FROM tl_lebenslagen WHERE id = ?', array($lebenslage))['name'];
        }

        sort($arrReturn);
        return implode(", ", $arrReturn);
    }
    
    /**
     * 
     * @param string|int $idUser
     */
    private function getBenutzer($idUser) {
        $arrReturn = $this->dbConnection->fetchAssoc('SELECT username FROM tl_member WHERE id = ?', array($idUser));
        
        return $arrReturn['username'];
    }
    
    /**
     * 
     * @param string $aliasOrt
     * @return string
     */
    private function getPlzOrt($aliasOrt) {
        $arrReturn = $this->dbConnection->fetchAssoc('SELECT name, plz FROM tl_staedte WHERE alias = ?', array($aliasOrt));
        
        return $arrReturn['plz'] . " " . $arrReturn['name'];
    }
    
    /**
     * 
     * @param string $aliasStadtteil
     * @return string
     */
    private function getStadtteil($aliasStadtteil) {
        $arrReturn = $this->dbConnection->fetchAssoc('SELECT name FROM tl_stadtteile WHERE alias = ?', array($aliasStadtteil));
        
        return $arrReturn['name'];
    }
    
    /**
     * 
     * @param string $aliasGewerbegebiet
     * @return string
     */
    private function getGewerbegebiet($aliasGewerbegebiet) {
        $arrReturn = $this->dbConnection->fetchAssoc('SELECT name FROM tl_gewerbegebiete WHERE alias = ?', array($aliasGewerbegebiet));
        
        return $arrReturn['name'];
    }

    private function getKeyText($strKey) {
        \System::loadLanguageFile('tl_firmen');

        switch ($strKey) {
            case 'id':
                return $GLOBALS['TL_LANG']['MSC']['version_diffs']['id'];
            case 'tstamp':
                return $GLOBALS['TL_LANG']['MSC']['version_diffs']['tstamp'];
            case 'name':
                return $GLOBALS['TL_LANG']['tl_firmen']['name'][0];
            case 'zusatz':
                return $GLOBALS['TL_LANG']['tl_firmen']['zusatz'][0];
            case 'alias':
                return $GLOBALS['TL_LANG']['tl_firmen']['alias'][0];
            case 'strasse':
                return $GLOBALS['TL_LANG']['tl_firmen']['strasse'][0];
            case 'hsnr':
                return $GLOBALS['TL_LANG']['tl_firmen']['hsnr'][0];
            case 'plz_ort':
                return $GLOBALS['TL_LANG']['tl_firmen']['plz_ort'][0];
            case 'stadtteil':
                return $GLOBALS['TL_LANG']['tl_firmen']['stadtteil'][0];
            case 'gewerbegebiet':
                return $GLOBALS['TL_LANG']['tl_firmen']['gewerbegebiet'][0];
            case 'request_update':
                return $GLOBALS['TL_LANG']['tl_firmen']['request_update'][0];
            case 'published':
                return $GLOBALS['TL_LANG']['tl_firmen']['published'][0];
            case 'request_publish':
                return $GLOBALS['TL_LANG']['tl_firmen']['request_publish'][0];
            case 'is_person':
                return $GLOBALS['TL_LANG']['tl_firmen']['is_person'][0];
            case 'hide_contacts':
                return $GLOBALS['TL_LANG']['tl_firmen']['hide_contacts'][0];
            case 'gplus':
                return $GLOBALS['TL_LANG']['tl_firmen']['gplus'][0];
            case 'xing':
                return $GLOBALS['TL_LANG']['tl_firmen']['xing'][0];
            case 'instagram':
                return $GLOBALS['TL_LANG']['tl_firmen']['instagram'][0];
            case 'twitter':
                return $GLOBALS['TL_LANG']['tl_firmen']['twitter'][0];
            case 'facebook':
                return $GLOBALS['TL_LANG']['tl_firmen']['facebook'][0];
            case 'mail':
                return $GLOBALS['TL_LANG']['tl_firmen']['mail'][0];
            case 'web':
                return $GLOBALS['TL_LANG']['tl_firmen']['web'][0];
            case 'telefon':
                return $GLOBALS['TL_LANG']['tl_firmen']['telefon'][0];
            case 'telefax':
                return $GLOBALS['TL_LANG']['tl_firmen']['telefax'][0];
            case 'geo_coord':
                return $GLOBALS['TL_LANG']['tl_firmen']['geo_coord'][0];
            case 'show_on_map':
                return $GLOBALS['TL_LANG']['tl_firmen']['show_on_map'][0];
            case 'logo':
                return $GLOBALS['TL_LANG']['tl_firmen']['logo'][0];
            case 'bild_1':
                return $GLOBALS['TL_LANG']['tl_firmen']['bild_1'][0];
            case 'bild_2':
                return $GLOBALS['TL_LANG']['tl_firmen']['bild_2'][0];
            case 'bild_3':
                return $GLOBALS['TL_LANG']['tl_firmen']['bild_3'][0];
            case 'bild_4':
                return $GLOBALS['TL_LANG']['tl_firmen']['bild_4'][0];
            case 'bild_5':
                return $GLOBALS['TL_LANG']['tl_firmen']['bild_5'][0];
            case 'bild_6':
                return $GLOBALS['TL_LANG']['tl_firmen']['bild_6'][0];
            case 'bild_7':
                return $GLOBALS['TL_LANG']['tl_firmen']['bild_7'][0];
            case 'bild_8':
                return $GLOBALS['TL_LANG']['tl_firmen']['bild_8'][0];
            case 'bild_9':
                return $GLOBALS['TL_LANG']['tl_firmen']['bild_9'][0];
            case 'weg_beschreibung':
                return $GLOBALS['TL_LANG']['tl_firmen']['weg_beschreibung'][0];
            case 'beschreibung':
                return $GLOBALS['TL_LANG']['tl_firmen']['beschreibung'][0];
            case 'branchen':
                return $GLOBALS['TL_LANG']['tl_firmen']['branchen'][0];
            case 'lebenslagen':
                return $GLOBALS['TL_LANG']['tl_firmen']['lebenslagen'][0];
            case 'kategorien':
                return $GLOBALS['TL_LANG']['tl_firmen']['kategorien'][0];
            case 'benutzer':
                return $GLOBALS['TL_LANG']['tl_firmen']['benutzer'][0];
            default:
                return "nicht zugewiesen";
        }
    }

}
