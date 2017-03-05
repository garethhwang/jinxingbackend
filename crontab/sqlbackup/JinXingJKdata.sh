#! /usr/bin/bash

BACKUPDIR="/home/backups/sql/"
LOGDIR="/home/backups/log/"
BACKUPFILE="${BACKUPDIR}database_`date '+%m-%d-%Y-%H-%M'`.sql.gz"
LOGFILE="${LOGDIR}database_`date '+%m-%d-%Y-%H-%M'`.log"

#check the backup dir
if [ ! -d $BACKUPDIR ]
then
	echo "${BACKUPDIR}: No such file or directory " | tee $LOGFILE 
	exit 1 
fi

#the real backup command for mysql database
if [ -f $BACKUPFILE ]
then 
	rm -f $BACKUPFILE
fi

mysqldump -h10.9.160.6 -uwork -pqweiop123890 --all-databases | gzip  > $BACKUPFILE

#check the backup results
if [ -s $BACKUPFILE ]
then
	echo "$BACKUPFILE backup successfully!" | tee $LOGFILE
else
	echo "$BACKUPFILE backup failed!" | tee $LOGFILE
	exit 1
fi

#save the lastest 20 backup files
TotalFileNum=` ls $BACKUPDIR | wc -l`;

if [ $TotalFileNum -gt 20 ]
then
	DeleteFileNum=`expr $TotalFileNum - 20`;
	ls -rt $BACKUPDIR | head -${DeleteFileNum} | while read File
	do
		echo "remove file $File" | tee $LOGFILE
		rm -rf $BACKUPDIR$File
	done
fi

