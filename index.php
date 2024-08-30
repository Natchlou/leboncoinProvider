<?php

require_once 'vendor/autoload.php';

$faker = \Faker\Factory::create();

// Ajoute ton custom provider
$faker->addProvider(new \Faker\Provider\fr_FR\Company($faker));
$faker->addProvider(new \Faker\Provider\fr_FR\Address($faker));
$faker->addProvider(new \App\Faker\LeboncoinProvider($faker));


$property = $faker->getProperty(4);
// Utilise ta méthode personnalisée
echo '<pre>';
var_dump($property);
var_dump($property['list_id']);
echo '</pre>';
