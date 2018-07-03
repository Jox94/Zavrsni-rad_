<?php include "functions.php"; ?>

<div class="topBar">
  <div class="container">
    <a href="javascript: void(0)" onclick="home()">Pregled</a>
    <a href="reorder.html">Sortiranje</a>
    <a href="notification.php">Notification <span><?php checkNotification(); ?></span></a>
    <a href="javascript:void(0)" id="user_logout">Odjava</a>
  </div>
</div>
<div class="container">
<div id='addUpdateForma'>
<h3>Ažuriranje/unos radnika</h3>
        <form method="POST" action="addUpdate.php" enctype="multipart/form-data">
          <table>
              <tr>
                <td>Maloprodaja <input type="radio" id="mpSektor" name="sektor" value="mp" onchange="editDropDown(this.value)"/></td>
                <td>Direkcija <input type="radio" id="dirSektor" name="sektor" value="dir" onchange="editDropDown(this.value)"/></td>
              </tr>
              <tr>
                <input name="id" hidden />
                <td>Ime: </td>
                <td><input type="text" id="ime" name="ime" onkeyup="update(this.getAttribute('name')+'='+this.value)" required/> </td>
              </tr>
              <tr>
                <td>Prezime: </td>
                <td><input type="text" id="prezime" name="prezime" value="" onkeyup="update(this.getAttribute('name')+'='+this.value)" required/>
                  <div id="rezultat"></div>
                </td>
              </tr>
              <tr>
			  <tr>
                <td>Datum rođenja: </td>
                <td><input type="date" id="dRodjenja" name="dRodjenja" value="1900-01-01" /></td>
              </tr>
              <tr>
			  <tr>
                <td>Obrazovanje: </td>
                <td><input type="text" id="obrazovanje" name="obrazovanje" value="" required/>
                </td>
              </tr>
              <tr>
			  <tr>
                <td>Datum zaposlenja: </td>
                <td><input type="date" id="dZaposlenja" name="dZaposlenja" value="1900-01-01" /></td>
              </tr>
              <tr>
                <td>Funkcija: </td>
                <td><select id="formFn" value="" name="funkcija" required></select></td>
              </tr>
              <tr>
                <td>Prodavnica / sektor: </td>
                <td><select id="formJed" value="" name="radJed" required></select></td>
              </tr>
              <tr>
                <td>Aktivan: </td>
                <td><input type="checkbox" id="vidljivost" name="vidljivost" value="1" /></td>
              </tr>
              <tr>
                <td>Dodajte sliku: </td>
                <td><input id="frmSlika" type="file" name="slika" placeholder="Izaberite sliku" accept=".jpg, .jpeg, .png, .gif"/></td>
              </tr>
              <tr>
                <td>Dodajte PDF: </td>
                <td><input type="file" name="pdf" placeholder="Izaberite PDF" accept=".pdf"/></td>
              </tr>
              <tr>
                <td></td>
                <td><input type="submit" value="Pošalji" name="submit"></td>
              </tr>
          </table>
        </form>   <!-- Forma za dodavanje / azuriranje radnika -->
    </div>
<div id="storeAddUpdate"><!-- Forma za dodavanje / azuriranje radnih jedinica -->
<h3>Ažuriranje/unos radnih jedinica</h3>
      <form method="POST" action="addUpdate.php">
        <table>
            <tr>
              <td>Maloprodaja <input type="radio" id="mpSektor" name="sektor" value="mp"/></td>
              <td>Direkcija <input type="radio" id="dirSektor" name="sektor" value="dir"/></td>
            </tr>
            <tr>
              <input name="idStore" hidden />
              <td>Naziv radne jedinice: </td>
              <td><input type="text" id="nazivRj" name="nazivRj" onkeyup="update(this.getAttribute('name')+'='+this.value)" required autocomplete="off"/> </td>
              <div id="rezultatStore"></div>
            </tr>
            <tr>
              <td>Grad: </td>
              <td><input type="text" id="gradRj" name="grad" onkeyup="update(this.getAttribute('name')+'='+this.value)" required autocomplete="off"/>
              <div id="rezultatGrad"></div>
            </td>

            </tr>
            <tr>
              <td>Država: </td>
              <td><input type="text" id="drzavaRj" name="drzavaRj" value="" required autocomplete="off"/>
              </td>
            </tr>
            <tr>
              <td>Aktivna: </td>
              <td><input type="checkbox" id="statusRj" name="statusRj" value="1" /></td>
            </tr>
            <tr>
              <td></td>
              <td><input type="submit" value="Pošalji" name="submit"></td>
            </tr>
        </table>
      </form>
    </div>

</div>
  <script src="/js/jquery.js"></script>
<script>
$(function logOut(){
    $('#user_logout').on('click', function(e){
        // HTTPAuth Logout code based on: http://tom-mcgee.com/blog/archives/4435
        e.preventDefault();
        try {
            // This is for Firefox
            $.ajax({
                // This can be any path on your same domain which requires HTTPAuth
                url: "/controller/admin.php",
                username: 'reset',
                password: 'reset',
                // If the return is 401, refresh the page to request new details.
                statusCode: { 401: function() {
                    alert('Uspešno ste se odjavili.');
                    document.location = "/";
                    }
                }
            });

        } catch (exception) {
            // Firefox throws an exception since we didn't handle anything but a 401 above
            // This line works only in IE
            if (!document.execCommand("ClearAuthenticationCache")) {
                // exeCommand returns false if it didn't work (which happens in Chrome) so as a last
                // resort refresh the page providing new, invalid details.
                alert('Uspešno ste se odjavili.');
                document.location = "http://reset:reset@" + document.location.hostname + document.location.pathname;
            }
        }

    });

});
</script>
