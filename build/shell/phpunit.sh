#!/bin/bash

if [[ ! $1 ]]
then
   docker-compose exec --user $(ls -lnd . | awk '{print $3}') backend vendor/bin/phpunit --coverage-html coverage tests/
else
    if [[ $1 = "--watch" ]]
    then
        docker-compose exec --user $(ls -lnd . | awk '{print $3}') backend vendor/bin/phpunit-watcher watch
    else
        docker-compose exec --user $(ls -lnd . | awk '{print $3}') backend vendor/bin/phpunit $@
    fi
fi
