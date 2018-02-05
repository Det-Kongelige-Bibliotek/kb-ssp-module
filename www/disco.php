<?php


$discoHandler = new sspmod_KB_IdPDisco(array('saml20-idp-remote', 'shib13-idp-remote'), 'saml');
$discoHandler->handleRequest();
