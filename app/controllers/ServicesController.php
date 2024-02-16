<?php

namespace App\Controllers;


class ServicesController {
    public function index() {
        echo "am i here?";
        // Include the view for rendering
        include '../app/views/services/index.php';
        // include '../app/views/user/index.php';

    }
}