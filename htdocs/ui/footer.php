<!-- Dolný navigačný panel zobrazený v dvoch stĺpcoch s dolným menu s 4 stránkami a 'autorskými právami' -->
<footer class="navbar navbar-expand-lg bg-light">
    <div class="container flex-wrap py-3 px-5 justify-content-md-start">
        <p class="pe-4 mb-0 text-muted"><strong>TM Architektura,</strong> <?=date("Y");?></p><!-- Autorské práva -->
        <!-- Dolné menu -->
        <ul class="navbar-nav flex-column justify-content-end border-start ps-3">
            <li class="nav-item"<?=($inc=="projects"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="main"?" active":"")?>" href="/">Domov</a></li>
            <li class="nav-item"<?=($inc=="projects"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="projects"?" active":"")?>" href="/projects.html">Projekty</a>
            </li>
            <li class="nav-item"<?=($inc=="projects"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="prices"?" active":"")?>" href="/prices.html">Cenník</a></li>
            <li class="nav-item"<?=($inc=="projects"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="contacts"?" active":"")?>" href="/contacts.html">Kontakt</a></li>
        </ul>
        <!-- //Dolné menu -->
    </div>
</footer>
<!-- //Dolný navigačný panel zobrazený v dvoch stĺpcoch s dolným menu s 4 stránkami a 'autorskými právami' -->

<!-- Aby sa zabezpečilo, že používateľ uvidí obsah čo najskôr, pripojenie skriptov sa odkladá na poslednú chvíľu. Princípy
moderných webových prehliadačov -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script><!-- Bootstrap 5 js library -->
<?php if (in_array($inc,array("projects", "contacts"))):?>
    <script src="js/<?=$inc?>.js"></script>
<?php endif; ?>
<?php if ($this->is_admin && $inc === "dashboard"): ?>
<script>
    const on = (listener, query, fn) => {
        document.querySelectorAll(query).forEach((item) => {
            item.addEventListener(listener, (el) => {
                fn(el);
            });
        });
    };
    document.addEventListener('DOMContentLoaded', function () {
        on("click", "button[data-action='reply']", (item) => {
            let id = item.target.dataset.id;
            if (id != null) {
                let ret = confirm("Označiť požiadavku s ID " + id + " ako zodpovedané?");
                if (ret) {
                    let url_request = location.href.split('?');
                    if (url_request.length == 2) {
                        location.href = "/dashboard/reply_request.html?id=" + id +"&" + url_request[1];
                    } else {
                        location.href = "/dashboard/reply_request.html?id=" + id;
                    }
                }
            }
        });
        on("click", "button[data-action='delete']", (item) => {
            let id = item.target.dataset.id;
            if (id != null) {
                let ret = confirm("Odstrániť požiadavku s identifikátorom " + id + "?");
                if (ret) {
                    let url_request = location.href.split('?');
                    if (url_request.length == 2) {
                        location.href = "/dashboard/delete_request.html?id=" + id +"&" + url_request[1];
                    } else {
                        location.href = "/dashboard/delete_request.html?id=" + id;
                    }
                }
            }
        });

    });
</script>
<?php endif; ?>
<?php if ($this->is_admin && $inc === "edit"): ?>
<script>
    const on = (listener, query, fn) => {
        document.querySelectorAll(query).forEach((item) => {
            item.addEventListener(listener, (el) => {
                fn(el);
            });
        });
    };
    function validateCurrentTab(form) {
        if (form !== undefined && form != null) {
            let validation = form.checkValidity();
            form.classList.add('was-validated');
            return validation;
        }
        return false;
    }
    async function showAddForm (url, options, EditorWnd) {
        try {
            const response = await fetch(url, options);
            if (!response.ok) {
                throw new Error(`${response}`);
            }
            const result = await response.json();
            if (result.status === undefined) {
                EditorWnd._element.querySelector('[name="form_action"]').value = "add";
                EditorWnd._element.querySelector('[name="published"]').checked = "true";
                const sb = EditorWnd._element.querySelector('[name="project_category_ids[]"]');
                for(let i=0;i<result.length;i++) {
                    let o = document.createElement('option');
                    o.value = result[i].id;
                    o.innerText = result[i].title;
                    sb.appendChild(o);
                }
                EditorWnd.show();
            }
        } catch (err) {
            console.error(err);
        }
    }
    async function showEditForm (url, options, EditorWnd) {
        try {
            const response = await fetch(url, options);
            if (!response.ok) {
                throw new Error(`${response}`);
            }
            const result = await response.json();
            if (result.status === undefined) {
                EditorWnd._element.querySelector('[name="id"]').value = result[0].id;
                EditorWnd._element.querySelector('[name="form_action"]').value = "update";
                EditorWnd._element.querySelector('[name="image_name"]').value = result[0].image;
                EditorWnd._element.querySelector('[name="image_width"]').value = result[0].image_ImageWidth;
                EditorWnd._element.querySelector('[name="image_height"]').value = result[0].image_ImageHeight;
                EditorWnd._element.querySelector('[name="title"]').value = result[0].title;
                EditorWnd._element.querySelector('[name="alias"]').value = result[0].alias;
                EditorWnd._element.querySelector('[name="intro_text"]').value = result[0].intro_text;
                EditorWnd._element.querySelector('[name="full_text"]').value = result[0].full_text;
                EditorWnd._element.querySelector('[name="customer"]').value = result[0].customer;
                EditorWnd._element.querySelector('[name="ordering"]').value = result[0].ordering;
                if (result[0].published) {
                    EditorWnd._element.querySelector('[name="published"]').checked = "true";
                }
                EditorWnd._element.querySelector('[name="meta_key"]').value = result[0].meta_key;
                EditorWnd._element.querySelector('[name="meta_description"]').value = result[0].meta_description;
                EditorWnd._element.querySelector('.preview').src = '/img/preview/' + result[0].image;
                const sb = EditorWnd._element.querySelector('[name="project_category_ids[]"]');
                for(let i=0;i<result[1].length;i++) {
                    let o = document.createElement('option');
                    o.value = result[1][i].id;
                    o.innerText = result[1][i].title;
                    for(let j=0;j<result[2].length;j++) {
                        if(result[1][i].id===result[2][j].project_category_id) {
                            o.selected = "true";
                            break;
                        }
                    }
                    sb.appendChild(o);
                }
                EditorWnd.show();
            }
        } catch (err) {
            console.error(err);
        }
    }
    async function addProject (form) {
        try {
            const newForm = new FormData();
            const data = new FormData(form);
            for (let [key, value] of data) {
                if(key!="published") {
                    newForm.append(key, value);
                } else {
                    newForm.append(key, form.querySelector('[name="published"]').checked);
                }

            }
            const request = {
                method: 'POST',
                body: newForm
            };
            const response = await fetch('/edit/insert_request.html', request);
            if (!response.ok) {
                alert('Chyba\n' + 'Kód odpovede zo servera: ' + response);
            }
            let result = await response.json();
            if (result.status !== undefined && result.status) {
                location.reload();
            }
        } catch (err) {
            console.error(err);
        }
    }
    async function updateProject (form) {
        try {
            const newForm = new FormData();
            const data = new FormData(form);
            for (let [key, value] of data) {
                if(key!="published") {
                    newForm.append(key, value);
                } else {
                    newForm.append(key, form.querySelector('[name="published"]').checked);
                }
            }
            const request = {
                method: 'POST',
                body: newForm
            };
            const response = await fetch('/edit/update_request.html', request);
            if (!response.ok) {
                alert('Chyba\n' + 'Kód odpovede zo servera: ' + response);
            }
            let result = await response.json();
            if (result.status !== undefined && result.status) {
                location.reload();
            }
        } catch (err) {
            console.error(err);
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        const EditorWnd = new bootstrap.Modal('#editProjectWnd');
        EditorWnd._element.addEventListener('hide.bs.modal', function (event) {
            this.querySelector('#editProjectForm').reset();
            this.querySelector('.preview').src="";
            this.querySelector('[name="project_category_ids[]"]').innerHTML="";
        });
        EditorWnd._element.querySelector('button[data-action="yesBtn"]').addEventListener('click', (event) => {
            event.preventDefault();
            event.stopImmediatePropagation();
            const form = EditorWnd._element.querySelector('#editProjectForm');
            let checkStatus = true;
            if (!validateCurrentTab(form)) {
                checkStatus = false;
            }
            form.classList.add('was-validated');
            if (!checkStatus) {
                alert('Chyba\nNie sú vyplnené všetky povinné polia alebo sú zadané údaje v nesprávnom formáte. Polia, ktoré musia byť vyplnené, sú označené *. Skontrolujte všetky karty, či neobsahujú chyby');
            } else {
                if( form.querySelector('[name="form_action"]').value === "update") {
                    updateProject(form);
                } else {
                    addProject(form);
                }
            }
        });
        EditorWnd._element.querySelector('button[data-action="noBtn"]').addEventListener('click', (event) => {
            EditorWnd.close();
        });
        EditorWnd._element.querySelector('#projectImage').addEventListener('change', (event) => {
            const file = event.target.files[0];
            const reader = new FileReader();
            const previewImg = event.target.closest('#editProjectWnd').querySelector('.preview');
            reader.addEventListener('load', function() {
                previewImg.src = reader.result;
            });
            if (file) {
                reader.readAsDataURL(file);
            }
        });
        on("click", "a[data-action='add']", (item) => {
            const url = '/edit/get_categories.html';
            const options = {
                method: 'GET',
            };
            showAddForm(url, options, EditorWnd);
        });
        on("click", "button[data-action='edit']", (item) => {
            let id = item.target.dataset.id;
            let result;
            if (id != null) {
                const url = '/edit/details.html?id=' + id;
                const options = {
                    method: 'GET',
                };
                showEditForm(url, options, EditorWnd);
            }
        });
        on("click", "button[data-action='delete']", (item) => {
            let id = item.target.dataset.id;
            if (id != null) {
                let ret = confirm("Odstrániť projekt s identifikátorom " + id + "?");
                if (ret) {
                    let url_request = location.href.split('?');
                    if (url_request.length == 2) {
                        location.href = "/edit/delete_request.html?id=" + id +"&" + url_request[1];
                    } else {
                        location.href = "/edit/delete_request.html?id=" + id;
                    }
                }
            }
        });

    });
</script>
<?php endif; ?>

</body>

</html>