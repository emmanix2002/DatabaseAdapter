<?php

namespace Emmanix2002\DatabaseAdapter;

use Emmanix2002\DatabaseAdapter\Exception\ConfigurationException;
use Emmanix2002\DatabaseAdapter\Exception\ConnectionException;
use PDO;

/**
 * Class MySqlAdapter
 *
 * @package Emmanix2002\DatabaseAdapter
 */
class MySqlAdapter implements AdapterInterface
{
    /**
     * The instance of the \PDO class
     *
     * @var \PDO
     */
    private $connection;
    
    /**
     * The database host
     *
     * @var string
     */
    private $host;
    
    /**
     * The database user
     *
     * @var string
     */
    private $user;
    
    /**
     * The database user's password
     *
     * @var string
     */
    private $password;
    
    /**
     * The database schema name
     *
     * @var string
     */
    private $schema;
    
    /**
     * The default connection configuration used with the create() method
     *
     * @var array
     */
    private static $defaultConfig = ['host' => 'localhost', 'schema' => '', 'password' => '', 'user' => 'root'];
    
    /**
     * This is a utility method that returns an instance of the class; allowing you to pass an associative array
     * containing the configuration while providing defaults.
     * The available configuration keys are:
     *  host        the database hostname (required, default: localhost)
     *  user        the database user (default: root)
     *  password    the database user password
     *  schema      the database schema to connect to
     *  autoconnect whether or not to automatically call the connect() method
     *
     * @param array $config
     *
     * @return MySqlAdapter
     */
    public static function create(array $config = []): MySqlAdapter
    {
        $host = !empty($config['host']) ? $config['host'] : self::getDefault('host');
        $user = !empty($config['user']) ? $config['user'] : self::getDefault('user');
        $password = !empty($config['password']) ? $config['password'] : self::getDefault('password');
        $schema = !empty($config['schema']) ? $config['schema'] : self::getDefault('schema');
        $autoconnect = !empty($config['autoconnect']) ? (bool) $config['autoconnect'] : false;
        return new static($host, $schema, $user, $password, $autoconnect);
    }
    
    /**
     * Returns the value of the default configuration option identified by the key name
     *
     * @param string $key
     *
     * @return string
     */
    public static function getDefault(string $key): string
    {
        return array_key_exists($key, self::$defaultConfig) ? self::$defaultConfig[$key] : '';
    }
    
    /**
     * Sets the value for default configuration key
     *
     * @param string $key
     * @param string $value the value for the setting (for boolean keys, pass NULL or a non-empty string)
     *
     * @return void
     */
    public static function setDefault(string $key, string $value = null)
    {
        if ($key !== 'autoconnect') {
            self::$defaultConfig[$key]  = $value;
        } else {
            self::$defaultConfig[$key]  = (bool) $value;
        }
    }
    
    /**
     * MySqlAdapter constructor.
     *
     * @param string $host
     * @param string $schema
     * @param string $user
     * @param string $password
     * @param bool   $autoConnect
     */
    public function __construct(string $host, string $schema, string $user, string $password, bool $autoConnect = false)
    {
        $this->setHost($host)
            ->setUser($user)
            ->setPassword($password)
            ->setSchema($schema);
        if ($autoConnect) {
            $this->connect();
        }
    }
    
    /**
     * Opens a connection to the database if no connection was previously opened, or if reconnect is TRUE
     *
     * @param bool $throwExceptionOnFail    throws an exception if connection failed
     * @param bool $reconnect               this forces a reconnect even when a connection was previously established
     *
     * @return AdapterInterface
     * @throws ConfigurationException
     */
    public function connect(bool $throwExceptionOnFail = true, bool $reconnect = false): AdapterInterface
    {
        if ($this->connection instanceof \PDO && !$reconnect) {
            return $this;
        }
        $exception = null;
        try {
            if (empty($this->host) || empty($this->schema)) {
                throw new ConfigurationException('The hostname and/or schema were not set');
            }
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->schema.';charset=utf8mb4';
            $this->connection = new PDO(
                $dsn,
                $this->user,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => false,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            # fix suggested by @ircmaxell see:
            # http://stackoverflow.com/questions/134099/are-pdo-prepared-statements-sufficient-to-prevent-sql-injection/12202218#12202218
        } catch (\PDOException $e) {
            $this->connection = null;
            $exception = $e;
        }
        if ($exception !== null && $throwExceptionOnFail) {
            throw $exception;
        }
        return $this;
    }
    
    /**
     * Returns the database hostname [to be] used for the connection
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }
    
    /**
     * Returns the connection password for the specified database username
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    
    /**
     * Returns the database schema to connect to with the connection
     *
     * @return string
     */
    public function getSchema(): string
    {
        return $this->schema;
    }
    
    /**
     * Returns the database username [to be] used for the connection
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }
    
    /**
     * Returns the actual \PDO object created after a successful connection or NULL
     *
     * @return \PDO
     */
    public function getConnection()
    {
        return !$this->connection instanceof \PDO ? $this->connection : null;
    }
    
    /**
     * Sets the database hostname to be used in the connection
     *
     * @param string $host
     *
     * @return AdapterInterface
     */
    public function setHost(string $host): AdapterInterface
    {
        if (empty($host)) {
            throw new \InvalidArgumentException(('Empty database hostname'));
        }
        $this->host = $host;
        return $this;
    }
    
    /**
     * Sets the database password to be used in the connection
     *
     * @param string $password
     *
     * @return AdapterInterface
     */
    public function setPassword(string $password = ''): AdapterInterface
    {
        $this->password = $password;
        return $this;
    }
    
    /**
     * Sets the database schema name to be used by the connection
     *
     * @param string $schema
     *
     * @return AdapterInterface
     */
    public function setSchema(string $schema): AdapterInterface
    {
        if (empty($schema)) {
            throw new \InvalidArgumentException('Empty schema name');
        }
        $this->schema = $schema;
        return $this;
    }
    
    /**
     * Sets the database username to be used in the connection
     *
     * @param string $user
     *
     * @return AdapterInterface
     */
    public function setUser(string $user): AdapterInterface
    {
        $this->user = $user;
        return $this;
    }
    
    /**
     * Starts a new database transaction on the active connection, if any
     *
     * @return void
     * @throws ConnectionException
     */
    public function transactionStart()
    {
        $this->connect();
        if (!$this->connection) {
            throw new ConnectionException('No database connection');
        }
        $this->connection->beginTransaction();
    }
    
    /**
     * Commits an active database transaction
     *
     * @return void
     * @throws ConnectionException
     */
    public function transactionCommit()
    {
        if (!$this->connection) {
            throw new ConnectionException('No database connection');
        }
        $this->connection->commit();
    }
    
    /**
     * Rolls back an active database transaction
     *
     * @return void
     * @throws ConnectionException
     */
    public function transactionRollback()
    {
        if (!$this->connection) {
            throw new ConnectionException('No database connection');
        }
        $this->connection->rollBack();
    }
    
    /**
     * Returns the last AUTO INCREMENT id used for the current connection instance
     *
     * @return int
     */
    public function getInsertId(): int
    {
        return $this->connection instanceof PDO ? (int) $this->connection->lastInsertId() : 0;
    }
    
    /**
     * Executes an SQL query against the active database connection, sending the supplied arguments with
     * the query. it will either return FALSE on failure, but for successes, depending on the value of $isSelect,
     * it will wither return TRUE or the retrieved database records.
     *
     * @param string $sql          the sql query to execute
     * @param bool   $isSelect     whether or not to get the matching records. Useful for SELECT queries
     * @param array  ...$arguments the arguments to use in the PDOStatement::execute() method call
     *
     * @return array|bool
     * @throws ConnectionException
     */
    public function exec(string $sql, bool $isSelect = false, ...$arguments)
    {
        if (empty($sql)) {
            throw new \InvalidArgumentException('Empty SQL query');
        }
        $this->connect();
        if (!$this->connection) {
            throw new ConnectionException('No database connection');
        }
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new ConnectionException('Could not prepare the query on the backend');
        }
        if (!$stmt->execute($arguments)) {
            return false;
        }
        return $isSelect ? $stmt->fetchAll(PDO::FETCH_ASSOC) : true;
    }
    
    /**
     * Executes an SQL SELECT query against the database, then copies the results of the query into an array
     *
     * @param string $sql
     * @param array  ...$arguments
     *
     * @return array
     */
    public function selectAll(string $sql, ...$arguments): array
    {
        $records = $this->exec($sql, true, ...$arguments);
        return !empty($records) ? $records : [];
    }
    
    /**
     * Similar to the selectAll() except that instead of returning the data as a multi-dimensional array,
     * it returns the first index of the array
     *
     * @param string $sql
     * @param array  ...$arguments
     *
     * @return array
     */
    public function selectOne(string $sql, ...$arguments): array
    {
        $records = $this->exec($sql, true, ...$arguments);
        return !empty($records) ? $records[0] : [];
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return __CLASS__.' Instance {Host: '.$this->host.', Schema: '.$this->schema.', User: '.$this->user.'}';
    }
}
