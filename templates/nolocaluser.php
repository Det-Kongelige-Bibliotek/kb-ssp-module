<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/header.php');
$errcode = $this->data['errorcode'];
$logoutURL = $this->data['logoutUrl'];
?>
    <h2><?php echo $this->t('{KB:KB:nolocaluser_header') ?></h2>
    <p>Vi kunne ikke finde dit ID</p>
    </div>
    <a href="<?php echo $logoutURL ?>">Logout og brug et andet id</a><br>Registrer dit RUC id';
<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/footer.php');
?>