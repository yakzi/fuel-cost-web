<?php

$localHostSiteFolderName = "fuelcost";
$localhostDatabaseName = "fuelcost";
$localHostDatabaseHostAddress = "localhost";
$localHostDatabaseUserName = "root";
$localHostDatabasePassword = "";


$useLocalHost = true;      


    $siteName = "http://localhost/" . $localHostSiteFolderName;
    $dbName = $localhostDatabaseName;
    $dbHost = $localHostDatabaseHostAddress;
    $dbUsername = $localHostDatabaseUserName;
    $dbPassword = $localHostDatabasePassword;


chmod("configuration.php", 0600); 
?>