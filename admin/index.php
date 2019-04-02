<?php 
// Change directory in order to use the same root  
// for all sections of the website
chdir('..');
// Load all system classes and files 
require_once('system/loader.php');
// Load database, exit if error
$pdo = Database::connect();
if (!$pdo) {
    echo 'Unable to connect to database :(';
    die();
}

// If user click the logout button
if ( isset($_GET['logout'])) {
    setcookie('user', '', -1);
    setcookie('access_code','', -1);
    include_once('admin/content/login.php');
    exit(0);
}

// Login User
$currentUser = null;
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim(strip_tags($_POST['username']));
    $password = trim(strip_tags($_POST['password']));
    $currentUser = User::load($pdo, $username);
    if ( $currentUser) {
        if ($currentUser->isPasswordValid($password)) {
            $cookieCode = $currentUser->setRandomCookieCode();
            $currentUser->save($pdo);
            setcookie('user', $username, 0);
            setcookie('access_code', $cookieCode, 0);
            include_once('admin/content/content.php');
        } else {
           // echo 'Login failed';
            include_once('admin/content/login.php');
        }    
    } else {
        // echo 'Login failed';
        include_once('admin/content/login.php');
    }
} else {

    // Check user access
    if (
        isset($_COOKIE['user']) &&
        isset($_COOKIE['access_code'])
    ) {
        $username = $_COOKIE['user'];
        $cookieCode =  $_COOKIE['access_code'];
        $currentUser = User::load($pdo, $username);
        if ($currentUser->isCookieCodeValid($cookieCode)) {
            // Load content if valid user
            include_once('admin/content/content.php');
        } else {
            include_once('admin/content/login.php');
        }
    } else {
        include_once('admin/content/login.php');
    }
}


 