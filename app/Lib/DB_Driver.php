<?php


namespace App\Lib;


class DB_Driver
{
    public $dbhost, $dbport, $dbuser, $dbpswd, $dbname, $dbcharset; // Данные по подключению к базе
    public $table; // Имя рабочей таблицы
    public $DB; // Указатель на базу данных
    protected $response;

}