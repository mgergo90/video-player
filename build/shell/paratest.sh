#!/bin/bash

if [[ ! $1 ]]
then
    docker-compose exec --user $(ls -lnd . | awk '{print $3}') backend vendor/bin/paratest --colors tests/
else
    docker-compose exec --user $(ls -lnd . | awk '{print $3}') backend vendor/bin/paratest $@
fi
