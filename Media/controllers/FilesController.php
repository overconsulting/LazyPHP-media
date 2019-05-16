<?php

namespace Media\controllers;

use app\controllers\cockpit\CockpitController;
use Core\Session;
use Core\Router;

use Media\models\File;
use Core\models\Site;

class FilesController extends CockpitController
{

    function getfileAction() {
        $attachment_location = UPLOADS_DIR.DS."file".DS.$_GET['filepath'];
        header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");

        $extention = substr($attachment_location, -3);
        
        header('Content-Type: application/'.$extention);
        readfile($attachment_location);
    }
}