<?php
	class sspmod_KB_BrugerbaseClient {
		
		private $baseURL;
		
		private $loginURI = '/admin/rest/login';
		private $expireURI = '/admin/rest/expire';

		public function __construct($baseURL) {
			assert(is_string($baseURL));
			
			$this->baseURL = $baseURL;
		}
		
		public function login($username,$password) {
			$url = \SimpleSAML\Utils\HTTP::addURLParameters($this->baseURL . $this->loginURI,
							array('id' => $username, 'password' => $password));
								
			list($result,$respHeaders) =  \SimpleSAML\Utils\HTTP::fetch($url,array(),TRUE);
			if(!isset($respHeaders)) {
				// No response headers, this means the request failed in some way, so re-use old data
                SimpleSAML_Logger::error('No response from brugerbase loginservice ');
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');		
            } elseif(preg_match('@^HTTP/1\.[01]\s200\s@', $respHeaders[0])) {
                // 200 response - login OK
                return json_decode($result,TRUE);
			} elseif(preg_match('@^HTTP/1\.[01]\s401\s@', $respHeaders[0])) {
               // 401 response - invalid password
                return NULL;
			} elseif(preg_match('@^HTTP/1\.[01]\s404\s@', $respHeaders[0])) {
               // 404 response - invalid password
                return NULL;	
           } else {
			    SimpleSAML_Logger::error('Brugerbase login unexpected response code '.$respHeaders[0]);
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');		
		   }
        }

		public function expire($username) {
			$url = \SimpleSAML\Utils\HTTP::addURLParameters($this->baseURL . $this->expireURI,
							array('id' => $username));
			list($result,$respHeaders) =  \SimpleSAML\Utils\HTTP::fetch($url,array(),TRUE);
			
			if(!isset($respHeaders)) {
				// No response headers, this means the request failed in some way, so re-use old data
                SimpleSAML_Logger::error('No response from brugerbase getting expire for user '.$username);
				throw new SimpleSAML_Error_Error('BRUGERBASENOTRESPONDING');		
			} elseif(preg_match('@^HTTP/1\.[01]\s200\s@', $respHeaders[0])) {
                // 200 response - login OK
				if (is_numeric($result)) 
					return intval($result);
				SimpleSAML_Logger::error('Brugerbase expire not a number '.$result);
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');		
			} else {
			    SimpleSAML_Logger::error('Brugerbase expire unexpected response code '.$respHeaders[0]);
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');		
		   }
		}
		
	}

?>