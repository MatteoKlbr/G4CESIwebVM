<?php
session_start();
$redirectPanel = ($_SESSION['role'] === 'admin') ? 'admin_panel.php' : 'pilote_panel.php';

require_once '../models/EntrepriseModel.php';
require_once __DIR__ . '/../Controllers/EntrepriseController.php';
use Controllers\EntrepriseController;

$controller = new EntrepriseController();
$controller->store();
