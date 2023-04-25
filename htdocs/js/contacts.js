// Tu je kód, ktorý funguje s frameworkom Bootstrap 5. Po kliknutí na tlačidlo odoslať sa zavolá funkcia validácie polí
// formulára a potom sa do tohto formulára pridá trieda was - validated podľa logiky validácie Bootstrapu.V modálnom
// okne Bootstrap zobrazí GDPR, nastaví zaškrtávacie políčko vo formulári po kliknutí na tlačidlo "súhlasím" alebo
// odstráni zaškrtávacie políčko, ak používateľ klikne na tlačidlo "nesúhlasím"

/* Funkcia, ktorá sa zavolá pri kliknutím na tlačidlo "súhlasím" modálneho okna GDPR */
function checkedOn() {
    const check = document.getElementById('check'); // Dostať checkbox formulára "Súhlasím so spracovaním osobných údajov" 
    if (check !== undefined && check != null) {
        check.checked = true; // Zapnuť checkbox formulára
    }
}

/* Funkcia, ktorá sa zavolá pri kliknutím na tlačidlo "nesúhlasím" modálneho okna GDPR */
function checkedOff() {
    const check = document.getElementById('check'); // Dostať checkbox formulára "Súhlasím so spracovaním osobných údajov" 
    if (check !== undefined && check != null) {
        check.checked = false; // Vypnuť checkbox formulára
    }
}

/* Vykonať JavaScript ihneď po načítaní stránky */
window.addEventListener('load', function (event) {

    /* Inicializačný kód pre validáciu polí formulára pomocou Bootstrapu */
    const forms = document.querySelectorAll('.needs-validation'); // Dostať všetky polia formulára, ktoré vyžadujú validaciu (ktoré majú triedu "needs-validation")
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => { // Reakcia na udalosť odoslania formulára na server
            if (!form.checkValidity()) { // Validácia polí formulára po jednotlivých prvkoch
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated'); // Pridanie triedy "was-validated" do formulára
            alert('Kontrola formulára bola úspešne dokončená!\nStlačte tlačidlo OK pre pokračovanie');
        }, false);
    })

    /* Inicializačný kód pre tlačidlá modálneho okna GDPR */
    const yesBtn = document.getElementById('yesBtn'); // Dostať tlačidlo "súhlasím" modálneho okna GDPR
    if (yesBtn !== undefined && yesBtn != null) {
        yesBtn.addEventListener('click', checkedOn); // Pripojenie funkcie, ktorá sa zavolá pri kliknutím na tlačidlo "súhlasím" modálneho okna GDPR
    }
    const noBtn = document.getElementById('noBtn'); // Dostať tlačidlo "nesúhlasím" modálneho okna GDPR
    if (noBtn !== undefined && noBtn != null) {
        noBtn.addEventListener('click', checkedOff); // Pripojenie funkcie, ktorá sa zavolá pri kliknutím na tlačidlo "nesúhlasím" modálneho okna GDPR
    }
});
