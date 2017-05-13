#!/bin/bash

export GETDATA_DIR=/home/user01/landings/integration_betapost
export GET_PHP=/usr/bin/php

cd $GETDATA_DIR

$GET_PHP -f index5.php
