<?php
/**
 * Centralized Database Connection Manager
 * Provides single point of database access (MySQLi)
 * PDO is not available on this server, using MySQLi instead
 */

/**
 * MySQLi Prepared Statement Wrapper
 * Provides PDO-compatible interface for MySQLi statements
 */
class MySQLiStatementWrapper {
    private $stmt = null;
    private $result = null;

    public function __construct($mysqli_stmt) {
        $this->stmt = $mysqli_stmt;
    }

    /**
     * Execute prepared statement with parameters (PDO-compatible)
     */
    public function execute($parameters = []) {
        if (empty($parameters)) {
            return $this->stmt->execute();
        }

        // Bind parameters
        // Determine types: 's' for string, 'i' for int, 'd' for double, 'b' for blob
        $types = '';
        foreach ($parameters as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }

        // Call bind_param with variadic arguments
        array_unshift($parameters, $types);
        call_user_func_array([$this->stmt, 'bind_param'], $this->refValues($parameters));

        $result = $this->stmt->execute();
        return $result;
    }

    /**
     * Get rowCount (PDO-compatible)
     */
    public function rowCount() {
        // For SELECT queries, use num_rows
        if ($this->stmt->num_rows !== null) {
            return $this->stmt->num_rows;
        }
        // For INSERT, UPDATE, DELETE use affected_rows
        return $this->stmt->affected_rows;
    }

    /**
     * Fetch one row as associative array
     * Fallback method for servers without mysqlnd driver
     */
    public function fetch() {
        // Check if get_result is available (requires mysqlnd)
        if (method_exists($this->stmt, 'get_result')) {
            if ($this->result === null) {
                $this->result = $this->stmt->get_result();
            }
            if ($this->result) {
                return $this->result->fetch_assoc();
            }
        } else {
            // Fallback: use store_result for servers without mysqlnd
            if ($this->result === null) {
                $this->stmt->store_result();
                $meta = $this->stmt->result_metadata();
                if (!$meta) return false;
                
                $row = [];
                $bindings = [];
                $fields = [];
                
                while ($field = $meta->fetch_field()) {
                    $fields[] = $field->name;
                    $row[$field->name] = null;
                    $bindings[] = &$row[$field->name];
                }
                
                // Use a safer binding approach
                if (count($bindings) > 0) {
                    call_user_func_array([$this->stmt, 'bind_result'], $bindings);
                    
                    if ($this->stmt->fetch()) {
                        $result = [];
                        foreach ($fields as $field) {
                            $result[$field] = $row[$field];
                        }
                        return $result;
                    }
                }
                return false;
            }
        }
        return false;
    }

    /**
     * Fetch all rows
     * Fallback method for servers without mysqlnd driver
     */
    public function fetchAll() {
        $results = [];
        
        // Check if get_result is available (requires mysqlnd)
        if (method_exists($this->stmt, 'get_result')) {
            if ($this->result === null) {
                $this->result = $this->stmt->get_result();
            }
            if ($this->result) {
                return $this->result->fetch_all(MYSQLI_ASSOC);
            }
        } else {
            // Fallback: use bind_result for servers without mysqlnd
            $meta = $this->stmt->result_metadata();
            if (!$meta) return [];
            
            $row = [];
            $params = [];
            
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            
            call_user_func_array([$this->stmt, 'bind_result'], $params);
            
            while ($this->stmt->fetch()) {
                $entry = [];
                foreach ($row as $key => $val) {
                    $entry[$key] = $val;
                }
                $results[] = $entry;
            }
        }
        
        return $results;
    }

    /**
     * Get underlying MySQLi statement
     */
    public function getStatement() {
        return $this->stmt;
    }

    /**
     * Helper to create references for bind_param
     */
    private function refValues(&$arr) {
        $refs = [];
        foreach ($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }
}

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
     * Get MySQLi connection
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Execute a query
     */
    public function query($sql) {
        return $this->connection->query($sql);
    }

    /**
     * Prepare a statement with PDO-compatible interface
     */
    public function prepare($sql) {
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->connection->error);
        }
        // Wrap the MySQLi statement in a compatibility wrapper
        return new MySQLiStatementWrapper($stmt);
    }

    /**
     * Get last insert ID
     */
    public function lastInsertId() {
        return $this->connection->insert_id;
    }

    /**
     * Escape string for safe SQL
     */
    public function escape($value) {
        return $this->connection->real_escape_string($value);
    }

    /**
     * Get affected rows from last query
     */
    public function affectedRows() {
        return $this->connection->affected_rows;
    }

    /**
     * Default configuration
     * ⚠️ DO NOT MODIFY - This configuration is locked for production
     */
    private function getDefaultConfig() {
        return [
            'host' => 'localhost',
            'user' => 'admincourier1',
            'password' => 'admincourier12026#$',
            'database' => 'courier1',
            'port' => 3306,
            'charset' => 'utf8mb4'
        ];
    }

    /**
     * Establish MySQLi connection
     */
    private function connect() {
        try {
            // Set error reporting for MySQLi
            error_reporting(E_ALL);
            
            $this->connection = @mysqli_connect(
                $this->config['host'],
                $this->config['user'],
                $this->config['password'],
                $this->config['database'],
                $this->config['port']
            );

            if (!$this->connection) {
                throw new Exception("Connection failed: " . mysqli_connect_error());
            }

            // Set charset
            if (!$this->connection->set_charset($this->config['charset'])) {
                throw new Exception("Error loading character set utf8mb4: " . $this->connection->error);
            }

        } catch (Exception $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            die("Database connection failed: " . htmlspecialchars($e->getMessage()));
        }
    }

    /**
     * Prevent cloning
     */
    public function __clone() {
        throw new Exception("Cloning is not allowed");
    }

    /**
     * Prevent unserialization
     */
    public function __wakeup() {
        throw new Exception("Unserialization is not allowed");
    }

    /**
     * Get connection error
     */
    public function getError() {
        return $this->connection->error;
    }

    /**
     * Close connection
     */
    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    /**
     * Destructor - close connection
     */
    public function __destruct() {
        $this->closeConnection();
    }
}

// Create global database instance
$DB = Database::getInstance();
