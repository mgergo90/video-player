#!/bin/bash

if [[ ! $1 ]]
then
    docker-compose run --rm --user $(ls -lnd . | awk '{print $3}') phpunit vendor/bin/paratest --colors tests/
else
    docker-compose run --rm --user $(ls -lnd . | awk '{print $3}') phpunit vendor/bin/paratest $@
fi
