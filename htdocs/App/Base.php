<?php

namespace App;

/**
 * Класс Base, реализующий механизмы автозагрузки классов, маршрутизации, вызова контроллеров и рендеринга шаблонов
 */
class Base
{
    private static $_instance = null;
    private $ROUTES;

    /**
     * Конструктор класса Base с защитой от дублирования.
     * Настройка вывода сообщений об ошибках, выбор кодировки, установка значений свойств, настройка автозагрузки классов
     */
    private function __construct()
    {
        ini_set('default_charset', $charset = 'UTF-8');
        if (extension_loaded('mbstring')) {
            mb_internal_encoding($charset);
        }
        ini_set('display_errors', 1);
        error_reporting((E_ALL | E_STRICT) & ~(E_NOTICE | E_USER_NOTICE));
        if (!isset($_SERVER['SERVER_NAME']) || $_SERVER['SERVER_NAME'] === '') {
            $_SERVER['SERVER_NAME'] = gethostname();
        }
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
     * Точка входа в класс Base для получения единственного экземпляра класса
     * @return Base|null Статический экземпляр класса Base
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Метод добавления нового маршрута в массив маршрутизации
     * @param string $path Шаблон запроса
     * @param string $func Связанный контроллер и метод
     */
    function addRoute($path, $func)
    {
        $this->ROUTES[] = array($path, $func);
    }

    /**
     * Основной метод класса, выполняющий маршрутизацию запросов, вызов соответствующих контроллеров и рендеринг шаблонов
     */
    function run()
    {
        $urlArr = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($urlArr[mb_strlen($urlArr) - 1] != '/') {
            $urlArr .= '/';
        }
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
     * Метод для рендеренига шаблонов
     * @param string $controllername Название класса контроллера
     * @param string $func Название метода контроллера
     */
    private function render($controllername, $func)
    {
        $controller = new $controllername($_REQUEST);
        ob_start();
        $controller->run($func, $_REQUEST);
        $body = ob_get_clean();
        echo $body;
    }

    /**
     * Метод перенаправления на другую страницу
     * @param string $url Новый URL-адрес для перенаправления
     */
    function reroute($url)
    {
        header('Location: ' . $url);
        exit();
    }

    /**
     * Метод отправки ответа сервера в формате application/json
     * @param int $success Код ответа сервера
     * @param string $data Сериализованные в строку данные в формате JSON
     */
    function returnJsonHttpResponse($success, $data)
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

}

return Base::getInstance();