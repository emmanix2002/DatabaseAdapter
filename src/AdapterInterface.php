<?php

namespace Emmanix2002\DatabaseAdapter;

/**
 * Interface AdapterInterface
 *
 * @package Emmanix2002\DatabaseAdapter
 */
interface AdapterInterface
{
    /**
     * Opens a connection to the database if no connection was previously opened, or if reconnect is TRUE
     *
     * @param bool $throwExceptionOnFail    throws an exception if connection failed
     * @param bool $reconnect               this forces a reconnect even when a connection was previously established
     *
     * @return AdapterInterface
     */
    public function connect(bool $throwExceptionOnFail = true, bool $reconnect = false): AdapterInterface;
    
    /**
     * Returns the database hostname [to be] used for the connection
     *
     * @return string
     */
    public function getHost(): string;
    
    /**
     * Returns the connection password for the specified database username
     *
     * @return string
     */
    public function getPassword(): string;
    
    /**
     * Returns the database schema to connect to with the connection
     *
     * @return string
     */
    public function getSchema(): string;
    
    /**
     * Returns the database username [to be] used for the connection
     *
     * @return string
     */
    public function getUser(): string;
    
    /**
     * Returns the actual \PDO object created after a successful connection or NULL
     *
     * @return \PDO
     */
    public function getConnection();
    
    /**
     * Sets the database hostname to be used in the connection
     *
     * @param string $host
     *
     * @return AdapterInterface
     */
    public function setHost(string $host): AdapterInterface;
    
    /**
     * Sets the database password to be used in the connection
     *
     * @param string $password
     *
     * @return AdapterInterface
     */
    public function setPassword(string $password = ''): AdapterInterface;
    
    /**
     * Sets the database schema name to be used by the connection
     *
     * @param string $schema
     *
     * @return AdapterInterface
     */
    public function setSchema(string $schema): AdapterInterface;
    
    /**
     * Sets the database username to be used in the connection
     *
     * @param string $user
     *
     * @return AdapterInterface
     */
    public function setUser(string $user): AdapterInterface;
    
    /**
     * Starts a new database transaction on the active connection, if any
     *
     * @return void
     */
    public function transactionStart();
    
    /**
     * Commits an active database transaction
     *
     * @return void
     */
    public function transactionCommit();
    
    /**
     * Rolls back an active database transaction
     *
     * @return void
     */
    public function transactionRollback();
    
    /**
     * Returns the last AUTO INCREMENT id used for the current connection instance
     *
     * @return int
     */
    public function getInsertId(): int;
    
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
     */
    public function exec(string $sql, bool $isSelect = false, ...$arguments);
    
    /**
     * Executes an SQL SELECT query against the database, then copies the results of the query into an array
     *
     * @param string $sql
     * @param array  ...$arguments
     *
     * @return array
     */
    public function selectAll(string $sql, ...$arguments): array;
    
    /**
     * Similar to the selectAll() except that instead of returning the data as a multi-dimensional array,
     * it returns the first index of the array
     *
     * @param string $sql
     * @param array  ...$arguments
     *
     * @return array
     */
    public function selectOne(string $sql, ...$arguments): array;
}
