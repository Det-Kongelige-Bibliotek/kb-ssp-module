<?php
    $globalConfig = SimpleSAML_Configuration::getInstance();
    $t = new SimpleSAML_XHTML_Template($globalConfig, 'KB:loginerror.php');
    $t->data['recoveryUrl'] = $globalConfig['brugerbase.baseurl'].'/user/recovery';
    $t->data['errorcode'] = $_GET['errorcode'];
    $t->show();
?>