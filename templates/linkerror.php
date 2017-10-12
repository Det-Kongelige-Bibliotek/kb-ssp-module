<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/header.php');
$errcode = $this->data['errorcode'];
$logoutURL = $this->data['logoutUrl'];
?>
    <h2><?php echo $this->t('{KB:KB:linkerror_header_'.$errcode.'}') ?></h2>
    <p><?php echo $this->t('{KB:KB:linkerror_text_'.$errcode.'}') ?></p>
</div>
<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/footer.php');
?>