<?php
class ControllerAccountAuthentication extends Controller {

    public function index()
    {

        $jxsession = $this->request->json("jxsession");
        $code = $this->request->json("code");
        $date = date("Ymd");

        if (empty($this->cache->get($jxsession))) {
            if (!empty($code)) {

                if ($this->cache->get($code)) {
                    $codeinfo = $this->cache->get($code);
                    $codeinfo=json_decode($codeinfo,true);
                    $data["openid"] = $codeinfo["openid"];
                    $data["wechat_id"] = $codeinfo["wechat_id"];

                }else {

                    $get_url = sprintf(WECHAT_USERTOKEN, AppID, AppSecret, $code);
                    $get_return = file_get_contents($get_url);
                    $get_return = (array)json_decode($get_return);
                    $data["openid"] = $get_return["openid"];
                    $this->load->model('wechat/userinfo');
                    if (isset($get_return["openid"])) {

                        $wechatid = $this->model_wechat_userinfo->isUserValid($get_return["openid"]);
                        if (isset($wechatid)) {
                            $data["wechat_id"] = $wechatid;

                        } else {
                            $wechatinfo = $this->getUser($get_return["access_token"], $get_return["openid"]);
                            $data["wechat_id"] = $this->model_wechat_userinfo->addWechatUser($wechatinfo);
                        }
                        $this->cache->set($code, json_encode(array('openid' => $get_return["openid"], 'wechat_id' => $data["wechat_id"])));

                    } else {
                        $this->error["error_warning"] = $get_return["errmsg"];
                        $data["wechat_id"] = "";
                    }

                }

                $jxsession = $this->authWechat($data["openid"]);

                return $jxsession;

            }else {

                return 0;
            }
        } else {

            return $jxsession;
        }
    }

    public function authWechat($openid) {

        $date = date("Ymd");
        $jxsession = md5($openid.$date);
        $this->load->model('wechat/userinfo');
        $customer_info = $this->model_wechat_userinfo->getCustomerByWechat($openid);
        $this->load->model('account/address');
        $customer_address = $this->model_account_address->getAddress($customer_info["address_id"],$customer_info["customer_id"]);
        $data = array_merge($customer_info,$customer_address);
        $this->cache->set($jxsession, json_encode($data));
        return $jxsession;

    }

    public function Wechat() {

        $log = new Log('wechat.log');
        $log ->write("asdasdasdasdasd") ;

        return 1234;

    }

    private function getUser($accesstoken, $openid)
    {
        $get_url = sprintf(WECHAT_GETUSERINFO, $accesstoken, $openid);
        $get_return = file_get_contents($get_url);
        $get_return = (array)json_decode($get_return);
        return $get_return;
    }


}