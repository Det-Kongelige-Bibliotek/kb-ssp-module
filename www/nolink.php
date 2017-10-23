<?php
    $config = SimpleSAML_Configuration::getInstance();

    $as = new SimpleSAML_Auth_Simple('default-sp');
    $as->logout(SimpleSAML_Module::getModuleURL('KB/nolink2.php'));



?>