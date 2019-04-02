<?php

/**
 * This file loads all required classes and files for the whole project
 */

/** 
 *  Load config files
 */
require_once('system/dbconfig.php');

 /**
  * Load Classes and tools
  */
 require_once("system/tools.php");
 require_once("system/Database.php");
 require_once("system/User.php");
 require_once("system/MenuItem.php");
 require_once("system/Settings.php");
 require_once("system/Page.php");