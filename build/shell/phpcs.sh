#!/bin/sh

if [ ! $1 ]
then
   docker-compose exec --user $(ls -lnd . | awk '{print $3}') backend vendor/squizlabs/php_codesniffer/bin/phpcs --standard=./phpcs.xml --extensions=php app tests --report=full
else
   docker-compose exec --user $(ls -lnd . | awk '{print $3}') backend vendor/squizlabs/php_codesniffer/bin/phpcs $@
fi