<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>PWA - Projekt - Mateo Arlov</title>
</head>
<body>
    <header id="zaglavlje">
        <h1 class="wrapper">we<span>LT</span></h1>
    </header>
    <nav id="navigacija">
        <div class="wrapper">
            <ul>
                <li><a href="index.php">Naslovnica</a></li>
                <li><a href="kategorija.php?id=posao_karijere">Posao &#38; Karijera</a></li>
                <li><a href="kategorija.php?id=hrana">Hrana</a></li>
                <li><a href="administracija.php">Administracija</a></li>
                <li><a href="unos.php">Unos vijesti</a></li>
                <li><a href="registracija.php">Registracija</a></li>
            </ul>
        </div>
    </nav>
<main>
    <br>
    <section role="main">
        <form enctype="multipart/form-data" action="registracija.php" method="POST" class="registracija">
            
            <div>
                <label for="ime">Ime: </label>
                    <div class="form-field">
                        <input type="text" name="ime" id="ime">
                    </div>
                    <span id="porukaIme" class="bojaPoruke"></span>
            </div>
            <br>
            <div>
                <label for="about">Prezime: </label>
                    <div class="form-field">
                        <input type="text" name="prezime" id="prezime">
                    </div>
                    <span id="porukaPrezime" class="bojaPoruke"></span>
            </div>
            <br>
            <div>
                <label for="content">Korisničko ime:</label>
            <!-- Ispis poruke nakon provjere korisničkog imena u bazi -->
                    <div class="form-field">
                        <input type="text" name="username" id="username">
                        <span id="porukaUsername" class="bojaPoruke"></span>
                    </div>
            </div>
            <br>
            <div>
                <label for="lozinka">Lozinka: </label>
                    <div class="form-field">
                        <input type="password" name="pass" id="pass">
                    </div>
                <span id="porukaPass" class="bojaPoruke"></span>
            </div>
            <br>
            <div>
                <label for="lozinka_ponovno">Ponovite lozinku: </label>
                    <div class="form-field">
                        <input type="password" name="passRep" id="passRep">
                    </div>
                <span id="porukaPassRep" class="bojaPoruke"></span>
            </div>
            <br>
            <div>
                <button class="gumb_registracija gumb" type="submit" value="Registracija" id="registracija" name="registracija">Registracija</button>
            </div>
            <br>
        </form>

    </section>


    <?php
        if(isset($_POST['registracija'])){
            include 'connect.php';
            //Dohvaćanje varijabli iz forme
            $ime = $_POST['ime'];
            $prezime = $_POST['prezime'];
            $username = $_POST['username'];
            $lozinka = $_POST['pass'];
            $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH);
            $razina = 0;
            $registriranKorisnik = '';
            $msg = '';

            //Provjera postoji li u bazi već korisnik s tim korisničkim imenom
            $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
            $stmt = mysqli_stmt_init($dbc);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 's', $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
            }
            if(mysqli_stmt_num_rows($stmt) > 0){
                echo "Korisničko ime već postoji!";
                // $msg='Korisničko ime već postoji!';
            }else{
            // Ako ne postoji korisnik s tim korisničkim imenom - Registracija korisnika u bazi pazeći na SQL injection

            $sql = "INSERT INTO korisnik (ime, prezime,korisnicko_ime, lozinka, razina)VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($dbc);
            if (mysqli_stmt_prepare($stmt, $sql)) {

                mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $username, $hashed_password, $razina);
                mysqli_stmt_execute($stmt);

                $registriranKorisnik = true;
                
                if($registriranKorisnik == true) {
                    echo '<p>Korisnik je uspješno registriran!</p>';
                    } else {
                    echo '<p>Došlo je do greške, pokušajte ponovno!';
                }
            }
        }
            mysqli_close($dbc);
    }
    ?>

</main>
<script type="text/javascript">
    document.getElementById("registracija").onclick = function(event) {

        var slanjeForme = true;

        // Ime korisnika mora biti uneseno
        var poljeIme = document.getElementById("ime");
        var ime = document.getElementById("ime").value;
        if (ime.length == 0) {
            slanjeForme = false;
            poljeIme.style.border="1px dashed red";
            document.getElementById("porukaIme").innerHTML="<br>Unesite ime!<br>";
        } else {
            poljeIme.style.border="1px solid green";
            document.getElementById("porukaIme").innerHTML="";
        }

        // Prezime korisnika mora biti uneseno
        var poljePrezime = document.getElementById("prezime");
        var prezime = document.getElementById("prezime").value;
        if (prezime.length == 0) {
            slanjeForme = false;
            poljePrezime.style.border="1px dashed red";
            document.getElementById("porukaPrezime").innerHTML="<br>Unesite prezime!<br>";
        } else {
            poljePrezime.style.border="1px solid green";
            document.getElementById("porukaPrezime").innerHTML="";
        }

        // Korisničko ime mora biti uneseno
        var poljeUsername = document.getElementById("username");
        var username = document.getElementById("username").value;
        if (username.length == 0) {
            slanjeForme = false;
            poljeUsername.style.border="1px dashed red";
            document.getElementById("porukaUsername").innerHTML="<br>Unesite korisničko ime!<br>";        
        } else {
            poljeUsername.style.border="1px solid green";
            document.getElementById("porukaUsername").innerHTML="";
        }

        // Provjera podudaranja lozinki
        var poljePass = document.getElementById("pass");
        var pass = document.getElementById("pass").value;
        var poljePassRep = document.getElementById("passRep");
        var passRep = document.getElementById("passRep").value;
        if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
            slanjeForme = false;
            poljePass.style.border="1px dashed red";
            poljePassRep.style.border="1px dashed red";
            document.getElementById("porukaPass").innerHTML="<br>Lozinke nisu iste!<br>";
            document.getElementById("porukaPassRep").innerHTML="<br>Lozinke nisu iste!<br>";
        } else {
            poljePass.style.border="1px solid green";
            poljePassRep.style.border="1px solid green";
            document.getElementById("porukaPass").innerHTML="";
            document.getElementById("porukaPassRep").innerHTML="";
        }

    if (slanjeForme != true) {
    event.preventDefault();
    }
};

</script>
    <footer id="podnozje">
        <h1>we<span>LT</span></h1>
        <p>Mateo Arlov - marlov@tvz.hr - 2021./2022.</p>
    </footer>
</body>
</html>