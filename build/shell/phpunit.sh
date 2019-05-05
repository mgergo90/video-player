#!/bin/bash

if [[ ! $1 ]]
then
    docker-compose run --rm --user $(ls -lnd . | awk '{print $3}') phpunit vendor/bin/phpunit --coverage-html coverage tests/
else
    if [[ $1 = "--watch" ]]
    then
        docker-compose run --user $(ls -lnd . | awk '{print $3}') --rm phpunit vendor/bin/phpunit-watcher watch
    else
        docker-compose run --user $(ls -lnd . | awk '{print $3}') --rm phpunit vendor/bin/phpunit $@
    fi
fi
