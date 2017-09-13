<?php
	class sspmod_KB_Auth_Process_ExpireWarn  extends SimpleSAML_Auth_ProcessingFilter {

		private $brugerbaseBaseUrl;
		private $PIDattribute;

		public function __construct($config, $reserved)
		{
			parent::__construct($config, $reserved);
			assert('is_array($config)');
			$this->brugerbaseBaseUrl = $config['brugerbaseBaseURL'];
			$this->PIDattribute = $config['PIDattribute'];
		}


			/**
         * Initialize processing of the redirect test.
         *
         * @param array &$state  The state we should update.
         */
        public function process(&$state) {

			assert(is_array($state['Attributes']));
			if (!array_key_exists($this->PIDattribute, $state['Attributes'])
				&& !is_array($state['Attributes'][$this->PIDattribute])
				&& (count($state['Attributes'][$this->PIDattribute]) < 1))
				throw new SimpleSAML_Error_Exception('The PID attributes '.$this->PIDattribute.' does not exist or has no value');

			$brugerbase = new sspmod_KB_BrugerbaseClient($this->brugerbaseBaseUrl);
			$expire = $brugerbase->expire($state['Attributes'][$this->PIDattribute][0]);
			if ($expire < 30) {
				$state['Attributes']['daysToExpire'] = $expire;
				$state['KB:brugerbase'] = $brugerbase;
				$state['KB:PID'] = $state['Attributes'][$this->PIDattribute][0];
				$state['KB:loginId'] = $state['Attributes']['loginId'][0];
				$id = SimpleSAML_Auth_State::saveState($state, 'KB:renew-password');
				$url = SimpleSAML_Module::getModuleURL('KB/renewpassword.php');
				\SimpleSAML\Utils\HTTP::redirectTrustedURL($url, array('StateId' => $id));
			}
		}
	}
?>