<?php

namespace OxygenzSAS\Paypal;

use PDO;
use PDOException;

class Database {
    // Instance unique de la classe (Singleton)
    private static $instance = null;

    // L'objet PDO pour la connexion à la base de données
    private static $options = [];
    private static $password = null;
    private static $username = null;
    private static $dsn;
    private $pdo;

    // Constructeur privé pour empêcher l'instanciation directe
    private function __construct($dsn, $username = null, $password = null, $options = []) {
        try {
            $this->pdo = new PDO($dsn, $username, $password, $options);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    // Méthode statique pour obtenir l'instance unique de la classe
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self(self::$dsn, self::$username, self::$password, self::$options);
        }
        return self::$instance;
    }

    // Méthode pour récupérer l'ID de la dernière ligne insérée
    public function getLastInsertId() {
        try {
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'ID de la dernière insertion : " . $e->getMessage();
            return null;
        }
    }

    // Méthode pour obtenir l'objet PDO pour exécuter des requêtes SQL
    public static function setOptions(array $options)
    {
        self::$options = $options;
    }

    /**
     * @param null $password
     */
    public static function setPassword($password)
    {
        self::$password = $password;
    }

    /**
     * @param null $username
     */
    public static function setUsername($username)
    {
        self::$username = $username;
    }

    /**
     * @param mixed $dsn
     */
    public static function setDsn($dsn)
    {
        self::$dsn = $dsn;
    }

    public function getConnection() {
        return $this->pdo;
    }

    // Empêcher la duplication de l'instance avec __clone
    public function __clone() {}

    // Empêcher la restauration de l'objet avec __wakeup
    public function __wakeup() {}

    // Méthode pour exécuter une requête SQL (select, insert, update, delete)
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt; // Retourne le statement PDO pour pouvoir récupérer les résultats
        } catch (PDOException $e) {
            echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
            return false;
        }
    }

    // Fonction dynamique pour créer une table avec une colonne auto-incrémentée
    public function getAutoIncrementSyntax() {
        // Détecter le type de base de données
        $dbType = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

        // Générer la syntaxe de la colonne auto-incrémentée en fonction du SGBD
        switch ($dbType) {
            case 'mysql':
                $autoIncrementSyntax = 'INT AUTO_INCREMENT PRIMARY KEY';
                break;
            case 'pgsql':
                // Utilisation de SERIAL pour PostgreSQL
                $autoIncrementSyntax = 'SERIAL';
                break;
            case 'sqlite':
                // SQLite utilise INTEGER PRIMARY KEY AUTOINCREMENT
                $autoIncrementSyntax = 'INTEGER PRIMARY KEY AUTOINCREMENT';
                break;
            case 'sqlsrv':
                // SQL Server utilise IDENTITY
                $autoIncrementSyntax = 'INT IDENTITY(1,1) PRIMARY KEY';
                break;
            default:
                throw new \Exception("Base de données non prise en charge : $dbType");
        }

        return $autoIncrementSyntax;
    }
}