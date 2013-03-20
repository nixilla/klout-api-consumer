<?php

namespace Klout\Api;

class Identity implements \ArrayAccess
{
    private $container = array();

    const TWITTER_SCREEN_NAME = 'twitter';
    const KLOUT_ID = 'ks';
    const TWITTER_ID = 'tw';
    const GOOGLE_PLUS_ID = 'gp';

    public static function getInstance(array $input)
    {
        $instance = new self;

        $instance->container = $input;

        if( ! isset($instance->container[self::KLOUT_ID]))
            $instance->container[self::KLOUT_ID] = isset($input['id']) ? $input['id'] : (isset($input['kloutId']) ? $input['kloutId'] : null);

        if(isset($input['score']) && is_array($input['score']))
            $instance->container['score'] = $input['score']['score'];

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

    public function getId($type = Identity::KLOUT_ID)
    {
        return isset($this->container[$type]) ? $this->container[$type] : null;
    }

    public function isLoaded()
    {
        return
            isset($this->container['score']) &&
            isset($this->container['topics']) &&
            isset($this->container['influence']);
    }

    public function toArray()
    {
        return $this->container;
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