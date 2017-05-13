#!/bin/bash

export GETDATA_DIR=/home/user01/landings/integration_betapost
export GET_PHP=/usr/bin/php

cd $GETDATA_DIR

#обновляем атрибут операции из betapost
$GET_PHP -f update_operation_attr.php
sleep 5
#обновляем трекеры в CRM, для заказов без трекеров
$GET_PHP -f update_tracker_crm.php
sleep 5
#получаем трекеры из betapost
$GET_PHP -f update_status_get_tracking.php
sleep 5
#обновляем статусы на основе трекеров
$GET_PHP -f update_status_crm.php
