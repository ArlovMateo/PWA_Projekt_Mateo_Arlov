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
        <?php
             include 'connect.php';
             define('UPLPATH', 'images/');
 
                //Početak ispisa članaka
                $clanak=$_GET['id'];
                $query = "SELECT * FROM pwa_tablica WHERE id=\"".$clanak."\" ";
                $result = mysqli_query($dbc, $query);

                $i=0;
                    while($row = mysqli_fetch_array($result)){
                        echo '<h2 class="wrapper">'.$row['kategorija'].'</h2>';
                        echo '<hr>';
                        echo '<section class="clanak">';
                            echo '<h3 class="clanak_tekst">'.$row['naslov'].'</h3>';
                            echo '<p class="clanak_tekst datum">Datum: '.$row['datum'].'</p><br>';
                            echo '<img src="' . UPLPATH . $row['slika'] . '">';
                             echo '<p class="clanak_tekst">'.$row['tekst'].'</p>';
                        echo '</section>';
                    }


        ?>
    </main>
    <footer id="podnozje">
        <h1>we<span>LT</span></h1>
        <p>Mateo Arlov - marlov@tvz.hr - 2021./2022.</p>
    </footer>
</body>
</html>