
function storeList(izbor) { /*AJAX request*/
  /*var izbor = "prikaz="+izbor;*/
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) { /*Obradjuje izbor sektora mp-dir*/
  if (izbor == 'prikaz=mp'|| izbor == 'prikaz=dir') {
  document.getElementById("radJedinice").innerHTML = this.responseText;
  prodavnica();
}
else {  /*Ispisuje odgovor za izabranu prodavnicu*/
  document.getElementById("lista").innerHTML = this.responseText;
     }
}};
  xhttp.open("POST", "controller/upit.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(izbor);
}

function sektor(izborBtn) {  /*Pocetna strana - izbor sektora*/
  // document.getElementById("homeSelect").style.display = "none";
  document.getElementById("content").style.display = "block";
  sessionStorage.setItem("sektor", izborBtn);
  izborBtn = "prikaz="+izborBtn;
  storeList(izborBtn);
}

function prodavnica(){  /*Izbor prodavnice za prikaz radnika*/
  var prodID = document.getElementsByClassName('prodavnice');
  var izborProd = "";
  for (var i=0; i<prodID.length;i++){
    prodID[i].addEventListener('click',function(){
      izborProd = "izborProd="+this.getAttribute('value');
      storeList(izborProd);
      sessionStorage.setItem("radJedinica", this.getAttribute('value'));
      sessionStorage.setItem("nazivRadJed", this.innerHTML);
      document.getElementById("naslov").innerHTML = this.innerHTML;
	// mobMenu("hide");
    });
  }
}

function history(){
  if(sessionStorage.getItem("sektor")){
      var sek = sessionStorage.getItem("sektor");
      sektor(sek);
    if(sessionStorage.getItem("radJedinica")){
      var radJed = "izborProd="+sessionStorage.getItem("radJedinica");
      storeList(radJed);
    }
  }
}

function update(pretraga) { /*AJAX request*/
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) { /*Obradjuje izbor sektora mp-dir*/
  if(pretraga.includes("ime") || pretraga.includes("prezime")){
    document.getElementById("rezultat").innerHTML = this.responseText;
  }
  else if(pretraga.includes("grad")){
    document.getElementById("rezultatGrad").innerHTML = this.responseText;
  }
  else{
    document.getElementById("rezultatStore").innerHTML = this.responseText;
  }
}};
  xhttp.open("POST", "../controller/update.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(pretraga);
}

function editDropDown(editParam){
  var editParam ="editParam=" + editParam;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) { /*Obradjuje izbor sektora mp-dir*/
    document.getElementsByClassName("container").innerHTML = this.responseText;
    var odgovor = this.responseText;
    $("#formFn").html($(odgovor).filter('.funkcija'));
    $("#formJed").html($(odgovor).filter('.prodSekt'));
  }};
    xhttp.open("POST", "../controller/update.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(editParam);
}

function closeList(){
   document.getElementById('rezultat').innerHTML = '';
   document.getElementById('rezultatStore').innerHTML = '';
}

function autoComplete(parametar){
  if(parametar == 'radnik'){
  $('.searchData').click(function() {
    $("input[name='id']").val($(this).find('span.id').text()); /*POSTAVlJA ID u Input Hidden*/
    var sektor = $(this).find('p.posJed').attr('data-sektor');
    if(sektor == 'mp' ? sektor='mp' : sektor='dir');
      $("input[id^="+sektor+"]").prop('checked',true);
      editDropDown(sektor);

    $('input#ime').val($(this).find('span.imeRadnika').text());
    $('input#prezime').val($(this).find('span.prezimeRadnika').text());

	$('input#dRodjenja').val($(this).find('p.radnik').attr('data-drodjenja'));
	$('input#obrazovanje').val($(this).find('p.radnik').attr('data-obrazovanje'));
	$('input#dZaposlenja').val($(this).find('p.fnRadnika').attr('data-dzaposlenja'));

    var fn = $(this).find('p.fnRadnika').attr('data-funkcija');                       /*Popunjavanje SELECT elementa na odabir radnika*/
    var prod = $(this).find('p.posJed').attr('data-prodID');
    setTimeout(function(){
      $("select#formFn").find($(".funkcija[value="+fn+"]")).prop('selected',true);
      $("select#formJed").find($(".prodSekt[value="+prod+"]")).prop('selected',true);
    },300);

    var status = $(this).find('p.radnik').attr('data-vidljivost');
    if(status == 1 ? status=true : status=false);
    $("#vidljivost").prop("checked", status);                                                                            /*KRAJ Popunjavanje SELECT elementa*/
});}

if(parametar == 'radJed'){
$('.searchData').click(function() {
var id = $(this).find('p.radJedSearch').attr('data-id');
$("input[name='idStore']").val(id); /*POSTAVlJA ID u Input Hidden*/
  $('input#nazivRj').val($(this).find('p.radJedSearch').text());
  $('input#gradRj').val($(this).find('p.grad').text());
  $('input#drzavaRj').val($(this).find('p.drzava').text());

  var status = $(this).find('p.grad').attr('data-status');
  if(status == 1 ? status=true : status=false);
  $("#statusRj").prop("checked", status);                                                                            /*KRAJ Popunjavanje SELECT elementa*/
});
}
if(parametar == 'grad'){
$('.searchData').click(function() {

  $('input#gradRj').val($(this).find('p.grad').text());
  $('input#drzavaRj').val($(this).find('p.drzava').text());

  var status = $(this).find('p.grad').attr('data-status');
  if(status == 1 ? status=true : status=false);
  $("#statusRj").prop("checked", status);                                                                            /*KRAJ Popunjavanje SELECT elementa*/
});
}
}

function reorder(orderParam){
  orderParam = "orderParam="+orderParam;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) { /*Obradjuje izbor sektora mp-dir*/
    document.getElementById("sortable").innerHTML = this.responseText;
  }};
    xhttp.open("POST", "../controller/update.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(orderParam);
}

function reorder(orderParam){
  sessionStorage.setItem("orderParam",orderParam);
  orderParam = "orderParam="+orderParam;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) { /*Obradjuje izbor sektora mp-dir*/
    document.getElementById("sortable").innerHTML = this.responseText;
      $( "#sortable" ).sortable();
      $( "#sortable" ).disableSelection();

  }};
    xhttp.open("POST", "../controller/update.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(orderParam);

}

function saveReorder(){
  var provera = prompt('Da li ste sigurni?','Upišite DA ako želite da sačuvate raspored');
  if (provera == 'DA') {
  var lista = document.getElementById("sortable");
  var child = lista.getElementsByTagName("li");
  var array = {};
  for(var i=0; i<=child.length-1; i++){
    array[child[i].getAttribute('data-id')]=i;
  }
  var orderParam = sessionStorage.getItem("orderParam");
  var request = $.ajax({
        url: "../controller/addUpdate.php",
        type: "post",
        data: {'noviRaspored':array,'parametar': orderParam}
      }
    );
    request.done(function (response, textStatus, jqXHR){
  alert('Novi raspored je sačuvan!');
        });
}
}

function home(){
  sessionStorage.removeItem("sektor");
  window.location.href = "/";
  // document.getElementById("homeSelect").style.display = "block";
  document.getElementById("content").style.display = "none";
}

function mobMenu(param){
	var radJedinica = document.getElementById('radJedinice');
		if(param == "hide"){
		radJedinica.style.animationName = "hide";
	}
	else{
	if(radJedinica.style.animationName != "show"){
		radJedinica.style.animationName = "show";
	}
	else {
		radJedinica.style.animationName = "hide";
	}
	}

}

var brojac = -1;
function listanje(param){
var rj = document.getElementsByClassName('prodavnice');

    for(var i=0;i<rj.length;i++){
        {(function(index){
        rj[i].onclick = function(){
         brojac = index;
            }    
        })(i);
        }
}

if(param == "napred"){
	if(brojac >= rj.length-1){
		brojac = 0;
		rj[brojac].click();
	}
	else {
		brojac = brojac + 1; 
		rj[brojac].click();
	}
}


if(param == "nazad"){
	if(brojac <= 0){
		brojac = rj.length-1;
		rj[brojac].click();}
	else{
		brojac = brojac - 1; 
		rj[brojac].click();
	}
}
}

function addFilter() {
    var filterType = document.getElementById('filterType').value;
    var filteri = document.getElementById('search-filters');
    var xhttp = new XMLHttpRequest();
    var tip = "filterType="+filterType;
xhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) { 
    filteri.innerHTML += this.responseText; 
}
};
  xhttp.open("POST", "../controller/addFilter.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(tip);
}

function removeFilter(element){
 element.parentNode.parentNode.removeChild(element.parentNode);
    }

function readUnread(id,notif){
	var notif = notif;
	if(notif=="read" ? notif = 0 : notif = 1);
	
    var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
if (this.readyState == 4 && this.status == 200) {
    notif.setAttribute('class',this.responseText); 
}
};
  xhttp.open("POST", "../controller/notification.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("notif="+notif);
	
}

