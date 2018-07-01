<!DOCTYPE html>
<html lang="rs">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Baza zaposlenih</title>
  <link rel="stylesheet" href="../css/baza.css" />
  <link rel="stylesheet" href="../css/baza_mobile.css" />
</head>
<body>
<div class="topBar">
  <div class="container">
    <a href="javascript: void(0)" onclick="home()">Pregled</a>
    <a href="/controller/admin.php">Admin</a>
  </div>
</div>
<div class="container">

<?php
include "functions.php";

function ispis($SQL){ /*Funkcija za konekciju i ispis zaposlenih */
  global $conn;
  require("connection.php");
    $rezult = $conn->query($SQL);
    if ($rezult->num_rows > 0) {
              // output data of each row
              $slika = "";
              while($red = $rezult->fetch_assoc()) {
                if($red['slikaUrl'] == "" ? $slika = 'dokumenti/slike/no_photo.jpg' : $slika = $red['slikaUrl']);
              echo "<div class='rRadnik'><a href='../".$slika."' alt='".$red['id']."_".$red['ime']."_".$red['prezime']."'>
              <img class='slikaRadnika' src='../".$slika."' alt='".$red['id']."_".$red['ime']."_".$red['prezime']."' />
              </a>
              <div id='tabela'>
			  <table>
			  <tr><td>Ime i prezime:</td><td><p class='imeRadnika'>".$red['ime']." ".$red['prezime']."</p></td></tr>
			  <tr><td>Datum rodjenja:</td><td><p class='dRodjenja'>".$red['dRodjenja']."</p></td></tr>
			  <tr><td>Obrazovanje:</td><td><p>".$red['obrazovanje']."</p></td></tr>
			  <tr><td>Datum zaposlenja:</td><td><p class='dZaposlenja'>".$red['dZaposlenja']."</p></td></tr>
              <tr><td>Radno messto:</td><td> <p class='fnRadnika'>".$red['nazivFunkcije']."</p></td></tr>
			  <tr><td>CV radnika:</td><td> <p class='cv'><a href='../".$red['pdfUrl']."'>CV zapslenog</a></p></td></tr>

			  </table>
              </div></div>";
              }
    }
}

  $id = $_REQUEST["id"];
  $upitRad = "SELECT z.id, z.ime, z.prezime,z.dRodjenja,z.dZaposlenja,z.obrazovanje,f.nazivFunkcije, z.slikaUrl, z.pdfUrl  FROM zaposleni AS z, funkcije AS f WHERE z.funkcija=f.fn AND z.vidljivost = 1 AND z.id = '".$id ."' ORDER BY z.funkcija";
  ispis($upitRad);

?>

</div>
</body>
<script src="/js/functions.js"></script>

</html>
