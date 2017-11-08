<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/header.php');
$globalConfig = SimpleSAML_Configuration::getInstance();
?>
<section id="content">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="well well-lg info ">
                <div id="msg" class="alert alert-success">
                    <p><b>Du er nu logget ud</b>. For at beskytte dine personlige oplysninger, skal du lukke alle browservinduer, inden du forlader computeren.</p>
                    <p>Hvis du ikke viderestilles inden for nogle få sekunder, klik <a href="<?php echo $globalConfig->getValue('pds.baseurl')?>?func=logout&calling_system=primo&url=https://rex.kb.dk:443/primo-explore/search?vid=NUI&performLogout=true">her for at komme retur til REX</a> </p>

                    <iframe style="display:none;" src="<?php echo $globalConfig->getValue('brugerbase.baseurl') ?>/logout" sandbox=""></iframe>
                    <iframe style="display:none;" src="<?php echo $globalConfig->getValue('rex.baseurl') ?>/userServices/menu/Logout" sandbox="" ></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/footer.php');
?>
