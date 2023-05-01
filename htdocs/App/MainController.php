<?php

namespace App;

/**
 * Class MainController
 * Trieda kontroléra spravuje vstupné požiadavky od používateľa a zabezpečuje správne priradenie požiadaviek k modelu alebo zobrazeniu.
 * @package App
 */
class MainController extends Controller
{

    /**
     * Metóda mapovania pravidiel routovania na konkrétne akcie v kontroléri.
     * @param string $function Názov metódy, ktorá sa má zavolať
     */
    public function run($function)
    {
        $app = Base::getInstance();
        $this->$function($app);
    }

    /**
     * Metóda vizuálneho zobrazenia hlavnej stránky.
     * @param Base $app Inštancia triedy Base
     */
    public function home($app)
    {
        $inc = 'home';
        $page_title = 'TM Architektúra';
        $page_desc = 'Architektúra, interiérový dizajn, urbanizmus';
        include_once 'ui/layout.php';
    }

    /**
     * Metóda vizuálneho zobrazenia portfólia
     * @param Base $app Inštancia triedy Base
     */
    public function projects($app)
    {
        $config = $app->getConfig();
        $model = new MainModel($config);
        $is_next_page = false;
        $total = $model->get_count_rows_in_projects();
        if ($this->args !== null && property_exists($this->args, "page") && (int)$this->args->page > 1) {
            $page = intval($this->args->page);
            if ($total !== null && count($total) > 0 && $total[0]["count_rows"] > $config["project_cards_per_page"] * $page) {
                $is_next_page = true;
            }
            $projects = $model->get_projects(($page - 1) * $config["project_cards_per_page"], $config["project_cards_per_page"]);
            $position = ($page - 1) * $config["project_cards_per_page"] + 1;
            include_once 'ui/projects_more_page.php';
        } else {
            $inc = 'projects';
            $page_title = 'TM Architektúra. Projekty';
            $page_desc = 'Fotogaléria architektonických projektov a konceptov';
            $projects = $model->get_projects(0, $config["project_cards_per_page"]);
            if ($total !== null && count($total) > 0 && $total[0]["count_rows"] > $config["project_cards_per_page"]) {
                $is_next_page = true;
            }
            $position = 1;
            include_once 'ui/layout.php';
        }
    }

    /**
     * Metóda vizuálneho zobrazenia stránky s cenami
     * @param Base $app Inštancia triedy Base
     */
    public function prices($app)
    {
        $inc = 'prices';
        $page_title = 'TM Architektúra. Cenník';
        $page_desc = 'Aktuálny cenník architektonických návrhov';
        include_once 'ui/layout.php';
    }

    /**
     * Metóda vizuálneho zobrazenia stránky s kontaktnými údajmi
     * @param Base $app Inštancia triedy Base
     */
    public function contacts($app)
    {
        $inc = 'contacts';
        $page_title = 'TM Architektúra. Kontakt';
        $page_desc = 'Adresa, kontaktné údaje a formulár spätnej väzby';
        include_once 'ui/layout.php';
    }

    /**
     * Metóda vizuálneho zobrazenia stránky s potvrdením prijatia požiadavky od návštevníka
     * @param Base $app Inštancia triedy Base
     */
    public function confirmation($app)
    {
        $fields = new \stdClass();
        foreach ($_POST as $key => $value) {
            $fields->$key = $value;
        }
        $err_msg = array();
        if (property_exists($fields, "name") && property_exists($fields, "email") && property_exists($fields, "request")) {
            if (empty($fields->name)) {
                $err_msg[] = "Musí byť zadané meno!";
            }
            if (empty($fields->email)) {
                $err_msg[] = "Musí byť zadaný e-mail!";
            }
            if (empty($fields->request)) {
                $err_msg[] = "Je potrebné položiť otázku!";
            }

        } else {
            $err_msg[] = "Je potrebné vyplniť všetky polia formulára!";
        }
        if (count($err_msg) === 0) {
            $config = $app->getConfig();
            $model = new MainModel($config);
            $model->toCRM($fields);
        }
        $inc = 'confirmation';
        $page_title = 'TM Architektúra. Potvrdenie o prijatí';
        $page_desc = 'Adresa, kontaktné údaje a formulár spätnej väzby';
        include_once 'ui/layout.php';

    }

}
