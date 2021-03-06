<?php
include(SimpleSAML_Module::getModuleDir('KB') . '/templates/includes/header.php');
$errcode = $this->data['errorCode'];
?>
    <section id="content">
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <div class="well well-lg info ">
                    <div id="msg" class="alert alert-danger">
                        <h2><?php echo $this->t('{KB:KB:error_header_' . $errcode . '}') ?></h2>
                        <div><?php echo $this->t('{KB:KB:error_text_' . $errcode . '}') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
include(SimpleSAML_Module::getModuleDir('KB') . '/templates/includes/footer.php');
?>