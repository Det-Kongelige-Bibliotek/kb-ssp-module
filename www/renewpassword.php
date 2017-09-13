<?php
$globalConfig = SimpleSAML_Configuration::getInstance();
$state = SimpleSAML_Auth_State::loadState($_REQUEST['StateId'], 'KB:renew-password');
$t = new SimpleSAML_XHTML_Template($globalConfig, 'KB:renewpass.php');
assert(isset($state['KB:brugerbase']));
$brugerbase = $state['KB:brugerbase'];
$loginId = $state['KB:loginId'];
try {
    if (isset($_POST['OK'])) {
        $oldpassword = $_POST['oldpassword'];
        $newpassword1 = $_POST['newpassword1'];
        $newpassword2 = $_POST['newpassword2'];
        if (strlen($newpassword1) < 8) {
            throw new SimpleSAML_Error_Error("PASSWORDTOSHORT");
        }
        if (!(preg_match('/[A-Za-z]/', $newpassword1) && preg_match('/[0-9]/', $newpassword1))) {
            throw new SimpleSAML_Error_Error("MUSTHAVELETTERSANDNUMBERS");
        }
        if ($newpassword1 !== $newpassword2) {
            throw new SimpleSAML_Error_Error("PASSWORDNOMATCH");
        }
        // The OK button was pressed
        if (!$brugerbase->login($loginId,$oldpassword)){
            throw new SimpleSAML_Error_Error("INVALIDOLDPASS");
        }
        if ($newpassword1 === $oldpassword) {
            throw new SimpleSAML_Error_Error("IDENTICALPASSWORD");
        }
        $brugerbase->resetpwd($loginId,$newpassword1);
        SimpleSAML_Auth_ProcessingChain::resumeProcessing($state);
    }
    if (isset($_POST['SKIP'])) {
        // The SKIP button was pressed
        SimpleSAML_Auth_ProcessingChain::resumeProcessing($state);
    }
} catch (SimpleSAML_Error_Error $e) {
    $t->data['errorcode'] = $e->getMessage();

}
$t->data['daysToExpire'] = $state['Attributes']['daysToExpire'];
$t->show();

?>