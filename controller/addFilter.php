<?php

if(isset($_REQUEST["filterType"]) && $_REQUEST["filterType"] != "*"){
    $filterType = $_REQUEST["filterType"];
    $SQLparam1 = "";
    $SQLparam2 = "";
    switch ($filterType) {
      case 'funkcija':
            $SQLparam1 = "fn, nazivFunkcije ";
            $SQLparam2 = "funkcije";
            $id = "fn";
            $naziv = "nazivFunkcije";
        break;
     case 'grad':
            $SQLparam1 = "gradID, nazivGrada";
            $SQLparam2 = "gradovi";
            $id = "gradID";
            $naziv = "nazivGrada";
        break;
      case 'drzava':
            $SQLparam1 = "drzavaID, nazivDrzave";
            $SQLparam2 = "drzave";
            $id = "drzavaID";
            $naziv = "nazivDrzave";
        break;
      default:
        echo "Greska!";
        break;
    }
    
  global $conn;
  require("connection.php");
  $SQL = "SELECT ".$SQLparam1." FROM ".$SQLparam2;
    $result = $conn->query($SQL);
    if ($result->num_rows > 0) {
        echo "<div class='filterParam'><span class='filterLabel'>".$filterType.": </span><select class='search-input' data-filterType='".$filterType."'>";
              while($row = $result->fetch_assoc()) {
                echo "<option value=".$row[$id].">".$row[$naziv]."</option>";
              }
        echo "</select><i class='fa fa-minus-square' onclick='removeFilter(this)'></i></div>";
    }
}

?>