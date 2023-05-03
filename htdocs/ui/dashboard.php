<main class="container">
    <section class="p-5">
        <h1 id="pagetitle">Dashboard</h1>
        <p class="lead text-muted">Správa a monitorovanie</p>
    </section>
    <hr>
    <!-- Blok požiadaviek -->
    <section class="p-5">
        <h2>Zoznam požiadaviek používateľov</h2>
        <?php if ($total>0): ?>
        <?php include "pagination.php"; ?>
        <?php endif; ?>
        <!--<div class="table-responsive-sm">-->
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Meno</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Otázka</th>
                    <th scope="col">Dátum požiadavky</th>
                    <th scope="col">Dátum odpovede</th>
                    <th scope="col">Akcie</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i=0; $i<count($requests); $i++): ?>
                <tr>
                    <td><?=$requests[$i]["id"]?></td>
                    <td><?=$requests[$i]["name"]?></td>
                    <td><?=$requests[$i]["email"]?></td>
                    <td><?=$requests[$i]["request"]?></td>
                    <td><?=$requests[$i]["created_at"]?></td>
                    <td><?=$requests[$i]["replied_at"]?></td>
                    <td>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <button type="button" class="btn btn-link" data-id="<?=$requests[$i]["id"]?>" data-action="delete" title="vymazať">x</button>
                            <button type="button" class="btn btn-link" data-id="<?=$requests[$i]["id"]?>" data-action="reply" title="odpovedať">o</button>
                        </div>
                    </td>
                </tr>
                <?php endfor; ?>
                </tbody>
            </table>
        <!--</div>-->
        <?php if ($total>0): ?>
        <?php include "pagination.php"; ?>
        <?php endif; ?>
    </section>
    <!-- //Blok požiadaviek -->
</main>
