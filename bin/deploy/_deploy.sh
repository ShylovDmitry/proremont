#!/usr/bin/env bash

if [ -z $1 ]; then
    echo "Usage: $0 <dev|prod>"
    exit 1
fi

SERVER_USER=ec2-user
SERVER_HOST=$SERVER_USER@52.28.148.152
SERVER_KEY="~/.ssh/proremont.pem"

STACK=$1
BASEDIR=$(dirname $0)
DEPLOY_FOLDER="/var/www/html/$STACK"

if [ $STACK = 'prod' ]; then
    OPTION_BLOG_PUBLIC=1
else
    OPTION_BLOG_PUBLIC=0
fi

npm install
composer install

rsync -avz --delete --no-perms -O -e "ssh -i \"$SERVER_KEY\"" \
    --exclude='*.sql' \
    --exclude='*.idea' \
    --exclude='*.git' \
    --exclude='*.gitignore' \
    --exclude='*.DS_Store' \
    --exclude='/README.md' \
    --exclude='/.htaccess' \
    --exclude='/composer*' \
    --exclude='/bin/deploy' \
    --exclude='/bin/local' \
    --exclude='/composer-artifacts' \
    --exclude='/.sass-cache' \
    --exclude='/node_modules' \
    --exclude='/public/wp-content/db.php' \
    --exclude='/public/wp/wp-content/*' \
    --exclude='/public/wp-config.php' \
    --exclude='/public/wp-content/cache/*' \
    --exclude='/public/wp-content/ewww/*' \
    --exclude='/public/wp-content/banners/*' \
    --exclude='/public/wp-content/uploads/*' \
    --exclude='/public/wp-content/wp-rocket-config/*' \
    . $SERVER_HOST:$DEPLOY_FOLDER


ssh -i "$SERVER_KEY" $SERVER_HOST "rm -f $DEPLOY_FOLDER/public/wp-config.php"
ssh -i "$SERVER_KEY" $SERVER_HOST "ln -fs $DEPLOY_FOLDER/public/wp-config-$STACK.php $DEPLOY_FOLDER/public/wp-config.php"

ssh -i "$SERVER_KEY" $SERVER_HOST "chown -R $SERVER_USER:www $DEPLOY_FOLDER/"
ssh -i "$SERVER_KEY" $SERVER_HOST "find $DEPLOY_FOLDER/ -type d -exec chmod 2775 {} \;"
ssh -i "$SERVER_KEY" $SERVER_HOST "find $DEPLOY_FOLDER/ -type f -exec chmod 0664 {} \;"
ssh -i "$SERVER_KEY" $SERVER_HOST "chmod 440 $DEPLOY_FOLDER/public/wp-config*.php"
ssh -i "$SERVER_KEY" $SERVER_HOST "chmod -R 770 $DEPLOY_FOLDER/public/wp-content/uploads"
ssh -i "$SERVER_KEY" $SERVER_HOST "chmod -R 774 $DEPLOY_FOLDER/public/wp-content/banners"
ssh -i "$SERVER_KEY" $SERVER_HOST "chmod -R 770 $DEPLOY_FOLDER/public/wp-content/cache"
ssh -i "$SERVER_KEY" $SERVER_HOST "chmod -R 777 $DEPLOY_FOLDER/public/wp-content/ewww"

ssh -i "$SERVER_KEY" $SERVER_HOST "cd $DEPLOY_FOLDER && sh cli/wp option update blog_public $OPTION_BLOG_PUBLIC"
ssh -i "$SERVER_KEY" $SERVER_HOST "cd $DEPLOY_FOLDER && sh cli/wp cache flush"
#ssh -i "$SERVER_KEY" $SERVER_HOST "cd $DEPLOY_FOLDER && sh cli/wp rocket preload"

ssh -i "$SERVER_KEY" $SERVER_HOST "rm -rf $DEPLOY_FOLDER/public/wp-content/cache/*"

#ssh -i "$SERVER_KEY" $SERVER_HOST "cp $DEPLOY_FOLDER/configs/supervisor/supervisord.conf /etc/supervisord.conf"

ssh -i "$SERVER_KEY" $SERVER_HOST "sudo ln -fs $DEPLOY_FOLDER/config /config"
ssh -i "$SERVER_KEY" $SERVER_HOST "sudo ln -fs /config/php/php.ini /etc/php-5.6.ini"

ssh -i "$SERVER_KEY" $SERVER_HOST "sudo /etc/init.d/nginx configtest && sudo /etc/init.d/nginx reload"
ssh -i "$SERVER_KEY" $SERVER_HOST "sudo /etc/init.d/php-fpm reload"

echo "Done."
