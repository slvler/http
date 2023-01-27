<?php

require 'Build.php';
require "HttpResponse.php";

$vvv = Build::connection()
    ->baseUrl('https://www.drupal.org/')
    ->query(['type' => 'book'])
    ->get('api-d7/node.json');

print_r($vvv->toArray());


