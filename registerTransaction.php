<?php
session_start();

session_unset();
session_destroy();
session_start();


$email = ltrim(rtrim(filter_input(INPUT_POST, "emailReg", FILTER_SANITIZE_EMAIL)));
if (empty($email) || (!filter_var($email, FILTER_VALIDATE_EMAIL)))
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        header("location: error.php"); 
    }
}

$password = ltrim(rtrim(filter_input(INPUT_POST, "passwordReg", FILTER_SANITIZE_STRING)));
if (empty($password))
{
    header("location: login.html"); 
}


require_once "configuration.php";


$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  


$query = "SELECT id, email, password FROM users WHERE email = :email";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":email", $email, PDO::PARAM_STR);
$statement->execute();



if ($statement->rowCount() > 0)
{
    $row = $statement->fetch(PDO::FETCH_OBJ);
    if ($password === $row->password)
    {
        $_SESSION["user_id"] = $row->id;
		$_SESSION["user_name"] = $row->email;
    }
}


$query = "INSERT INTO users (email, password) VALUES(:email, :password)";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":email", $email, PDO::PARAM_STR);
$statement->bindParam(":password", $password, PDO::PARAM_STR);
$statement->execute();

header("location: login.html");
?>