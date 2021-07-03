<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php
session_start();

$userid = $_SESSION["user_id"];
$dist = ltrim(rtrim(filter_input(INPUT_POST, "dist", FILTER_SANITIZE_STRING)));
$fuel = ltrim(rtrim(filter_input(INPUT_POST, "fuel", FILTER_SANITIZE_STRING)));
$fuelPrice = ltrim(rtrim(filter_input(INPUT_POST, "fuelPrice", FILTER_SANITIZE_STRING)));


require_once "configuration.php";


$dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   



$query = "INSERT INTO records (userid, dist, fuel, fuelPrice) VALUES(:userid, :dist, :fuel, :fuelPrice)";
$statement = $dbConnection->prepare($query);
$statement->bindParam(":userid", $userid, PDO::PARAM_STR);
$statement->bindParam(":dist", $dist, PDO::PARAM_STR);
$statement->bindParam(":fuel", $fuel, PDO::PARAM_STR);
$statement->bindParam(":fuelPrice", $fuelPrice, PDO::PARAM_STR);
$statement->execute();

if ($statement->rowCount() > 0)
{
	header("location: index.html");
}
else
{
    echo "<p>Record not added to database.</p>";
}

?>

</body>
</html>