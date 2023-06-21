#!/bin/bash

cd /docker-entrypoint-initdb.d
mysql -uroot -ptestpass < drop.sql
mysql -uroot -ptestpass < mysql_create.sql

# Start the MySQL server
/docker-entrypoint.sh mysqld
