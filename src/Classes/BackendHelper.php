<?php

namespace LeiersDesign\ContaoCatalog\Classes;

use Contao\DataContainer;

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
class BackendHelper {

    private $dbCon;

    public function __construct() {
        $this->dbCon = \Contao\System::getContainer()->get('database_connection');
    }

    /**
     * 
     * @param DataContainer $dc
     * @throws Exception
     */
    public function getGeoCoordinates(DataContainer $dc) {
        if ($dc->id == NULL) {
            throw new Exception('Der Datensatz wurde nicht gefunden.');
        }

        if ($dc->activeRecord->geo_coord != NULL) {
            
        }

        $strasseHsnr = $dc->activeRecord->hsnr . ',' . $dc->activeRecord->strasse;
        $plz_ort = $dc->activeRecord->plz_ort;

        $arrAdresse = $this->dbCon->fetchAssoc("SELECT name, plz FROM tl_staedte WHERE alias = ?", array($plz_ort));
        $plz = $arrAdresse['plz'];
        $ort = $arrAdresse['name'];

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

        //DB-Update with Doctrine
        $this->dbCon->update('tl_firmen', array('geo_coord' => $coordinates), array('id' => $dc->id));
    }

    /**
     * @param $varValue
     * @param $dc
     * @return var
     */
    public function formatUrl($varValue, DataContainer $dc) {
        $disallowed = array('http://', 'https://');
        foreach ($disallowed as $d) {
            if (strpos($varValue, $d) === 0) {
                return str_replace($d, '', $varValue);
            }
        }
        return $varValue;
    }
    
    public function getCatalogSystemMessages() {
        $stmt = $this->dbCon->executeQuery("SELECT name, id FROM tl_firmen WHERE request_update = ?", array(1));
        $arrCompanies = $stmt->fetchAll();
        $strReturn = "";
        
        foreach ($arrCompanies as $company) {
            $name = $company['name'];
            $id = $company['id'];
            $strReturn .= sprintf('<p class="tl_error">Die Firma <b>%s <i>(ID: %s)</i></b> wartet auf die Freischaltung der neuen Version.</p>', $name, $id);
        }
        
        return $strReturn;
    }

}
