<?php

namespace LeiersDesign\ContaoCatalog\Elements;

use Contao\Controller;
use Contao\FilesModel;
use Contao\StringUtil;
use LeiersDesign\ContaoCatalog\Classes\FrontendHelper;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OverviewMap
 *
 * @author leiers//DESIGN
 */
class OverviewMap extends \ContentElement {

    protected $strTemplate = 'ce_overview_map';

    public function generate() {
        if (TL_MODE === 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . sprintf($GLOBALS['TL_LANG']['MSC']['catalog']['modules']['overview_map']) . ' ###';
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

        $objDBCompanies = $this->Database->prepare("SELECT name, alias, strasse, hsnr, plz_ort, geo_coord, telefon, telefax, web, mail FROM tl_firmen WHERE published = '1' AND show_on_map = '1'")->execute();
        $arrCompanies = [];

        while ($objDBCompanies->next()) {
            $arrCompanies[] = $objDBCompanies->row();
        }

        if (empty($arrCompanies)) {
            return;
        }
        
        foreach($arrCompanies as $key => $company) {
            $arrCompanies[$key]['plz_ort'] = FrontendHelper::getPlzOrt($arrCompanies[$key]['plz_ort']);
            $arrCompanies[$key]['detailLink'] = FrontendHelper::getPlzOrt($arrCompanies[$key]['plz_ort']);
        }

        /**
         * Include JS & CSS for leaflet if leaflet isn't loaded by bundle leiersdesign/contao-leaflet-maps
         */
        if (empty($GLOBALS['TL_JAVASCRIPT']['leaflet'])) {
            $GLOBALS['TL_JAVASCRIPT']['leaflet'] = 'bundles/contaocatalog/leaflet/leaflet.js|static';
        }

        if (empty($GLOBALS['TL_CSS']['leaflet'])) {
            $GLOBALS['TL_CSS']['leaflet'] = 'bundles/contaocatalog/leaflet/leaflet.css|static';
        }

        if ($this->map_layers) {
            if (empty($GLOBALS['TL_JAVASCRIPT']['leaflet_omnivore'])) {
                $GLOBALS['TL_JAVASCRIPT']['leaflet_omnivore'] = 'bundles/contaocatalog/leaflet/leaflet-omnivore.min.js|static';
            }
            
            $this->Template->layers = $this->decodeMapLayers($this->map_layers);
        }

        $width = unserialize($this->map_size_width);
        $height = unserialize($this->map_size_height);

        $this->Template->mapID = 'overview_map_container_' . $this->id;
        $this->Template->contentID = $this->id;
        $this->Template->width = $width['value'] . $width['unit'];
        $this->Template->height = $height['value'] . $height['unit'];
        $this->Template->map_center = $this->map_center_coords;
        $this->Template->zoom = $this->map_zoom;
        $this->Template->map_disable_mouse_wheel_zoom = $this->map_disable_mouse_wheel_zoom;
        $this->Template->markers = $arrCompanies;
    }

    /**
     * 
     * @param type $strSerialized
     * @return array
     */
    private function decodeMapLayers($strSerialized) {
        $arrLayerFiles = \StringUtil::deserialize($strSerialized, true);
        
        
        $arrModified = [];

        foreach ($arrLayerFiles as $key => $layerUuid) {
            $tmpFile = FilesModel::findByUuid($layerUuid);

            $arrModified[$key] = [
                'ext' => $tmpFile->extension,
                'path' => $tmpFile->path
            ];
        }

        return $arrModified;
    }

}
