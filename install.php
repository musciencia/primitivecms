<?php

// Load all necessary files and classes for the whole project
require_once('system/loader.php');

// Connect to database
$pdo = Database::connect();
if ($pdo) {
    echo "Succesfully connected to database";
    echo '<pre>';
    // var_dump(Database::createTable(Page::class));
    echo 'Creating Page table...</br>';
    Page::createTable($pdo);

    echo 'Creating Setting table...</br>';
    Settings::createTable($pdo);

    echo 'Set default settings...</br>';
    echo '  Default home page -> home... </br>';
    echo '  Default theme -> ugly... </br>';
    echo '  Website Name -> Primitive CMS... </br>';
    $settings = array('home'=>'home', 'theme'=>'ugly', 'sitename'=>'Primitive CMS');
    Settings::save($pdo, $settings);

   
    echo 'Creating MenuItem table...</br>';
    MenuItem::createTable($pdo);

    echo '  Create Home menu item... </br>';
    $menuItem = MenuItem::create('Home','?page=home', 0);
    $menuItem->save($pdo);

    echo '  Create About menu item... </br>';
    $menuItem = MenuItem::create('About Us','?page=about', 1);
    $menuItem->save($pdo);

    echo '  Create Contact menu item... </br>';
    $menuItem = MenuItem::create('Contact Us','?page=contact', 2);
    $menuItem->save($pdo);
    
    echo 'Creating smaple pages...</br>';
    echo '   Creating home page...</br>';
    $page = Page::create('home', 'Home', 'Home Content', 'default');
    $page->save($pdo);

    echo '   Creating about page...</br>';
    $page = Page::create('about', 'About', 'About Content', 'default');
    $page->save($pdo);
    
    echo '   Creating contact page...</br>';
    $page = Page::create('contact', 'Contact Us', 'Contact Us Content', 'default');
    $page->save($pdo);
    
    echo '   Creating sample page...</br>';
    $page = Page::create('sample-page', 'Sample Page', 'Sample Page Content', 'default');
    $page->save($pdo);

    echo 'Creating User table...</br>';
    User::createTable($pdo);
    echo '   Creating admin user...</br>';
    $user = User::create('admin','admin','password');
    $user->save($pdo);

    echo 'Setup completed succesfully!</br>';
    echo 'Please remove install.php from your server</br>';
    echo '</pre>';
} else {
    echo "Unable to connect to database";
}
