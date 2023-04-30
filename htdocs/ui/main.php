<!DOCTYPE html>
<html lang="sk">

<head>
    <!-- Používanie meta značiek -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Architektúra, interiérový dizajn, urbanizmus">
    <!-- //Používanie meta značiek -->
    <link rel="shortcut icon" href="data:,"><!-- Špeciálna metóda, aby prehliadač nežiadal ikonu zo 'servera', ak ju webová stránka nemá -->
    <!-- Štýly aj Javascript sú v samostatných súboroch -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"><!-- Štýly Bootstrap 5 -->
    <link href="css/main.css" rel="stylesheet"><!-- Spoločné štýly pre všetky stránky -->
    <link href="css/home.css" rel="stylesheet"><!-- Individuálne štýly aktuálnej stránky -->
    <!-- //Štýly aj Javascript sú v samostatných súboroch -->
    <title>TM Architektúra</title>
</head>

<body>
    <!-- Špeciálna celoobrazovková šablóna pre domovskú stránku -->

    <div class="site-wrapper w-100 h-100">
        <div class="site-wrapper-inner w-100 h-100 m-0 p-0">

            <!-- Horný navigačný panel s horným menu s 4 stránkami a logom -->
            <header class="container-fluid navbar navbar-expand-sm navbar-top">
                <nav class="container-fluid flex-wrap py-3 px-5">
                    <a class="navbar-brand mb-0" href="index.html">TM Architektura</a><!-- Textový logotyp -->
                    <!-- Tlačidlo ako Hamburger, ktoré zobrazuje horné menu na mobilných zariadeniach -->
                    <button class="navbar-toggler btn-sm" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapseContainer" aria-controls="navbarCollapseContainer"
                        aria-expanded="false" aria-label="Toggle menu">
                        <span class="navbar-toggler-icon"></span><!-- Obrázok ako hamburger -->
                    </button>
                    <!-- //Tlačidlo ako Hamburger, ktoré zobrazuje horné menu na mobilných zariadeniach -->
                    <!-- Horné menu -->
                    <div class="collapse navbar-collapse justify-content-end" id="navbarCollapseContainer">
                        <ul class="navbar-nav">
                            <li class="nav-item" aria-current="page"><a class="nav-link active"
                                    href="index.html">Domov</a></li>
                            <li class="nav-item"><a class="nav-link" href="projects.html">Projekty</a></li>
                            <li class="nav-item"><a class="nav-link" href="prices.html">Cenník</a></li>
                            <li class="nav-item"><a class="nav-link" href="contacts.html">Kontakt</a></li>
                        </ul>
                    </div>
                    <!-- //Horné menu -->
                </nav>
            </header>
            <!-- Blok karuselu (Bootstrap 5) dôležitých projektov ako pozadie domovskej stránky, roztiahne sa na celú obrazovku -->
            <div id="presentationCarousel" class="carousel carousel-dark slide carousel-fade w-100 h-100" data-bs-ride="carousel">
                <div class="carousel-inner h-100">
                    <div class="carousel-item active w-100 h-100">
                        <div class="w-100 h-100 slide-item" style="background-image: url('img/covers/covertrub2.jpg');">
                        </div>
                        <h1 class="carousel-item-text py-3 px-5"><strong>Ateliér TM Architektúra. Project 1</strong>
                        </h1>
                    </div>
                    <div class="carousel-item w-100 h-100">
                        <div class="w-100 h-100 slide-item" style="background-image: url('img/covers/covertrub3.jpg');">
                        </div>
                        <h1 class="carousel-item-text py-3 px-5"><strong>Ateliér TM Architektúra. Project 2</strong>
                        </h1>
                    </div>
                    <div class="carousel-item w-100 h-100">
                        <div class="w-100 h-100 slide-item" style="background-image: url('img/covers/covertrub4.jpg');">
                        </div>
                        <h1 class="carousel-item-text py-3 px-5"><strong>Ateliér TM Architektúra. Project 3</strong>
                        </h1>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#presentationCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Predchádzajúci</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#presentationCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Nasledujúci</span>
                </button>
            </div>
            <!-- //Blok karuselu (Bootstrap 5) dôležitých projektov ako pozadie domovskej stránky, roztiahne sa na celú obrazovku -->
        </div>
    </div>

    <!-- Aby sa zabezpečilo, že používateľ uvidí obsah čo najskôr, pripojenie skriptov sa odkladá na poslednú chvíľu. Princípy
    moderných webových prehliadačov -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script><!-- Bootstrap 5 js library -->
    
</body>

</html>