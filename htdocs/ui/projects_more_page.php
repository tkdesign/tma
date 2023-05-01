<!-- Obsah ďalšie stránky galérie -->
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
    <a class="btn btn-outline-secondary mt-4" id="nextPage" href="/projects.html?page=<?=$page+1?>">Chcem
        viac</a><!-- Link ako tlačidlo pre stránkovanie -->
<?php endif; ?>
<!-- Neexistuje žiadny link alebo tlačidlo pre stránkovanie, čo znamená, že posledná stránka na serveri -->
<!-- //Obsah ďalšie stránky galérie -->