<?php

namespace LeiersDesign\ContaoCatalog\Classes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Contao\DataContainer;
use Contao\Controller;

/**
 * Description of VersionManager
 *
 * @author leiers//DESIGN
 */
class VersionManager {

    private $dbConnection;

    public function __construct() {
        $this->dbConnection = \Contao\System::getContainer()->get('database_connection');
    }

    public function deleteVersion(DataContainer $dc) {
        $count = $this->dbConnection->delete('tl_firmen_versions', array('company_id' => $dc->id));

        if ($count > 1) {
            //Wenn keine Version vorhanden war
        }
    }

    /**
     * 
     * @param Contao\DataContainer $dc
     */
    public function createVersion(DataContainer $dc) {
        $pID = $dc->id;

        $arrCompany = $this->dbConnection->fetchAssoc("SELECT * FROM tl_firmen WHERE id = ?", array($pID));

        $id = $arrCompany['id'];
        $tstamp = $arrCompany['tstamp'];
        $name = $arrCompany['name'];
        $zusatz = $arrCompany['zusatz'];
        $alias = $arrCompany['alias'];
        $strasse = $arrCompany['strasse'];
        $hsnr = $arrCompany['hsnr'];
        $plz_ort = $arrCompany['plz_ort'];
        $stadtteil = $arrCompany['stadtteil'];
        $gewerbegebiet = $arrCompany['gewerbegebiet'];
        $geo_coord = $arrCompany['geo_coord'];
        $show_on_map = $arrCompany['show_on_map'];
        $telefon = $arrCompany['telefon'];
        $telefax = $arrCompany['telefax'];
        $web = $arrCompany['web'];
        $mail = $arrCompany['mail'];
        $facebook = $arrCompany['facebook'];
        $twitter = $arrCompany['twitter'];
        $instagram = $arrCompany['instagram'];
        $xing = $arrCompany['xing'];
        $gplus = $arrCompany['gplus'];
        $beschreibung = $arrCompany['beschreibung'];
        $weg_beschreibung = $arrCompany['weg_beschreibung'];
        $branchen = $arrCompany['branchen'];
        $lebenslagen = $arrCompany['lebenslagen'];
        $kategorien = $arrCompany['kategorien'];
        $logo = $arrCompany['logo'];
        $bild_1 = $arrCompany['bild_1'];
        $bild_2 = $arrCompany['bild_2'];
        $bild_3 = $arrCompany['bild_3'];
        $bild_4 = $arrCompany['bild_4'];
        $bild_5 = $arrCompany['bild_5'];
        $bild_6 = $arrCompany['bild_6'];
        $bild_7 = $arrCompany['bild_7'];
        $bild_8 = $arrCompany['bild_8'];
        $bild_9 = $arrCompany['bild_9'];
        $benutzer = $arrCompany['benutzer'];
        $is_person = $arrCompany['is_person'];
        $hide_contacts = $arrCompany['hide_contacts'];
        $published = $arrCompany['published'];
        $request_update = $arrCompany['request_update'];
        $request_publish = $arrCompany['request_publish'];

        $versionExistant = $this->dbConnection->fetchAssoc("SELECT * FROM tl_firmen_versions WHERE company_id = ?", array($pID));

        if ($versionExistant !== false) {
            $this->dbConnection->delete('tl_firmen_versions', array('company_id' => $pID));
        }

        $this->dbConnection->insert('tl_firmen_versions', array(
            'company_id' => $pID,
            'tstamp' => $tstamp,
            'name' => $name,
            'zusatz' => $zusatz,
            'alias' => $alias,
            'strasse' => $strasse,
            'hsnr' => $hsnr,
            'plz_ort' => $plz_ort,
            'stadtteil' => $stadtteil,
            'gewerbegebiet' => $gewerbegebiet,
            'geo_coord' => $geo_coord,
            'show_on_map' => $show_on_map,
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
            'benutzer' => $benutzer,
            'is_person' => $is_person,
            'hide_contacts' => $hide_contacts,
            'published' => $published,
            'request_update' => $request_update,
            'request_publish' => $request_publish
        ));

        $backLink = Controller::replaceInsertTags("{{link::back}}");
        return "<div class='catalog-return'><p>Die neue Version für <b>$name</b> wurde erfolgreich erstellt.</p>"
                . "<p class='header_back'>$backLink</p></div>";
    }

    /**
     * 
     * @param Contao\DataContainer $dc
     */
    public function switchVersion(DataContainer $dc) {
        $id = $dc->id;

        $arrCompany = $this->dbConnection->fetchAssoc("SELECT * FROM tl_firmen_versions WHERE company_id = ?", array($id));
        
        $tstamp = $arrCompany['tstamp'];
        $name = $arrCompany['name'];
        $zusatz = $arrCompany['zusatz'];
        $alias = $arrCompany['alias'];
        $strasse = $arrCompany['strasse'];
        $hsnr = $arrCompany['hsnr'];
        $plz_ort = $arrCompany['plz_ort'];
        $stadtteil = $arrCompany['stadtteil'];
        $gewerbegebiet = $arrCompany['gewerbegebiet'];
        $geo_coord = $arrCompany['geo_coord'];
        $show_on_map = $arrCompany['show_on_map'];
        $telefon = $arrCompany['telefon'];
        $telefax = $arrCompany['telefax'];
        $web = $arrCompany['web'];
        $mail = $arrCompany['mail'];
        $facebook = $arrCompany['facebook'];
        $twitter = $arrCompany['twitter'];
        $instagram = $arrCompany['instagram'];
        $xing = $arrCompany['xing'];
        $gplus = $arrCompany['gplus'];
        $beschreibung = $arrCompany['beschreibung'];
        $weg_beschreibung = $arrCompany['weg_beschreibung'];
        $branchen = $arrCompany['branchen'];
        $lebenslagen = $arrCompany['lebenslagen'];
        $kategorien = $arrCompany['kategorien'];
        $logo = $arrCompany['logo'];
        $bild_1 = $arrCompany['bild_1'];
        $bild_2 = $arrCompany['bild_2'];
        $bild_3 = $arrCompany['bild_3'];
        $bild_4 = $arrCompany['bild_4'];
        $bild_5 = $arrCompany['bild_5'];
        $bild_6 = $arrCompany['bild_6'];
        $bild_7 = $arrCompany['bild_7'];
        $bild_8 = $arrCompany['bild_8'];
        $bild_9 = $arrCompany['bild_9'];
        $benutzer = $arrCompany['benutzer'];
        $is_person = $arrCompany['is_person'];
        $hide_contacts = $arrCompany['hide_contacts'];
        $published = $arrCompany['published'];
        $request_update = $arrCompany['request_update'];
        $request_publish = $arrCompany['request_publish'];

        $versionExistant = $this->dbConnection->fetchAssoc("SELECT * FROM tl_firmen_versions WHERE company_id = ?", array($id));
        
        if ($versionExistant !== false) {
            $this->dbConnection->delete('tl_firmen_versions', array('company_id' => $id));
        }

        $this->dbConnection->update('tl_firmen', array(
            'tstamp' => $tstamp,
            'name' => $name,
            'zusatz' => $zusatz,
            'alias' => $alias,
            'strasse' => $strasse,
            'hsnr' => $hsnr,
            'plz_ort' => $plz_ort,
            'stadtteil' => $stadtteil,
            'gewerbegebiet' => $gewerbegebiet,
            'geo_coord' => $geo_coord,
            'show_on_map' => $show_on_map,
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
            'benutzer' => $benutzer,
            'is_person' => $is_person,
            'hide_contacts' => $hide_contacts,
            'published' => $published,
            'request_update' => '',
            'request_publish' => $request_publish
                ),
                array('id' => $id)
        );

        $backLink = Controller::replaceInsertTags("{{link::back}}");
        return "<div class='catalog-return'><p>Die Version für <b>$name</b> wurde erfolgreich in die Live-Umgebung übertragen.</p></div>";
    }

}
