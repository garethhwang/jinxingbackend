<?php
class ControllerAccountAuthentication extends Controller {

    public function index() {

        $jxsession =  $this->request->json("jxsession");
        if(!empty($this->cache->get($jxsession))){
            if(strlen($this->cache->get($jxsession)) == 11){

            }
        }

    }
}