<?php

namespace Klout\Test\Api;

use Klout\Api\Identity;

class IdentityTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessors()
    {
        $consumer = $this
            ->getMock('Klout\Api\Consumer', array('getIdentity'));

        $consumer
            ->expects($this->once())
            ->method('getIdentity')
            ->with(
                $this->equalTo('tester'),
                $this->equalTo(Identity::TWITTER_SCREEN_NAME)
            )
            ->will(
                $this->returnValue(Identity::getInstance(array(
                    'kloutId' => 12345,
                    'nick' => 'tester',
                    'score' => 51,
                    'topics' => array(),
                    'influence' => array('ok')
                ), $consumer))
            );

        $identity = $consumer->getIdentity('tester', Identity::TWITTER_SCREEN_NAME);

        $this->assertEquals(51, $identity->getScore(), 'Accessor method getScore OK');
        $this->assertEquals(51, $identity['score'], 'ArrayAccess method [score] OK');

        $this->assertEquals(array(), $identity->getTopics(), 'Accessor method getTopics OK');
        $this->assertEquals(array(), $identity['topics'], 'Accessor method [topics] OK');

        $this->assertEquals(array('ok'), $identity->getInfluence(), 'Accessor method getInfluence OK');
        $this->assertEquals(array('ok'), $identity['influence'], 'Accessor method [influence] OK');
    }
}
