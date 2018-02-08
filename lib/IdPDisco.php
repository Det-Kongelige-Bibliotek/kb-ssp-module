<?php



class sspmod_KB_IdPDisco extends SimpleSAML_XHTML_IdPDisco
{

    /**
     *
     */
    protected function getSavedIdP()
    {
        $prevIdP = null;

        if (!$this->config->getBoolean('idpdisco.enableremember', false)) {
            // saving of IdP choices is disabled
            return null;
        }

        if ($this->getCookie('remember') === '1' || $this-isPassive) {
            $this->log('Return previously saved IdP because of remember cookie set to 1 or because of isPassive');
            $prevIdP =  $this->getPreviousIdP();
        }

	    $IDPList = $this->getScopedIDPList();
        if (!empty($IDPList) && !array_key_exists($prevIdP,$IDPList)) {
            $this->log('Previously saved IdP is not ind scoped IDPList');
            return null;
	    }

        return $prevIdP;
    }

}
