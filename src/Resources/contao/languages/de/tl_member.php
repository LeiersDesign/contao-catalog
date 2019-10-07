<?php

if (TL_MODE == "BE") {
    $GLOBALS['TL_LANG']['tl_member']['agb_akzeptiert'] = array('AGB akzeptiert', 'Nutzer hat die AGB akzeptiert.');
    $GLOBALS['TL_LANG']['tl_member']['datenschutz_akzeptiert'] = array('Datenschutz akzeptiert', 'Nutzer hat die Datenschutzbestimmungen akzeptiert.');
    $GLOBALS['TL_LANG']['tl_member']['urheberrecht_bestaetigt'] = array('Urheberrecht bestätigt', 'Nutzer hat bestätigt, dass Fotos & Texte sein (geistiges) Eigentum sind und diese im Portal veröffentlichet werden dürfen.');
} else {
    $GLOBALS['TL_LANG']['tl_member']['agb_akzeptiert'] = array('AGB akzeptiert', 'Ich habe die AGB gelesen und akzeptiere diese.');
    $GLOBALS['TL_LANG']['tl_member']['datenschutz_akzeptiert'] = array('Datenschutz akzeptiert', 'Ich habe die Datenschutzbestimmungen gelesen und akzeptiere diese.');
    $GLOBALS['TL_LANG']['tl_member']['urheberrecht_bestaetigt'] = array('Urheberrecht bestätigt', 'Nutzer hat bestätigt, dass ich der Urheber der Fotos & Texte bin oder ich die Rechte an diesen besitze und diese im Portal veröffentlichet werden dürfen.');
}