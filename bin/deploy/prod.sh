#!/usr/bin/env bash

read -p "You are deploying to PRODUCTION. Are you sure? " -n 1 -r
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi
echo ""

BASEDIR=$(dirname $0)
sh $BASEDIR/_deploy.sh prod
