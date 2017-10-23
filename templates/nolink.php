<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/header.php');
$errcode = $this->data['errorcode'];
$logoutURL = $this->data['logoutUrl'];
?>
    <h2>Vi kunne ikke finde dit RUC id</h2>
    <div><p>
        Hvis du ikke er registreret som låner ved Det Kgl. Bibliotek kan du <a href="https://user-stage.kb.dk/user/create"> Registrere dig som bruger her </a> Husk at vælge studerede ved RUC og angive dit RUC-id
            </p><p>
        Hvis du allerede er registrerest som låner kan du tilføje dit RUC id på <a href="https://user-stage.kb.dk/user/edit">https://user-stage.kb.dk/user/edit</a>
        </p>
    </div>
<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/footer.php');
?>