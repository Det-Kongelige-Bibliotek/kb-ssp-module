<?php
class sspmod_KB_Auth_Source_BrugerbaseAuth extends sspmod_core_Auth_UserPassBase {
	
	private $brugerbase;
	
	 public function __construct($info, $config) {
        assert('is_array($info)');
        assert('is_array($config)');
		
        // Call the parent constructor first, as required by the interface
        parent::__construct($info, $config);
		
		$this->brugerbase = new sspmod_KB_BrugerbaseClient($config['brugerbaseBaseURL']);
	 }
 
	  public function login($username, $password) {
                assert('is_string($username)');
                assert('is_string($password)');
				
			$user = $this->brugerbase->login($username,$password);	
	        if ($user == NULL) {
				throw new SimpleSAML_Error_Error('WRONGUSERPASS');			
			}
			
			if ($this->brugerbase->expire($username) < 0) {
				throw new SimpleSAML_Error_Exception('USERPASSEXPIRED');
			}
			
			$attributes = array();
			$attributes['eduPersonPricipalName'] = array($user['userId'].'@kb.dk');
			$attributes['norEduPersonLIN'] = array($user['userId']);
			$attributes['gn'] = array($user['gn']);
			$attributes['sn'] = array($user['sn']);
			$attributes['cn'] =	array($user['gn'].' '.$user['sn']);
			
			foreach($user['userAttributesesByUserId'] as $userattr) {
				if ($userattr['attributeId'] === 'email') {
					if(!array_key_exists('mail',$attributes)) {
						$attributes['mail'] = array();
					}
					$attributes['mail'][] = $userattr['val'];
				}
			}
			return $attributes;
        }

}
?>