<?php
/**
 * Simple PHP Ajax Response Kit
 *
 * Test file
 *
 * WARNING: use only on development environment!
 *
 * @author Caspius Labs
 * @link https://github.com/CaspiusLabs/SPARK
 * @version 1.1.8
 * @package Utils
 *
 */


require_once 'config.php'; // must run as first
require_once 'common.php'; // must run as second

setReporting();
removeMagicQuotes();
unregisterGlobals();

/********************************************************/

// test code here

session_start();

debug($_SESSION);
