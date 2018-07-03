<?php
include "connection.php";
include "functions.php";

if(isset($_POST['sektor']) && isset($_POST['ime']) && isset($_POST['prezime']) && isset($_POST['funkcija']) && isset($_POST['radJed'])){
$sektor = $_POST['sektor'];
$ime = $_POST['ime'];
$prezime = $_POST['prezime'];
$funkcija = $_POST['funkcija'];
$radJed = $_POST['radJed'];
$aktivan = isset($_POST['vidljivost']);
$dRodj = $_POST['dRodjenja'];
$obraz = $_POST['obrazovanje'];
$dZapos = $_POST['dZaposlenja'];


if(isset($_POST['id']) && $_POST['id'] != ""){ /* UPDATE */
  $id = $_POST['id'];
  $nazivFajla = $id."_".$ime."_".$prezime;
  $updateQry = "UPDATE zaposleni
                SET ime = '".$ime."', prezime = '".$prezime."', dRodjenja = '".$dRodj."', obrazovanje = '".$obraz."', dZaposlenja = '".$dZapos."' ,funkcija = '".$funkcija."', sektor = '".$sektor."', prodavnica = '".$radJed."', vidljivost = '".$aktivan."', slikaUrl = 'dokumenti/slike/".$nazivFajla.".jpg'
                WHERE ID = ".$id."";
  $conn->query($updateQry);

  if(isset($_FILES['slika']) && $_FILES['slika']['size'] != 0){
    $dokument = 'slika';
    fileUpload($dokument,$nazivFajla,$id);
  }
  if(isset($_FILES['pdf']) && $_FILES['pdf']['size'] != 0){
    $dokument = 'pdf';
    fileUpload($dokument,$nazivFajla,$id);
  }
  echo "Podaci o radniku su ažurirani - povratak na stranicu za dodavanje / ažuriranje";
  header( "refresh:2;url=admin.php");
}
else {                                      /* INSERT */
  $insertQry = "INSERT INTO zaposleni (ime, prezime, dRodjenja, obrazovanje, dZaposlenja, funkcija, sektor, prodavnica, vidljivost)
                VALUES ('".$ime."', '".$prezime."','".$dRodj."', '".$obraz."' , '".$dZapos."', '".$funkcija."', '".$sektor."', '".$radJed."','".$aktivan."')";
  $rez = $conn->query($insertQry);

  $newID = mysqli_insert_id($conn); /* +1 */
  $nazivFajla = $newID."_".$ime."_".$prezime;

  if(isset($_FILES['slika']) && $_FILES['slika']['size'] != 0){
    $dokument = 'slika';
    fileUpload($dokument,$nazivFajla,$newID);
  }
  if(isset($_FILES['pdf']) && $_FILES['pdf']['size'] != 0){
    $dokument = 'pdf';
    fileUpload($dokument,$nazivFajla,$newID);
  }

  echo "Podaci o radniku su ažurirani - povratak na stranicu za dodavanje / ažuriranje";
  header( "refresh:2;url=admin.php");

}

}

if(isset($_POST['sektor']) && isset($_POST['nazivRj']) && isset($_POST['grad']) && isset($_POST['drzavaRj']) && isset($_POST['statusRj'])){
$sektor = $_POST['sektor'];
$nazivRj = $_POST['nazivRj'];
$grad = $_POST['grad'];
$gradID = mnemonik($grad, 'grad');
$drzava = $_POST['drzavaRj'];
$drzavaID = mnemonik($drzava, 'drzava');
$status = isset($_POST['statusRj']);
$naziv = mnemonik($nazivRj,'rj');

if(isset($_POST['idStore']) && $_POST['idStore'] != ""){ /* UPDATE */
  $idStore = $_POST['idStore'];
  $updateQry = "UPDATE prodavnice
                SET prodID = '".$sektor.$naziv."' nazivRadJed = '".$nazivRj."', grad = '".$grad."', drzava = '".$drzava."', status = '".$status."' WHERE prodID = ".$idStore." ";
  $conn->query($updateQry);

  echo "Podaci o radnoj jedinici su ažurirani - povratak na stranicu za dodavanje / ažuriranje";
  header( "refresh:2;url=admin.php");
}
else {                        /* INSERT */
  $rbr = $conn->query("SELECT MAX(rbr) as rb FROM prodavnice");
  $rbr = $rbr->fetch_assoc();
  $rbr = $rbr["rb"] + 1;
  $rbrG = $conn->query("SELECT MAX(rbr) as rb FROM gradovi");
  $rbrG = $rbrG->fetch_assoc();
  $rbrG = $rbrG["rb"] + 1;
  $rbrD = $conn->query("SELECT MAX(rbr) as rb FROM drzave");
  $rbrD = $rbrD->fetch_assoc();
  $rbrD = $rbrD["rb"] + 1;

  $conn->query("INSERT INTO drzave (drzavaID, nazivDrzave, rbr)
                VALUES ('".$drzavaID."','".$drzava."','".$rbrD."') ");

  $conn->query("INSERT INTO gradovi (gradID, nazivGrada, drzava, rbr)
                VALUES ('".$gradID."','".$grad."','".$drzavaID."','".$rbrG."')");

  $conn->query("INSERT INTO prodavnice (prodID, nazivRadJed, grad, rbr, status)
                VALUES ('".$sektor.$naziv.$rbr."', '".$nazivRj."', '".$gradID."', '".$rbr."', '".$status."' )");


  echo "Podaci o radnoj jedinici su ažurirani - povratak na stranicu za dodavanje / ažuriranje";
  header( "refresh:2;url=admin.php");

}

}

if(isset($_POST['noviRaspored']) && isset($_POST['parametar'])){
  $noviRaspored = $_POST['noviRaspored'];
  $orderParametar = $_POST['parametar'];
  $id = null;
  switch ($orderParametar) {
    case 'funkcije':
        $id = 'fn';
      break;
        case 'prodavnice':
        $id = 'prodID';
      break;
        case 'gradovi':
        $id = 'gradID';
      break;
        case 'drzave':
        $id = 'drzavaID';
      break;
    default:
      echo "RASPORED - Greska!";
      break;
  }
  $query = "UPDATE ".$orderParametar." SET rbr = '";
  orderUpdate($noviRaspored,$query,$id);
  
  $msg = "Azuriran je raspored u sekciji ".$orderParametar;
  updateNotification($msg);
}

$conn->close();
 ?>
