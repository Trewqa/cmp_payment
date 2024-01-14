<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$host = '127.0.0.1';
$user = 'mysql_user';
$password = 'mysql_password';
$database = 'mysql_database';

$paypal_email = "sb-ceaol29158626@business.example.com";

global $pdo;

try {

    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

if (isset($_GET['token'])) {

    $token = $_GET['token'];
    echo checkToken($token);
    die();
}

function checkToken($token) {
    global $pdo;

    try {

        $stmt = $pdo->prepare('SELECT 1 FROM cmp_payment_tokens WHERE token = :token AND expire_datetime > NOW()');
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);

        $stmt->execute();
        
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return true;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        die();
    }
}

function setToken($token, $email) {
    global $pdo;

    $stmt = $pdo->prepare('INSERT IGNORE INTO cmp_payment_tokens VALUES (null, :valor1, :valor2, now() + interval 1 year)');
    
    $stmt->bindValue(':valor1', $token);
    $stmt->bindValue(':valor2', $email);

    $stmt->execute();
}