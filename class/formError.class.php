<?php

class FormError{

    private $errs;

    public function __construct()
    {
        $this->errs = array();
    }

    public function addError($msg){
        $this->errs[] = $msg;
    }

    public function listErrors(){
        return $this->errs;
    }

    public function noError(){
        if(count($this->errs) > 0){
            return false;
        }else{
            return true;
        }
    }

}

$formErr = new FormError();

?>