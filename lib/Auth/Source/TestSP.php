<?php

class sspmod_KB_Auth_Source_TestSP extends sspmod_saml_Auth_Source_SP
{

	public function startSSO($idp, array $state)
	{
		assert('is_string($idp)');

		if (strpos($idp,'birk.wayf.dk')) {
			$idp = 'http://bridge-local.kb.dk/simplesaml/saml2/idp/metadata.php';
			$state['saml:IDPList'] = array($idp);
		}

		$idpMetadata = $this->getIdPMetadata($idp);

		$type = $idpMetadata->getString('metadata-set');
		switch ($type) {
			case 'shib13-idp-remote':
				$this->startSSO1($idpMetadata, $state);
				assert('FALSE'); /* Should not return. */
			case 'saml20-idp-remote':
				$this->startSSO2($idpMetadata, $state);
				assert('FALSE'); /* Should not return. */
			default:
				/* Should only be one of the known types. */
				assert('FALSE');
		}
	}
}
