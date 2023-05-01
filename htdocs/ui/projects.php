<main class="container">
    <section class="p-5">
        <h1 id="pagetitle">Projekty</h1>
        <p class="lead text-muted">Architektonické projekty a koncepty</p>
    </section>
    <section class="p-5">
        <!-- Kontajner galérie projektu -->
        <div class="container-fluid" id="cardsContainer">
            <!-- Obsah prvej stránky galérie -->
            <div class="row">
                <?php foreach ($projects as $key => $project): ?>
                    <div class="card" id="card<?= ($position++) ?>">
                        <div class="card-image-top">
                            <img class="w-100 h-100"
                                 src="<?= (!empty($project["image"]) ? "img/preview/" . $project["image"] : "") ?>"
                                 data-src="<?= (!empty($project["image"]) ? "img/details/" . $project["image"] : "") ?>"
                                 alt="<?= $project["intro_text"] ?>">
                        </div>
                        <h5 class="card-title text-muted"><?= $project["title"] ?></h5>
                        <p class="card-text text-muted"><?= $project["intro_text"] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ($is_next_page): ?>
                <a class="btn btn-outline-secondary mt-4" id="nextPage" href="/projects.html?page=2">Chcem
                    viac</a><!-- Link ako tlačidlo pre stránkovanie -->
            <?php endif; ?>
            <!-- //Obsah prvej stránky galérie -->
        </div>
        <!-- //Kontajner galérie projektu -->
    </section>
    <!-- Kontainer modálneho okna Bootstrap pre LightBox -->
    <div class="modal" id="LightBox">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"></h1>
                    <!-- Prvok, do ktorého sa pridáva nadpis aktuálneho obrázka -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid"></div><!-- Kontajner, do ktorého sa pridáva aktuálny obrázok -->
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- //Kontainer modálneho okna Bootstrap pre LightBox -->
</main>
