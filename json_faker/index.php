<?php 
require_once 'vendor/autoload.php';

use Porte22\Faker\FakerJson;

$faker = new FakerJson();
$faker->parseJson();
?>