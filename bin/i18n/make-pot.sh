#!/usr/bin/env bash

BASE_DIR=`cd $(dirname $0); pwd`
CLIDIR="cli/wp"
LOCAL_DIR="$BASE_DIR/../../"

COMMAND="cd $LOCAL_DIR; sh $CLIDIR i18n make-pot $LOCAL_DIR/public/wp-content/themes/common/ $LOCAL_DIR/public/wp-content/languages/themes/common.pot;"
eval $COMMAND

echo "Done."
