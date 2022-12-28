<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST');

require_once "controllers/templateController.php";
require_once "controllers/curlController.php";
require_once "controllers/controllerUsers.php";
// require_once "controllers/controllerVendor.php";

// require_once "extensions/vendor/autoload.php";

$index = new TemplateController;
$index->index();
