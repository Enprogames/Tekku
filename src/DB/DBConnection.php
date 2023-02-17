<?php

require ('DB/Config.php');

class DBConnection {
    private $pdo, $config;

    public function connect() {
        $this->config = new Config();
        if ($this->pdo == null) {
            try {
                $this->pdo = new \PDO($this->config->DB_URL, $this->config->DB_USER, $this->config->DB_PASS);
            } catch (\PDOException $e) {
                $e->getMessage();
            }
        }
        return $this->pdo;
    }
}
