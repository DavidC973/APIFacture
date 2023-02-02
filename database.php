<?php

use Faker\Factory;
require_once 'vendor/autoload.php';

$hostname = 'localhost';
$user = 'root';
$password = 'root';
$dbname = 'facture';


$connection = mysqli_connect($hostname, $user, $password);
$sql = "CREATE database if not exists facture";

if (mysqli_query ($connection, $sql)) {
    echo "Database created succesfully". PHP_EOL;
} else {
    echo "Error creating databse: " . mysqli_error($connection). PHP_EOL;
}

$connection -> select_db($dbname);

$sql_client = "CREATE TABLE if not exists client (
    id INT(6) UNSIGNED AUTO INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
    )";

if (mysql_query($connection, $sql_client)) {
    echo "Table client created successfully" . PHP_EOL;
} else {
    echo "Error creating table: " . mysqli_error($connection). PHP_EOL;
}

$sql_facture = "CREATE TABLE if not exists facture (
    id INT (6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    montant INT(6) UNSIGNED NOT NULL,
    client_id INT(6) UNSIGNED NOT NULL,
    payee boolean NOT NULL,
    FOREIGN KEY (client_id) REFERENCES client(id)
    )";

if ($connection -> query($sql_facture) === TRUE) {
    echo "Table des Facture créée avec succès\n";
} else  {
    echo "Erreur lors de la création de la table des factures: " . $conn->error . "\n";
}

$faker = Factory::create('fr_FR');

for ($i =0; $i < 10; $i++){
    $nom = $faker->firstname;
    $sql = "INSERT INTO client (nom) VALUES ('nom')";
    if ($connection->query($sql) ===TRUE){
        echo"Nouveau client créé avec succès\n";
    } else {
        echo "Erreur lors de la creation du client: ". $conn->error . "\n";
    }
}

$sql_count_client = "SELECT COUNT(*) FROM client";

if($connection->query($sql_count_client) === TRUE) {
    echo "Nombre de client " . $connection->query($sql_count_client) . "\n";
} else {
    echo "Erreur lors de la récupération du nombre de client: " . $connection->error . "\n";
}
$number_client = $connection->query($sql_count_client)->fetch_assoc();

for($i=0; $i < 40; $i++){
    $montant = $faker->numberBetween(100,1000);
    $client_id = $faker->numberBetween(1, $number_client['COUNT(*)']);
    $payee = $faker->numberBetween(0, 1);
    $sql = "INSERT INTO facture (montant, client_id, payee) VALUES ($montant, $client_id, $payee)";
    if ($connection->query($sql) ===TRUE){
        echo "Nouvelle facture créée avec succès\n";
    } else {
        echo "Erreur lors de la création de la facture: " . $conn->error . "\n";
    }
}