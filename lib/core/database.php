<?php

/**
 * @class Database
 * @extends PDO
 */
class Database extends PDO
{
    const DEFAULT_SETTING = 'default';
    const DEFAULT_CHARSET = 'UTF-8';

    /** @var Database[] $instance */
    private static $instance;

    /**
     * Get connection from database setting
     * @param string $setting
     * @return Database
     */
    public static function getConnection($setting = self::DEFAULT_SETTING)
    {
        if (!self::$instance[$setting]) {
            $config = self::getSettings($setting);
            self::$instance[$setting] = new self(
                self::createDSN($config),
                $config['user'],
                $config['pass']
            );
            self::$instance[$setting]->setAttribute(self::ATTR_ERRMODE, self::ERRMODE_EXCEPTION);
        }
        return self::$instance[$setting];
    }

    /**
     * Get defined config settings
     * @param $key
     * @return mixed
     * @throws PDOException
     * @throws Exception
     */
    public static function getSettings($key)
    {
        $ini_file = ROOT_DIR . 'config/databases.ini';
        if (!file_exists($ini_file)) {
            throw new Exception('databases.ini not found.');
        }

        $ini_config = parse_ini_file($ini_file, true);
        if (!array_key_exists($key, $ini_config) || !$ini_config[$key]) {
            throw new PDOException('No config settings for "' . $key . '"');
        }

        return $ini_config[$key];
    }

    /**
     * Create data source name from config
     * @param array $config
     * @return string
     */
    protected static function createDSN(array $config)
    {
        $charset = (array_key_exists('charset', $config) && $config['charset']) ?
            $config['charset'] : self::DEFAULT_CHARSET;
        return $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['db'] . ';charset=' . $charset;
    }

    /**
     * Run sql command and bind parameters
     * @param string $command
     * @param $bind
     * @return PDOStatement
     */
    public function run($command, $bind = null)
    {
        $statement = $this->prepare($command);
        $statement->execute($bind);
        return $statement;
    }
}