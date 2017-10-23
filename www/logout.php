<?php

if (!array_key_exists('stateId', $_GET)) {
    throw new SimpleSAML_Error_BadRequest('Missing required stateId query parameter.');
}
$state = SimpleSAML_Auth_State::loadState($_GET['stateId'], 'KB:fetchlocal');
$state['saml:sp:State']['SimpleSAML_Auth_Source.Return'] = 'http://rex-test.kb.dk';
SimpleSAML_Auth_ProcessingChain::resumeProcessing($state);

assert('FALSE');
