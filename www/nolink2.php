<?php
$globalConfig = SimpleSAML_Configuration::getInstance();

$t = new SimpleSAML_XHTML_Template($globalConfig, 'KB:nolink.php');
$t->data['name'] = $_GET['name'];
$t->show();