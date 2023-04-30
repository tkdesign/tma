<?php

namespace App;

/**
 * Класс для серверной проверки учетных данных и импорта сайта на целевой сервер
 */
class MainModel extends Model
{

    /**
     * Конструктор класс MainModel, передающий в конструктор базового класса массив учетных данных для подключения к базе данных
     * @param array $config Массив учетных данных из конфигурационного файла
     */
    public function __construct($config)
    {
        parent::__construct($config);
    }

    /**
     * Обертка для стандартной функции экранирования строк для безопасного использования в sql-запросах
     * @param string $text Исходная строка
     * @param bool $extra Режим расширенного экранирования
     * @return string Экранированная строка
     */
    protected function quote($text, $extra = false)
    {
        $result = $this->db->real_escape_string($text);
        if ($extra) {
            $result = addcslashes($result, '%_');
        }
        return $result;
    }

    public function connect()
    {
        // TODO: Implement connect() method.
    }
}