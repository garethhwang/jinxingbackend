#!/usr/bin/bash

CUR_DIR=$(cd "$(dirname "${BASH_SOURCE-$0}")"; pwd);

source $CUR_DIR/../conf/db.conf

CUSTOMER_TABLE="ph_customer"; 
WECHAT_USER_TABLE="wechat_user";

if [ x$1 == x ]
then
	echo "Need customer Id!";
	exit 1;
fi

customer_id=$1;

wechat_id_sql="SELECT wechat_id FROM ${CUSTOMER_TABLE} WHERE customer_id=${customer_id}";

result=`mysql -h${HOSTNAME} -u${USERNAME} -p${PASSWORD} -B ${DBNAME} -e "${wechat_id_sql}" `
wechat_id=`echo $result | cut -d ' ' -f 2`

wechat_openid_sql="SELECT openid FROM ${WECHAT_USER_TABLE} WHERE wechat_id=${wechat_id}";

result=`mysql -h${HOSTNAME} -u${USERNAME} -p${PASSWORD} -B ${DBNAME} -e "${wechat_openid_sql}" | cut -d ' ' -f2`
wechat_openid=`echo $result | cut -d ' ' -f 2`
echo $wechat_openid

