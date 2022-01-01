<?php
date_default_timezone_set('Asia/Jakarta');
ini_set('memory_limit', '-1');
set_time_limit(-1);
ini_set('max_input_vars', -1);
session_start();
// Authorization: Bearer <token>

require_once __DIR__ . '/terminate/autoload.php';

use App\App;
$objek = new App();