<!doctype html>
<html lang="en">

<head>
<?php
      session_start();
  ?>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>FuelCost</title>

</head>

<body>

  <div class=container>
    <div class="col-md-8 offset-md-2">
      <h1 class="text-center mt-5"><?php echo "Witaj " . $_SESSION["user_name"];?></h1>      
      <p class="lead text-center">Dodawaj i przeglądaj swoje wydatki na paliwo dzięki FuelCost.</p>
      <hr class="my-4">
      <div>
        <form id="addTransaction" action="addTransaction.php" method="post">
          <div class="form-group">
            <input type="number" class="mt-2" step="0.01" id="dist" name="dist" placeholder="Pokonany dystans" required />
            <input type="number" class="mt-2" step="0.01" id="fuel" name="fuel" placeholder="Ilość spalonego paliwa" required />
            <input type="number" class="mt-2" step="0.01" id="fuelPrice" name="fuelPrice" placeholder="Cena paliwa (PLN/l)"" required/>
          <button type="submit">Dodaj</button>
        </form>
      </div>
    </div>

    <?php

    require_once "configuration.php";


    $dbConnection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM records WHERE userid = " . $_SESSION["user_id"];
    $statement = $dbConnection->prepare($query);
    $statement->execute();

    $sumFuel = 0;
    $sumDist = 0;
    $sumFuelPrice = 0;
    $sumAllFuelExpenses = 0;
    if ($statement->rowCount() > 0) {
      echo "<table style='width: 100%; text-align:center' class='table table-sm table-striped'>";
      $result = $statement->fetchAll(PDO::FETCH_OBJ);
      echo "<tr>";
      echo "<th>" . 'Dystans' . "</th><th>" . 'Zużyte paliwo' . "</th><th>" . 'Cena paliwa' . "</tr>";
      foreach ($result as $row) {
        $sumFuel = $sumFuel + $row->fuel;
        $sumDist = $sumDist + $row->dist;
        $sumRowFuelExpenses = $row->fuel * $row->fuelPrice;
        $sumAllFuelExpenses = $sumAllFuelExpenses + $sumRowFuelExpenses;
        echo "<tr>";
        echo "<td>" . $row->dist . "</td><td>" . $row->fuel . "</td><td>" . $row->fuelPrice . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    }
    ?>
    <div class="bg-light d-flex justify-content-between">
    <div>Suma przejechanych kilometrów: </div>
    <div><?php echo round($sumDist,2)?> km</div>
    </div>    
    <div class="bg-light d-flex justify-content-between">
    <div>Ilość zużytego paliwa:</div>
    <div><?php echo round($sumFuel, 1)?> l</div>
    </div>
    <div class="bg-light d-flex justify-content-between mb-3">
    <div>Suma wydatków na paliwo:</div>
    <div><?php echo round($sumAllFuelExpenses, 2)?> PLN</div>
    </div>
  </div>
  <div class="col-md-8 offset-md-2">
  <button type="button" class="btn btn-danger mb-2">Wyloguj się</button>
  </div>
  <!--<footer class="footer">
    <div class="footer " style="background-color: rgba(0, 0, 0, 0.05);">
      <div class="copyright">    © 2021 Copyright:
        Jakub Zięba
      </div>
    </div>
    
  </footer>-->


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>