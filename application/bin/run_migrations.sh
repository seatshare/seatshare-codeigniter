#!/bin/bash 

BASEDIR=$(dirname $(dirname $(dirname $0)))
cd $BASEDIR
php index.php migration