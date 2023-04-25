/* Kreatívny bod */

var nextItem; // Deklarácia globálnej premennej, v ktorej bude uložená pozícia stránkovania
var lightBox; // Deklarácia pglobálnej remennej, v ktorej bude uložený objekt modálnehi okna

/* Funkcia, ktorá sa zavolá pri kliknutím na tlačidlo stránkovania na konci stránky  */
function clickHandler(evt) {
    evt.stopImmediatePropagation();
    evt.preventDefault();
    const container = document.querySelector('#cardsContainer'); // Dostať kontajner s galériou projektov
    if (container !== undefined && container != null) { // Ak aktuálna stránka obsahuje galériu projektov, treba zavolať funkciu asynchrónneho stránkovania
        loadMore(); // Volanie funkcie asynchrónneho stránkovania
    }
}

/* Funkcia asynchrónneho stránkovania (implementácia nekonečného posúvania pomocou aktuálnej technológie async/await) */
async function loadMore() {
    const container = document.querySelector('#cardsContainer'); // Dostať kontajner s galériou projektov
    if(container!==undefined || container!=null) {
        const currentNextPage = container.querySelector("#nextPage"); // Dostať tlačidlo stránkovania na konci stránky
        try {
            let response = await fetch('page' + nextItem + '.html'); // Dostať 'promise' s obsahom novej stránky zo 'servera'; globálna premenná nextItem obsahuje číslo novej stránky, ktorá sa má získať zo 'servera'
            if (currentNextPage !== undefined && currentNextPage != null) {
                currentNextPage.remove(); // Odstránenie tlačidla stránkovania na konci aktuálnej stránky, pretože nová stránka už bola prijatá zo 'servera'
            }
            container.innerHTML += await response.text(); // Pridať odpovede 'servera' na koniec kontajnera s galériou projektov
            nextItem++; // globálna premenná nextItem obsahuje číslo novej stránky, ktorá sa má získať zo 'servera'
            const newNextPage = document.querySelector("#nextPage"); // Dostať nové tlačidlo na konci stránky
            if (newNextPage !== undefined && newNextPage != null) { // Ak má obsah novej stránky na konci tlačidlo, je potrebné k nemu znovu pripojiť možnosť asynchrónneho stránkovania, pretože ide o nové tlačidlo, staré bolo odstránené spolu s pripojenou funkciou
                newNextPage.addEventListener('click', clickHandler); // Pripojenie funkcie, ktorá sa zavolá pri kliknutím na tlačidlo na konci stránky, aby bolo jasnejšie demonštrované asynchrónne stránkovanie 
            }
            const links = document.querySelectorAll('.card img');
            Array.from(links).forEach(link => {
                link.addEventListener('click',clickHandler2);
            });
        } catch (err) {
            if (currentNextPage !== undefined && currentNextPage != null) {
                currentNextPage.remove(); // Zmazať tlačidlo stránkovania na konci aktuálnej stránky, ak došlo k nejakej chybe počas asynchrónneho stránkovania
            }
            console.log('Fetch error:' + err); // Výpis chybovej správy do konzoly
        }
    } 
}

/* Funkcia, ktorá zobrazí aktuálny obrázok v modálnom okne.  */
function loadImage(el) {
    const lbBody = lightBox._element.querySelector('.modal-body .container-fluid'); // Dostať kontainer pre zobrazenia aktuálneho obrázka z kontajnera s id LightBox z objektu modálneho okna 
    if(lbBody!==undefined || lbBody!=null) {
        try {
            const lbHeader = lightBox._element.querySelector('.modal-header h1'); // Dostať prvok na zobrazenie nadpisu aktuálneho obrázka z kontajnera s id LightBox z objektu modálneho okna 
            if(lbHeader!==undefined && lbHeader!=null){
                lbHeader.innerText=el.alt; // Zobrazenie nadpisu aktuálneho obrázka do modálneho okna
            }
            lbBody.innerHTML='<img src="'+el.dataset.src+'" alt="'+el.alt+'"/>'; // Pridanie aktuálneho obrázka do modálneho okna
            lightBox.show(); // Zobraziť modálne okno
        }
        catch (err) {
            console.log('LightBox error:'+err); // Výpis chybovej správy do konzoly
        }
    }
}

/* Funkcia, ktorá sa zavolá pri kliknutím na obrázku */
function clickHandler2(evt) {
    evt.stopImmediatePropagation();
    evt.preventDefault();
    if (lightBox !==undefined && lightBox!=null) {
        loadImage(this); // Volanie funkcie na zobrazenie aktuálneho obrázka v modálnom okne
    }
}

/* Vykonať JavaScript ihneď po načítaní stránky */
window.addEventListener('load', function (event) {

    /* Inicializačný kód stránkovania */
    nextItem = 2;
    const currentNextPage = document.querySelector("#nextPage"); // Dostať tlačidlo stránkovania na konci stránky
    if (currentNextPage !== undefined && currentNextPage != null) { // Ak aktuálna stránka obsahuje tlačidlo stránkovania na konci stránky, musí byť pripojená možnosť asynchrónneho stránkovania
        currentNextPage.addEventListener('click', clickHandler); // Pripojenie funkcie, ktorá sa zavolá pri kliknutím na tlačidlo stránkovania na konci stránky, aby bolo jasnejšie demonštrované asynchrónne stránkovanie
    }

    /* Inicializačný kód lightboxa */
    lightBox = new bootstrap.Modal("#LightBox"); // Vytvorenie nového objektu modálneho okna Bootstrap pre existujúci kontajner s id LightBox
    if (lightBox !==undefined && lightBox!=null) {
        lightBox._element.addEventListener('hidden.bs.modal', event => { // Pripojenie šípkovej funkcie, ktorá sa zavolá, keď bolo modálne okno zatvorené
            const lbBody = lightBox._element.querySelector('.modal-body .container-fluid'); // Dostať kontainer s obrázkom z kontajnera s id LightBox z objektu modálneho okna
            if(lbBody!==undefined || lbBody!=null) {
                try {
                    const lbHeader = lightBox._element.querySelector('.modal-header h1'); // Dostať prvok, ktorý obsahuje nadpis obrázka z kontajnera s id LightBox z objektu modálneho okna
                    if(lbHeader!==undefined && lbHeader!=null){
                        lbHeader.innerText=""; // Vymazať nadpis obrázka
                    }
                    lbBody.innerHTML=""; // Odstrániť obrázok
                }
                catch (err) {
                    console.log('LightBox error:'+err); // Výpis chybovej správy do konzoly
                }
            }
        });
        const links = document.querySelectorAll('.card img'); // Dostať všetky obrázky z galérie
        Array.from(links).forEach(link => {
            link.addEventListener('click',clickHandler2); // Pripojenie funkcie, ktorá sa zavolá pri kliknutím na obrázku
        });
    }
});

/* //Kreatívny bod */