#!/usr/bin/bash

CUR_DIR=$(cd "$(dirname "${BASH_SOURCE-$0}")"; pwd);

source $CUR_DIR/../conf/db.conf
CUR_TABLE="ph_customer"; 
DUMP_FILE="$CUR_DIR/../dumpsql/getlasttime.sql";

if [ -f $DUMP_FILE ] 
then
	rm -rf $DUMP_FILE;
fi

mysql -h${HOSTNAME} -u${USERNAME} -p${PASSWORD} -B ${DBNAME} -N -e "select customer_id, receiptdate, ispregnant from ${CUR_TABLE}" > $DUMP_FILE

if [ $? == 0 ] 
then
	echo "Dump table:${CUR_TABLE} successfully!"
else 
	echo "Dump table:${CUR_TABLE} failed!"
	exit 1;
fi

TODAY=`date -d today +%Y-%m-%d`
STR_TODAY=`date -d "${TODAY}" +%s`

if [ -f $DUMP_FILE ]
then
	cat $DUMP_FILE | while read LINE
  	do
		CustomerId=`echo $LINE | cut -d " " -f 1`;
		Date=`echo $LINE | cut -d " " -f 2`;
		Ispregnant=`echo $LINE | cut -d " " -f 3`
		
		if [ "$Date" != "NULL" ] && [ "$Ispregant" != "0" ]; then
		
			STR_Date=`date -d "${Date}" +%s`

			if [ $STR_TODAY -eq $STR_Date ]; then
				customer_openid=`$CUR_DIR/get_customer_openid.sh $CustomerId`
				`php $CUR_DIR/../php/sendmessage.php ${customer_openid} ${Date} >/dev/null 2>&1 `
				echo "send msg to inform customerid = $CustomerId $customer_openid";
			fi	

			echo "customerid = $CustomerId, date = $Date, today = $TODAY ";
			echo "customerid = $CustomerId, date = $STR_Date, today = $STR_TODAY ";
		fi
	done      
fi
