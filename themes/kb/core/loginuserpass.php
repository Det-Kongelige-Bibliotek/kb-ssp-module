<?php
$globalConfig = SimpleSAML_Configuration::getInstance();
$this->data['header'] = $this->t('{login:user_pass_header}');

if (strlen($this->data['username']) > 0) {
$this->data['autofocus'] = 'password';
} else {
$this->data['autofocus'] = 'username';
}
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/header.php');
?>
<section id="content">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="row">
                <div class="well well-lg info ">
                    <div>
                        <span class="tab active">
                            Log ind
                        </span>
                        <a href='<?php echo $globalConfig["brugerbase.baseurl"] ?>/user/create?locale=da'>
                            <span class="tab">
                                Ny l&aring;ner
                            </span>
                        </a>
                    </div>
                    <div >
                        <form action="?" class="form-horizontal" method="post" name="f">
                            <div class="form-group">
                                <div >
                                    <label for="username" class="control-label"><?php echo $this->t('{login:username}'); ?></label>
                                </div>
                                <div >
                                    <input id="username" name="username" class="form-control" tabindex="1" placeholde="CPR eller L&Atilde;&yen;ner nr" required="required" type="password" value="<?php echo htmlspecialchars($this->data['username']); ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div >
                                    <label for="password" class="control-label">Adgangskode</label>
                                </div>
                                <div >
                                    <input id="password" name="password" class="form-control" tabindex="1" placeholde="Adgangskode" required="required" type="password" <?php echo $this->t('{login:password}'); ?>/>
                                </div>
                            </div>
                            <?php
                            foreach ($this->data['stateparams'] as $name => $value) {
                                echo('<input type="hidden" name="'.htmlspecialchars($name).'" value="'.htmlspecialchars($value).'" />');
                            }
                            ?>
                            <div class="form-group">
                                <div class="row text-center">
                                    <?php
                                    if ($this->data['errorcode'] !== null) {
                                    ?>
                                    <div id="msg" class="alert alert-danger">
                                        <p><strong><?php
                                                echo htmlspecialchars($this->t(
                                                    '{errors:title_'.$this->data['errorcode'].'}',
                                                    $this->data['errorparams']
                                                )); ?></strong></p>

                                        <p><?php
                                            echo htmlspecialchars($this->t(
                                                '{errors:descr_'.$this->data['errorcode'].'}',
                                                $this->data['errorparams']
                                            )); ?></p>
                                    </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row text-center submit">
                                    <input name="submit" type="submit" class="btn btn-success"  value="<?php echo $this->t('{login:login_button}'); ?>" />
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <div class="text-center">
                                    <a href='<?php echo $globalConfig["brugerbase.baseurl"] ?>/user/recovery?locale=da_DK' style="color:#FFF;">Har du glemt din adgangskode?</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
    </div>
</section>


<?php
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/footer.php');
?>
