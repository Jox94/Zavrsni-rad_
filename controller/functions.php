<?php
require ("connection.php");

function ispisJed($SQL){ /*Funkcija za konekciju i ispis prodavnica-sektora */
  global $conn;
  require("connection.php");
    $rezult = $conn->query($SQL);
    if ($rezult->num_rows > 0) {
      echo "<ul>";
       $grad = "";
       $drzava = "";
              // output data of each row
              while($red = $rezult->fetch_assoc()) {
                if($red['nazivDrzave'] != $drzava){
                  $drzava = $red['nazivDrzave'];
                  echo "<li class='drzava'>".$drzava."</li>";}
                if($red['nazivGrada'] != $grad){
                    $grad = $red['nazivGrada'];
                    echo "<li class='grad'>".$grad."</li>";
                  }
              echo "<li class='prodavnice' value='".$red['prodID']."'>".$red['nazivRadJed']."</li>";
              }
      echo "</ul>";
    }
}

function ispisRad($SQL){ /*Funkcija za konekciju i ispis zaposlenih */
  global $conn;
  require("connection.php");
    $rezult = $conn->query($SQL);
    if ($rezult->num_rows > 0) {
              // output data of each row
              $slika = "";
              while($red = $rezult->fetch_assoc()) {
                if($red['slikaUrl'] == "" ? $slika = 'dokumenti/slike/no_photo.jpg' : $slika = $red['slikaUrl']);
              echo "<div class='radnik'><a href='controller/review.php?id=".$red['id']."'>
              <img src='".$slika."' alt='".$red['id']."_".$red['ime']."_".$red['prezime']."' />
              </a>
              <p class='imeRadnika'>".$red['ime']." ".$red['prezime']."</p>
              <p class='fnRadnika'>".$red['nazivFunkcije']."</p>
              </div>";
              }
    }
}

function ajaxSearch($query){  /*Pretraga baze*/
  global $conn;
  require("connection.php");
  $SQLr = "SELECT DISTINCT z.id, z.ime, z.prezime,z.dRodjenja, z.dZaposlenja, z.obrazovanje, z.sektor, z.vidljivost, f.fn, f.nazivFunkcije, z.slikaUrl, p.prodID, p.nazivRadJed FROM zaposleni AS z, funkcije AS f, prodavnice AS p WHERE z.funkcija=f.fn AND p.prodID = z.prodavnica AND ".$query." ORDER BY funkcija";
  $SQLrj = "SELECT DISTINCT p.prodID, p.nazivRadJed, g.gradID, g.nazivGrada,d.nazivDrzave, d.drzavaID, p.status FROM prodavnice AS p,gradovi AS g, drzave AS d, zaposleni AS z WHERE g.gradID = p.grad AND d.drzavaID = g.drzava AND ".$query." ORDER BY p.nazivRadJed";
  $SQLg = "SELECT DISTINCT g.gradID, g.nazivGrada,d.nazivDrzave, d.drzavaID, p.status FROM prodavnice AS p,gradovi AS g, drzave AS d WHERE g.gradID = p.grad AND d.drzavaID = g.drzava AND ".$query." ORDER BY g.nazivGrada";


if (strpos($query, 'ime') || strpos($query, 'prezime')){
  $searchParam = '"radnik"';
  $rezult = $conn->query($SQLr);
  if ($rezult->num_rows > 0) {
    echo "<span id='closeList' onclick='closeList()'>x</span>";
    echo "<ul>";
            // output data of each row
            while($red = $rezult->fetch_assoc()) {
            echo "<li class='searchData' onclick='autoComplete(".$searchParam.")'>
            <img src='../" .$red['slikaUrl']. "' />
            <span>ID</span><span class='id'>". $red['id'] ."</span>
            <p class='radnik' data-vidljivost='".$red['vidljivost']."' data-dRodjenja='".$red['dRodjenja']."' data-obrazovanje='".$red['obrazovanje']."'><span class='imeRadnika'>".$red['ime']."</span> <span class='prezimeRadnika'>".$red['prezime']."</span></p>
            <p class='fnRadnika' data-funkcija='".$red['fn']."' data-dZaposlenja='".$red['dZaposlenja']."'>".$red['nazivFunkcije']."</p>
            <p class='posJed' data-sektor='".$red['sektor']."' data-prodId='".$red['prodID']."'>".$red['nazivRadJed']."</p>
            </li>";

          }
    echo "</ul>";
    }
  }
  elseif(strpos($query, 'nazivRadJed')){
    $searchParam = '"radJed"';
    $rezult = $conn->query($SQLrj);
    if ($rezult->num_rows > 0) {
      echo "<span id='closeList' onclick='closeList()'>x</span>";
      echo "<ul>";
              // output data of each row
              while($red = $rezult->fetch_assoc()) {
              echo "<li class='searchData' onclick='autoComplete(".$searchParam.")'>
              <p class='radJedSearch' data-id='".$red['prodID']."'>".$red['nazivRadJed']."</p>
              <p class='grad' data-gradID='".$red['gradID']."' data-status='".$red['status']."'>".$red['nazivGrada']."</p>
              <p class='drzava' data-drzavaID='".$red['drzavaID']."'>".$red['nazivDrzave']."</p>
              </li>";

            }
      echo "</ul>";
      }
    }
    else{
      $searchParam = '"grad"';
      $rezult = $conn->query($SQLg);
      if ($rezult->num_rows > 0) {
        echo "<span id='closeList' onclick='closeList()'>x</span>";
        echo "<ul>";
                // output data of each row
                while($red = $rezult->fetch_assoc()) {
                echo "<li class='searchData' onclick='autoComplete(".$searchParam.")'>
                <p class='grad' data-gradID='".$red['gradID']."' data-status='".$red['status']."'>".$red['nazivGrada']."</p>
                <p class='drzava' data-drzavaID='".$red['drzavaID']."'>".$red['nazivDrzave']."</p>
                </li>";

              }
        echo "</ul>";
        }
      }

  }

function editSelect($param){  /*Prikaz f-ja / radnih jedinica na osnovu izabranog sektora*/
  global $conn;
  require("connection.php");
  $param = $param;
  $SQLf ="SELECT f.fn, f.nazivFunkcije FROM funkcije AS f WHERE f.fn LIKE '".$param."%'";
  $SQLr ="SELECT p.prodID, p.nazivRadJed FROM prodavnice AS p WHERE p.prodID LIKE '".$param."%'";

      $rezult = $conn->query($SQLf);
  if ($rezult->num_rows > 0) {
            // output data of each row
            while($red = $rezult->fetch_assoc()) {
            echo "<option class='funkcija' value='".$red['fn']."'>".$red['nazivFunkcije']."</option>";
            }
          }
      $rezult = $conn->query($SQLr);
  if ($rezult->num_rows > 0) {
            // output data of each row
            while($red = $rezult->fetch_assoc()) {
            echo "<option class='prodSekt' value='".$red['prodID']."'>".$red['nazivRadJed']."</option>";
            }
          }
}

function fileUpload($dokument,$nazivFajla,$id){
  global $conn;
  require("connection.php");
$folder = "";
$kolona = "";
if($dokument == 'slika'){$folder='slike'; $kolona='slikaUrl';} else {$folder = "pdf"; $kolona='pdfUrl';};
  $errors= array();
	$file_name = $_FILES[$dokument]['name'];
	$file_size =$_FILES[$dokument]['size'];
	$file_tmp =$_FILES[$dokument]['tmp_name'];
	$file_type=$_FILES[$dokument]['type'];
  $fileExp = explode('.',$_FILES[$dokument]['name']);
	$file_ext=strtolower(end($fileExp));

	$expensions= array("jpeg","jpg","png","gif","pdf");
	if(in_array($file_ext,$expensions)=== false){
		$errors[]="Izabrani tip fajla nije dozvoljen, izaberi neki od navedenih: JPG, JPEG, PNG, GIF, PDF! ";
	}

  $putanja = $folder."/".$nazivFajla.".".$file_ext;

	if(empty($errors)==true){
		move_uploaded_file($file_tmp,"../dokumenti/".$putanja);
    $updateURL = "UPDATE zaposleni
                  SET ".$kolona." = 'dokumenti/".$putanja."'
                  WHERE ID = ".$id."";
    $conn->query($updateURL);
	}else{
		print_r($errors);

}
}

function mnemonik($param, $subjekat){
$i = 0;
$mnem = "";
if($subjekat == "rj"){
while ($i<strlen($param)){
$mnem .= substr($param, $i, 1);
$i += 2;};
}
if($subjekat == "grad" || $subjekat == "drzava"){
$mnem = substr($param, 0, 3);
}
echo $mnem."<br/>";
$mnem = str_replace(' ', '', $mnem);

return $mnem;
}

function reorder($query){
  global $conn;
  require("connection.php");

  $rezult = $conn->query($query);

  if ($rezult->num_rows > 0) {
      $id = null;
      $grad = "";
      $naziv = "";
        while($red = $rezult->fetch_assoc()) {
          if(isset($red['nazivGrada']) && $grad != $red['nazivGrada'] ){
            $grad = ', '.$red['nazivGrada'];
          }
          if(isset($red['fn'])){$id = $red['fn']; $naziv= $red['nazivFunkcije'];}
            if(isset($red['prodID'])){$id = $red['prodID']; $naziv=$red['nazivRadJed'].$grad;}
               if(isset($red['gradID'])){$id = $red['gradID']; $naziv=$red['nazivGrada'];}
                 if(isset($red['drzavaID'])){$id = $red['drzavaID']; $naziv=$red['nazivDrzave'];}

          echo "<li class='ui-state-default' data-id='".$id."' >".$naziv."</li>";
      }
}
}

function orderUpdate($raspored,$query,$id){
  global $conn;
  require("connection.php");
  $query= $query;
  $raspored = $raspored;
  $id = $id;
  foreach ($raspored as $key => $value) {
    $conn->query($query.$value."' WHERE ".$id."='".$key."'");
}
}
function checkNotification(){
	global $conn;
	$SQL = "SELECT COUNT(readed) AS BrojPoruka FROM notification WHERE readed = 0";
	$result = $conn->query($SQL);
	
	if ($result->num_rows > 0) {
              while($red = $result->fetch_assoc()) {				  
                echo $red['BrojPoruka'];              
              }
    }
}

function fetchNotification(){
	global $conn;
    $SQL = "SELECT * FROM notification";
    $result = $conn->query($SQL);

    if ($result->num_rows > 0) {
		
       	echo "<table><thead><th>ID</th><th>Korisnik</th><th>Aktivnost</th><th>Vreme</th></thead>";
		$status = "";
              while($red = $result->fetch_assoc()) {
				  if($red['readed']==1 ? $status="read" : $status="unread");				  
                echo "<tr class='".$status."'><td>".$red['id']."</td><td>".$red['user']."</td><td>".$red['action']."</td><td>".$red['date']."</td></tr>";              
              }
		
        echo "</table>";
    }
}

function updateNotification($action){
	global $conn;
	$SQL = "";
	if($action!="read" || $action!="unread"){
		$SQL = "INSERT INTO notification (action) VALUES ('".$action."')";
	} else {
		$SQL = "UPDATE notification (action) VALUES ('".$action."')";
	}
	$conn->query($SQL);
	
	
}
?>
