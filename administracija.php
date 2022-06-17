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
                <li><a href="kategorija.php?id=posaoikarijera">Posao &#38; Karijera</a></li>
                <li><a href="kategorija.php?id=hrana">Hrana</a></li>
                <li><a href="administracija.php">Administracija</a></li>
                <li><a href="unos.php">Unos vijesti</a></li>
                <li><a href="registracija.php">Registracija</a></li>
            </ul>
        </div>
    </nav>
    <main>
        <br>
        <form action="administracija.php" method="post" enctype="multipart/form-data" class="prijava">
            <label for="korisnicko_ime">Korisničko ime:</label><br>
            <input type="text" name="username" id="username"><br>
            <span id="porukaKorisnickoime" class="bojaPoruke"></span>
            <br>
            <label for="lozinka">Lozinka:</label><br>
            <input type="password" name="lozinka" id="lozinka"><br>
            <span id="porukaLozinka" class="bojaPoruke"></span>
            <br>
            <button type="submit" value="prijava" name="prijava" id="prijava" class="gumb_registracija">Prijava</button>
            <br>
        </form>
        <script type="text/javascript">
            document.getElementById("prijava").onclick = function(event){
                var slanjeForme = true;

                //Korisničko ime mora biti uneseno
                var poljeKime = document.getElementById("username");
                var kime = document.getElementById("username").value;
                if (kime.length == 0) {
                    slanjeForme = false;
                    poljeKime.style.border="1px dashed red";
                    document.getElementById("porukaKorisnickoime").innerHTML="<br>Unesite korisnicko ime!<br>";
                } else {
                    poljeKime.style.border="1px solid green";
                    document.getElementById("porukaKorisnickoime").innerHTML="";
                    }

                //Lozinka mora biti unesena
                var poljeLozinka = document.getElementById("lozinka");
                var lozinka = document.getElementById("lozinka").value;
                if (lozinka.length == 0) {
                    slanjeForme = false;
                    poljeLozinka.style.border="1px dashed red";
                    document.getElementById("porukaLozinka").innerHTML="<br>Unesite lozinku!<br>";
                } else {
                    poljeLozinka.style.border="1px solid green";
                    document.getElementById("porukaLozinka").innerHTML="";
                    }
                    
                    if (slanjeForme != true) {
                        event.preventDefault();
                        }
        }
        </script>
        <?php
            session_start();
            include 'connect.php';
            define('UPLPATH', 'images/');
            error_reporting(E_ERROR | E_PARSE);
            if (isset($_POST['prijava'])) {

                //Dohvaćanje varijabli iz forme
                $prijavaImeKorisnika = $_POST['username'];
                $prijavaLozinkaKorisnika = $_POST['lozinka'];

                //Upit koji povezuje korisničko ime sa bazom
                $sql = "SELECT korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
                $stmt = mysqli_stmt_init($dbc);
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                }
                mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika);
                mysqli_stmt_fetch($stmt);

                //Provjera lozinke
                if (password_verify($_POST['lozinka'], $lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0) {

                    $uspjesnaPrijava = true;

                    // Provjera da li je admin
                        if($levelKorisnika == 1) {
                            $admin = true;
                        } else {
                            $admin = false;
                        }
                    }
                    //postavljanje session varijabli
                    $_SESSION['$username'] = $imeKorisnika;
                    $_SESSION['$level'] = $levelKorisnika;

                    } else {
                        $uspjesnaPrijava = false;
                    }            
        ?>

        <?php
        // Pokaži stranicu ukoliko je korisnik uspješno prijavljen i administrator je
        if (($uspjesnaPrijava == true && $admin == true) || (isset($_SESSION['$username'])) && $_SESSION['$level'] == 1) {
            $query = "SELECT * FROM pwa_tablica";
            $result = mysqli_query($dbc, $query);
            while($row = mysqli_fetch_array($result)){
                echo '
        <form enctype="multipart/form-data" action="administracija.php" method="POST" class="administracija">

            <div class="form-item">
                <label for="title">Naslov vijesti</label>
                    <div class="form-field">
                        <input type="text" name="title" class="form-field-textual" 
                        value="'.$row['naslov'].'">                    
                    </div>
            </div>

            <div class="form-item">
                <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
                    <div class="form-field">
                    <textarea name="about" id="" cols="30" rows="10" class="form-field-textual">'.$row['sazetak'].'</textarea>
                    </div>
            </div>

            <div class="form-item">
                <label for="content">Sadržaj vijesti</label>
                    <div class="form-field">
                        <textarea name="content" id="" cols="30" rows="10" class="form-field-textual">'.$row['tekst'].'</textarea>
                    </div>
            </div>

            <div class="form-item">
                <label for="image">Slika: </label>
                    <div class="form-field">
                        <input type="file" accept="image/jpg,image/gif,image/jpeg" class="input-text" id="image" 
                        value="'.$row['slika'].'" name="image"/> <br><img src="' . UPLPATH . 
                        $row['slika'] . '" width=100px>
                    </div>
            </div>

            <div class="form-item">
                <label for="category">Kategorija vijesti</label>
                    <div class="form-field">
                    <select name="category" id="" class="form-field-textual" 
                    value="'.$row['kategorija'].'">                    
                            <option value="posaoikarijera">Posao &#38; Karijera</option>
                            <option value="hrana">Hrana</option>
                        </select>
                    </div>
            </div>
            <br>
            <div class="form-item">
                <div class="form-field">
                    
                    <label>Spremiti u arhivu:
                    <div class="form-field">';
                        if($row['arhiva'] == 0) {
                        echo '<input type="checkbox" name="archive" id="archive"/> 
                        Arhiviraj?';
                        } else {
                        echo '<input type="checkbox" name="archive" id="archive" 
                        checked/> Arhiviraj?';
                        }
                        echo '</div>
                    </label>
                
                </div>
            </div>
            <br>
            <div class="form-item">
                <input type="hidden" name="id" class="form-field-textual" 
                value="'.$row['id'].'">            
                <button type="reset" value="Poništi"  class="gumb gumb_cancel">Poništi</button>
                <button type="submit" value="Prihvati" name="prihvati"  class="gumb gumb_accept">Prihvati</button>
                <button type="submit" value="Izmjeni" name="update" class="gumb gumb_update">Izmjeni</button>
                <button type="submit" name="delete" value="Izbriši" class="gumb gumb_delete"> Izbriši</button>
            </div>
            <br>
            <hr>
        </form>
        ';
            }   
        } elseif($uspjesnaPrijava == true && $admin == false){
            echo '<p>Bok ' . $imeKorisnika . '! Uspješno ste prijavljeni, ali niste administrator.</p>';
        } elseif (isset($_SESSION['$username']) && $_SESSION['$level'] == 0){
            echo '<p>Bok ' . $_SESSION['$username'] . '! Uspješno ste prijavljeni, ali niste administrator.</p>';
        } elseif ($uspjesnaPrijava == false){
            echo '<br><span class="login_msg">Logiraj se!</span><br>';
        }
        ?>
                <?php
                    //Upiti
                        //Delete
                        if(isset($_POST['delete'])){
                            $id=$_POST['id'];
                            $delete = "DELETE FROM pwa_tablica WHERE id=$id ";
                            $result_delete = mysqli_query($dbc, $delete);
                            mysqli_close($dbc);
                        }

                        //Update
                        if(isset($_POST['update'])){
                            $picture = $_FILES['image']['name'];
                            $title=$_POST['title'];
                            $about=$_POST['about'];
                            $content=$_POST['content'];
                            $category=$_POST['category'];
                            if(isset($_POST['archive'])){
                            $archive=1;
                            }else{
                            $archive=0;
                            }
                            $target_dir = 'images/'.$picture;
                            move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir);

                            $update = "INSERT INTO pwa_tablica (datum, naslov, sazetak, tekst, slika, kategorija, 
                            arhiva ) VALUES ('$date', '$title', '$about', '$content', '$picture', 
                            '$category', '$archive')";

                            $result_update = mysqli_query($dbc, $update) or die('Error querying databese.');
                            mysqli_close($dbc);
                        }                 
        ?>
        <br>
    </main>
    <footer id="podnozje">
        <h1>we<span>LT</span></h1>
        <p>Mateo Arlov - marlov@tvz.hr - 2021./2022.</p>
    </footer>
</body>
</html>