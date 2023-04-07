<?php

class Config {
    /**
     * Stores configuration details for this project, such as
     * the URL for the MySQL database
     */
    public $DB_HOST, $DB_PORT, $DB_NAME, $CHARSET, $DB_USER, $DB_PASS, $DB_URL;

    public function __construct() {
        $this->DB_HOST = $_ENV['DB_HOST'];
        $this->DB_PORT = $_ENV['DB_PORT'];
        $this->DB_NAME = $_ENV['DB_NAME'];
        $this->CHARSET = 'utf8';
        $this->DB_USER = $_ENV['DB_USER'];
        $this->DB_PASS = $_ENV['DB_PASS'];
        $this->DB_URL = "mysql:host={$this->DB_HOST};port={$this->DB_PORT};dbname={$this->DB_NAME};charset={$this->CHARSET}";
    }
}
