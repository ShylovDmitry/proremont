#!/usr/bin/env bash

read -p "You are overriding PRODUCTION database. Are you sure? " -n 1 -r
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi
echo ""

BASEDIR=$(dirname $0)
sh $BASEDIR/_migratedb.sh dev prod
