<?php
    $globalConfig = SimpleSAML_Configuration::getInstance();
    $state = SimpleSAML_Auth_State::loadState($_GET['stateId'], 'KB:fetchlocal');
    $state['saml:sp:State']['SimpleSAML_Auth_Source.Return'] = SimpleSAML_Module::getModuleURL('KB/nolink.php?name='.$state['KB:idpName']);
    SimpleSAML_Auth_ProcessingChain::resumeProcessing($state);

    assert('FALSE');
?>