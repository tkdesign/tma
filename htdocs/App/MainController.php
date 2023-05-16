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
        if (session_status() === PHP_SESSION_NONE) {
            // funkcia session_start() ešte nebola zavolaná
            session_start();
        }
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
                if (session_status() === PHP_SESSION_NONE) {
                    // funkcia session_start() ešte nebola zavolaná
                    session_start();
                }
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
            if (count($admin_profile) > 0) {
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
     * Metóda odstránenia položky z tabuľky crm
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
     * Metóda označenia položky v tabuľke crm ako položky, na ktorú bolo odpovedané
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

    /**
     * Metóda zobrazenia zoznamu projektov uložených v tabuľke projects_$lang
     * @param Base $app Inštancia triedy Base
     */
    public function portfolioEdit($app)
    {
        if ($this->is_admin) {
            $config = $app->getConfig();
            $model = new MainModel($config);
            $is_next_page = false;
            $total = $model->readCountCards();
            if ($this->args !== null && property_exists($this->args, "page") && (int)$this->args->page > 1) {
                $page = intval($this->args->page);
                if ($total !== null && count($total) > 0 && $total[0]["count_rows"] > $config["cards_records_per_page"] * $page) {
                    $is_next_page = true;
                }
                $requests = $model->readCards(($page - 1) * $config["cards_records_per_page"], $config["cards_records_per_page"]);
            } else {
                $requests = $model->readCards(0, $config["cards_records_per_page"]);
                if ($total !== null && count($total) > 0 && $total[0]["count_rows"] > $config["cards_records_per_page"]) {
                    $is_next_page = true;
                }
                $page = 1;
            }
            $url_parameters = $this->args;
            if ($url_parameters !== null && property_exists($url_parameters, "page")) {
                unset($url_parameters->page);
            }
            $count_pages = ceil((int)$total[0]["count_rows"] / (int)$config["cards_records_per_page"]);
            $inc = 'edit';
            $page_title = 'TM Architektúra. Portfolio editor';
            $page_desc = 'Portfolio editor';
            include_once 'ui/layout.php';
        } else {
            http_response_code(403);
            die();
        }
    }

    /**
     * Metóda odstránenia položky z tabuľky projects_$lang
     * @param Base $app Inštancia triedy Base
     */
    public function getCategories($app)
    {
        if ($this->is_admin) {
            $config = $app->getConfig();
            $model = new MainModel($config);
            $all_categories = $model->getCategories();
            if (count($all_categories) > 0) {
                $response = json_encode($all_categories);
                $app->returnJsonHttpResponse(true, $response);
            } else {
                $response = json_encode(array('status' => FALSE));
                $app->returnJsonHttpResponse(false, $response);
            }
        } else {
            http_response_code(403);
            die();
        }
    }

    /**
     * Metóda odstránenia položky z tabuľky projects_$lang
     * @param Base $app Inštancia triedy Base
     */
    public function detailsCard($app)
    {
        if ($this->is_admin) {
            $config = $app->getConfig();
            $model = new MainModel($config);
            if ($this->args !== null && property_exists($this->args, "id") && intval($this->args->id) > 0) {
                $id = intval($this->args->id);
                $project = $model->readCard($id);
                if (count($project) > 0) {
                    $all_categories = $model->getCategories();
                    $linked_categories = $model->getLinkedCategories($id);
                    $response = json_encode(array($project[0], $all_categories, $linked_categories));
                    $app->returnJsonHttpResponse(true, $response);
                } else {
                    $response = json_encode(array('status' => FALSE));
                    $app->returnJsonHttpResponse(false, $response);
                }
            }
        } else {
            http_response_code(403);
            die();
        }
    }

    /**
     * Metóda odstránenia položky z tabuľky projects_$lang
     * @param Base $app Inštancia triedy Base
     */
    public function deleteCard($app)
    {
        if ($this->is_admin) {
            $config = $app->getConfig();
            $model = new MainModel($config);
            if ($this->args !== null && property_exists($this->args, "id") && intval($this->args->id) > 0) {
                $project = $model->readCard(intval($this->args->id));
                if (count($project)>0) {
                    $res = $model->deleteCard(intval($this->args->id));
                    if ($res) {
                        $previewPath = $_SERVER['DOCUMENT_ROOT'] . '/img/preview/' . $project[0]['image'];
                        $originalPath = $_SERVER['DOCUMENT_ROOT'] . '/img/details/' . $project[0]['image'];
                        try {
                            if(file_exists($previewPath) && is_file($previewPath)) {
                                unlink($previewPath);
                            }
                            if(file_exists($originalPath) && is_file($originalPath)) {
                                unlink($originalPath);
                            }
                        } catch (\Exception $err) {

                        }
                    }
                }
                $total = $model->readCountCards();
                $url_parameters = $this->args;
                $page = 1;
                if ($total > 0) {
                    $count_pages = ceil((int)$total[0]["count_rows"] / (int)$config["cards_records_per_page"]);
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
                $url = "/edit.html" . ($page > 1 ? "?page=" . $page . (!empty((array)$url_parameters) ? "&" . $app->parseObject($url_parameters) : "") : (!empty((array)$url_parameters) ? "?" . $app->parseObject($url_parameters) : ""));
                $app->reroute($url);
            }
        } else {
            http_response_code(403);
            die();
        }
    }

    /**
     * Metóda aktualizácie údajov v tabuľke projects_$lang
     * @param $app Inštancia triedy Base
     */
    public function updateCard($app)
    {
        if ($this->is_admin) {
            $config = $app->getConfig();
            $status = false;
            $message = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_FILES['image'])&&!empty($_FILES['image']['name'])) {
                    $originalName = basename($_FILES['image']['name']);
                    $originalName = uniqid("tma") . "." . $originalName;
                    $targetFile = $_SERVER['DOCUMENT_ROOT'].'/img/details/' . $originalName;
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                    $check = getimagesize($_FILES['image']['tmp_name']);
                    // Kontrola, či je súbor s obrázkom skutočný obrázok alebo nie
                    if ($check !== false) {
                        $width = $check[0];
                        $height = $check[1];
                        // Kontrola určitých formátov súborov
                        if ($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                            $message = 'Povolené sú len súbory JPG, JPEG, PNG a GIF.';
                        } else {
                            // Nahratie originálneho súboru
                            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                                // Vytvorenie náhľadu
                                $thumbWidth = 600;
                                $thumbHeight = intval($height / $width * $thumbWidth);
                                $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
                                switch ($imageFileType) {
                                    case 'jpg':
                                    case 'jpeg':
                                        $originalImage = imagecreatefromjpeg($targetFile);
                                        break;
                                    case 'png':
                                        $originalImage = imagecreatefrompng($targetFile);
                                        break;
                                    case 'gif':
                                        $originalImage = imagecreatefromgif($targetFile);
                                        break;
                                }
                                imagecopyresized($thumbImage, $originalImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
                                $thumbFile = $_SERVER['DOCUMENT_ROOT'] . '/img/preview/' . $originalName;
                                switch ($imageFileType) {
                                    case 'jpg':
                                    case 'jpeg':
                                        imagejpeg($thumbImage, $thumbFile);
                                        break;
                                    case 'png':
                                        imagepng($thumbImage, $thumbFile);
                                        break;
                                    case 'gif':
                                        imagegif($thumbImage, $thumbFile);
                                        break;
                                }
                                imagedestroy($thumbImage);
                                imagedestroy($originalImage);
                                $data = new stdClass();
                                foreach ($_POST as $key => $value) {
                                    $data->$key=$value;
                                }
                                $data->image = $originalName;
                                $data->image_ImageWidth = $width;
                                $data->image_ImageHeight = $height;
                                if (property_exists($data, "published") && $data->published === "true") {
                                    $data->published = 1;
                                } else {
                                    $data->published = 0;
                                }
                                $model = new MainModel($config);
                                $project = $model->readCard(intval($data->id));
                                if (count($project)>0) {
                                    $previewPath = $_SERVER['DOCUMENT_ROOT'] . '/img/preview/' . $project[0]['image'];
                                    $originalPath = $_SERVER['DOCUMENT_ROOT'] . '/img/details/' . $project[0]['image'];
                                    try {
                                        if(file_exists($previewPath) && is_file($previewPath)) {
                                            unlink($previewPath);
                                        }
                                        if(file_exists($originalPath) && is_file($originalPath)) {
                                            unlink($originalPath);
                                        }
                                    } catch (\Exception $err) {

                                    }
                                }
                                if ($model->updateCard($data)) {
                                    $status = true;
                                }
                            } else {
                                $message = 'Chyba pri nahrávaní vášho súboru.';
                            }
                        }
                    } else {
                        $message = 'Súbor nie je obrázok.';
                    }
                } else {
                    $data = new stdClass();
                    foreach ($_POST as $key => $value) {
                        $data->$key=$value;
                    }
                    $data->image = $data->image_name;
                    $data->image_ImageWidth = $data->image_width;
                    $data->image_ImageHeight = $data->image_height;
                    if (property_exists($data, "published") && $data->published === "true") {
                        $data->published = 1;
                    } else {
                        $data->published = 0;
                    }
                    $model = new MainModel($config);
                    if ($model->updateCard($data)) {
                        $status = true;
                    }
                }
            }
            $response = json_encode(array('status' => $status,'message' => $message));
            $app->returnJsonHttpResponse($status, $response);
        } else {
            http_response_code(403);
            die();
        }
    }

    /**
     * Metóda vkladania rekordu do tabuľky projects_$lang
     * @param Base $app Inštancia triedy Base
     */
    public function insertCard($app)
    {
        if ($this->is_admin) {
            $config = $app->getConfig();
            $status = false;
            $message = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
                $originalName = basename($_FILES['image']['name']);
                $originalName = uniqid("tma") . "." . $originalName;
                $targetFile = $_SERVER['DOCUMENT_ROOT'].'/img/details/' . $originalName;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                $check = getimagesize($_FILES['image']['tmp_name']);
                // Kontrola, či je súbor s obrázkom skutočný obrázok alebo nie
                if ($check !== false) {
                    $width = $check[0];
                    $height = $check[1];
                    // Kontrola určitých formátov súborov
                    if ($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                        $message = 'Povolené sú len súbory JPG, JPEG, PNG a GIF.';
                    } else {
                        // Nahratie originálneho súboru
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                            // Vytvorenie náhľadu
                            $thumbWidth = 600;
                            $thumbHeight = intval($height / $width * $thumbWidth);
                            $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
                            switch ($imageFileType) {
                                case 'jpg':
                                case 'jpeg':
                                    $originalImage = imagecreatefromjpeg($targetFile);
                                    break;
                                case 'png':
                                    $originalImage = imagecreatefrompng($targetFile);
                                    break;
                                case 'gif':
                                    $originalImage = imagecreatefromgif($targetFile);
                                    break;
                            }
                            imagecopyresized($thumbImage, $originalImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
                            $thumbFile = $_SERVER['DOCUMENT_ROOT'] . '/img/preview/' . $originalName;
                            switch ($imageFileType) {
                                case 'jpg':
                                case 'jpeg':
                                    imagejpeg($thumbImage, $thumbFile);
                                    break;
                                case 'png':
                                    imagepng($thumbImage, $thumbFile);
                                    break;
                                case 'gif':
                                    imagegif($thumbImage, $thumbFile);
                                    break;
                            }
                            imagedestroy($thumbImage);
                            imagedestroy($originalImage);
                            $data = new stdClass();
                            foreach ($_POST as $key => $value) {
                                $data->$key=$value;
                            }
                            $data->image = $originalName;
                            $data->image_ImageWidth = $width;
                            $data->image_ImageHeight = $height;
                            if (property_exists($data, "published") && $data->published === "true") {
                                $data->published = 1;
                            } else {
                                $data->published = 0;
                            }
                            $model = new MainModel($config);
                            if ($model->insertCard($data)) {
                                $status = true;
                            }
                        } else {
                            $message = 'Chyba pri nahrávaní vášho súboru.';
                        }
                    }
                } else {
                    $message = 'Súbor nie je obrázok.';
                }
            }
            $response = json_encode(array('status' => $status,'message' => $message));
            $app->returnJsonHttpResponse($status, $response);
        } else {
            http_response_code(403);
            die();
        }
    }

}
