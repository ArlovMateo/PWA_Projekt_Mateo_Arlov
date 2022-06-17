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
    <form enctype="multipart/form-data" action="skripta.php" method="POST" class="unos_vijesti">

        <div class="form-item">
            <label for="title">Naslov vijesti</label>
                <div class="form-field">
                    <input type="text" name="title" id="title" class="form-field-textual">
                </div>
                <span id="porukaTitle" class="bojaPoruke"></span>
        </div>

        <div class="form-item">
            <label for="about">Kratki sadržaj vijesti (do 50 znakova)</label>
                <div class="form-field">
                    <textarea name="about" id="about" id="" cols="35" rows="5" class="form-field-textual"></textarea>
                </div>
                <span id="porukaAbout" class="bojaPoruke"></span>
        </div>

        <div class="form-item">
            <label for="content">Sadržaj vijesti</label>
                <div class="form-field">
                    <textarea name="content" id="content" id="" cols="35" rows="5" class="form-field-textual"></textarea>
                </div>
                <span id="porukaContent" class="bojaPoruke"></span>
        </div>

        <div class="form-item">
            <label for="image">Slika: </label>
                <div class="form-field">
                    <input type="file" accept="image/jpg,image/gif" class="input-text" name="image" id="image"/>
                </div>
                <span id="porukaSlika" class="bojaPoruke"></span>
        </div>

        <div class="form-item">
            <label for="category">Kategorija vijesti</label>
                <div class="form-field">
                    <select name="category" id="category" class="form-field-textual">
                        <option value="posaoikarijera">Posao &#38; Karijera</option>
                        <option value="hrana">Hrana</option>
                    </select>
                </div>
                <span id="porukaKategorija" class="bojaPoruke"></span>
        </div>
        <br>
        <div class="form-item">
            <div class="form-field">
                
                <label>Spremiti u arhivu:</label> <input type="checkbox" name="archive">

            </div>
        </div>
        <br>
        <div class="form-item">
            <button type="reset" value="Poništi">Poništi</button>
            <button type="submit" value="Prihvati" id="slanje">Prihvati</button>
        </div>
    </form>
        <br>
</main>
<script type="text/javascript">
    // Provjera forme prije slanja
    document.getElementById("slanje").onclick = function(event) {

    var slanjeForme = true;

    // Naslov vjesti (5-30 znakova)
    var poljeTitle = document.getElementById("title");
    var title = document.getElementById("title").value;

    if (title.length < 5 || title.length > 30) {

    slanjeForme = false;
    poljeTitle.style.border="1px dashed red";
    document.getElementById("porukaTitle").innerHTML="Naslov vijesti mora imati između 5 i 30 znakova!<br>";

    } else {
    poljeTitle.style.border="1px solid green";
    document.getElementById("porukaTitle").innerHTML="";
    }

    // Kratki sadržaj (10-100 znakova)
    var poljeAbout = document.getElementById("about");
    var about = document.getElementById("about").value;

    if (about.length < 10 || about.length > 100) {

    slanjeForme = false;
    poljeAbout.style.border="1px dashed red";
    document.getElementById("porukaAbout").innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";

    } else {
    poljeAbout.style.border="1px solid green";
    document.getElementById("porukaAbout").innerHTML="";
    }

    // Sadržaj mora biti unesen
    var poljeContent = document.getElementById("content");
    var content = document.getElementById("content").value;

    if (content.length == 0) {

    slanjeForme = false;
    poljeContent.style.border="1px dashed red";
    document.getElementById("porukaContent").innerHTML="Sadržaj mora biti unesen!<br>";

    } else {
    poljeContent.style.border="1px solid green";
    document.getElementById("porukaContent").innerHTML="";
    }

    // Slika mora biti unesena
    var poljeSlika = document.getElementById("image");
    var image = document.getElementById("image").value;

    if (image.length == 0) {

    slanjeForme = false;
    poljeSlika.style.border="1px dashed red";
    document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>";

    } else {
    poljeSlika.style.border="1px solid green";
    document.getElementById("porukaSlika").innerHTML="";
    }

    // Kategorija mora biti odabrana
    var poljeCategory = document.getElementById("category");

    if(document.getElementById("category").selectedIndex == 0) {
    slanjeForme = false;
    poljeCategory.style.border="1px dashed red";

    document.getElementById("porukaKategorija").innerHTML="Kategorija mora biti odabrana!<br>";
    } else {

    poljeCategory.style.border="1px solid green";
    document.getElementById("porukaKategorija").innerHTML="";
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
    <?php
        // Sva pohrana u bazu se i dalje izvršava u datoteci skripta.php
    ?>

</body>
</html>