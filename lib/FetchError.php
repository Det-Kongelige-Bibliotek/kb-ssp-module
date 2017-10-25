<?php
class sspmod_KB_FetchError extends SimpleSAML_Error_Exception {
    private $errcode;
    public function __construct($msg, Exception $cause = NULL) {
        assert('is_string($msg)');
        $this->errcode = $msg;
        parent::__construct($msg, -1, $cause);
    }
    
    public function errcode() {
        return $this->errcode;
    }

    public function show() {
        $config = SimpleSAML_Configuration::getInstance();
        $t = new SimpleSAML_XHTML_Template($config, 'KB:fetcherror.php');
        $t->data['errcode'] = $this->errcode;
        $t->show();
    }

}