<?php
class sspmod_KB_FetchError extends SimpleSAML_Error_Exception {
    public function __construct($msg, Exception $cause = NULL) {
        assert('is_string($status)');
        assert('is_null($subStatus) || is_string($subStatus)');
        assert('is_null($statusMessage) || is_string($statusMessage)');
        parent::__construct($msg, -1, $cause);
    }

    public function show() {
        $config = SimpleSAML_Configuration::getInstance();
        $t = new SimpleSAML_XHTML_Template($config, 'KB:fetcherror.php');
        $t->show();
    }

}