<?php
	class sspmod_KB_BrugerbaseClient {
		
		private $baseURL;

        private $getUserPidURI = '/admin/rest/user';
		private $getUserRemoteURI = '/admin/rest/remoteuser';
		private $loginURI = '/admin/rest/login';
		private $expireURI = '/admin/rest/expire';
		private $blockedURI = '/admin/rest/blocked';
		private $resetPwdURI = '/admin/rest/resetpwd';

		public function __construct($baseURL) {
			assert(is_string($baseURL));
			
			$this->baseURL = $baseURL;
		}

        public function getUser_PID($id) {
            assert('is_string($id)');
            $url = \SimpleSAML\Utils\HTTP::addURLParameters($this->baseURL . $this->getUserPidURI,
                array('id' => $id));
            list($result, $respHeaders) = \SimpleSAML\Utils\HTTP::fetch($url,
                array('http'=>array('ignore_errors' => TRUE)), TRUE);
            if(!isset($respHeaders)) {
                // No response headers, this means the request failed in some way, so re-use old data
                SimpleSAML_Logger::error('No response from brugerbase loginservice ');
                throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');
            } elseif(preg_match('@^HTTP/1\.[01]\s200\s@', $respHeaders[0])) {
                return json_decode($result,TRUE);
            } elseif(preg_match('@^HTTP/1\.[01]\s404\s@', $respHeaders[0])) {
                return NULL;
            } else {
                SimpleSAML_Logger::error('Brugerbase login unexpected response code '.$respHeaders[0]);
                throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');
            }
        }

		public function getUser_REMOTE($attributeId,$value,$verificationAttribute = NULL) {
			assert('is_string($attributeId)');
			assert('is_string($value)');
			$url = \SimpleSAML\Utils\HTTP::addURLParameters($this->baseURL . $this->getUserRemoteURI,
				array('remoteid' => $value, 'attributeid' => $attributeId ));
			if ($verificationAttribute !== NULL) {
				$url = \SimpleSAML\Utils\HTTP::addURLParameters($url, array('verificationattribute' => $verificationAttribute));
			}
			list($result, $respHeaders) = \SimpleSAML\Utils\HTTP::fetch($url,
				array('http'=>array('ignore_errors' => TRUE)), TRUE);
			if(!isset($respHeaders)) {
				// No response headers, this means the request failed in some way, so re-use old data
				SimpleSAML_Logger::error('No response from brugerbase loginservice ');
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');
			} elseif(preg_match('@^HTTP/1\.[01]\s200\s@', $respHeaders[0])) {
				return json_decode($result,TRUE);
			} elseif(preg_match('@^HTTP/1\.[01]\s404\s@', $respHeaders[0])) {
				return NULL;
			} else {
				SimpleSAML_Logger::error('Brugerbase login unexpected response code '.$respHeaders[0]);
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');
			}
		}
		
		public function login($username,$password) {
			assert('is_string($username)');
			assert('is_string($password)');
			$url = \SimpleSAML\Utils\HTTP::addURLParameters($this->baseURL . $this->loginURI,
							array('id' => $username, 'password' => $password));
			list($result, $respHeaders) = \SimpleSAML\Utils\HTTP::fetch($url,
				array('http'=>array('ignore_errors' => TRUE)), TRUE);
			if(!isset($respHeaders)) {
				// No response headers, this means the request failed in some way, so re-use old data
                SimpleSAML_Logger::error('No response from brugerbase loginservice ');
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');		
            } elseif(preg_match('@^HTTP/1\.[01]\s200\s@', $respHeaders[0])) {
				// 200 response - login OK
				return json_decode($result,TRUE);
			} elseif(preg_match('@^HTTP/1\.[01]\s401\s@', $respHeaders[0])) {
				// 200 response - login OK
				return NULL;
			} elseif(preg_match('@^HTTP/1\.[01]\s404\s@', $respHeaders[0])) {
				// 200 response - login OK
				return NULL;
			} else {
			    SimpleSAML_Logger::error('Brugerbase login unexpected response code '.$respHeaders[0]);
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');		
		   }
        }

		public function expire($username) {
			$url = \SimpleSAML\Utils\HTTP::addURLParameters($this->baseURL . $this->expireURI,
							array('id' => $username));
			list($result,$respHeaders) =  \SimpleSAML\Utils\HTTP::fetch($url,
				array('http'=>array('ignore_errors' => TRUE)),TRUE);
			
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

		public function blocked($username) {
			$url = \SimpleSAML\Utils\HTTP::addURLParameters($this->baseURL . $this->blockedURI,
				array('id' => $username));
			list($result,$respHeaders) =  \SimpleSAML\Utils\HTTP::fetch($url,
				array('http'=>array('ignore_errors' => TRUE)),TRUE);

			if(!isset($respHeaders)) {
				// No response headers, this means the request failed in some way, so re-use old data
				SimpleSAML_Logger::error('No response from brugerbase getting expire for user '.$username);
				throw new SimpleSAML_Error_Error('BRUGERBASENOTRESPONDING');
			} elseif(preg_match('@^HTTP/1\.[01]\s200\s@', $respHeaders[0])) {
				// 200 response - login OK
				SimpleSAML_Logger::info('Brugerbase blocked response '.var_export($result,'TRUE'));
				if (strpos($result,'true') !== false) {
					return TRUE;
				}
				if (strpos($result,'false') !== false) {
					return FALSE;
				}
				SimpleSAML_Logger::error('Brugerbase blocked unexpected response '.$result);
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');
			} else {
				SimpleSAML_Logger::error('Brugerbase expire unexpected response code '.$respHeaders[0]);
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');
			}
		}

		public function resetpwd($userid,$newpass) {
			assert('is_string($userid)');
			assert('is_string($newpass)');
			$postdata = http_build_query(
				array(
					'id' => $userid,
					'password' => $newpass
				)
			);
			$context = array('http' =>
				array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
				)
			);
			$url = $this->baseURL . $this->resetPwdURI;
			list($result,$respHeaders) =  \SimpleSAML\Utils\HTTP::fetch($url,$context,TRUE);
			if(!isset($respHeaders)) {
				// No response headers, this means the request failed in some way, so re-use old data
				SimpleSAML_Logger::error('No response from brugerbase reset password for '.$userid);
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');
			} elseif(preg_match('@^HTTP/1\.[01]\s200\s@', $respHeaders[0])) {
				// 200 response - login OK
				return TRUE;
			} elseif(preg_match('@^HTTP/1\.[01]\s500\s@', $respHeaders[0])) {
				SimpleSAML_Logger::error('reset password Internal server error '.$respHeaders[0]);
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');
			} else {
				SimpleSAML_Logger::error('Brugerbase expire unexpected response code '.$respHeaders[0]);
				throw new SimpleSAML_Error_Exception('BRUGERBASENOTRESPONDING');
			}
			// we should never get here
			assert('FALSE');
		}
	}
?>