<?php
session_start();
require_once '../Controllers/OfferController.php'; // Ce fichier se trouve dans le même dossier
use Controllers\OfferController;

$controller = new OfferController();
$controller->store();
