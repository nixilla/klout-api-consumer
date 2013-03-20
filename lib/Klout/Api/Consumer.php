<?php

namespace Klout\Api;

class Consumer
{
    const API_ENDPOINT = 'http://api.klout.com';

    private $key;
    private $client;

    public function __construct($client, $key)
    {
        $this->client = $client;
        $this->key = $key;
    }

    /**
     * @param $identity
     * @param string $type
     * @return Identity
     */
    public function getIdentity($identity, $type = Identity::KLOUT_ID)
    {
        if(! $identity instanceof Identity)
            if($type)
                $identity = Identity::getInstance(array($type => $identity));

        if( ! $identity->getId())
        {
            if(Identity::TWITTER_SCREEN_NAME != $type)
            {
                $json = $this->client->call(
                    sprintf('%s/v2/identity.json/%s/%s?key=%s', self::API_ENDPOINT, $type, $identity->getId($type), $this->key),
                    'get',
                    array(),
                    ''
                );
            }
            else
            {
                $json = $this->client->call(
                    sprintf('%s/v2/identity.json/%s?key=%s&screenName=%s', self::API_ENDPOINT, $type, $this->key, $identity->getId($type)),
                    'get',
                    array(),
                    ''
                );
            }
        }
        else
        {
            $json = $this->client->call(
                sprintf('%s/v2/user.json/%s?key=%s', self::API_ENDPOINT, $identity->getId(), $this->key),
                'get',
                array(),
                ''
            );


        }

        return Identity::getInstance(json_decode($json, true));

    }
}