<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Aca estará una pagina de inicio";
});

require __DIR__ . '/settings.php';
