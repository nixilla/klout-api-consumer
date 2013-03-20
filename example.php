<?php

// make sure that you run `composer install` before executing this script
// run it with php ./example.php

require_once './vendor/autoload.php';

$key = 'YOUR_KEY_HERE';

$client = new Buzz\Browser();
$consumer = new Klout\Api\Consumer($client, $key);

$identity = $consumer->getIdentity('rasmus', Klout\Api\Identity::TWITTER_SCREEN_NAME);

printf("My id: %s\n", $identity->getId()); // should be 265950

echo sprintf("Identity is%s loaded\n", $identity->isLoaded() ? ' ' : ' not');

$identity = $consumer->getIdentity($identity);

echo sprintf("Identity is%s loaded\n", $identity->isLoaded() ? ' ' : ' not');

if(count($identity->getTopics()))
{
    echo "My Topics:\n";
    foreach($identity->getTopics() as $topic)
        printf("\t%s\n", $topic['displayName']);
}

printf("\nnmyInfluencers (%s)\n\n", $identity['influence']['myInfluencersCount']);

foreach($identity['influence']['myInfluencers'] as $someone)
{
    if( ! $someone->isLoaded())
    {
        $someone = $consumer->getIdentity($someone);
        echo sprintf(
            "Score for user %s: %s, no of topics: %s, influencers %s, influencees: %s\n",
            $someone['nick'],
            $someone->getScore(),
            count($someone->getTopics()),
            $someone['influence']['myInfluencersCount'],
            $someone['influence']['myInfluenceesCount']
        );
        if(count($someone->getTopics()))
        {
            echo "Topics:\n";
            foreach($someone->getTopics() as $topic)
                printf("\t%s\n", $topic['displayName']);
        }
    }
}

printf("\nnmyInfluencees (%s)\n\n", $identity['influence']['myInfluenceesCount']);

foreach($identity['influence']['myInfluencees'] as $someone)
{
    if( ! $someone->isLoaded())
    {
        $someone = $consumer->getIdentity($someone);
        echo sprintf(
            "Score for user %s: %s, no of topics: %s, influencers %s, influencees: %s\n",
            $someone['nick'],
            $someone->getScore(),
            count($someone->getTopics()),
            $someone['influence']['myInfluencersCount'],
            $someone['influence']['myInfluenceesCount']
        );
        if(count($someone->getTopics()))
        {
            echo "Topics:\n";
            foreach($someone->getTopics() as $topic)
                printf("\t%s\n", $topic['displayName']);
        }

    }
}

// you can anything that comes from API using ArrayAccess

//print_r($identity->toArray());
//echo "\n";