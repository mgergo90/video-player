#!/bin/sh

if [ ! $1 ]
then
   docker-compose run --rm --user $(ls -lnd . | awk '{print $3}') phpunit vendor/phpmd/phpmd/src/bin/phpmd app,tests text phpmd.xml --suffixes='php'
else
   docker-compose run --rm --user $(ls -lnd . | awk '{print $3}') phpunit vendor/phpmd/phpmd/src/bin/phpmd $@
fi