<?php

function compareId($a, $b) {
    return intval($a->getId()) - intval($b->getId());
}

function compareOrder($a, $b) {
    return intval($a->getOrder()) - intval($b->getOrder());
}

function getThemeNames() {
    $themeNames = array();
    $dirs = array_diff(scandir('themes'),array('.','..'));
    foreach ($dirs as $dir) {
        if ( is_dir("themes/$dir") ) {
            $themeNames[] = $dir;
        }
    }
    return $themeNames;
}

