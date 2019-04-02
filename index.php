<?php

// Load all necessary files and classes for the whole project
require_once('system/loader.php');

// Load database, exit if error
$pdo = Database::connect();

if ($pdo == false ) {
    echo 'Unable to connect to database :(';
    die();
}


$result = Database::getTableNames();
if ( !Database::tablesExist(array('user','page','menutiem','settings') ) ) {
    echo 'No tables found, please run setup.php';
    die();
}

// Set up settings variables
$settings = Settings::load($pdo);

// Set global variables and functions
$page = null;

$menuItems = MenuItem::loadAll($pdo);
// usort($menuItems, 'compareOrder');

function getThemeDir() {
    global $settings;
    $dir = 'themes/' . $settings['theme'];
    if ( !file_exists($dir) ) {
        $dir = 'themes/ugly';
    }
    return $dir;
}


function getTemplateFile() {
    global $page;
    $templateFile = getThemeDir() . '/templates/' . $page->getTemplate() . '.php';
    if ( !file_exists($templateFile)) {
        $templateFile = 'themes/ugly/templates/default.php';
    }
    return $templateFile;
}


$pageParam =  isset($_GET['page']) ? trim(strip_tags($_GET['page'])) : $settings['home'];
// if the parameter is anumber use page id otherwise use page code
if (is_numeric($pageParam)) {
    $page = Page::loadById($pdo, $pageParam);
} else {
    $page = Page::loadByCode($pdo, $pageParam);
}

// If page found on database
if ( $page ) {
    include( getTemplateFile() );   
} else {
    echo 'Page not found';
}


