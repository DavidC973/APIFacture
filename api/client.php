<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "facture";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion à la base de ddonnées échouée : " . $conn->connect_error);
}

$method = $_SERVER['REQUEST_METHOD'];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

switch($method){
    case 'GET':
        if(isset($_GET['id'])){
            getClientByID();
        }elseif(isset($_GET['nom'])){
            getClientByName();
        }else{
        handleGetRequest();
        }
        break;
    case 'DELETE':
        handleDeleteRequest();
        break;
    case 'POST';
        handlePostRequest();
        break;
    default:
        echo "Methode non prise en charge";
        break;
}

function getClientByID(){
    global $conn;
    $id = $_GET['id'];
    $sql = "SELECT * FROM client WHERE id = $id";
    $result = $conn->query($sql);
    if ($result-> num_rows >0){
        $data = array();
        while ($row = $result-> fetch_assoc()){
            $data[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }else{
        echo "Aucun client trouvé";
    }
}

function handleGetRequest(){
    global $conn;
    $sql = "SELECT * FROM client";
    $result = $conn->query($sql);
    if ($result-> num_rows > 0){
        $data = array();
        while ($row = $result-> fetch_assoc()){
            $data[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }else{
        echo "Aucun article trouvé";
    }
}

function handleDeleteRequest(){
    global $conn;
    $id = $_GET['id'];
    $sql = "DELETE * FROM client WHERE id = $id";
    
    if ($conn-> query($sql) === TRUE){
        echo "Suppression réussie";
    }else{
        echo "Erreur lors de la suppression: " . $conn->error;
    }
}

function getClientByName(){
    global $conn;
    $nom = $_GET['nom'];
    $sql = "SELECT * FROM client WHERE nom = '$nom'";
    $result = $conn->query($sql);
    if ($result-> num_rows >0){
        $data = array();
        while ($row = $result-> fetch_assoc()){
            $data[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }else{
        echo "Aucun client trouvé";
    }
}

function handlePostRequest()
{
    global $conn;
    $name = $_POST['nom'];
    $sql = "INSERT INYO client (nom) VALUES ('$name')";
    if($conn->query($sql)=== TRUE){
        echo"Insertion réussie";
    } else {
        echo "Erreur lors de l'insertion: " . $conn->error;
    }
}