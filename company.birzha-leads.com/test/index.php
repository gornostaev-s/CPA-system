<?php

use App\Services\TildaService;

ini_set('display_errors', E_ALL);

require 'vendor/load.php';
require 'TildaService.php';

ini_set('default_charset', 'UTF-8');
$file = file_get_contents('https://xn----dtbefathsrmyjdj1f.xn--p1ai/tstore/yml/d1c1eaefd9452fcdc77df16cc9932994.yml');

libxml_use_internal_errors(true);
$xml = simplexml_load_string($file);
if (false === $xml) {
    $errors = libxml_get_errors();
    echo 'Errors are '.var_export($errors, true);
    throw new \Exception('invalid XML');
}

$offers = $xml->shop->offers->offer;
foreach ($offers as $obj) {
    $images = [];
    foreach ($obj->param as $param) {
        if ($param['name'] == 'Дата') {
            $dateString = (string)$param[0];
            if (!empty($dateString) && strtotime($dateString) < time()) {
                $yml[] = [
                    'name' => (string)$obj->name,
                    'id' => (string)$obj['id'],
                ];
            }
        }
    }
}

if (empty($yml)) {
    die;
}

$import = '';
$offers = '';

ob_start();
include __DIR__ . '/files/import.php';
$import = ob_get_contents();
ob_end_clean();

ob_start();
include __DIR__ . '/files/offers.php';
$offers = ob_get_contents();
ob_end_clean();

$tilda = (new TildaService())
    ->setImport($import)
    ->setOffers($offers)
    ->files()
    ->import()
;
?>



