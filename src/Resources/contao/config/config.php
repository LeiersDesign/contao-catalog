<?php

if (TL_MODE == 'BE') {
    $GLOBALS['TL_CSS'][] = 'bundles/contaocatalog/css/catalog_be.css|static';

    if (\Contao\Input::get('do') == 'unternehmen') {
        $GLOBALS['TL_CSS'][] = 'bundles/contaocatalog/css/catalog_be_list.css|static';
    }

    if (\Contao\Input::get('key') == 'versionDiffs') {
        $GLOBALS['TL_CSS'][] = 'assets/colorbox/css/colorbox.min.css|static';
        $GLOBALS['TL_JAVASCRIPT'][] = 'assets/jquery/js/jquery.min.js';
        $GLOBALS['TL_JAVASCRIPT'][] = 'assets/colorbox/js/colorbox.min.js';
        $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/contaocatalog/js/versionDiffs.js';
    }
}

if (TL_MODE == 'FE') {
    $GLOBALS['TL_CSS'][] = 'bundles/contaocatalog/css/catalog_fe.css|static';
}

/**
 * 
 * Backend Modules
 * 
 */
/**
 * Portal
 */
$GLOBALS['BE_MOD']['portal']['unternehmen'] = array(
    'tables' => array('tl_firmen', 'tl_firmen_events')
);

/**
 * Taxonomie
 */
$GLOBALS['BE_MOD']['taxonomie']['staedte'] = array(
    'tables' => array('tl_staedte', 'tl_stadtteile', 'tl_gewerbegebiete')
);

$GLOBALS['BE_MOD']['taxonomie']['kategorien'] = array(
    'tables' => array('tl_kategorien')
);

$GLOBALS['BE_MOD']['taxonomie']['branchen'] = array(
    'tables' => array('tl_branchen')
);

$GLOBALS['BE_MOD']['taxonomie']['lebenslagen'] = array(
    'tables' => array('tl_lebenslagen')
);


$GLOBALS['BE_MOD']['portal']['benutzer'] = $GLOBALS['BE_MOD']['accounts']['member'];
$GLOBALS['BE_MOD']['portal']['benutzerpakete'] = $GLOBALS['BE_MOD']['accounts']['mgroup'];

/**
 * Eigene Operationen
 */
//Versionsunterschiede
$GLOBALS['BE_MOD']['portal']['unternehmen']['versionDiffs'] = array('LeiersDesign\ContaoCatalog\Classes\VersionDifferences', 'showVersionDifferences');
$GLOBALS['BE_MOD']['portal']['unternehmen']['versionCreate'] = array('LeiersDesign\ContaoCatalog\Classes\VersionManager', 'createVersion');
$GLOBALS['BE_MOD']['portal']['unternehmen']['versionSwitch'] = array('LeiersDesign\ContaoCatalog\Classes\VersionManager', 'switchVersion');

/**
 * Fontend Modules
*/
$GLOBALS['FE_MOD']['catalog']['list_user_companies'] = 'LeiersDesign\ContaoCatalog\Modules\ListUserCompanies';
$GLOBALS['FE_MOD']['catalog']['toggle_user_company'] = 'LeiersDesign\ContaoCatalog\Modules\ToggleUserCompany';
$GLOBALS['FE_MOD']['catalog']['company_preview'] = 'LeiersDesign\ContaoCatalog\Modules\CompanyPreview';
$GLOBALS['FE_MOD']['catalog']['company_edit'] = 'LeiersDesign\ContaoCatalog\Modules\CompanyEdit';
$GLOBALS['FE_MOD']['catalog']['company_detail'] = 'LeiersDesign\ContaoCatalog\Modules\CompanyDetail';

/**
 * Frontend Elements
 */
$GLOBALS['TL_CTE']['portal']['list_single_company'] = 'LeiersDesign\ContaoCatalog\Elements\ListSingleCompany';
$GLOBALS['TL_CTE']['portal']['overview_map'] = 'LeiersDesign\ContaoCatalog\Elements\OverviewMap';

/**
 * Hooks (Backend)
 */
$GLOBALS['TL_HOOKS']['getSystemMessages'][] = array('LeiersDesign\ContaoCatalog\Classes\BackendHelper', 'getCatalogSystemMessages');

