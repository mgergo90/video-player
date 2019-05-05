#!/bin/sh

if [ ! $1 ]
then
   docker-compose exec --user $(ls -lnd . | awk '{print $3}') backend bash
else
   docker-compose exec --user $(ls -lnd . | awk '{print $3}') backend $@
fi