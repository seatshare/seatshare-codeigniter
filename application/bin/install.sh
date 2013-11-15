#!/bin/bash

BASEDIR=$(dirname $(dirname $(dirname $0)))

##### CONFIG
if [ -f $BASEDIR/application/config/config.php ]
	then
		echo "Site is already configured."
		exit 1;
fi
echo "Copying config file into place ... "
cp $BASEDIR/application/config/config.php.dist $BASEDIR/application/config/config.php


##### DATABASE
echo "Copying database file into place ... "
cp $BASEDIR/application/config/database.php.dist $BASEDIR/application/config/database.php


##### API_KEYS
echo "Copying api_keys file into place ... "
cp $BASEDIR/application/config/api_keys.php.dist $BASEDIR/application/config/api_keys.php

##### EMAIL
echo "Copying email file into place ... "
cp $BASEDIR/application/config/email.php.dist $BASEDIR/application/config/email.php


echo ""
echo "SeatShare is now configured for development. If this is a production or"
echo "staging environment, you will need to update the configuration files."
echo ""

echo "Done!"