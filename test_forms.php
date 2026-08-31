<?php 
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::create('/admin/login', 'GET'));
$html = $response->getContent();
preg_match_all('/<form[^>]*>/', $html, $matches);
print_r($matches);
