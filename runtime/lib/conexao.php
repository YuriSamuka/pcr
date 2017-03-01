<?php

define('HOST', 'localhost');
define('DBNAME', 'pcr_db_28_01_2017');
define('CHARSET', 'utf8');
define('USER', 'root');
define('PASSWORD', '');

/**
 * @author : Yuri Samuel
 * @since : 29/01/2017 01:25
 * @version: 1.0
 *
 */

class Conexao
{
    private static $pdo;

    private function __construct() {
    }
    public static function instaciar(){
        if (!isset(self::$pdo)){
            try {
                $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', PDO::ATTR_PERSISTENT => true);
                self::$pdo = new PDO('mysql:host=' . HOST . '; dbname=' . DBNAME . '; charset=' . CHARSET . ';', USER, PASSWORD, $opcoes);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (PDOException $e){
                print 'Erro: ' . $e->getMessage();
            }
        }
    return self::$pdo;
    }
}