#!/bin/sh

if [ ! $1 ]
then
   docker-compose exec --user $(ls -lnd . | awk '{print $3}') backend vendor/phpmd/phpmd/src/bin/phpmd app,tests text phpmd.xml --suffixes='php'
else
   docker-compose exec --user $(ls -lnd . | awk '{print $3}') backend vendor/phpmd/phpmd/src/bin/phpmd $@
fi