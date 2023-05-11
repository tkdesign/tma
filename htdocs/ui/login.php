<main class="container">
    <section class="p-5">
        <h1 id="pagetitle">Login</h1>
        <p class="lead text-muted">Vstup do backendu</p>
    </section>
    <hr>
    <!-- Blok formulára -->
    <section class="p-5">
        <form method="post" action="/auth.html" class="col-md-6 needs-validation">
            <!-- CSRF token -->
            <input type="hidden" name="token" value="<?=$token?>">
            <!-- //CSRF token -->
            <!-- Polia: Meno, Heslo-->
            <label for="username" class="form-label">Meno</label>
            <input type="text" id="username" placeholder="Zadajte meno" class="form-control" name="username" required="">
            <br>
            <label for="password" class="form-label">Heslo</label>
            <input type="password" id="password" placeholder="Zadajte heslo" class="form-control" name="password" required="">
            <!-- //Polia: Meno, Heslo -->
            <br>
            <!-- Tlačidlo Odoslať -->
            <button type="submit" class="btn btn-outline-secondary mt-4">Odoslať</button>
            <!-- //Tlačidlo Odoslať -->
        </form>
        <!-- //Formulár -->
    </section>
    <!-- //Blok formulára -->
</main>
