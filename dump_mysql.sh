#!/bin/sh

mysqldump --single-transaction -hmarie -ucsci311h csci311h_tekku -p > docker-entrypoint-initdb.d/db_backup.sql
