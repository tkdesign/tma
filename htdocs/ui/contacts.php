<main class="container">
    <!-- Blok s adresou a kontaktnými údajmi -->
    <section class="p-5">
        <!-- Rôzne nadpisy -->
        <h1>Kontaktné a fakturačné údaje</h1>
        <h2 class="lead">Adresa ateliéru</h2>
        <!-- //Rôzne nadpisy -->
        <p>Naš workshop na Slovensku nájdete na adrese Hollého 8, 949 01 Nitra.</p>
        <h2 class="lead">Kontaktné údaje</h2>
        <!-- Odkazy na email a telefón (mailto: , tel: ) -->
        <p>tel: <a href="tel:+421950445631">+421 950 445 631</a>, email: <a
                href="mailto:hello@tmarchitektura.sk">hello@tmarchitektura.sk</a></p>
        <!-- //Odkazy na email a telefón (mailto: , tel: ) -->
    </section>
    <!-- //Blok s adresou a kontaktnými údajmi -->
    <hr>
    <!-- Blok formulára spätnej väzby -->
    <section class="p-5">
        <h1>Kontaktný formulár</h1>
        <!-- Formulár, ktorý po validácii odosiela údaje na stránku s názvom "confirmation.html" (stránka s poďakovaním) na "serveri" -->
        <form action="confirmation.html" class="col-md-6 needs-validation">
            <!-- Polia: Meno, Email, Textarea -->
            <label for="name" class="form-label">Meno</label>
            <input type="text" id="name" placeholder="Zadajte meno" class="form-control">
            <br>
            <label for="mail" class="form-label">E-mail</label>
            <input type="email" id="mail" placeholder="Zadajte e-mail" class="form-control" required="">
            <br>
            <label for="question" class="form-label">Vaša správa</label>
            <textarea id="question" placeholder="Zadajte vašu správu" class="form-control" required=""></textarea>
            <!-- //Polia: Meno, Email, Textarea -->
            <!-- Checkbox GDPR "Súhlasím so spracovaním osobných údajov" -->
            <input type="checkbox" id="check" class="form-check-input me-2" required=""><label for="check"
                                                                                               class="form-label">Súhlasím <a class="link-secondary" href="#GDPRModalWnd"
                                                                                                                              data-bs-toggle="modal">so spracovaním osobných údajov</a></label>
            <!-- //Checkbox GDPR "Súhlasím so spracovaním osobných údajov" -->
            <br>
            <!-- Tlačidlo Odoslať -->
            <button type="submit" class="btn btn-outline-secondary mt-4">Odoslať</button>
            <!-- //Tlačidlo Odoslať -->
        </form>
        <!-- //Formulár, ktorý po validácii odosiela údaje na stránku s názvom "confirmation.html" (redirect na thank you page) na "serveri" -->
    </section>
    <!-- //Blok formulára spätnej väzby -->
    <!-- Kontainer modálneho okna Bootstrap pre GDPR -->
    <div class="modal" id="GDPRModalWnd">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Vážime si vaše súkromie</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Vaše meno a e-mail použijeme len na naše interné účely.</p>
                    <p>Na komunikáciu s vami budeme používať váš e-mail. Súhlas s vyššie uvedeným spracúvaním zo
                        strany našej spoločnosti môžete poskytnúť kliknutím na príslušné tlačidlo.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link-secondary" data-bs-dismiss="modal"
                            id="noBtn">Nesúhlasím</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            id="yesBtn">Súhlasím</button>
                </div>
            </div>
        </div>
    </div>
    <!-- //Kontainer modálneho okna Bootstrap pre GDPR -->
</main>
