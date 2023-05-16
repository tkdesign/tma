<main class="container">
    <section class="p-5">
        <h1 id="pagetitle"><?=$page_title?></h1>
        <p class="lead text-muted"><?=$page_desc?></p>
        <a role="button" class="btn btn-outline-primary" data-action="add">+ Pridať</a>
    </section>
    <hr>
    <!-- Blok projektov -->
    <section class="p-5">
        <h2>Zoznam projektov</h2>
        <?php if ($total>0): ?>
        <?php include "pagination.php"; ?>
        <?php endif; ?>
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Názov</th>
                <th scope="col">Pseudonym</th>
                <th scope="col">Objednávanie</th>
                <th scope="col">Stav publikácie</th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i=0; $i<count($requests); $i++): ?>
            <tr>
                <td><?=$requests[$i]["id"]?></td>
                <td><?=$requests[$i]["title"]?></td>
                <td><?=$requests[$i]["alias"]?></td>
                <td><?=$requests[$i]["ordering"]?></td>
                <td><?=$requests[$i]["published"]?></td>
                <td>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-link" data-id="<?=$requests[$i]["id"]?>" data-action="delete" title="vymazať">x</button>
                        <button type="button" class="btn btn-link" data-id="<?=$requests[$i]["id"]?>" data-action="edit" title="upraviť">o</button>
                    </div>
                </td>
            </tr>
            <?php endfor; ?>
            </tbody>
        </table>
        <?php if ($total>0): ?>
        <?php include "pagination.php"; ?>
        <?php endif; ?>
    </section>
    <!-- Kontainer modálneho okna Bootstrap pre Editoru projektu -->
    <div class="modal" id="editProjectWnd">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Editor projektu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="editProjectForm" method="post" action="/edit/update_request.html">
                        <input type="hidden" name="id" id="projectId">
                        <input type="hidden" name="form_action" id="projectFormAction">
                        <input type="hidden" name="image_name" id="projectImageName">
                        <input type="hidden" name="image_width" id="projectImageWidth">
                        <input type="hidden" name="image_height" id="projectImageHeight">
                        <div class="mb-3">
                            <label for="projectTitle" class="form-label">Názov *</label>
                            <input type="text" class="form-control" name="title" id="projectTitle"
                                   aria-describedby="helpIdProjectTitle" placeholder="" required="" autocomplete="on">
                            <small id="helpIdProjectTitle" class="form-text text-muted">Názov projektu, ktorý sa zobrazí v nadpise karty projektu</small>
                        </div>
                        <div class="mb-3">
                            <label for="projectAlias" class="form-label">Pseudonym *</label>
                            <input type="text" class="form-control" name="alias" id="projectAlias"
                                   aria-describedby="helpIdProjectAlias" placeholder="" required="">
                            <small id="helpIdProjectAlias" class="form-text text-muted">Pseudonym projektu pre optimalizáciu SEO</small>
                        </div>
                        <div class="mb-3">
                            <label for="projectIntroText" class="form-label">Krátky popis</label>
                            <textarea class="form-control" name="intro_text" id="projectIntroText" rows="3" aria-describedby="helpIdProjectIntroText" placeholder=""></textarea>
                            <small id="helpIdProjectIntroText" class="form-text text-muted">Krátky popis projektu</small>
                        </div>
                        <div class="mb-3">
                            <label for="projectFullText" class="form-label">Úplný popis</label>
                            <textarea class="form-control" name="full_text" id="projectFullText" rows="3" aria-describedby="helpIdProjectFullText" placeholder=""></textarea>
                            <small id="helpIdProjectFullText" class="form-text text-muted">Úplný popis projektu</small>
                        </div>
                        <div class="mb-3">
                            <label for="projectCategoryIds" class="form-label">Kategória *</label>
                            <select class="form-select" id="projectCategoryIds" size="3" name="project_category_ids[]" aria-describedby="helpIdProjectCategoryIds" multiple required>
                            </select>
                            <small id="helpIdProjectCategoryIds" class="form-text text-muted">Výber jednej alebo viacerých kategórií pre projekt</small>
                        </div>
                        <div class="mb-3">
                            <label for="projectCustomer" class="form-label">Zákazník</label>
                            <input type="text" class="form-control" name="customer" id="projectCustomer"
                                   aria-describedby="helpIdProjectCustomer" placeholder="">
                            <small id="helpIdProjectCustomer" class="form-text text-muted">Meno zákazníka</small>
                        </div>
                        <div class="mb-3">
                            <label for="projectMetaKey" class="form-label">Meta kľúč</label>
                            <input type="text" class="form-control" name="meta_key" id="projectMetaKey"
                                   aria-describedby="helpIdProjectMetaKey" placeholder="">
                            <small id="helpIdProjectMetaKey" class="form-text text-muted">Meta kľúč pre SEO optimalizáciu</small>
                        </div>
                        <div class="mb-3">
                            <label for="projectMetaDescription" class="form-label">Meta popis</label>
                            <textarea class="form-control" name="meta_description" id="projectMetaDescription" rows="3" aria-describedby="helpIdProjectMetaDescription" placeholder=""></textarea>
                            <small id="helpIdProjectMetaDescription" class="form-text text-muted">Meta popis pre SEO optimalizáciu</small>
                        </div>
                        <div class="mb-3">
                            <label for="projectOrdering" class="form-label">Poradie zobrazenia</label>
                            <input type="text" class="form-control" name="ordering" id="projectOrdering"
                                   aria-describedby="helpIdProjectOrdering" placeholder="">
                            <small id="helpIdProjectOrdering" class="form-text text-muted">Poradie, v akom sa projekt zobrazuje v zozname projektov na webovej stránke</small>
                        </div>
                        <div class="mb-3">
                            <input class="form-check-input" type="checkbox" name="published" id="projectOrdering" aria-describedby="helpProjectOrdering" value="">
                            <label class="form-check-label" for="projectOrdering">Stav</label>
                            <br>
                            <small id="helpProjectOrdering" class="form-text text-muted">Povolenie zverejnenia projektu</small>
                        </div>
                        <div class="mb-3">
                            <label for="projectImage" class="form-label">Nový obrázok</label>
                            <input class="form-control" type="file" name="image" id="projectImage" aria-describedby="helpIdProjectImage"
                                   placeholder="">
                            <small id="helpIdProjectImage" class="form-text text-muted">Vyberte obrázok projektu, ktorý chcete nahrať na server</small>
                        </div>
                        <div class="mb-3">
                            <img class="img-fluid preview">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link-secondary" data-bs-dismiss="modal"
                            data-action="noBtn">Zrušiť</button>
                    <button type="submit" class="btn btn-outline-secondary"
                            data-action="yesBtn">Uložiť</button>
                </div>
            </div>
        </div>
    </div>
    <!-- //Kontainer modálneho okna Bootstrap pre Editoru projektu -->

    <!-- //Blok projektov -->
</main>
