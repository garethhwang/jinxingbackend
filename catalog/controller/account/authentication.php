<?php
class ControllerAccountAuthentication extends Controller {

    public function index()
    {

        $log = new Log('wechat.log');
        $jxsession = $this->request->json("jxsession",0);
        $code = $this->request->json("code",0);
        $log->write("session=".$jxsession."   code=".$code);

        if (!empty($jxsession)) {

            return $jxsession;

        } else {

            if (!empty($code)) {

                if ($this->cache->get($code)) {
                    $codeinfo = $this->cache->get($code);
                    $codeinfo=json_decode($codeinfo,true);
                    $data["openid"] = $codeinfo["openid"];
                    $data["wechat_id"] = $codeinfo["wechat_id"];
                    $log->write("openid111=".$data["openid"]."   wechat111=".$data["wechat_id"]);

                }else {

                    $get_url = sprintf(WECHAT_USERTOKEN, AppID, AppSecret, $code);
                    $get_return = file_get_contents($get_url);
                    $get_return = (array)json_decode($get_return);
                    $this->load->model('wechat/userinfo');
                    $log->write("openid111=11111");
                    if (isset($get_return["openid"])) {

                        $data["openid"] = $get_return["openid"];
                        $wechatid = $this->model_wechat_userinfo->isUserValid($get_return["openid"]);
                        $log->write("openid111=22222");
                        if (isset($wechatid)) {
                            $data["wechat_id"] = $wechatid;

                        } else {
                            $wechatinfo = $this->getUser($get_return["access_token"], $get_return["openid"]);
                            $data["wechat_id"] = $this->model_wechat_userinfo->addWechatUser($wechatinfo);
                        }
                        $this->cache->set($code, json_encode(array('openid' => $get_return["openid"], 'wechat_id' => $data["wechat_id"])));

                    } else {
                        //$this->error["error_warning"] = $get_return["errmsg"];
                        $data["wechat_id"] = "";

                    }

                    //$log->write("openid222=".$data["openid"]."   wechat222=".$data["wechat_id"]);

                }
                $log->write("openid111=".$data["openid"]);

                $jxsession = $this->authWechatuser($data["openid"]);
                $this->customer->wechatlogin( $data["openid"]);
                //$log->write("jxssion=".$jxsession);

                return $jxsession;

            }else {

                $jxsession = "";

                return $jxsession ;
            }
        }
    }

    public function authWechatuser($openid) {

        $log = new Log('wechat.log');

        $date = date("Y-m-d h:i:sa");
        $this->load->model('wechat/userinfo');
        $customer_info = $this->model_wechat_userinfo->getCustomerByWechat($openid);

        if(!empty($customer_info["address_id"]) && !empty($customer_info["customer_id"])){

            $log->write("openid111=777777");
            $jxsession = md5($customer_info["customer_id"].$customer_info["telephone"].$date);
            $this->load->model('account/address');
            $customer_address = $this->model_account_address->getAddress($customer_info["address_id"],$customer_info["customer_id"]);
            $data = array_merge($customer_info,$customer_address);
            $this->cache->set($jxsession, json_encode($data));
        }else {
            $jxsession="";
        }

        return $jxsession;

    }

    private function getUser($accesstoken, $openid)
    {
        $get_url = sprintf(WECHAT_GETUSERINFO, $accesstoken, $openid);
        $get_return = file_get_contents($get_url);
        $get_return = (array)json_decode($get_return);
        return $get_return;
    }




}