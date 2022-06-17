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

    <?php

        //Dohvaćanje varijabli
        include 'connect.php';

        if (isset($_POST['title'])){
            
            $title=$_POST['title'];
        }
            
        if (isset($_POST['about'])){

            $about=$_POST['about'];
        }

        if (isset($_POST['content'])){

            $content=$_POST['content'];
        }

        if (isset($_POST['category'])){

            $category=$_POST['category'];
        }

        if(isset($_POST['archive'])){
         $archive=1;
        }else{
         $archive=0;
        }

        $date=date('d.m.Y.');

        $picture = $_FILES['image']['name'];
        $target_dir = 'images/'.$picture;

        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir);
        $query = "INSERT INTO pwa_tablica (datum, naslov, sazetak, tekst, slika, kategorija, 
        arhiva ) VALUES ('$date', '$title', '$about', '$content', '$picture', 
        '$category', '$archive')";
        $result = mysqli_query($dbc, $query) or die('Error querying databese.');
        mysqli_close($dbc);

    ?>
    <main>
        <section class="clanak">

            <div class="row">
                <p class="category">
                    <?php
                        echo $category;
                    ?>
                </p>
                <h3 class="title">
                    <?php
                    echo $title;
                    ?>
                </h3>
                <p class="autor">AUTOR:</p>
                <br>
                <p class="autor">OBJAVLJENO:</p>
            </div>
            <br>
            <section class="slika">
                <?php
                    echo "<img src='images/$picture' >";
                ?>
            </section>

            <section class="about">
                <p>
                    <?php
                        echo $about;
                    ?>
                </p>
            </section>
            <br>
            <section class="sadrzaj">
                <p>
                    <?php
                        echo $content;
                    ?>
                    </p>
            </section>

        </section>

    </main>
    <footer id="podnozje">
        <h1>we<span>LT</span></h1>
        <p>Mateo Arlov - marlov@tvz.hr - 2021./2022.</p>
    </footer>
</body>
</html>