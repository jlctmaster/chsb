#!/bin/bash
#	Source Script: https://danielrico.wordpress.com/2011/10/06/hacer-respaldos-automaticos-de-base-de-datos-postgres-en-linux-cron/
#	Modified By: Jorge Colmenarez <jlct.master@gmail.com>
#	Edition Date: 2015-01-29 
#	Changed: Add Validations for Folder with Database Name and Create if not exists

## Variables
FECHA_ACTUAL=`date +%Y%m%d`
HORA_ACTUAL=`date +%H%M`
## User and Password of PostgreSQL
export PGUSER="admin"
export PGPASSWORD="4dm1n12tr4t0r"
## File Name
ARCH_RESP=$FECHA_ACTUAL$HORA_ACTUAL
## Folder
DIR_RESP="/var/www/CHSB/BD/Backups"
## Database
## To make a backup of more than one database add the names in single quotation marks separated by space
## Example: BD_ARRAY=('bd1' 'bd2' 'bd3')
DB_ARRAY=('bdchsb' 'chsbdb')
## Backup
index=0
count="${#DB_ARRAY[*]}"
echo 'Database Server Backing'
while [ $index -lt $count ];
do
echo 'Backing: '${DB_ARRAY[$index]-i}
## if not exists create folder with the database name
if [ ! -d $DIR_RESP/${DB_ARRAY[$index]} ]
then
mkdir $DIR_RESP/${DB_ARRAY[$index]}
fi
## create backups
pg_dump -h localhost -F c -b -f $DIR_RESP/${DB_ARRAY[$index]}/${DB_ARRAY[$index]}_$ARCH_RESP.backup ${DB_ARRAY[$index] -i }
let "index = $index + 1"
done
#
unset PGUSER
unset PGPASSWORD