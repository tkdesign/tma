<main class="container">
    <!-- Blok s informáciami o úspešnom odoslaní žiadosti (formulára) a tlačidlom na prechod na inú stránku (fotogaléria)  -->
    <section class="p-5">
        <?php if (count($err_msg)>0): ?>
        <h1>Pri spracovaní formulára na serveri došlo k chybe</h1>
        <?php foreach($err_msg as $err): ?>
        <p><?=$err?></p>
        <?php endforeach; ?>
        <hr>
        <p>Vráťte sa späť, obnovte stránku a skúste to znova.</p>
        <a class="btn btn-outline-secondary mt-4" href="/contacts.html">Späť</a><!-- Link ako tlačidlo s preklikom na inú stránku (kontaktné informácie) -->
        <?php else: ?>
        <h1>Potvrdenie o prijatí</h1>
        <p>Ďakujeme, že ste nás kontaktovali!</p>
        <p>Určite si vašu správu prečítame a čo najskôr vám odpovieme.</p>
        <p>Zatiaľ si pozrite príklady našej práce.</p>
        <a class="btn btn-outline-secondary mt-4" href="/projects.html">Do galérie projektov</a><!-- Link ako tlačidlo s preklikom na inú stránku (galéria projektov) -->
        <?php endif; ?>
    </section>
    <!-- //Blok s informáciami o úspešnom odoslaní žiadosti (formulára) a tlačidlom na prechod na inú stránku (fotogaléria)  -->
</main>
