<?php

namespace Klout\Api;

class Identity implements \ArrayAccess
{
    private $container = array();
    private $consumer;

    const TWITTER_SCREEN_NAME = 'screenName';

    public static function getInstance(array $input, $consumer)
    {
        $instance = new self;

        $instance->container = $input;
        $instance->consumer = $consumer;

        return $instance;
    }

    public function getScore()
    {
        return isset($this->container['score']) ? $this->container['score'] : null;
    }

    public function getTopics()
    {
        return isset($this->container['topics']) ? $this->container['topics'] : null;
    }

    public function getInfluence()
    {
        return isset($this->container['influence']) ? $this->container['influence'] : null;
    }

    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException('Read-only object');
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
        throw new \RuntimeException('Read-only object');
    }

    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}