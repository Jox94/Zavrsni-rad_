<?php
include "connection.php";
require("functions.php");

$flname = "";
$query = "";
$grad = "";
if(isset($_REQUEST['prezime'])){ /*AJAX LIVE SEARCH*/
  $flname = $_REQUEST['prezime'];
  $query = "z.prezime LIKE '".$flname."%'";
  ajaxSearch($query);
}
if(isset($_REQUEST['ime'])){ /*AJAX LIVE SEARCH*/
  $flname = $_REQUEST['ime'];
  $query = "z.ime LIKE '".$flname."%'";
  ajaxSearch($query);
}
if(isset($_REQUEST['editParam'])){
  $editParam = $_REQUEST['editParam'];
  editSelect($editParam);
}
if(isset($_REQUEST['nazivRj'])){ /*AJAX LIVE SEARCH*/
  $radJed = $_REQUEST['nazivRj'];
  $query = "p.nazivRadJed LIKE '".$radJed."%'";
  ajaxSearch($query);
}
if(isset($_REQUEST['grad'])){ /*AJAX LIVE SEARCH - GRADOVI*/
  $grad = $_REQUEST['grad'];
  $query = "g.nazivGrada LIKE '".$grad."%'";
  ajaxSearch($query);
}
if(isset($_REQUEST['orderParam'])){ /*REORDER*/
  $orderParam = $_REQUEST['orderParam'];
  $query = "";
  switch ($orderParam) {
    case 'funkcije':
        $query = "SELECT DISTINCT fn, nazivFunkcije FROM Funkcije ORDER BY rbr";
      break;
      case 'prodavnice':
        $query = "SELECT DISTINCT p.prodID, p.nazivRadJed, g.nazivGrada FROM prodavnice AS p, gradovi AS g WHERE p.grad = g.gradID ORDER BY g.rbr,p.rbr";
      break;
      case 'gradovi':
        $query = "SELECT DISTINCT g.gradID, g.nazivGrada, d.nazivDrzave FROM drzave AS d, gradovi AS g WHERE d.drzavaID = g.drzava ORDER BY g.rbr";
      break;
      case 'drzave':
        $query = "SELECT DISTINCT drzavaID, nazivDrzave FROM Drzave ORDER BY rbr";
      break;
    default:
      echo "Greska!";
      break;
  }
  reorder($query);

}


$conn->close();
 ?>
