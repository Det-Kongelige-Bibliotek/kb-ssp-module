<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/header.php');
$globalConfig = SimpleSAML_Configuration::getInstance();
//$errcode = $this->data['errorcode'];
//$logoutURL = $this->data['logoutUrl'];
?>
    <section id="content">
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <div class="well well-lg info ">
                    <div id="msg" class="alert alert-success">
                        <h2><?php echo $this->t('{KB:KB:nolink_header}') ?></h2>
                        <div><?php echo $this->t('{KB:KB:nolink_text}', array('CREATEURL' => $globalConfig->getValue('brugerbase.baseurl').'/create', 'EDITURL' => $globalConfig->getValue('brugerbase.baseurl').'/edit')) ?></div>
                    </div>
                </div>
            </div>
    </section>
<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/footer.php');
?>