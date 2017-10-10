<?php
    $globalConfig = SimpleSAML_Configuration::getInstance();
    if ($_GET['errorcode'] === 'NOLOCALUSER')
        $t = new SimpleSAML_XHTML_Template($globalConfig, 'KB:nolocaluser.php');
    else
        $t = new SimpleSAML_XHTML_Template($globalConfig, 'KB:linkerror.php');
    $t->data['recoveryUrl'] = 'http://kub-postgres-dev-01.kb.dk:8080/user/recovery';
    $t->data['errorcode'] = $_GET['errorcode'];
    $t->data['logoutUrl'] = \SimpleSAML\Utils\HTTP::addURLParameters(
        SimpleSAML_Module::getModuleURL('KB/logout.php'),
        array('stateId' => $_GET['stateId'])
    );
    $t->show();
?>