<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/header.php');
$errcode = $this->data['errorcode'];
?>
<h2><?php echo $this->t('{KB:KB:loginerror_header_'.$errcode.'}') ?></h2>
<div><?php echo $this->t('{KB:KB:loginerror_text_'.$errcode.'}',array(RECOVERYURL => $this->data['recoveryUrl'])) ?></div>
<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/footer.php');
?>