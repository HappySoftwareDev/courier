<?php
/**
 * Centralized Database Connection Manager
 * Provides single point of database access (PDO)
 */

class Database {
    private static $instance = null;
    private $connection = null;
    private $config = [];

    private function __construct($config = []) {
        $this->config = array_merge($this->getDefaultConfig(), $config);
        $this->connect();
    }

    /**
     * Get or create database instance (Singleton pattern)
     */
    public static function getInstance($config = []) {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * Get PDO connection
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Execute a query (for backward compatibility with existing code)
     */
    public function query($sql) {
        return $this->connection->query($sql);
    }

    /**
     * Prepare a statement
     */
    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }

    /**
     * Get last insert ID
     */
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    /**
     * Default configuration
     */
    private function getDefaultConfig() {
        return [
            'host' => 'localhost',
            'user' => 'wgroosco_wp598app',
            'password' => 'Appwgrooscourier2024#$',
            'database' => 'wgroosco_app.wgroos',
            'charset' => 'utf8mb4'
        ];
    }

    /**
     * Establish PDO connection
     */
    private function connect() {
        try {
            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['database']};charset={$this->config['charset']}";
            
            $this->connection = new PDO(
                $dsn,
                $this->config['user'],
                $this->config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            die("Database connection failed. Please try again later.");
        }
    }

    /**
     * Prevent cloning
     */
    private function __clone() {}

    /**
     * Prevent unserialization
     */
    private function __wakeup() {}
}

// Create global database instance
$DB = Database::getInstance();
?>


