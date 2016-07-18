<?php

namespace Emmanix2002\DatabaseAdapter\Tests;

use Emmanix2002\DatabaseAdapter\MySqlAdapter;
use PHPUnit\Framework\TestCase;

class MySqlAdapterTest extends TestCase
{
    /**
     * @var MySqlAdapter
     */
    private $adapter;
    
    public function setup()
    {
        MySqlAdapter::setDefault('host', 'local');
        MySqlAdapter::setDefault('schema', 'none');
        MySqlAdapter::setDefault('user', 'usr');
        MySqlAdapter::setDefault('password', 'pswd');
        $this->adapter = MySqlAdapter::create();
    }
    
    /**
     * @covers MySqlAdapter::getHost
     */
    public function testGetHost()
    {
        $this->assertEquals('local', $this->adapter->getHost());
    }
    
    /**
     * @covers MySqlAdapter::getPassword
     */
    public function testGetPassword()
    {
        $this->assertEquals('pswd', $this->adapter->getPassword());
    }
    
    /**
     * @covers MySqlAdapter::getSchema
     */
    public function testGetSchema()
    {
        $this->assertEquals('none', $this->adapter->getSchema());
    }
    
    /**
     * @covers MySqlAdapter::getUser
     */
    public function testGetUser()
    {
        $this->assertEquals('usr', $this->adapter->getUser());
    }
    
    /**
     * @covers MySqlAdapter::connect
     */
    public function testConnectFailure()
    {
        $this->expectException(\PDOException::class);
        $this->adapter->connect();
    }
    
    /**
     * @covers MySqlAdapter::setHost
     */
    public function testSetHost()
    {
        $this->adapter->setHost('localhost');
        $this->assertEquals('localhost', $this->adapter->getHost());
    }
    
    /**
     * @covers MySqlAdapter::setSchema
     */
    public function testSetSchema()
    {
        $this->adapter->setSchema('schema_name');
        $this->assertEquals('schema_name', $this->adapter->getSchema());
    }
    
    /**
     * @covers MySqlAdapter::setPassword
     */
    public function testSetPassword()
    {
        $this->adapter->setPassword('my_password');
        $this->assertEquals('my_password', $this->adapter->getPassword());
    }
    
    /**
     * @covers MySqlAdapter::setUser
     */
    public function testSetUser()
    {
        $this->adapter->setUser('db_user');
        $this->assertEquals('db_user', $this->adapter->getUser());
    }
    
    
}