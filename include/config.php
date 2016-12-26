<?php
/* Set locale to Dutch */
setlocale(LC_ALL, 'nld_nld');

// DB-verbinding
$db = new PDO('mysql:host=localhost;dbname=kalender','root','');
$db->setAttribute(PDO::ATTR_ERRMODE,
    PDO::ERRMODE_WARNING);

// TemplatePower includen
include("class.TemplatePower.inc.php");