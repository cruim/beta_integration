#!/bin/bash

export GETDATA_DIR=/home/user01/landings/integration_betapost
export GET_PHP=/usr/bin/php

cd $GETDATA_DIR

#получаем список документов исполнителя
$GET_PHP -f update_performer_doc.php
sleep 5
#считываем информацию из документов "Отгрузка клиентам"
$GET_PHP -f update_performer_doc6.php
sleep 5
#считываем информацию из документов "Оплата от клиентов"
$GET_PHP -f update_performer_doc8.php

