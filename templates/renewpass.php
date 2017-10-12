<?php
$this->data['header'] = $this->t('{KB:KB:renew_pass_header}', array('DAYS' => $this->data['daysToExpire']));
include(SimpleSAML_Module::getModuleDir('KB').'/templates/includes/header.php');
?>
<section id="content">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="row">

                <div class="well well-lg info ">

                    <div>
                        <div>
                                    <span class="tab active">Log Ind
                                    </span>
                        </div>

                        <p class="alert alert-danger">
                            <?php echo $this->t('{KB:KB:renew_pass_header}',array('DAYS' => $this->data['daysToExpire'])); ?>                        </p>
                        <p style="font-weight:lighter;">
                            <?php echo $this->t('{KB:KB:renew_pass_text}'); ?>
                        </p>

                        <form id="fm2" class="form-horizontal" action="?" method="post" name="f">
                            <input id="StateId" type="hidden" name="StateId" value="<?php echo $_REQUEST['StateId']?>"/>
                            <div class="form-group">
                                <label for="oldPassword" class="control-label"><?php echo $this->t('{KB:KB:oldpassword}'); ?></label>
                                <div>
                                    <input id="oldpassword" class="form-control" type="password" tabindex="1" name="oldpassword"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="newPassword" class="control-label"><?php echo $this->t('{KB:KB:newpassword1}'); ?></label>
                                <div>
                                    <input id="newpassword1" class="form-control" type="password" tabindex="2" name="newpassword1"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="newPasswordConfirm" class="control-label"><?php echo $this->t('{KB:KB:newpassword2}'); ?></label>
                                <div>
                                    <input id="newpassword2" class="form-control" type="password" tabindex="3" name="newpassword2"/>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                    <span class="">
                    <?php
                        if ($this->data['errorcode'] !== null) {
                    ?>
                            <div class="alert alert-danger">
                            <?php
                            echo htmlspecialchars($this->t(
                                '{KB:KB:error_'.$this->data['errorcode'].'}'
                            )); ?>
                                </div>
                    <?php
                        }
                    ?>
                                    </span>
                                    <span class="">
                                        <input type="submit" class="btn btn-success" tabindex="4"
                                            value="<?php echo $this->t('{KB:KB:renew_password}'); ?>" name="OK" >
                                        </input>
                                    </span>
                                    <span class="">
                                        <input type="submit" class="btn btn-danger" tabindex="4"
                                            value="<?php echo $this->t('{KB:KB:renew_skip}'); ?>" name="SKIP">
                                        </input>
                                    </span>
                            </div>
                        </form>
                        <hr/>
                        <p class="text-center">
                        </p>
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