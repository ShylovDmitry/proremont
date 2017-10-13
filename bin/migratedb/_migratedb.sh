#!/usr/bin/env bash

SERVER_USER=ec2-user
SERVER_HOST=$SERVER_USER@52.28.148.152
SERVER_KEY="~/.ssh/proremont.pem"

BASE_DIR=`cd $(dirname $0); pwd`
CLIDIR="cli/wp"

FROM_STACK=$1
TO_STACK=$2

DEV_DIR="/var/www/html/dev/"
PROD_DIR="/var/www/html/prod/"
LOCAL_DIR="$BASE_DIR/../../"

DEV_URL="http://dev.proremont.co"
PROD_URL="http://proremont.co"
LOCAL_URL="http://proremont.local"


if [ $FROM_STACK = "prod" ]; then
    FROM_DIR=$PROD_DIR
    FROM_URL=$PROD_URL
elif [ $FROM_STACK = "dev" ]; then
    FROM_DIR=$DEV_DIR
    FROM_URL=$DEV_URL
else
    FROM_DIR=$LOCAL_DIR
    FROM_URL=$LOCAL_URL
fi

if [ $TO_STACK = 'prod' ]; then
    TO_DIR=$PROD_DIR
    TO_URL=$PROD_URL
elif [ $TO_STACK = "dev" ]; then
    TO_DIR=$DEV_DIR
    TO_URL=$DEV_URL
else
    TO_DIR=$LOCAL_DIR
    TO_URL=$LOCAL_URL
fi


if [ $TO_STACK = 'prod' ]; then
    OPTION_BLOG_PUBLIC=0
else
    OPTION_BLOG_PUBLIC=0
fi



COMMAND_EXPORT="cd $FROM_DIR; sh $CLIDIR db export dump.sql;"
COMMAND_IMPORT="cd $TO_DIR; sh $CLIDIR db reset --yes; sh $CLIDIR db import dump.sql; sh $CLIDIR search-replace $FROM_URL $TO_URL; sh $CLIDIR option update blog_public $OPTION_BLOG_PUBLIC; sh $CLIDIR cache flush;"
COMMAND_CLEAN="cd $TO_DIR; rm dump.sql;"

if [ $FROM_STACK = 'local' ]; then
    eval $COMMAND_EXPORT
    rsync --remove-source-files -azv -e "ssh -i \"$SERVER_KEY\"" $FROM_DIR/dump.sql $SERVER_HOST:$TO_DIR
else
    ssh -i $SERVER_KEY $SERVER_HOST "$COMMAND_EXPORT"
    rsync --remove-source-files -azv -e "ssh -i \"$SERVER_KEY\"" $SERVER_HOST:$FROM_DIR/dump.sql $TO_DIR
fi


if [ $TO_STACK = 'local' ]; then
    eval $COMMAND_IMPORT
    eval $COMMAND_CLEAN
else
    ssh -i $SERVER_KEY $SERVER_HOST "$COMMAND_IMPORT"
    ssh -i $SERVER_KEY $SERVER_HOST "$COMMAND_CLEAN"
fi

echo "Done."
