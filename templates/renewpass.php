<?php
$this->data['header'] = $this->t('{KB:KB:renew_pass_header}', array('DAYS' => $this->data['daysToExpire']));
$this->includeAtTemplateBase('includes/header.php');
?>

<?php
if ($this->data['errorcode'] !== null) {
    ?>
    <div style="border-left: 1px solid #e8e8e8; border-bottom: 1px solid #e8e8e8; background: #f5f5f5">
        <img src="/<?php echo $this->data['baseurlpath']; ?>resources/icons/experience/gtk-dialog-error.48x48.png"
             class="float-l erroricon" style="margin: 15px" alt=""/>

        <h2><?php echo $this->t('{KB:KB:renew_error_header}'); ?></h2>
        
        <p><?php
            echo htmlspecialchars($this->t(
                '{KB:KB:error_'.$this->data['errorcode'].'}'
            )); ?></p>
    </div>
<?php
}

?>
    <h2 style="break: both"><?php echo $this->t('{KB:KB:renew_pass_header}',array('DAYS' => $this->data['daysToExpire'])); ?></h2>

    <p class="renewtext"><?php echo $this->t('{KB:KB:renew_pass_text}'); ?></p>

    <form action="?" method="post" name="f">
        <table>
            <tr>
                <td><label for="oldpassword"><?php echo $this->t('{KB:KB:oldpassword}'); ?></label></td>
                <td>
                    <input id="oldpassword" type="password" tabindex="1" name="oldpassword"/>
                </td>
            </tr>
            <tr>
                <td><label for="newpassword1"><?php echo $this->t('{KB:KB:newpassword1}'); ?></label></td>
                <td>
                    <input id="newpassword1" type="password" tabindex="2" name="newpassword1"/>
                </td>
            </tr>
            <tr>
                <td><label for="newpassword2"><?php echo $this->t('{KB:KB:newpassword2}'); ?></label></td>
                <td>
                    <input id="newpassword2" type="password" tabindex="3" name="newpassword2"/>
                </td>
            </tr>
            <input id="StateId" type="hidden" name="StateId" value="<?php echo $_REQUEST['StateId']?>"/>
            <tr id="submit"><td>
                    <input type="submit" class="btn" tabindex="4"
                        value="<?php echo $this->t('{KB:KB:renew_password}'); ?>" name="OK" >
                    </input>
                    <input type="submit" class="btn" tabindex="4"
                        value="<?php echo $this->t('{KB:KB:renew_skip}'); ?>" name="SKIP">
                    </input>
                </td>
            </tr>
        </table>
        <?php
        ?>
    </form>
<?php
$this->includeAtTemplateBase('includes/footer.php');
?>
