<?php
/**
 * dbname : MyGuestHouse
 */

class Conf {
    // Configuration de Florian (HOME)
    /*static private $databases = array (
        'hostname' => 'localhost',
        'database' => 'MyGuestHouse',
        'login' => 'root',
        'password' => 'root'
    );*/

    // Configuration de Clément (HOME)
    /*static private $databases = array (
        'hostname' => 'localhost',
        'database' => 'desbinq',
        'login' => 'root',
        'password' => 'tdlepd2803'
    );*/

    // Configuration de Quentin (HOME) (Si vous ne voulez pas utiliser ma conf, merci de la commenter en utilisant des  /* */ et pas des // :))
    static private $databases = array (
        'hostname' => 'localhost',
        'database' => 'MyGuestHouse',
        'login' => 'root',
        'password' => ''
    );

    // Configuration IUT
    /*static private $databases = array (
        'hostname' => 'infolimon',
        'database' => 'desbinq',
        'login' => 'desbinq',
        'password' => 'azerty123'
    );*/

    static public $theme = 'default';

    static private $debug = true;

    static public $power = array(
        'admin' => 100,
        'membre' => 10,
        'visiteur' => 0
    );

    static public function getHostname() {
        return self::$databases['hostname'];
    }

    static public function getDatabase() {
        return self::$databases['database'];
    }

    static public function getLogin() {
        return self::$databases['login'];
    }

    static public function getPassword() {
        return self::$databases['password'];
    }

    static public function getDebug() {
        return self::$debug;
    }
}

