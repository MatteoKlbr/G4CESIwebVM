<?php
session_start();
require_once 'Controllers/EntrepriseController.php';

use Controllers\EntrepriseController;

$controller = new EntrepriseController();
$controller->create();
