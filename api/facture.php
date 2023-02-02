<?php


$servername = "localhost";
$username = "root";
$password= "root";
$dbname = "facture";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn-> connect_error){
    die("Connexion à la base de données échouée: " . $conn->connect_error);
}

$method = $_SERVER['REQUEST_METHOD'];
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8");

switch($method){
    case 'GET':
        if(isset($_GET['client_id'])){
            getfactureByClient();
        }elseif(isset($_GET['payee'])){
            getfacturePayed();
        }elseif(isset($_GET['impayee'])){
            getfactureUnpayed();
        }else{
            handleGetRequest();
        }
        break;
    }

function handleGetRequest(){
    global $conn;
    $sql = "SELECT * FROM facture";
    $result = $conn->query($sql);
    if ($result->num_rows >0) {
        $data = array();
        while ($row = $result-> fetch_assoc()){
            $data [] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }else {
        echo "Aucun article trouvé";
    }
}

function getFactureByClient(){
    global $conn;
    $id = $_GET['client_id'];
    $sql = "SELECT * FROM facture WHERE client_id = $id";
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

function getFacturePayed()
{
    global $conn;
    $sql = "SELECT * FROM facture WHERE payee = 1";
    $result = $conn->query($sql);
    if ($result-> num_rows >0){
        $data = array();
        while ($row = $result-> fetch_assoc()){
            $data[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }else{
        echo "Aucune facture trouvée";
    }
}

function getFactureUnpayed()
{
    global $conn;
    $sql = "SELECT * FROM facture WHERE payee = 0";
    $result = $conn->query($sql);
    if ($result-> num_rows >0){
        $data = array();
        while ($row = $result-> fetch_assoc()){
            $data[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }else{
        echo "Aucune facture trouvée";
    }
}
