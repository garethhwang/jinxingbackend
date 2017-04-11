<?php


class ModelWechatUserinfo extends Model
{
    public function getUserInfo($openid){
        $result=$this->db->query("select * from wechat_user where openid='".$openid."'");
        return $result->row;
    }

    public function getUserInfoByWechatId($wechat_id){
        $result=$this->db->query("select * from wechat_user where wechat_id='".$wechat_id."'");
        return $result->row;
    }

    public function getCustomerByWechat($openid) {
        //$log=new Log('wechat.log');
        //$log->write("select * from wechat_user, " . DB_PREFIX . "customer, " . DB_PREFIX . "physical where openid='".$openid."' and wechat_user.wechat_id = " . DB_PREFIX . "customer.wechat_id and " . DB_PREFIX . "customer.customer_id = " . DB_PREFIX . "physical.customer_id ");

        $result = $this->db->query("select * from wechat_user, " . DB_PREFIX . "customer, " . DB_PREFIX . "physical where openid='".$openid."' and wechat_user.wechat_id = " . DB_PREFIX . "customer.wechat_id and " . DB_PREFIX . "customer.customer_id = " . DB_PREFIX . "physical.customer_id ");
        return $result->row;
    }


    public function addWechatUser($data){
        $this->db->query("insert into wechat_user(subscribe,openid,nickname,sex,city,country,province,wlanguage,headimgurl,date_added) values('1','".$data["openid"]."','".$data["nickname"]."','".$data["sex"]."','".$data["city"]."','".$data["country"]."','".$data["province"]."','".$data["language"]."','".$data["headimgurl"]."',NOW())");
        $result=$this->db->query("select * from wechat_user where openid='".$data["openid"]."'");
        return $result->row["wechat_id"];
    }

    public function isUserValid($openid){
        $result=$this->db->query("select * from wechat_user where openid='".$openid."'");
        if($result->row){
            return $result->row["wechat_id"];
        }
    }

    public function addAdvise($data,$customer_id){
        $this->db->query("INSERT INTO " . DB_PREFIX . "advise SET customer_id = '" . (int)$customer_id . "', advise_text= '" . $this->db->escape($data['advisetext']) . "', date_add=NOW()");
    }

    public function subscribe($openid){
        $this->db->query("update wechat_user set subscribe=1 where openid='".$openid."'");
    }

    public function unsubscribe($openid){
        $this->db->query("update wechat_user set subscribe=0 where openid='".$openid."'");
    }

    public function getCityName($cityid){
        $result=$this->db->query("select name from wechat_city where city_id='".$cityid."'");
        if($result->row){
            return $result->row["name"];
        }
    }

    public function getDistrictName($districtid){
        $result=$this->db->query("select name from wechat_district where district_id='".$districtid."'");
        if($result->row){
            return $result->row["name"];
        }
    }

    public function getOfficeName($officeid){
        $result=$this->db->query("select name from wechat_office where office_id='".$officeid."'");
        if($result->row){
            return $result->row["name"];
        }
    }


   /* public function insertinto(){

        $result = $this->db->query("select a.customer_id,a.date_added,b.lastmenstrualdate from " . DB_PREFIX . "customer a , " . DB_PREFIX . "physical b where a.customer_id = b.customer_id ");
        $insertdata = $result->rows;

        //var_dump($insertdata);


        foreach($insertdata as $query){

            if(isset($query["lastmenstrualdate"])){

                $this->db->query("UPDATE " . DB_PREFIX . "clone_customer SET firreceipt = DATE_ADD( '".$this->db->escape($query["lastmenstrualdate"])."',INTERVAL 10 WEEK), secreceipt = DATE_ADD( '".$this->db->escape($query["lastmenstrualdate"])."',INTERVAL 20 WEEK),thireceipt = DATE_ADD( '".$this->db->escape($query["lastmenstrualdate"])."',INTERVAL 34 WEEK) WHERE customer_id = '" . (int)$query["customer_id"] . "'");
            }


           if($query["lastmenstrualdate"]==null || $query["lastmenstrualdate"]=="0000-00-00"){

                $temp = date_create($query["date_added"]);
                $fircheck = date_modify($temp,"+12 weeks");$fircheck = date_format($fircheck,'Y-m-d');$firchecks = date_create($fircheck);$firchecks = date_modify($firchecks,"+7 days");$firchecks = date_format($firchecks,'Y-m-d');$temp = date_create($query["date_added"]);
                $seccheck = date_modify($temp,"+16 weeks");$seccheck = date_format($seccheck,'Y-m-d');$secchecks = date_create($seccheck);$secchecks = date_modify($secchecks,"+7 days");$secchecks = date_format($secchecks,'Y-m-d');$temp = date_create($query["date_added"]);
                $thicheck = date_modify($temp,"+20 weeks");$thicheck = date_format($thicheck,'Y-m-d');$thichecks = date_create($thicheck);$thichecks = date_modify($thichecks,"+7 days");$thichecks = date_format($thichecks,'Y-m-d');$temp = date_create($query["date_added"]);
                $foucheck = date_modify($temp,"+24 weeks");$foucheck = date_format($foucheck,'Y-m-d');$fouchecks = date_create($foucheck);$fouchecks = date_modify($fouchecks,"+7 days");$fouchecks = date_format($fouchecks,'Y-m-d');$temp = date_create($query["date_added"]);
                $fifcheck = date_modify($temp,"+28 weeks");$fifcheck = date_format($fifcheck,'Y-m-d');$fifchecks = date_create($fifcheck);$fifchecks = date_modify($fifchecks,"+7 days");$fifchecks = date_format($fifchecks,'Y-m-d');$temp = date_create($query["date_added"]);
                $sixcheck = date_modify($temp,"+30 weeks");$sixcheck = date_format($sixcheck,'Y-m-d');$sixchecks = date_create($sixcheck);$sixchecks = date_modify($sixchecks,"+7 days");$sixchecks = date_format($sixchecks,'Y-m-d');$temp = date_create($query["date_added"]);
                $sevcheck = date_modify($temp,"+32 weeks");$sevcheck = date_format($sevcheck,'Y-m-d');$sevchecks = date_create($sevcheck);$sevchecks = date_modify($sevchecks,"+7 days");$sevchecks = date_format($sevchecks,'Y-m-d');$temp = date_create($query["date_added"]);
                $eigcheck = date_modify($temp,"+36 weeks");$eigcheck = date_format($eigcheck,'Y-m-d');$eigchecks = date_create($eigcheck);$eigchecks = date_modify($eigchecks,"+7 days");$eigchecks = date_format($eigchecks,'Y-m-d');$temp = date_create($query["date_added"]);
                $nincheck = date_modify($temp,"+37 weeks");$nincheck = date_format($nincheck,'Y-m-d');$ninchecks = date_create($nincheck);$ninchecks = date_modify($ninchecks,"+7 days");$ninchecks = date_format($ninchecks,'Y-m-d');$temp = date_create($query["date_added"]);
                $tencheck = date_modify($temp,"+38 weeks");$tencheck = date_format($tencheck,'Y-m-d');$tenchecks = date_create($tencheck);$tenchecks = date_modify($tenchecks,"+7 days");$tenchecks = date_format($tenchecks,'Y-m-d');$temp = date_create($query["date_added"]);
                $tenseccheck = date_modify($temp,"+39 weeks");$tenseccheck = date_format($tenseccheck,'Y-m-d');$tensecchecks = date_create($tenseccheck);$tensecchecks = date_modify($tensecchecks,"+7 days");$tensecchecks = date_format($tensecchecks,'Y-m-d');$temp = date_create($query["date_added"]);
                $tenthicheck = date_modify($temp,"+40 weeks");$tenthicheck = date_format($tenthicheck,'Y-m-d');$tenthichecks = date_create($tenthicheck);$tenthichecks = date_modify($tenthichecks,"+7 days");$tenthichecks = date_format($tenthichecks,'Y-m-d');

                $this->db->query("INSERT INTO " . DB_PREFIX . "checklist SET customer_id = '" . (int)$query["customer_id"] . "',lastmenstrualdate ='".$query["date_added"]."', fircheck =  '".$fircheck."',fircheckurl =  '" . checklist . "1?start=".$fircheck."&end=".$firchecks."' , seccheck =  '".$seccheck."', seccheckurl =  '" . checklist . "2?start=".$seccheck."&end=".$secchecks."' , thicheck =  '".$thicheck."', thicheckurl =  '" . checklist . "3?start=".$thicheck."&end=".$thichecks."' , foucheck =  '".$foucheck."', foucheckurl =  '" . checklist . "4?start=".$foucheck."&end=".$fouchecks."' , fifcheck =  '".$fifcheck."', fifcheckurl =  '" . checklist . "5?start=".$fifcheck."&end=".$fifchecks."' , sixcheck =  '".$sixcheck."', sixcheckurl =  '" . checklist . "6?start=".$sixcheck."&end=".$sixchecks."' , sevcheck =  '".$sevcheck."', sevcheckurl =  '" . checklist . "7?start=".$sevcheck."&end=".$sevchecks."' , eigcheck =  '".$eigcheck."', eigcheckurl =  '" . checklist . "8?start=".$eigcheck."&end=".$eigchecks."' , nincheck =  '".$nincheck."', nincheckurl =  '" . checklist . "9?start=".$nincheck."&end=".$ninchecks."' , tencheck =  '".$tencheck."', tencheckurl =  '" . checklist . "10?start=".$tencheck."&end=".$tenthichecks."&firend=".$tenchecks."&secstart=".$tenseccheck."&secend=".$tensecchecks."&thistart=".$tenthicheck."'");


            }else{

                $temp = date_create($query["lastmenstrualdate"]);
                $fircheck = date_modify($temp,"+12 weeks");$fircheck = date_format($fircheck,'Y-m-d');$firchecks = date_create($fircheck);$firchecks = date_modify($firchecks,"+7 days");$firchecks = date_format($firchecks,'Y-m-d');$temp = date_create($query["lastmenstrualdate"]);
                $seccheck = date_modify($temp,"+16 weeks");$seccheck = date_format($seccheck,'Y-m-d');$secchecks = date_create($seccheck);$secchecks = date_modify($secchecks,"+7 days");$secchecks = date_format($secchecks,'Y-m-d');$temp = date_create($query["lastmenstrualdate"]);
                $thicheck = date_modify($temp,"+20 weeks");$thicheck = date_format($thicheck,'Y-m-d');$thichecks = date_create($thicheck);$thichecks = date_modify($thichecks,"+7 days");$thichecks = date_format($thichecks,'Y-m-d');$temp = date_create($query["lastmenstrualdate"]);
                $foucheck = date_modify($temp,"+24 weeks");$foucheck = date_format($foucheck,'Y-m-d');$fouchecks = date_create($foucheck);$fouchecks = date_modify($fouchecks,"+7 days");$fouchecks = date_format($fouchecks,'Y-m-d');$temp = date_create($query["lastmenstrualdate"]);
                $fifcheck = date_modify($temp,"+28 weeks");$fifcheck = date_format($fifcheck,'Y-m-d');$fifchecks = date_create($fifcheck);$fifchecks = date_modify($fifchecks,"+7 days");$fifchecks = date_format($fifchecks,'Y-m-d');$temp = date_create($query["lastmenstrualdate"]);
                $sixcheck = date_modify($temp,"+30 weeks");$sixcheck = date_format($sixcheck,'Y-m-d');$sixchecks = date_create($sixcheck);$sixchecks = date_modify($sixchecks,"+7 days");$sixchecks = date_format($sixchecks,'Y-m-d');$temp = date_create($query["lastmenstrualdate"]);
                $sevcheck = date_modify($temp,"+32 weeks");$sevcheck = date_format($sevcheck,'Y-m-d');$sevchecks = date_create($sevcheck);$sevchecks = date_modify($sevchecks,"+7 days");$sevchecks = date_format($sevchecks,'Y-m-d');$temp = date_create($query["lastmenstrualdate"]);
                $eigcheck = date_modify($temp,"+36 weeks");$eigcheck = date_format($eigcheck,'Y-m-d');$eigchecks = date_create($eigcheck);$eigchecks = date_modify($eigchecks,"+7 days");$eigchecks = date_format($eigchecks,'Y-m-d');$temp = date_create($query["lastmenstrualdate"]);
                $nincheck = date_modify($temp,"+37 weeks");$nincheck = date_format($nincheck,'Y-m-d');$ninchecks = date_create($nincheck);$ninchecks = date_modify($ninchecks,"+7 days");$ninchecks = date_format($ninchecks,'Y-m-d');$temp = date_create($query["lastmenstrualdate"]);
                $tencheck = date_modify($temp,"+38 weeks");$tencheck = date_format($tencheck,'Y-m-d');$tenchecks = date_create($tencheck);$tenchecks = date_modify($tenchecks,"+7 days");$tenchecks = date_format($tenchecks,'Y-m-d');$temp = date_create($query["lastmenstrualdate"]);
                $tenseccheck = date_modify($temp,"+39 weeks");$tenseccheck = date_format($tenseccheck,'Y-m-d');$tensecchecks = date_create($tenseccheck);$tensecchecks = date_modify($tensecchecks,"+7 days");$tensecchecks = date_format($tensecchecks,'Y-m-d');$temp = date_create($query["lastmenstrualdate"]);
                $tenthicheck = date_modify($temp,"+40 weeks");$tenthicheck = date_format($tenthicheck,'Y-m-d');$tenthichecks = date_create($tenthicheck);$tenthichecks = date_modify($tenthichecks,"+7 days");$tenthichecks = date_format($tenthichecks,'Y-m-d');

                $this->db->query("INSERT INTO " . DB_PREFIX . "checklist SET customer_id = '" . (int)$query["customer_id"] . "',lastmenstrualdate ='".$query["lastmenstrualdate"]."', fircheck =  '".$fircheck."',fircheckurl =  '" . checklist . "1?start=".$fircheck."&end=".$firchecks."' , seccheck =  '".$seccheck."', seccheckurl =  '" . checklist . "2?start=".$seccheck."&end=".$secchecks."' , thicheck =  '".$thicheck."', thicheckurl =  '" . checklist . "3?start=".$thicheck."&end=".$thichecks."' , foucheck =  '".$foucheck."', foucheckurl =  '" . checklist . "4?start=".$foucheck."&end=".$fouchecks."' , fifcheck =  '".$fifcheck."', fifcheckurl =  '" . checklist . "5?start=".$fifcheck."&end=".$fifchecks."' , sixcheck =  '".$sixcheck."', sixcheckurl =  '" . checklist . "6?start=".$sixcheck."&end=".$sixchecks."' , sevcheck =  '".$sevcheck."', sevcheckurl =  '" . checklist . "7?start=".$sevcheck."&end=".$sevchecks."' , eigcheck =  '".$eigcheck."', eigcheckurl =  '" . checklist . "8?start=".$eigcheck."&end=".$eigchecks."' , nincheck =  '".$nincheck."', nincheckurl =  '" . checklist . "9?start=".$nincheck."&end=".$ninchecks."' , tencheck =  '".$tencheck."', tencheckurl =  '" . checklist . "10?start=".$tencheck."&end=".$tenthichecks."&firend=".$tenchecks."&secstart=".$tenseccheck."&secend=".$tensecchecks."&thistart=".$tenthicheck."'");
            }


        }

    }*/




}