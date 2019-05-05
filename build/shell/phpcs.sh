#!/bin/sh

if [ ! $1 ]
then
   docker-compose run --rm --user $(ls -lnd . | awk '{print $3}') phpunit vendor/squizlabs/php_codesniffer/bin/phpcs --standard=./phpcs.xml --extensions=php app tests --report=full
else
   docker-compose run --rm --user $(ls -lnd . | awk '{print $3}') phpunit vendor/squizlabs/php_codesniffer/bin/phpcs $@
fi