<?php

namespace App;

use stdClass;

/**
 * Class Base
 * Trieda Base je dispatcher/router/render. Určuje, ktorý kontrolér a akciu treba volať na základe URL adresy požiadavky
 * Trieda Base predstavuje triedu, ktorá implementuje Singleton návrhový vzor.
 * @package App
 */
class Base
{
    private static $_instance = null;
    private array $ROUTES;
    private array $config;

    /**
     * Base constructor.
     * Konštruktor triedy Base so zabezpečením proti duplikácii.
     */
    private function __construct()
    {
        ini_set('default_charset', $charset = 'UTF-8'); // nastavenie predvoleného kódovania na unicode pre spracovanie údajov pri prenose medzi klientom a serverom
        if (extension_loaded('mbstring')) {
            mb_internal_encoding($charset); // nastavenie kódovania unicode pre funkcie z rozšírenia php mbstring
        }
        /*Nastavenie výstupu chybových správ*/
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        /*//Nastavenie výstupu chybových správ**/
        if (!isset($_SERVER['SERVER_NAME']) || $_SERVER['SERVER_NAME'] === '') {
            $_SERVER['SERVER_NAME'] = gethostname();
        }
        /*Registrácia anonymnej funkcie pre automatické načítanie tried*/
        spl_autoload_register(function ($class) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
            return false;
        });
    }

    /**
     * Singleton
     * V prípade, že existuje už jediný exemplár triedy Base, táto metóda vráti referenciu na tento exemplár. Ak
     * neexistuje, vytvorí sa nový a táto metóda vráti referenciu na novovytvorený objekt.
     * @return Base|null Jediný exemplár triedy Base (Singleton)
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Metóda na pridanie cesty do routovacieho poľa
     * @param string $path Šablóna cesty
     * @param string $func Prepojený kontrolér a metóda
     */
    public function addRoute($path, $func)
    {
        $this->ROUTES[] = array($path, $func);
    }

    /**
     * Metóda centrálneho kontroléra (front controller), ktorá je zodpovedná za spracovanie požiadaviek na základe
     * pravidla smerovania.
     * @param array $config Pole s nastaveniami webovej stránky
     */
    public function run($config)
    {
        $this->config = $config;
        $urlArr = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $key = array_search($_SERVER['REQUEST_METHOD'] . ' ' . $urlArr, array_column($this->ROUTES, 0));
        list($class, $func) = explode('->', $this->ROUTES[$key][1]);
        if ($key !== false) {
            $controllername = 'App\\' . $class;
            $this->render($controllername, $func);
        } else {
            http_response_code(404);
            $error_code = "404";
            $error_title = "Not Found";
            $error_desc = "The requested URL was not found on this server.";
            include_once('ui/404.php');
            die();
        }
    }

    /**
     * Spôsob prípravy reprezentácie dátového modelu pomocou kontroléra
     * @param string $controllername Názov triedy kontroléra
     * @param string $func Názov metódy kontroléra
     * @noinspection PhpUndefinedMethodInspection
     */
    private function render($controllername, $func)
    {
        $controller = new $controllername($_REQUEST);
        ob_start();
        $controller->run($func);
        $body = ob_get_clean();
        echo $body;
    }

    /**
     * Metóda presmerovania požiadavky na inú stránku
     * @param string $url Nová adresa URL pre presmerovanie
     */
    public function reroute($url)
    {
        header('Location: ' . $url);
        exit();
    }

    /**
     * Getter konfiguračného dátového poľa
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Metóda na prevod dvojrozmerného asociatívneho poľa (kľúč:hodnota) na reťazec, ktorý sa pridá do url ako reťazec parametrov.
     * @param stdClass $obj Asociatívne pole na vstupe
     * @return string Reťazec, ktorý sa pridá do url ako reťazec parametrov
     */
    public function parseObject($obj)
    {
        return implode("&", array_map(function ($key, $value) {
            return $key . "=" . $value;
        }, array_keys(get_object_vars($obj)), array_values(get_object_vars($obj))));
    }

}

return Base::getInstance(); // Vrátiť jednu inštanciu objektu triedy Base