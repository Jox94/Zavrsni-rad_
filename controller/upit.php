<?php
include 'functions.php';

/*Lista upita*/
$upitProd = "SELECT p.prodID, p.nazivRadJed, g.nazivGrada, d.nazivDrzave FROM prodavnice AS p, gradovi AS g, drzave AS d WHERE p.grad = g.gradID AND g.drzava = d.drzavaID AND prodId LIKE 'mp%' AND status = 1 ORDER BY d.rbr, g.rbr, p.rbr";
$upitDir = "SELECT p.prodID, p.nazivRadJed, g.nazivGrada, d.nazivDrzave FROM prodavnice AS p, gradovi AS g, drzave AS d WHERE p.grad = g.gradID AND g.drzava = d.drzavaID AND prodId LIKE 'dir%' AND status = 1 ORDER BY p.rbr";

/*Prihvatanje izora sa početne stranice*/
$prikaz ="";
if (isset($_REQUEST["prikaz"]) && !empty($_REQUEST["prikaz"])){
  $prikaz = $_REQUEST["prikaz"];
    switch ($prikaz) {
      case 'mp':
        ispisJed($upitProd);
        break;
      case 'dir':
        ispisJed($upitDir);
        break;
      default:
        echo "Greska!";
        break;
    }
}

$izborProd ="";
if (isset($_REQUEST["izborProd"]) && !empty($_REQUEST["izborProd"])){
  $izborProd = $_REQUEST["izborProd"];
  $upitRad = "SELECT z.id, z.ime, z.prezime,f.nazivFunkcije, z.slikaUrl, z.pdfUrl  FROM zaposleni AS z, funkcije AS f WHERE z.funkcija=f.fn AND z.vidljivost = 1 AND z.prodavnica = '".$izborProd ."' ORDER BY f.rbr";
  ispisRad($upitRad);
}

/*Prikaz sadržaja za izabrani sektor na početnoj stranici*/


 ?>
