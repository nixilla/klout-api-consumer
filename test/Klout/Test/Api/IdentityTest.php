<?php

namespace Klout\Test\Api;

use Klout\Api\Identity;

class IdentityTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessors()
    {
        $consumer = $this
            ->getMockBuilder('Klout\Api\Consumer')
            ->disableOriginalConstructor()
            ->getMock();

        $consumer
            ->expects($this->once())
            ->method('getIdentity')
            ->with(
                $this->equalTo('tester'),
                $this->equalTo(Identity::TWITTER_SCREEN_NAME)
            )
            ->will(
                $this->returnValue(Identity::getInstance(array(
                    Identity::KLOUT_ID => 12345,
                    'score' => 51,
                    'topics' => array(),
                    'influence' => array('ok')
                )))
            );

        $identity = $consumer->getIdentity('tester', Identity::TWITTER_SCREEN_NAME);

        $this->assertEquals(12345, $identity->getId(), 'Default id is kloutId');
        $this->assertEquals(12345, $identity->getId(Identity::KLOUT_ID), 'kloutId is correct');

        $this->assertEquals(51, $identity->getScore(), 'Accessor method getScore OK');
        $this->assertEquals(51, $identity['score'], 'ArrayAccess method [score] OK');

        $this->assertEquals(array(), $identity->getTopics(), 'Accessor method getTopics OK');
        $this->assertEquals(array(), $identity['topics'], 'Accessor method [topics] OK');

        $this->assertEquals(array('ok'), $identity->getInfluence(), 'Accessor method getInfluence OK');
        $this->assertEquals(array('ok'), $identity['influence'], 'Accessor method [influence] OK');
    }

    public function testIsLoaded()
    {
        $identity = Identity::getInstance(array(Identity::KLOUT_ID => 123321));

        $this->assertFalse($identity->isLoaded(), 'Identity is not loaded');

        $consumer = $this
            ->getMockBuilder('Klout\Api\Consumer')
            ->disableOriginalConstructor()
            ->getMock();

        $consumer
            ->expects($this->once())
            ->method('getIdentity')
            ->with($this->equalTo($identity))
            ->will(
                $this->returnValue(Identity::getInstance(array(
                    Identity::KLOUT_ID => 12345,
                    'score' => 51,
                    'topics' => array(),
                    'influence' => array('ok')
                )))
            );

        $identity = $consumer->getIdentity($identity);

        $this->assertTrue($identity->isLoaded(), 'Identity is loaded');

    }

    /**
     * @expectedException \RuntimeException
     */
    public function testUnset()
    {
        $identity = Identity::getInstance(array(Identity::KLOUT_ID => 123321));

        unset($identity[Identity::KLOUT_ID]);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testSet()
    {
        $identity = Identity::getInstance(array(Identity::KLOUT_ID => 123321));

        $identity[Identity::KLOUT_ID] = '123321321';
    }

    public function testIsset()
    {
        $identity = Identity::getInstance(array(Identity::KLOUT_ID => 123321));

        if(isset($identity[Identity::KLOUT_ID]))
            $this->assertTrue(true);
    }
}
