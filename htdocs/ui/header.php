<!DOCTYPE html>
<html lang="sk">

<head>
    <!-- Používanie meta značiek -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$page_desc?>">
    <!-- //Používanie meta značiek -->
    <link rel="shortcut icon" href="data:,"><!-- Špeciálna metóda, aby prehliadač nežiadal ikonu zo 'servera', ak ju webová stránka nemá -->
    <!-- Štýly aj Javascript sú v samostatných súboroch -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"><!-- Štýly Bootstrap 5 -->
    <link href="/css/main.css" rel="stylesheet"><!-- Spoločné štýly pre všetky stránky -->
    <?php if (!in_array($inc, array("contacts","confirmation","dashboard","edit","login"))): ?>
    <link href="css/<?=$inc?>.css" rel="stylesheet"><!-- Individuálne štýly aktuálnej stránky -->
    <?php endif; ?>
    <!-- //Štýly aj Javascript sú v samostatných súboroch -->
    <title><?=$page_title?></title>
</head>

<body>
<!-- Pre túto stránku bolo použité obyčajné adaptívne rozloženie -->

<!-- Horný navigačný panel s horným menu s 4 stránkami a logom -->
<header class="navbar navbar-expand-lg bg-light sticky-top"><!-- sticky-top = Navigácia viditeľná počas scrollovania -->
    <nav class="container flex-wrap py-3 px-5">
        <a class="navbar-brand mb-0" href="/">TM Architektura</a><!-- Textový logotyp -->
        <!-- Tlačidlo ako Hamburger, ktoré zobrazuje horné menu na mobilných zariadeniach -->
        <button class="navbar-toggler btn-lg" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapseContainer" aria-controls="navbarCollapseContainer" aria-expanded="false"
                aria-label="Toggle menu">
            <span class="navbar-toggler-icon"></span><!-- Obrázok ako hamburger -->
        </button>
        <!-- //Tlačidlo ako Hamburger, ktoré zobrazuje horné menu na mobilných zariadeniach -->
        <!-- Horné menu -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapseContainer">
            <ul class="navbar-nav">
                <li class="nav-item"<?=($inc=="main"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="main"?" active":"")?>" href="/">Domov</a></li>
                <li class="nav-item"<?=($inc=="projects"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="projects"?" active":"")?>"
                                                            href="/projects.html">Projekty</a></li>
                <li class="nav-item"<?=($inc=="prices"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="prices"?" active":"")?>" href="/prices.html">Cenník</a></li>
                <li class="nav-item"<?=($inc=="contacts"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="contacts"?" active":"")?>" href="/contacts.html">Kontakt</a></li>
                <?php if($this->is_admin): ?>
                <li class="nav-item"<?=($inc=="dashboard"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="dashboard"?" active":"")?>" href="/dashboard.html">Dashboard</a></li>
                <li class="nav-item"<?=($inc=="dashboard"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="edit"?" active":"")?>" href="/edit.html">Manažment</a></li>
                <li class="nav-item"><a class="nav-link" href="/logout.html">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- //Horné menu -->
    </nav>
</header>
<!-- //Horný navigačný panel s horným menu s 4 stránkami a logom -->