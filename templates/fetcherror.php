<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/header.php');
$errcode = $this->data['errcode'];
?>
<section id="content">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="well well-lg info ">
                <div id="msg" class="alert alert-danger">
                    <h1><?php echo $this->t('{KB:KB:fetcherror_header_' . $errcode . '}') ?></h1>
                    <div><?php echo $this->t('{KB:KB:fetcherror_text_' . $errcode . '}') ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/footer.php');
?>