<?php
class ModelAccountPhysical extends Model {
    /*public function addPhysical($data) {


        $this->db->query("INSERT INTO " . DB_PREFIX . "physical SET customer_id = '" . (int)$this->customer->getId(). "', realname = '" . $this->db->escape($data['realname']) . "', height = '" . $this->db->escape($data['height']) . "', weight = '" . $this->db->escape($data['weight']) . "', bmiindex = '" . $this->db->escape($data['bmiindex']) . "', bmitype = '" . $this->db->escape($data['bmitype']) . "', lastmenstrualdate = '" . $this->db->escape($data['lastmenstrualdate']) . "', edc = '" . $this->db->escape($data['edc']) . "', gravidity = '" . $this->db->escape($data['gravidity']) . "', parity = '" . $this->db->escape($data['parity']) . "', vaginaldelivery = '" . $this->db->escape($data['vaginaldelivery']) . "', aesarean = '" . $this->db->escape($data['aesarean']) . "', spontaneousabortion = '" . $this->db->escape($data['spontaneousabortion']) . "', drug_inducedabortion = '" . $this->db->escape($data['drug_inducedabortion']) . "', fetal = '" . $this->db->escape($data['fetal']) . "', highrisk = '" . $this->db->escape($data['highrisk']) . "', highriskfactor = '" . $this->db->escape($data['highriskfactor']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "'");

        $physical_id = $this->db->getLastId();

        return $physical_id;
    }*/

    public function editPhysical($physical_id, $data) {

        $this->db->query("UPDATE " . DB_PREFIX . "physical SET realname = '" . $this->db->escape($data['realname']) . "', height = '" . $this->db->escape($data['height']) . "', weight = '" . $this->db->escape($data['weight']) . "', bmiindex = '" . $this->db->escape($data['bmiindex']) . "', bmitype = '" . $this->db->escape($data['bmitype']) . "', lastmenstrualdate = '" . $this->db->escape($data['lastmenstrualdate']) . "', edc = '" . $this->db->escape($data['edc']) . "', gravidity = '" . $this->db->escape($data['gravidity']) . "', parity = '" . $this->db->escape($data['parity']) . "', vaginaldelivery = '" . $this->db->escape($data['vaginaldelivery']) . "', aesarean = '" . $this->db->escape($data['aesarean']) . "', spontaneousabortion = '" . $this->db->escape($data['spontaneousabortion']) . "', drug_inducedabortion = '" . $this->db->escape($data['drug_inducedabortion']) . "', fetal = '" . $this->db->escape($data['fetal']) . "', highrisk = '" . $this->db->escape($data['highrisk']) . "', highriskfactor = '" . $this->db->escape($data['highriskfactor']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "' WHERE physical_id  = '" . (int)$physical_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");

        $lastmenstrual = $this->db->query("SELECT lastmenstrualdate FROM " . DB_PREFIX . "physical  WHERE customer_id = '" . (int)$this->customer->getId() . "'");

        $lastmenstrualdate = $lastmenstrual->row['lastmenstrualdate'];

        $temp = date_create($lastmenstrualdate);
        $fircheck = date_modify($temp,"+12 weeks");$fircheck = date_format($fircheck,'Y-m-d');$firchecks = date_create($fircheck);$firchecks = date_modify($firchecks,"+7 days");$firchecks = date_format($firchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $seccheck = date_modify($temp,"+16 weeks");$seccheck = date_format($seccheck,'Y-m-d');$secchecks = date_create($seccheck);$secchecks = date_modify($secchecks,"+7 days");$secchecks = date_format($secchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $thicheck = date_modify($temp,"+20 weeks");$thicheck = date_format($thicheck,'Y-m-d');$thichecks = date_create($thicheck);$thichecks = date_modify($thichecks,"+7 days");$thichecks = date_format($thichecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $foucheck = date_modify($temp,"+24 weeks");$foucheck = date_format($foucheck,'Y-m-d');$fouchecks = date_create($foucheck);$fouchecks = date_modify($fouchecks,"+7 days");$fouchecks = date_format($fouchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $fifcheck = date_modify($temp,"+28 weeks");$fifcheck = date_format($fifcheck,'Y-m-d');$fifchecks = date_create($fifcheck);$fifchecks = date_modify($fifchecks,"+7 days");$fifchecks = date_format($fifchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $sixcheck = date_modify($temp,"+30 weeks");$sixcheck = date_format($sixcheck,'Y-m-d');$sixchecks = date_create($sixcheck);$sixchecks = date_modify($sixchecks,"+7 days");$sixchecks = date_format($sixchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $sevcheck = date_modify($temp,"+32 weeks");$sevcheck = date_format($sevcheck,'Y-m-d');$sevchecks = date_create($sevcheck);$sevchecks = date_modify($sevchecks,"+7 days");$sevchecks = date_format($sevchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $eigcheck = date_modify($temp,"+36 weeks");$eigcheck = date_format($eigcheck,'Y-m-d');$eigchecks = date_create($eigcheck);$eigchecks = date_modify($eigchecks,"+7 days");$eigchecks = date_format($eigchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $nincheck = date_modify($temp,"+37 weeks");$nincheck = date_format($nincheck,'Y-m-d');$ninchecks = date_create($nincheck);$ninchecks = date_modify($ninchecks,"+7 days");$ninchecks = date_format($ninchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $tencheck = date_modify($temp,"+38 weeks");$tencheck = date_format($tencheck,'Y-m-d');$tenchecks = date_create($tencheck);$tenchecks = date_modify($tenchecks,"+7 days");$tenchecks = date_format($tenchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $tenseccheck = date_modify($temp,"+39 weeks");$tenseccheck = date_format($tenseccheck,'Y-m-d');$tensecchecks = date_create($tenseccheck);$tensecchecks = date_modify($tensecchecks,"+7 days");$tensecchecks = date_format($tensecchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $tenthicheck = date_modify($temp,"+40 weeks");$tenthicheck = date_format($tenthicheck,'Y-m-d');$tenthichecks = date_create($tenthicheck);$tenthichecks = date_modify($tenthichecks,"+7 days");$tenthichecks = date_format($tenthichecks,'Y-m-d');

        $this->db->query("UPDATE " . DB_PREFIX . "checklist SET lastmenstrualdate ='".$lastmenstrualdate."', fircheck =  '".$fircheck."',fircheckurl =  '" . checklist . "1?start=".$fircheck."&end=".$firchecks."' , seccheck =  '".$seccheck."', seccheckurl =  '" . checklist . "2?start=".$seccheck."&end=".$secchecks."' , thicheck =  '".$thicheck."', thicheckurl =  '" . checklist . "3?start=".$thicheck."&end=".$thichecks."' , foucheck =  '".$foucheck."', foucheckurl =  '" . checklist . "4?start=".$foucheck."&end=".$fouchecks."' , fifcheck =  '".$fifcheck."', fifcheckurl =  '" . checklist . "5?start=".$fifcheck."&end=".$fifchecks."' , sixcheck =  '".$sixcheck."', sixcheckurl =  '" . checklist . "6?start=".$sixcheck."&end=".$sixchecks."' , sevcheck =  '".$sevcheck."', sevcheckurl =  '" . checklist . "7?start=".$sevcheck."&end=".$sevchecks."' , eigcheck =  '".$eigcheck."', eigcheckurl =  '" . checklist . "8?start=".$eigcheck."&end=".$eigchecks."' , nincheck =  '".$nincheck."', nincheckurl =  '" . checklist . "9?start=".$nincheck."&end=".$ninchecks."' , tencheck =  '".$tencheck."', tencheckurl =  '" . checklist . "10?start=".$tencheck."&end=".$tenthichecks."&firend=".$tenchecks."&secstart=".$tenseccheck."&secend=".$tensecchecks."&thistart=".$tenthicheck."'WHERE customer_id = '" . (int)$this->customer->getId() . "'");

    }

    public function deletePhysical($physical_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "physical WHERE physical_id = '" . (int)$physical_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");
    }

    public function getPhysical($physical_id) {
        $physical_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "physical WHERE physical_id = '" . (int)$physical_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");

        if ($physical_query->num_rows) {


            $physical_data = array(
                'physical_id'     => $physical_query->row['physical_id'],
                'realname'      => $physical_query->row['realname'],
                'height'        => $physical_query->row['height'],
                'weight'        => $physical_query->row['weight'],
                'bmiindex'      => $physical_query->row['bmiindex'],
                'bmitype'      => $physical_query->row['bmitype'],
                'lastmenstrualdata'       => $physical_query->row['lastmenstrualdata'],
                'edc'           => $physical_query->row['edc'],
                'gravidity'        => $physical_query->row['gravidity'],
                'parity'           => $physical_query->row['parity'],
                'vaginaldelivery'      =>$physical_query->row['vaginaldelivery'],
                'aesarean'     => $physical_query->row['aesarean'],
                'spontaneousabortion'        => $physical_query->row['spontaneousabortion'],
                'drug_inducedabortion'     => $physical_query->row['drug_inducedabortion'],
                'fetal'     => $physical_query->row['fetal'],
                'highrisk' => $physical_query->row['highrisk'],
                'highriskfactor'   => $physical_query->row['highriskfactor'],
                'custom_field'   => json_decode($physical_query->row['custom_field'], true)
            );

            return $physical_data;
        } else {
            return false;
        }
    }

}