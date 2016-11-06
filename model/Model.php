<?php

require_once File::build_path(array('config', 'Conf.php'));

/**
 * Model provides data managment and interactions to the database
 *
 *
 * Clement's commit
 *
 *      Function Init ,error ,
 *
 * TODO accessors - selectors
 */
class Model
{
    /**
     * PDO Object provides the query management
     */
    public static $pdo;

    public static function Init(){
        $hostname = Conf::getHostname();
        $database_name = Conf::getDatabase();
        $login = Conf::getLogin();
        $password = Conf::getPassword();

        try {
            self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name",$login,$password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            if (Conf::getDebug())   echo $e->getMessage();
            else                    echo "Une erreur est survenue ! Merci de réessayer plus tard";
            die();
        }

    }

    public static function error($error) {
        $displayError = $error;
        $view = 'error';
        $pagetitle= 'MyGuestHouse - Erreur';
        $powerNeeded = true;
        require File::build_path(array('view', 'view.php'));
    }
}
Model::Init();