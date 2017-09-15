<?php
class sspmod_KB_Auth_Process_FetchLocalAttributes  extends SimpleSAML_Auth_ProcessingFilter{
    private $brugerbaseBaseUrl;
    private $idps;


    public function __construct($config, $reserved)
    {
        parent::__construct($config, $reserved);
        assert('is_array($config)');
        $this->idps = $config['idps'];
        assert('is_array($this->idps)');
        $this->brugerbaseBaseUrl = $config['brugerbaseBaseURL'];
        assert('$this->brugerbaseBaseUrl');
    }


    /**
     * Initialize processing of the redirect test.
     *
     * @param array &$state  The state we should update.
     */
    public function process(&$state) {
        $idp = $state['saml:sp:IdP'];
        SimpleSAML_Logger::info('idp '.$idp);
        $brugerbase = new sspmod_KB_BrugerbaseClient($this->brugerbaseBaseUrl);
        SimpleSAML_Logger::info('idps '.var_export($this->idps,TRUE));
        if (array_key_exists($idp,$this->idps )) {
            if ($this->idps[$idp]['method'] === 'PID') {
                if (!array_key_exists($this->idps[$idp]['PIDattribute'],$state['Attributes']))
                    throw new SimpleSAML_Error_Exception('CONFIGERROR');
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
                if (!array_key_exists($remoteAttribute,$state['Attributes']) ||
                    count($state['Attributes'][$remoteAttribute]) < 1)
                    throw new SimpleSAML_Error_Exception('NOREMOTEATTRIBUTE');
                $value = $state['Attributes'][$remoteAttribute][0];
                $users = $brugerbase->getUser_REMOTE($localAttribute, $value, $verificationAttribute);
                SimpleSAML_Logger::info('local users '.var_export($users,TRUE));
                if ($users == NULL) throw new SimpleSAML_ERROR_ERROR("NOLOCALUSERFOUND");
                if (count($users) > 1) throw new SimpleSAML_ERROR_ERROR("TOMANYLOCALUSERS");
                $this->setLocalAttributes($state['Attributes'], $users[0]);
            }
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
            if ($userattr['libCode'] === 'prefLang') {
                $this->addAttributeValue($attributes,'libCode',$userattr['val']);
            }
        }
        foreach($user['userAttributesesByUserId'] as $userattr) {
            if ($userattr['barcode'] === 'prefLang') {
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