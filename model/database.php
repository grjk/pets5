<?php

require_once("config.php");

Class Database
{
    // PDO object
    private $_dbh;

    function __construct()
    {
        try {
            // Create connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e) {
            echo $e->getMEssage();
        }
    }
}