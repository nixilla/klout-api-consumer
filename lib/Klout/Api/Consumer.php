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
                $user = json_decode($this->client->call(
                    sprintf(
                        '%s/v2/identity.json/%s/%s?key=%s',
                        self::API_ENDPOINT,
                        $type,
                        $identity->getId($type),
                        $this->key
                    ),
                    'get',
                    array(),
                    ''
                )->getContent(), true);
            }
            else
            {
                $user = json_decode($this->client->call(
                    sprintf(
                        '%s/v2/identity.json/%s?key=%s&screenName=%s',
                        self::API_ENDPOINT,
                        $type,
                        $this->key,
                        $identity->getId($type)
                    ),
                    'get',
                    array(),
                    ''
                )->getContent(), true);
            }
        }
        else
        {
            $user = json_decode($this->client->call(
                sprintf(
                    '%s/v2/user.json/%s?key=%s',
                    self::API_ENDPOINT,
                    $identity->getId(),
                    $this->key
                ),
                'get',
                array(),
                ''
            )
                ->getContent(),
                true
            );

            $user = array_merge($user, $identity->toArray());

            $user['topics'] = json_decode($this->client->call(
                sprintf(
                    '%s/v2/user.json/%s/topics?key=%s',
                    self::API_ENDPOINT,
                    $identity->getId(),
                    $this->key
                ),
                'get',
                array(),
                ''
            )->getContent(),true);

            $influence = json_decode($this->client->call(
                    sprintf(
                        '%s/v2/user.json/%s/influence?key=%s',
                        self::API_ENDPOINT,
                        $identity->getId(),
                        $this->key
                    ),
                    'get',
                    array(),
                    ''
                )
                    ->getContent(),
                true
            );

            foreach($influence as $key => $ins)
            {
                if(is_array($ins))
                {
                    foreach($ins as $someone)
                        $user['influence'][$key][] = Identity::getInstance($someone['entity']['payload']);
                }
                else
                {
                    $user['influence'][$key] = $ins;
                }
            }


        }
        return Identity::getInstance($user);

    }
}