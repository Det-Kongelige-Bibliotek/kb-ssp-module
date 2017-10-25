<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/header.php');
?>
<section id="content">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="well well-lg info ">
                <div id="msg" class="alert alert-danger">
                    <h1>Fejl ved henting af brugerdata</h1>
                    <p>Dit RUC id er tilknytte flere forskellige konti</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/footer.php');
?>