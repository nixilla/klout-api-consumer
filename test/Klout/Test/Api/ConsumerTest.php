<?php

namespace Klout\Test\Api;

use Klout\Api\Identity;
use Klout\Api\Consumer;

class ConsumerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetIdentityWithIdentity()
    {
        $consumer = new Consumer($this->getClientWithAllCalls(
            Identity::getInstance(
                array(
                    Identity::KLOUT_ID => 123321,
                    'influence' => array(
                        'myInfluencers' => array('entity' => array('payload' => array()))
                    )
                )
            )), 'secret_key_here');

        $identity = $consumer->getIdentity(Identity::getInstance(array(Identity::KLOUT_ID => 123321)));

        $this->assertEquals('123321', $identity->getId(), 'Identity OK');
    }

    public function testGetIdentityWithKloutId()
    {
        $consumer = new Consumer($this->getClientWithAllCalls(array(Identity::KLOUT_ID => 123321)), 'secret_key_here');
        $identity = $consumer->getIdentity('123321');

        $this->assertEquals('123321', $identity->getId(), 'Identity OK');
    }

    public function testGetIdentityWithTwitterId()
    {
        $consumer = new Consumer(
            $this->getClientWithSingleCall(
                array(Identity::KLOUT_ID => 123321, Identity::TWITTER_ID => '4324234234'),
                Identity::TWITTER_ID
            ), 'secret_key_here');
        $identity = $consumer->getIdentity('4324234234', Identity::TWITTER_ID);

        $this->assertEquals('123321', $identity->getId(), 'Identity OK');
    }

    public function testGetIdentityWithGooglePlusId()
    {
        $consumer = new Consumer(
            $this->getClientWithSingleCall(
                array(Identity::KLOUT_ID => 123321, Identity::GOOGLE_PLUS_ID => '4324234234'),
                Identity::GOOGLE_PLUS_ID
            ), 'secret_key_here');
        $identity = $consumer->getIdentity('4324234234', Identity::GOOGLE_PLUS_ID);

        $this->assertEquals('123321', $identity->getId(), 'Identity OK');
    }

    public function testGetIdentityWithTwitterScreenName()
    {
        $consumer = new Consumer(
            $this->getClientWithSingleCall(
                array(Identity::KLOUT_ID => 123321, Identity::TWITTER_SCREEN_NAME => 'tester'),
                Identity::TWITTER_SCREEN_NAME
            ), 'secret_key_here');
        $identity = $consumer->getIdentity('tester', Identity::TWITTER_SCREEN_NAME);

        $this->assertEquals('123321', $identity->getId(), 'Identity OK');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetIdentityWithUserNotFound()
    {
        $consumer = new Consumer($this->getClientWithSingleCall(null, Identity::TWITTER_SCREEN_NAME), 'secret_key_here');
        $identity = $consumer->getIdentity('tester', Identity::TWITTER_SCREEN_NAME);
    }

    /**
     * @param $input
     * @param string $type
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getClientWithSingleCall($input, $type = Identity::KLOUT_ID)
    {
        $client = $this->getMock('Buzz\Browser', array('call'));

        switch($type)
        {
            case Identity::TWITTER_SCREEN_NAME:
                $url = 'http://api.klout.com/v2/identity.json/twitter?key=secret_key_here&screenName=tester';
                break;
            case Identity::KLOUT_ID:
                $url = sprintf('http://api.klout.com/v2/user.json/%s?key=secret_key_here', $input[$type]);
                break;
            default:
                $url = sprintf('http://api.klout.com/v2/identity.json/%s/%s?key=secret_key_here', $type, $input[$type]);
        }

        $client
            ->expects($this->at(0))
            ->method('call')
            ->with(
                $this->equalTo($url),
                $this->equalTo('get'),
                $this->equalTo(array()),
                $this->equalTo('')
            )
            ->will($this->returnValue($this->getResponseObject($input)));

        return $client;
    }

    /**
     * @param $input
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getClientWithAllCalls($input)
    {
        $client = $this->getClientWithSingleCall($input);

        $client
            ->expects($this->at(1))
            ->method('call')
            ->with(
                $this->equalTo('http://api.klout.com/v2/user.json/123321/topics?key=secret_key_here'),
                $this->equalTo('get'),
                $this->equalTo(array()),
                $this->equalTo('')
            )
            ->will($this->returnValue($this->getResponseObject($input)));

        $client
            ->expects($this->at(2))
            ->method('call')
            ->with(
                $this->equalTo('http://api.klout.com/v2/user.json/123321/influence?key=secret_key_here'),
                $this->equalTo('get'),
                $this->equalTo(array()),
                $this->equalTo('')
            )
            ->will($this->returnValue($this->getResponseObject($input)));

        return $client;
    }

    /**
     * @param array $input
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getResponseObject($input)
    {
        if($input instanceof Identity)
            $input = $input->toArray();

        $response = $this->getMock('Buzz\Message', array('getContent'));

        $response
            ->expects($this->at(0))
            ->method('getContent')
            ->will($this->returnValue(json_encode($input)));

        return $response;
    }
}
