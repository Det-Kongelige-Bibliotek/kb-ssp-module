<?php

if (!array_key_exists('header', $this->data)) {
    $this->data['header'] = 'selectidp';
}
$this->data['header'] = $this->t($this->data['header']);
$this->data['autofocus'] = 'preferredidp';
include(SimpleSAML_Module::getModuleDir('KB') . '/templates/includes/header.php');
foreach ($this->data['idplist'] as $idpentry) {
    if (isset($idpentry['name'])) {
        $this->includeInlineTranslation('idpname_' . $idpentry['entityid'], $idpentry['name']);
    } elseif (isset($idpentry['OrganizationDisplayName'])) {
        $this->includeInlineTranslation('idpname_' . $idpentry['entityid'], $idpentry['OrganizationDisplayName']);
    }
    if (isset($idpentry['description'])) {
        $this->includeInlineTranslation('idpdesc_' . $idpentry['entityid'], $idpentry['description']);
    }
}
?>
<section id="content">
    <div class="container">
        <div class="col-md-6 col-md-offset-3">
            <div class="row">
                <div class="well well-lg info ">
                    <div>
                        <span class="tab active">
                            <?php echo $this->data['header']; ?>
                            </span>
                    </div>
                    <div>
                        <form method="get" action="<?php echo $this->data['urlpattern']; ?>">
                            <input type="hidden" name="entityID"
                                   value="<?php echo htmlspecialchars($this->data['entityID']); ?>"/>
                            <input type="hidden" name="return"
                                   value="<?php echo htmlspecialchars($this->data['return']); ?>"/>
                            <input type="hidden" name="returnIDParam"
                                   value="<?php echo htmlspecialchars($this->data['returnIDParam']); ?>"/>
                            <p><?php
                                echo $this->t('selectidp_full');
                                if ($this->data['rememberenabled']) {
                                    echo '<br /><input type="checkbox" name="remember" value="1" title="' . $this->t('remember') . '" />' .
                                        $this->t('remember');
                                }
                                ?></p>
                            <?php


                            foreach ($this->data['idplist'] as $idpentry) {
                                    if (array_key_exists('icon', $idpentry) && $idpentry['icon'] !== null) {
                                        $iconUrl = \SimpleSAML\Utils\HTTP::resolveURL($idpentry['icon']);
                                        echo '<img class="float-l" style="clear: both; margin: 1em; padding: 3px; border: 1px solid #999"' .
                                            ' src="' . htmlspecialchars($iconUrl) . '" />';
                                    }

                                    echo '<button type="submit" class="btn btn-success" name="idp_' . htmlspecialchars($idpentry['entityid']) . '">';
                                    echo '<h3 style="margin-top: 8px">' . htmlspecialchars($this->t('idpname_' . $idpentry['entityid'])) . '</h3>';
                                    if (!empty($idpentry['description'])) {
                                        echo '	<p>' . htmlspecialchars($this->t('idpdesc_' . $idpentry['entityid'])) . '</p>';
                                    }
                                    echo '</button>';
                                
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>