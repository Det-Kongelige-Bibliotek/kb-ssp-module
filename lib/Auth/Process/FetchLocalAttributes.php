<?php
class sspmod_KB_Auth_Process_FetchLocalAttributes  extends SimpleSAML_Auth_ProcessingFilter{
    private $brugerbaseBaseUrl;
    private $idps;
    private $skip_for;

    public function __construct($config, $reserved)
    {
        parent::__construct($config, $reserved);
        assert('is_array($config)');
        $this->idps = $config['idps'];
        assert('is_array($this->idps)');
        $this->brugerbaseBaseUrl = $config['brugerbaseBaseURL'];
        assert('$this->brugerbaseBaseUrl');
        if (array_key_exists('skip.for',$config)) {
            assert('is_array($config["skip.for"])');
            $this->skip_for = $config['skip.for'];
        } else {
            $this->skip_for = array();
        }
    }


    /**
     * Initialize processing of the redirect test.
     *
     * @param array &$state  The state we should update.
     */
    public function process(&$state) {
        $idp = $state['saml:sp:IdP'];
        if (array_key_exists('core:SP',$state['saml:sp:State']) && in_array($state['saml:sp:State']['core:SP'],$this->skip_for)) {
            return;
        }
        $brugerbase = new sspmod_KB_BrugerbaseClient($this->brugerbaseBaseUrl);
        if (array_key_exists($idp,$this->idps )) {
            $state['Attributes']['remoteInstitution'] = array($this->idps[$idp]['name']);
            if ($this->idps[$idp]['method'] === 'PID') {
                if (!array_key_exists($this->idps[$idp]['PIDattribute'],$state['Attributes'])) {
                    SimpleSAML_Logger::error("PID attribute does not exist ".var_dump($state['Attributes'],true));
                    throw new SimpleSAML_Error_Error('CONFIGERROR');
                }
                $pid = $state['Attributes'][$this->idps[$idp]['PIDattribute']][0];

                $user = $brugerbase->getUser_PID($pid);
                if ($user != NULL) {
                    $this->setLocalAttributes($state['Attributes'], $user);
                }
            }
            if ($this->idps[$idp]['method'] === 'ATTRIBUTE') {
                $remoteAttribute = $this->idps[$idp]['remoteAttribute'];
                $localAttribute = $this->idps[$idp]['localAttribute'];
                $verificationAttribute = $this->idps[$idp]['verificationAttribute'];
                assert('is_string($remoteAttribute)');
                assert('is_string($localAttribute)');
                assert('is_string($verificationAttribute)');
                SimpleSAML_Logger::debug("remote attribute is "+$remoteAttribute);
                if (!array_key_exists($remoteAttribute,$state['Attributes']) ||
                    count($state['Attributes'][$remoteAttribute]) < 1) {
                    SimpleSAML_Logger::error("Remote attribute "+$remoteAttribute+" has no value");
                    throw new SimpleSAML_Error_Error("REMOTEATTRNOVALUE");
                }
                $value = $state['Attributes'][$remoteAttribute][0];
                if ($this->idps[$idp]['removeScope']) {
                    $value = strstr($value,'@',TRUE);
                }
                $users = $brugerbase->getUser_REMOTE($localAttribute, $value, $verificationAttribute);
                SimpleSAML_Logger::info('local users '.var_export($users,TRUE));
                if ($users == NULL) {
                    $state['KB:remoteID'] = $value;
                    $state['KB:idpName'] = $this->idps[$idp]['name'];
                    $stateId  = SimpleSAML_Auth_State::saveState($state, 'KB:fetchlocal');
                    \SimpleSAML\Utils\HTTP::redirectTrustedURL(
                        \SimpleSAML\Utils\HTTP::addURLParameters(
                            SimpleSAML_Module::getModuleURL('KB/linkerror.php'),
                            array('errorcode' => 'NOLOCALUSER', 'stateId' => $stateId)
                        )
                    );
                }
                if (count($users) > 1) {
                    SimpleSAML_Logger::error("To many users found for "+$value);
                    throw new SimpleSAML_Error_Error("TOMANYLOCALUSERS");
                }
                $this->setLocalAttributes($state['Attributes'], $users[0]);
            }
            if ($this->idps[$idp]['method'] === 'REGIONH') {
                $state['Attributes']['loginID'] = Array('CUH-'.$state['saml:sp:NameID']->value);
                $kbadgang = $state['Attributes']['http://schemas.microsoft.com/ws/2008/06/identity/claims/role'][0];
                if ($kbadgang === 'JA') {
                    $state['Attributes']['oid'] = Array('1.3.6.1.4.1.11356.2.3.17');
                }
                // this attribute causes problems for the cas server
                unset($state['Attributes']['http://schemas.microsoft.com/ws/2008/06/identity/claims/role']);
            }
            if ($this->idps[$idp]['method'] === 'SKIP') {

            }
        } else {
            SimpleSAML_Logger::error("Fetch attributes not configured for "+$idp);
            throw new SimpleSAML_Error_Error("CONFIGERROR");
        }
    }

    private function setLocalAttributes(&$attributes,$user) {
        $this->addAttributeValue($attributes,'PID',$user['userId']);
        $this->addAttributeValue($attributes,'loginID',$user['loginId']);
        $this->addAttributeValue($attributes,'gn',$user['gn']);
        $this->addAttributeValue($attributes,'sn',$user['sn']);
        foreach($user['userAttributesesByUserId'] as $userattr) {
            if ($userattr['attributeId'] === 'email') {
                $this->addAttributeValue($attributes,'email',$userattr['val']);
            }
        }
        foreach($user['userAttributesesByUserId'] as $userattr) {
            if ($userattr['attributeId'] === 'oid') {
                $this->addAttributeValue($attributes,'oid',$userattr['val']);
            }
        }
        foreach($user['userAttributesesByUserId'] as $userattr) {
            if ($userattr['attributeId'] === 'prefLang') {
                $this->addAttributeValue($attributes,'prefLang',$userattr['val']);
            }
        }
        foreach($user['userAttributesesByUserId'] as $userattr) {
            if ($userattr['attributeId'] === 'type') {
                $this->addAttributeValue($attributes,'type',$userattr['val']);
            }
        }
        foreach($user['userAttributesesByUserId'] as $userattr) {
            if ($userattr['attributeId'] === 'subType') {
                $this->addAttributeValue($attributes,'subType',$userattr['val']);
            }
        }
        foreach($user['userAttributesesByUserId'] as $userattr) {
            if ($userattr['attributeId'] === 'libCode') {
                $this->addAttributeValue($attributes,'libCode',$userattr['val']);
            }
        }
        foreach($user['userAttributesesByUserId'] as $userattr) {
            if ($userattr['attributeId'] === 'barcode') {
                $this->addAttributeValue($attributes,'barcode',$userattr['val']);
            }
        }
    }

    private function addAttributeValue(&$attributes,$attrname,$value) {
        if (!array_key_exists($attrname,$attributes )) {
            $attributes[$attrname] = array();
        }
        $attributes[$attrname][] = $value;
    }
}
?>
