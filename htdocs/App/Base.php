<?php

namespace App;

/**
 * Class Base
 * Trieda Base je dispatcher/router/render. Určuje, ktorý kontrolér a akciu treba volať na základe URL adresy požiadavky
 * Trieda Base predstavuje triedu, ktorá implementuje Singleton návrhový vzor.
 * @package App
 */
class Base
{
    private static $_instance = null;
    private $ROUTES;
    private $config;

    /**
     * Base constructor.
     * Konštruktor triedy Base so zabezpečením proti duplikácii.
     */
    private function __construct()
    {
        ini_set('default_charset', $charset = 'UTF-8'); // установка в качестве кодировки по умолчанию кодировки юникод для обработки данных при передаче между клиентом и сервером
        if (extension_loaded('mbstring')) {
            mb_internal_encoding($charset); // установка кодировки юникод для функций из расширения php mbstring
        }
        /*Настрйка вывода сообщений об ошибках*/
        ini_set('display_errors', 1);
        error_reporting((E_ALL | E_STRICT) & ~(E_NOTICE | E_USER_NOTICE));
        /*//Настрйка вывода сообщений об ошибках*/
        if (!isset($_SERVER['SERVER_NAME']) || $_SERVER['SERVER_NAME'] === '') {
            $_SERVER['SERVER_NAME'] = gethostname();
        }
        /*Регистрация анонимной функции для автозагрузки классов*/
        spl_autoload_register(function ($class) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
            return false;
        });
//        self::$_instance = $this;
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
     */
    public function run($config)
    {
        $this->config = $config;
        $urlArr = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        /*if ($urlArr[mb_strlen($urlArr) - 1] != '/') {
            $urlArr .= '/';
        }*/
        $key = array_search($_SERVER['REQUEST_METHOD'] . ' ' . $urlArr, array_column($this->ROUTES, 0));
        list($class, $func) = explode('->', $this->ROUTES[$key][1]);
        if ($key !== false) {
            $controllername = 'App\\' . $class;
            $this->render($controllername, $func);
        } else {
            http_response_code(404);
            include_once('ui/404.php');
            die();
        }
    }

    /**
     * Spôsob prípravy reprezentácie dátového modelu pomocou kontroléra
     * @param string $controllername Názov triedy kontroléra
     * @param string $func Názov metódy kontroléra
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
     * Metóda odoslania odpovede servera vo formáte application/json
     * @param int $success Kód odpovede servera
     * @param string $data Serializované údaje vo formáte JSON
     */
    public function returnJsonHttpResponse($success, $data)
    {
        ob_clean();
        header_remove();
        header("Content-type: application/json; charset=utf-8");
        if ($success) {
            http_response_code(200);
        } else {
            http_response_code(500);
        }
        echo $data;
        exit();
    }

    /**
     * Getter konfiguračného dátového poľa
     * @return array
     */
    public function getConfig() {
        return $this->config;
    }

}

return Base::getInstance();