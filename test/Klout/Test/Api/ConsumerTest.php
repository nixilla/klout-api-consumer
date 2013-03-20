<?php

namespace Klout\Test\Api;

use Klout\Api\Identity;
use Klout\Api\Consumer;

class ConsumerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetIdentityWithIdentity()
    {
        $client = $this->getMock('Buzz\Browser', array('call'));

        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                $this->equalTo('http://api.klout.com/v2/user.json/123321?key=secret_key_here'),
                $this->equalTo('get'),
                $this->equalTo(array()),
                $this->equalTo('')
            )
            ->will($this->returnValue(json_encode(array('kloutId' => 123321))));

        $consumer = new Consumer($client, 'secret_key_here');
        $identity = $consumer->getIdentity(Identity::getInstance(array(Identity::KLOUT_ID => 123321)));
        $this->assertEquals('123321', $identity->getId(), 'Identity OK');
    }

    public function testGetIdentityWithKloutId()
    {
        $client = $this->getMock('Buzz\Browser', array('call'));

        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                $this->equalTo('http://api.klout.com/v2/user.json/123321?key=secret_key_here'),
                $this->equalTo('get'),
                $this->equalTo(array()),
                $this->equalTo('')
            )
            ->will($this->returnValue(json_encode(array('kloutId' => 123321))));

        $consumer = new Consumer($client, 'secret_key_here');
        $identity = $consumer->getIdentity('123321');
        $this->assertEquals('123321', $identity->getId(), 'Identity OK');
    }

    public function testGetIdentityWithTwitterId()
    {
        $client = $this->getMock('Buzz\Browser', array('call'));

        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                $this->equalTo('http://api.klout.com/v2/identity.json/tw/4324234234?key=secret_key_here'),
                $this->equalTo('get'),
                $this->equalTo(array()),
                $this->equalTo('')
            )
            ->will($this->returnValue(json_encode(array('id' => 123321, 'network' => 'ks'))));

        $consumer = new Consumer($client, 'secret_key_here');
        $identity = $consumer->getIdentity('4324234234', Identity::TWITTER_ID);

        $this->assertEquals('123321', $identity->getId(), 'Identity OK');
    }

    public function testGetIdentityWithGooglePlusId()
    {
        $client = $this->getMock('Buzz\Browser', array('call'));

        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                $this->equalTo('http://api.klout.com/v2/identity.json/gp/4324234234?key=secret_key_here'),
                $this->equalTo('get'),
                $this->equalTo(array()),
                $this->equalTo('')
            )
            ->will($this->returnValue(json_encode(array('id' => 123321, 'network' => 'ks'))));

        $consumer = new Consumer($client, 'secret_key_here');
        $identity = $consumer->getIdentity('4324234234', Identity::GOOGLE_PLUS_ID);

        $this->assertEquals('123321', $identity->getId(), 'Identity OK');
    }

    public function testGetIdentityWithTwitterScreenName()
    {
        $client = $this->getMock('Buzz\Browser', array('call'));

        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                $this->equalTo('http://api.klout.com/v2/identity.json/twitter?key=secret_key_here&screenName=tester'),
                $this->equalTo('get'),
                $this->equalTo(array()),
                $this->equalTo('')
            )
            ->will($this->returnValue(json_encode(array('id' => 123321, 'network' => 'ks'))));

        $consumer = new Consumer($client, 'secret_key_here');
        $identity = $consumer->getIdentity('tester', Identity::TWITTER_SCREEN_NAME);

        $this->assertEquals('123321', $identity->getId(), 'Identity OK');
    }
}
