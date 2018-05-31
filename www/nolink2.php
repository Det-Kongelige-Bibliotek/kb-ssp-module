<?php
$globalConfig = SimpleSAML_Configuration::getInstance();
\SimpleSAML\Utils\HTTP::setCookie('idpdisco_saml_remember', '0', array(
    'lifetime' => (60 * 60 * 24 * 90),
    'path'     => '/simplesaml/',
    'httponly' => false,
), false);
$t = new SimpleSAML_XHTML_Template($globalConfig, 'KB:nolink.php');
$t->data['name'] = $_GET['name'];
$t->show();