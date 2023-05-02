<main class="container">
    <section class="p-5">
        <h1>Cenník</h1>
        <p>Tu nájdete orientačné ceny našich architektonických a dizajnérskych prác. Skutočná cena dizajnérskej
            práce závisí od jej zloženia a faktorov, ktoré uľahčujú alebo zvyšujú časovú náročnosť tvorivého a
            pracovného procesu.</p>
        <p>Cenník našich prác je rozdelený do nasledujúcich skupín:</p>
        <!-- Zoznam skupín cenníkov-->
        <ul>
            <?php foreach($price_groups as $group):?>
            <li><?=$group["title"]?></li>
            <?php endforeach;?>
        </ul>
        <!-- //Zoznam skupín cenníkov-->
        <!-- Accordion na zobrazenie cenníkov -->
        <div class="accordion" id="pricesAccordion">
            <?php for($idx = 1; $idx <= count($price_groups); $idx++):?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?=$idx?>">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse<?=$idx?>" aria-expanded="true" aria-controls="collapse<?=$idx?>">
                        <?=$price_groups[$idx - 1]["title"]?>
                    </button>
                </h2>
                <div id="collapse<?=$idx?>" class="accordion-collapse collapse<?=($idx==1?" show":"")?>" aria-labelledby="heading<?=$idx?>"
                     data-bs-parent="#pricesAccordion">
                    <div class="accordion-body">
                        <!-- Blok informáciami o cenníke č.<?=$idx?> -->
                        <?=$price_groups[$idx - 1]["desc"]?>
                        <!-- Tabuľková prezentácia cenníka č.<?=$idx?> -->
                        <table class="table">
                            <tr class="table-light ">
                                <th>OBSAH PRÁCE</th>
                                <th>CENA</th>
                                <th>DOBA DODANIA</th>
                                <th>INFO</th>
                            </tr>
                            <?php $idx2 = 1; ?>
                            <?php for ($idx2 = 1; $idx2 <= count($prices[$price_groups[$idx-1]["id"]]); $idx2++) :?>
                            <tr>
                                <td><strong><?=$prices[$price_groups[$idx-1]["id"]][$idx2-1]["title"]?></strong></td>
                                <td><?=$prices[$price_groups[$idx-1]["id"]][$idx2-1]["price"]?></td>
                                <td><?=$prices[$price_groups[$idx-1]["id"]][$idx2-1]["duration"]?></td>
                                <td><?=$prices[$price_groups[$idx-1]["id"]][$idx2-1]["desc"]?></td>
                            </tr>
                            <?php endfor; ?>
                        </table>
                        <!-- //Tabuľková prezentácia cenníka č.1 -->
                        <p class="text-muted">*Ceny neobsahujú dph.</p>
                        <!-- //Blok informáciami o cenníke č.1 -->
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        <!-- //Accordion na zobrazenie cenníkov -->
    </section>
</main>
