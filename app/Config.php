<?php


namespace App;


class Config
{
    const ADMIN_LOGIN = 'admin';
    const SITE_URL = 'http://gfl.test';

    const PATH_TO_TEMPLATES = __DIR__ . '/../public/templates';
    const PATH_TO_IMAGES = '/public/img/';
    const PATH_TO_PUBLIC = '/public/';

    const NAME_ACTIONS = 'action';

    const DEFAULT_ACTION = 'index';

    const SITE_NAME = 'Library Test';

    /** DATABASE */
    const DB_HOST = '127.0.0.1';
    const DB_USER = 'gfl.test';
    const DB_NAME = 'gfl.test';
    const DB_PASS = '*yBC$Pb89wm!aEY';
    const DB_CHARSET = 'utf8';

    /** /DATABASE */

    /** MAILER */
    const ADDRESS_FROM = 'noreply.girafffee@gmail.com';
    const ADDRESS_PASS = 'SaNkO20001221';
    const ADDRESS_ADMIN = 'sanko200065@gmail.com';
    /** /MAILER */

    public static function inc($path)
    {
        if(file_exists($path))
            include "$path";
        else
            include "../$path";
    }

    public static function img($name = 'default.jpg')
    {
        return self::PATH_TO_IMAGES . $name;
    }

    public static function pub($path)
    {
        return self::PATH_TO_PUBLIC . $path;
    }


}