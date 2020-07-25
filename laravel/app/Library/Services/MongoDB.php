<?php

namespace App\Library\Services;

use Illuminate\Database\QueryException;
use InvalidArgumentException;

class MongoDB
{
    private $host;
    private $port;
    private $username;
    private $password;
    private $database;
    private $protocol;
    private $options;

    private $manager = null;
    private $uri = null;
    private $collection = null;
    private $query = null;

    public function __construct($host = '127.0.0.7', $port = '27017', $username = '', $password = '', $database = '', $is_srv = FALSE, $options = null)
    {

        $this->host = $host;
        $this->port = $port;
        $this->username = urlencode($username);
        $this->password = urlencode($password);
        $this->database = $database;
        $this->protocol = ($is_srv ? 'mongodb+srv://' : 'mongodb://');
        $this->options = $options;

        $this->connection();
    }

    public function collection($name)
    {
        $name = trim($name);
        if ($name) {
            $this->collection = $name;
            return $this;
        }

        throw new InvalidArgumentException("A collection name is not defined.");
    }

    public function query(array $filter, array $options = [])
    {
        if (is_array($filter)) {
            $this->query = new \MongoDB\Driver\Query($filter, $options);
            return $this;
        }

        throw new InvalidArgumentException("A query filter is not defined.");
    }

    public function exec()
    {
        //reconnect
        if (!$this->manager) {
            $this->connection();
        }

        return $this->manager->executeQuery($this->getDatabase(true) . $this->getCollection(), $this->query);
    }

    private function connection()
    {
        try {
            $this->uri = $this->getUri();
            $this->manager = new \MongoDB\Driver\Manager($this->uri, $this->getOptions());
        } catch (Exception $e) {
            throw new QueryException(
                //($sql, array $bindings, Throwable $previous)
                $this->getUri(true),
                [],
                $e
            );
        }
    }


    private function getDatabase($includeDot = false)
    {
        if ($this->database) {
            return $this->database . ($includeDot ? '.' : '');
        }

        throw new InvalidArgumentException("A database name is not defined.");
    }

    private function getCollection()
    {
        if ($this->collection) {
            return $this->collection;
        }

        throw new InvalidArgumentException("A collection name is not defined.");
    }

    private function getUri($viewable = false)
    {
        if ($viewable) {
            return "{$this->protocol}{$this->username}:**********@{$this->host}:{$this->port}/{$this->database}";
        } else {
            return "{$this->protocol}{$this->username}:{$this->password}@{$this->host}:{$this->port}/{$this->database}";
        }
    }

    private function getOptions()
    {
        $options = [];

        if ($this->options) {
            if (!is_array($this->options)) {
                foreach (explode('&', $this->options) as $option) {
                    $optionParts = explode('=', $option);
                    switch (true) {
                        case is_numeric($optionParts[1]):
                            $options[$optionParts[0]] = (int)$optionParts[1];
                            break;
                        case in_array($optionParts[1], ['true', 'false']):
                            $options[$optionParts[0]] = ($optionParts[1] === 'true' ? true : false);
                            break;
                        default:
                            $options[$optionParts[0]] = $optionParts[1];
                            break;
                    }
                }
            } else {
                $options = $this->options;
            }
        }
        $this->options = $options;

        return $options;
    }
}
