<?php
session_start();
require_once 'EntrepriseController.php';
use Controllers\EntrepriseController;

$controller = new EntrepriseController();
$controller->create();
