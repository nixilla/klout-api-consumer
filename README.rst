KloutApiConsumer
================

This is small library that allows you to easily interact with `KloutAPI v2`_.

.. _`KloutAPI v2`: http://klout.com/s/developers/v2

Usage:
``````

Identity methods
''''''''''''''''

.. code-block:: php

    <?php

    $consumer = new Klout\Api\Consumer();
    $consumer->setKey($key);

    // or in one go
    $consumer = new Klout\Api\Consumer($key);

    // http://api.klout.com/v2/identity.json/tw/{twitter_id}
    $identity = $consumer->getIdentity($twitter_id, Klout::TWITTER_ID);

    // http://api.klout.com/v2/identity.json/gp/{google_id}
    $identity = $consumer->getIdentity($google_id, Klout::GOOGLE_ID);

    // http://api.klout.com/v2/identity.json/twitter?screenName={twitter_screen_name}
    $identity = $consumer->getIdentity($twitter_screen_name, Klout::TWITTER_SCREEN_NAME);

    // http://api.klout.com/v2/identity.json/klout/{klout_id/tw
    $identity = $consumer->getIdentity($klout_id, Klout::KLOUT_ID);

User methods:
'''''''''''''

.. code-block:: php

    <?php

    $consumer = new Klout\Api\Consumer($key);

    // http://api.klout.com/v2/user.json/{klout_id}
    $identity = $consumer->getIdentity($klout_id, Klout::KLOUT_ID);

    // http://api.klout.com/v2/user.json/{klout_id}/score
    $score = $consumer->getIdentity($klout_id, Klout::KLOUT_ID)->getScore();
    // or if you have $identity
    $score = $identity->getScore();

    // http://api.klout.com/v2/user.json/{klout_id}/topics
    $topics = $consumer->getIdentity($klout_id, Klout::KLOUT_ID)->getTopics();
    // or
    $topics = $identity->getTopics();

    // http://api.klout.com/v2/user.json/{klout_id}/influence
    $influence = $consumer->getIdentity($klout_id, Klout::KLOUT_ID)->getInfluence();
    // or
    $influence = $identity->getInfluence();



Other usage:
''''''''''''

.. code-block:: php

    <?php

    $consumer = new Klout\Api\Consumer($key);

    $influencers = $consumer
        ->getIdentity($twitter_screen_name, Klout::TWITTER_SCREEN_NAME)
        ->getInfluence()['myInfluencers']; // PHP 5.4

    foreach($influencers as $identity)
        echo $identity;

    // using ArrayAccess
    $identity = $consumer->getIdentity($twitter_screen_name, Klout::TWITTER_SCREEN_NAME);
    foreach($identity['influence']['myInfluencers'] as $identity)
        echo $identity;

    // you can also get their score, topics, influence too
    foreach($identity['influence']['myInfluencees'] as $identity)
        echo $identity['score'];

