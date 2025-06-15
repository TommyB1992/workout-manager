<?php

namespace App\Controllers;

use App\Core\View;

class Controller {

    public function __construct() {
        View::setGlobal('base_url', 'http://localhost:8000/');
    }

}