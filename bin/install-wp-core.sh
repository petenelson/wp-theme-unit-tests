#!/bin/bash

# Print commands to the screen
# set -x

# Catch Errors
set -euo pipefail

# sudo -E docker-php-ext-install mysqli
# sudo apt-get update
# sudo apt-get install default-mysql-client

# Set up WordPress installation.
export WP_DEVELOP_DIR=./tmp/wordpress/
export WP_VERSION=5.8.3

if [ -d "$WP_DEVELOP_DIR" ] 
then
    echo "Directory $WP_DEVELOP_DIR exists, deleting..." 
    rm -rf $WP_DEVELOP_DIR
fi

mkdir -p $WP_DEVELOP_DIR

# Use the Git mirror of WordPress.
git clone --depth=1 --branch="$WP_VERSION" git://develop.git.wordpress.org/ $WP_DEVELOP_DIR

# Set up WordPress configuration.
pushd $WP_DEVELOP_DIR
echo $WP_DEVELOP_DIR

composer install

cp wp-tests-config-sample.php wp-tests-config.php

# If you're running this from a Mac terminal, you can add
# mysql to /etc/hosts and point it to 127.0.0.1
sed -i "s/youremptytestdbnamehere/wordpress_test/" wp-tests-config.php
sed -i "s/localhost/mysql/" wp-tests-config.php
sed -i "s/yourusernamehere/root/" wp-tests-config.php
sed -i "s/yourpasswordhere/password/" wp-tests-config.php

# Switch back to the plugin dir
popd

# Stop printing commands to screen
set +x
