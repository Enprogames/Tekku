<?php

require ('Config.php');

class DBConnection {
    private $pdo, $config;

    public function connect() {
        $this->config = new Config();
        if ($this->pdo == null) {
            try {
                $this->pdo = new PDO($this->config->DB_URL, $this->config->DB_USER, $this->config->DB_PASS);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //set the error mode to exception
            } catch (PDOException $e) {
                $e->getMessage();
                throw $e;
            }
        }
        return $this->pdo;
    }
}
