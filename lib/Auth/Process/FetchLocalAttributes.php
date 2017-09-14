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
                SimpleSAML_Logger::info('idp config '.var_export($this->idps[$idp],TRUE));
                if (!array_key_exists($this->idps[$idp]['PIDattribute'],$state['Attributes']))
                    throw new SimpleSAML_Error_Exception('CONFIGERROR');
                SimpleSAML_Logger::info('PID attribute '.$this->idps[$idp]['PIDattribute']);
                $pid = $state['Attributes'][$this->idps[$idp]['PIDattribute']][0];

                SimpleSAML_Logger::info("fetching brugerbase user ".$pid);
                $user = $brugerbase->getUser_PID($pid);
                SimpleSAML_Logger::info("got user ".var_export($user,TRUE));
                if ($user != NULL) {
                    $this->setLocalAttributes($state['Attributes'], $user);
                }
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