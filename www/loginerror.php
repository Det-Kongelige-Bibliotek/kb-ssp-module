<?php
    $globalConfig = SimpleSAML_Configuration::getInstance();
    $t = new SimpleSAML_XHTML_Template($globalConfig, 'KB:loginerror.php');
    $t->data['recoveryUrl'] = 'http://kub-postgres-dev-01.kb.dk:8080/user/recovery';
    $t->data['errorcode'] = $_GET['errorcode'];
    $t->show();
?>