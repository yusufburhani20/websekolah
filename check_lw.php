<?php 
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::create('/admin/login', 'GET'));
$html = $response->getContent();
preg_match('/<script src="([^"]+livewire\.js[^"]*)"/', $html, $m);
echo $m[1] ?? 'Not found';
