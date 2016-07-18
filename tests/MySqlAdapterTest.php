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
    
    public function testGetHost()
    {
        $this->assertEquals('local', $this->adapter->getHost());
    }
    
    public function testGetPassword()
    {
        $this->assertEquals('pswd', $this->adapter->getPassword());
    }
    
    public function testGetSchema()
    {
        $this->assertEquals('none', $this->adapter->getSchema());
    }
    
    public function testGetUser()
    {
        $this->assertEquals('usr', $this->adapter->getUser());
    }
    
    public function testConnectFailure()
    {
        $this->expectException(\PDOException::class);
        $this->adapter->connect();
    }
    
    public function testSetHost()
    {
        $this->adapter->setHost('localhost');
        $this->assertEquals('localhost', $this->adapter->getHost());
    }
    
    public function testSetSchema()
    {
        $this->adapter->setSchema('schema_name');
        $this->assertEquals('schema_name', $this->adapter->getSchema());
    }
    
    public function testSetPassword()
    {
        $this->adapter->setPassword('my_password');
        $this->assertEquals('my_password', $this->adapter->getPassword());
    }
    
    public function testSetUser()
    {
        $this->adapter->setUser('db_user');
        $this->assertEquals('db_user', $this->adapter->getUser());
    }
    
    
}