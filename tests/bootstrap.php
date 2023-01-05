<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author fernando
 */
// TODO: check include path
//ini_set('include_path', ini_get('include_path'));
$baseDir = dirname(__DIR__);

// put your code here
require_once $baseDir . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($baseDir);
$dotenv->load();
