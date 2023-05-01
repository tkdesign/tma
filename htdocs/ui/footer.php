<!-- Dolný navigačný panel zobrazený v dvoch stĺpcoch s dolným menu s 4 stránkami a 'autorskými právami' -->
<footer class="navbar navbar-expand-lg bg-light">
    <div class="container flex-wrap py-3 px-5 justify-content-md-start">
        <p class="pe-4 mb-0 text-muted"><strong>TM Architektura,</strong> <?=date("Y");?></p><!-- Autorské práva -->
        <!-- Dolné menu -->
        <ul class="navbar-nav flex-column justify-content-end border-start ps-3">
            <li class="nav-item"<?=($inc=="projects"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="main"?" active":"")?>" href="/">Domov</a></li>
            <li class="nav-item"<?=($inc=="projects"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="projects"?" active":"")?>" href="projects.html">Projekty</a>
            </li>
            <li class="nav-item"<?=($inc=="projects"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="prices"?" active":"")?>" href="prices.html">Cenník</a></li>
            <li class="nav-item"<?=($inc=="projects"?" aria-current=\"page\"":"")?>><a class="nav-link<?=($inc=="contacts"?" active":"")?>" href="contacts.html">Kontakt</a></li>
        </ul>
        <!-- //Dolné menu -->
    </div>
</footer>
<!-- //Dolný navigačný panel zobrazený v dvoch stĺpcoch s dolným menu s 4 stránkami a 'autorskými právami' -->

<!-- Aby sa zabezpečilo, že používateľ uvidí obsah čo najskôr, pripojenie skriptov sa odkladá na poslednú chvíľu. Princípy
moderných webových prehliadačov -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script><!-- Bootstrap 5 js library -->
<?php if (in_array($inc,array("projects", "contacts"))):?>
    <script src="js/<?=$inc?>.js"></script>
<?php endif; ?>

</body>

</html>