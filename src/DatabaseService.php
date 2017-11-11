<?php

namespace Justly;


class DatabaseService
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @var DatabaseService
     */
    private static $instance;

    /**
     * @var array
     */
    private static $defaultPdoParameters;

    /**
     * Sets the parameters used to create the pdo connection for the shared instance returned by getInstance()
     *
     * @param array $defaultPdoParameters
     */
    public static function setDefaultPdoParameters(array $defaultPdoParameters)
    {
        self::$defaultPdoParameters = $defaultPdoParameters;
    }

    /**
     * Returns a shared database service instance for the application.
     *
     * @return DatabaseService
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            $pdo = new \PDO(...self::$defaultPdoParameters);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$instance = new self($pdo);
        }

        return self::$instance;
    }


}