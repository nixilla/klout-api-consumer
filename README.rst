KloutApiConsumer
================

This is small library that allows you to easily interact with `KloutAPI v2`_.

.. _`KloutAPI v2`: http://klout.com/s/developers/v2

.. image:: https://travis-ci.org/nixilla/klout-api-consumer.png?branch=master

Installation
````````````

The easiest way - via packagist_:

.. _packagist: https://packagist.org/packages/nixilla/klout-api-consumer

.. code-block:: json

    {
        "require": {
            "nixilla/klout-api-consumer": "~0.6"
        }
    }

Usage:
``````

See example.php

Contributing (with tests):
``````````````````````````

.. code-block:: sh

    git clone git://github.com/nixilla/klout-api-consumer.git && \
    cd klout-api-consumer && \
    mkdir bin && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=bin && \
    ./bin/composer.phar install --dev && \
    ./bin/phpunit


Now you can add your code and send me pull request.
