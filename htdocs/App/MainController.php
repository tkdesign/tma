<?php

namespace App;

use stdClass;

/**
 * Class MainController
 * Trieda kontroléra spravuje vstupné požiadavky od používateľa a zabezpečuje správne priradenie požiadaviek k modelu alebo zobrazeniu.
 * @package App
 */
class MainController extends Controller
{

    private bool $is_admin;

    /**
     * MainController constructor.
     * @param string $args reťazec parametrov z url
     */
    public function __construct($args)
    {
        parent::__construct($args);
        $this->is_admin = false;
        if (isset($_COOKIE[session_name()])) {
            session_start();
            if (isset($_SESSION['username']) && isset($_SESSION['crypt']) && $_COOKIE[session_name()] == session_id()) {
                $app = Base::getInstance();
                $config = $app->getConfig();
                $model = new UsersModel($config);
                $admin_profile = $model->readUser($_SESSION['username']);
                $crypt = $admin_profile[0]["password"];
                if ($_SESSION['username'] !== $admin_profile[0]["username"] || $_SESSION['crypt'] !== $crypt) {
                    session_destroy();
                    $app->reroute("/login.html");
                    exit();
                }
                if (($_SESSION['lastseen'] + $config['expiry'] * 3600) < time()) {
                    session_destroy();
                    $app->reroute("/login.html");
                    exit();
                }
                $this->is_admin = true;
            }
        }
    }

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
        $total = $model->readCountProjects();
        if ($this->args !== null && property_exists($this->args, "page") && (int)$this->args->page > 1) {
            $page = intval($this->args->page);
            if ($total !== null && count($total) > 0 && $total[0]["count_rows"] > $config["project_cards_per_page"] * $page) {
                $is_next_page = true;
            }
            $projects = $model->readProjects(($page - 1) * $config["project_cards_per_page"], $config["project_cards_per_page"]);
            $position = ($page - 1) * $config["project_cards_per_page"] + 1;
            include_once 'ui/projects_more_page.php';
        } else {
            $inc = 'projects';
            $page_title = 'TM Architektúra. Projekty';
            $page_desc = 'Fotogaléria architektonických projektov a konceptov';
            $projects = $model->readProjects(0, $config["project_cards_per_page"]);
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
        $config = $app->getConfig();
        $model = new PricesModel($config);
        $price_groups = $model->readPriceGroups();
        $prices = array();
        foreach ($price_groups as $group) {
            $prices[$group["id"]] = $model->readPrices($group["id"]);
        }
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
        $config = $app->getConfig();
        /* Generovanie a uloženie anti-CSRF tokenu do premennej relácie na ochranu formulára */
        $token = hash_hmac('sha256', microtime(true) . mt_rand(), $config["secret_key"]);
        session_start();
        $_SESSION['csrf_token'] = $token;
        $_SESSION['csrf_token_time'] = time();
        /* //Generovanie a uloženie anti-CSRF tokenu do premennej relácie na ochranu formulára */
        include_once 'ui/layout.php';
    }

    /**
     * Metóda vizuálneho zobrazenia stránky s potvrdením prijatia požiadavky od návštevníka
     * @param Base $app Inštancia triedy Base
     */
    public function confirmation($app)
    {
        $fields = new stdClass();
        foreach ($_POST as $key => $value) {
            $fields->$key = $value;
        }
        $err_msg = array();
        if (property_exists($fields, "name") && property_exists($fields, "email") && property_exists($fields, "request")) {
            /*Kontrola tokenu anti-CSRF*/
            if (empty($fields->token)) {
                $err_msg[] = "Chyba tokenu anti-CSRF";
            } else {
                session_start();
                if (hash_equals($_SESSION['csrf_token'], $fields->token)) {
                    // Kontrola platnosti tokenu
                    $token_life = 3600; // Maximálna platnosť tokenu v sekundách
                    $current_time = time();
                    $token_time = $_SESSION['csrf_token_time'];
                    if (($current_time - $token_time) > $token_life) {
                        $err_msg[] = "Chyba tokenu anti-CSRF";
                    }
                } else {
                    $err_msg[] = "Chyba tokenu anti-CSRF";
                }
            }
            /*//Kontrola tokenu anti-CSRF*/
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
            $model->insertCrm($fields);
        }
        $inc = 'confirmation';
        $page_title = 'TM Architektúra. Potvrdenie o prijatí';
        $page_desc = 'Adresa, kontaktné údaje a formulár spätnej väzby';
        include_once 'ui/layout.php';

    }

    /**
     * Metóda zrušenia autorizácie a presmerovania na autorizačnú stránku
     * @param Base $app Inštancia triedy Base
     */
    public function logout($app)
    {
        if ($this->is_admin) {
            session_start();
            session_destroy();
            $app->reroute("/login.html");
            exit();
        }
    }

    /**
     * Metóda na spracovanie požiadavky POST z autorizačného formulára.
     * @param Base $app Inštancia triedy Base
     */
    public function auth($app)
    {
        $err_msg = "";
        if (!isset($_COOKIE['sent'])) {
            $err_msg = 'Pre vstup do tejto oblasti musia byť povolené cookies';
        } else {
            $config = $app->getConfig();
            $model = new UsersModel($config);
            $admin_profile = $model->readUser($_POST['username']);
            if(count($admin_profile)>0) {
                $crypt = $admin_profile[0]["password"];
                if ($_POST['username'] != $admin_profile[0]["username"] || !password_verify($_POST['password'], $crypt)) {
                    $err_msg = "Nesprávne ID používateľa alebo heslo";
                } else {
                    session_start();
                    session_unset();
                    setcookie('sent', '', (time() - 365 * 24 * 60 * 60), '/');
                    $_SESSION['username'] = $admin_profile[0]["username"];
                    $_SESSION['crypt'] = $crypt;
                    $_SESSION['lastseen'] = time();
                    header('Location: /dashboard.html');
                    exit();
                }
            } else {
                $err_msg = "Nesprávne ID používateľa alebo heslo";
            }
        }
        $this->login($app);
    }

    /**
     * Metóda zobrazenia formulára na autorizáciu na webovej stránke
     * @param Base $app Inštancia triedy Base
     */
    public function login($app)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $inc = 'login';
        $page_title = 'TM Architektúra. Login';
        $page_desc = 'Vstup do backendu';
        $config = $app->getConfig();
        /*Generovanie a uloženie anti-CSRF tokenu do premennej relácie na ochranu formulára*/
        $token = hash_hmac('sha256', microtime(true) . mt_rand(), $config["secret_key"]);
        setcookie("sent", true, time() + $config['expiry'] * 3600);
        $_SESSION['csrf_token_login'] = $token;
        $_SESSION['csrf_token_time_login'] = time();
        /*//Generovanie a uloženie anti-CSRF tokenu do premennej relácie na ochranu formulára*/
        include_once 'ui/layout.php';
    }

    /**
     * Metóda zobrazenia sekcie správy a monitorovania hlavných parametrov
     * @param Base $app Inštancia triedy Base
     */
    public function dashboard($app)
    {
        if ($this->is_admin) {
            $config = $app->getConfig();
            $model = new MainModel($config);
            $is_next_page = false;
            $total = $model->readCountCrm();
            if ($this->args !== null && property_exists($this->args, "page") && (int)$this->args->page > 1) {
                $page = intval($this->args->page);
                if ($total !== null && count($total) > 0 && $total[0]["count_rows"] > $config["crm_records_per_page"] * $page) {
                    $is_next_page = true;
                }
                $requests = $model->readCrm(($page - 1) * $config["crm_records_per_page"], $config["crm_records_per_page"]);
            } else {
                $requests = $model->readCrm(0, $config["crm_records_per_page"]);
                if ($total !== null && count($total) > 0 && $total[0]["count_rows"] > $config["crm_records_per_page"]) {
                    $is_next_page = true;
                }
                $page = 1;
            }
            $url_parameters = $this->args;
            if ($url_parameters !== null && property_exists($url_parameters, "page")) {
                unset($url_parameters->page);
            }
            $count_pages = ceil((int)$total[0]["count_rows"] / (int)$config["crm_records_per_page"]);
            $inc = 'dashboard';
            $page_title = 'TM Architektúra. Dashboard';
            $page_desc = 'Správa a monitorovanie';
            include_once 'ui/layout.php';
        } else {
            http_response_code(403);
            die('Forbidden');
        }
    }

    /**
     * Metóda odstránenia položky z databázy crm
     * @param Base $app Inštancia triedy Base
     */
    public function deleteRequest($app)
    {
        if ($this->is_admin) {
            $config = $app->getConfig();
            $model = new MainModel($config);
            if ($this->args !== null && property_exists($this->args, "id") && intval($this->args->id) > 0) {
                $model->deleteCrm(intval($this->args->id));
                $total = $model->readCountCrm();
                $url_parameters = $this->args;
                $page = 1;
                if ($total > 0) {
                    $count_pages = ceil((int)$total[0]["count_rows"] / (int)$config["crm_records_per_page"]);
                    $page = (property_exists($this->args, "page") ? $this->args->page : 1);
                }
                if ($url_parameters !== null) {
                    if (property_exists($url_parameters, "page")) {
                        unset($url_parameters->page);
                    }
                    if (property_exists($url_parameters, "id")) {
                        unset($url_parameters->id);
                    }
                }
                $url = "/dashboard.html" . ($page > 1 ? "?page=" . $page . (!empty((array)$url_parameters) ? "&" . $app->parseObject($url_parameters) : "") : (!empty((array)$url_parameters) ? "?" . $app->parseObject($url_parameters) : ""));
                $app->reroute($url);
            }
        } else {
            http_response_code(403);
            die('Forbidden');
        }
    }

    /**
     * Metóda označenia položky v databáze crm ako položky, na ktorú bolo odpovedané
     * @param Base $app Inštancia triedy Base
     */
    public function replyRequest($app)
    {
        if ($this->is_admin) {
            $config = $app->getConfig();
            $model = new MainModel($config);
            if ($this->args !== null && property_exists($this->args, "id") && intval($this->args->id) > 0) {
                $model->updateCrm(intval($this->args->id));
                $total = $model->readCountCrm();
                $url_parameters = $this->args;
                $page = 1;
                if ($total > 0) {
                    $count_pages = ceil((int)$total[0]["count_rows"] / (int)$config["crm_records_per_page"]);
                    $page = (property_exists($this->args, "page") ? $this->args->page : 1);
                }
                if ($url_parameters !== null) {
                    if (property_exists($url_parameters, "page")) {
                        unset($url_parameters->page);
                    }
                    if (property_exists($url_parameters, "id")) {
                        unset($url_parameters->id);
                    }
                }
                $url = "/dashboard.html" . ($page > 1 ? "?page=" . $page . (!empty((array)$url_parameters) ? "&" . $app->parseObject($url_parameters) : "") : (!empty((array)$url_parameters) ? "?" . $app->parseObject($url_parameters) : ""));
                $app->reroute($url);
            }
        } else {
            http_response_code(403);
            die('Forbidden');
        }

    }

}
