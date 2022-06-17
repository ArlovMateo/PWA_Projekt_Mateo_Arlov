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
            //Posao i karijera
            echo "<section id='posao_karijere' class='wrapper'>";
            echo "<h2>Posao &#38; Karijera</h2>";
            echo "<div class='clanci'>";
                //Početak ispisa članaka
                $query = "SELECT * FROM pwa_tablica WHERE arhiva=0 AND kategorija='posaoikarijera' LIMIT 3";
                $result = mysqli_query($dbc, $query);
                $i=0;
                while($row = mysqli_fetch_array($result)){
                    
                            echo "<article>";
                                echo '<img src="' . UPLPATH . $row['slika'] . '"';
                                echo '<h3>';
                                echo '<a class="naslovi_clanaka" href="clanak.php?id='.$row['id'].'">';
                                echo $row['naslov'];
                                echo '</a></h3>';
                                //echo "<h3><a href='clanak.php?id='".$row['id'].">".$row['naslov']."</a></h3>";
                                echo "<p>".$row['tekst']."</p>";
                                echo "<p class='datum'>".$row['datum']."</p>";
                                echo "<hr>";
                            echo "</article>";

                }
            echo "</div>";
            echo "</section>";    
        ?> 

            <br>
        
            <?php
            //Hrana
            echo "<section id='hrana' class='wrapper'>";
            echo "<h2>Hrana</h2>";
            echo "<div class='clanci'>";
                //Početak ispisa članaka
                $query = "SELECT * FROM pwa_tablica WHERE arhiva=0 AND kategorija='hrana' LIMIT 3";
                $result = mysqli_query($dbc, $query);
                $i=0;
                while($row = mysqli_fetch_array($result)){
                    
                            echo "<article>";
                                echo '<img src="' . UPLPATH . $row['slika'] . '"';
                                echo '<h3>';
                                echo '<a class="naslovi_clanaka" href="clanak.php?id='.$row['id'].'">';
                                echo $row['naslov'];
                                echo '</a></h3>';
                                //echo "<h3><a href='clanak.php?id='".$row['id'].">".$row['naslov']."</a></h3>";
                                echo "<p>".$row['tekst']."</p>";
                                echo "<p class='datum'>".$row['datum']."</p>";
                                echo "<hr>";
                            echo "</article>";

                }
            echo "</div>";
            echo "</section>";    
        ?> 
    </main>
    <br>
    <footer id="podnozje">
        <h1>we<span>LT</span></h1>
        <p>Mateo Arlov - marlov@tvz.hr - 2021./2022.</p>
    </footer>
</body>
</html>