<?php
if (!array_key_exists('header', $this->data)) {
    $this->data['header'] = '{KB:KB:selectidp}';
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
        <div class="col-md-12">
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
                                echo $this->t('{KB:KB:selectidp_full}');
                                if ($this->data['rememberenabled']) {
                                    echo '<br /><input type="checkbox" name="remember" value="1" title="' . $this->t('{KB:KB:remember}') . '" />' .
                                        $this->t('{KB:KB:remember}');
                                }
                                ?></p>
                            <?php

                            echo '<div class="row">';
                            foreach ($this->data['idplist'] as $idpentry) {
				                if (array_key_exists('new.row',$idpentry) && $idpentry['new.row'] === TRUE) {
					                echo '</div>';
				                    echo '<div class="row">';
				                }
				                if (array_key_exists('div.class',$idpentry) && $idpentry['div.class'] !== '') {
					                $divclass = $idpentry['div.class'];
				                } else {
					                $divclass = 'col-sm-8';
				                }
                                 $iconUrl = null;
                                 if ($this->getLanguage() === 'en') {
                                     if (array_key_exists('icon_en', $idpentry) && $idpentry['icon_en'] !== null) {
                                         $iconUrl = SimpleSAML_Module::getModuleURL($idpentry['icon_en']);
                                     }
                                 }
                                 if ($iconUrl === null) {
                                     if (array_key_exists('icon', $idpentry) && $idpentry['icon'] !== null) {
                                         $iconUrl = SimpleSAML_Module::getModuleURL($idpentry['icon']);
                                     }
                                 }

                                    if (!array_key_exists('copy.of',$idpentry)) {
                                        echo '<div class="'.$divclass.'"><button type="submit" class="btn  btn-wizard" name="idp_' . htmlspecialchars($idpentry['entityid']) . '">';
                                        if ($iconUrl !== null) {
                                            echo '<img class="idp-logo" src="' . $iconUrl . '">';
                                        }
                                        echo '<strong>' . $this->t('idpname_' . $idpentry['entityid']) . '</strong>';
                                        if (!empty($idpentry['description'])) {
                                            echo '	<small>' . htmlspecialchars($this->t('idpdesc_' . $idpentry['entityid'])) . '</small>';
                                        }
                                        echo '</button></div>';
                                    } else {
                                        $copyIdp = $this->data['idplist'][$idpentry['copy.of']];
                                        echo '<div class="'.$divclass.'"><button type="submit" class="btn  btn-wizard" name="idp_' . htmlspecialchars($copyIdp['entityid']) . '">';
                                        if ($iconUrl !== null) {
                                            echo '<img class="idp-logo" src="' . $iconUrl . '">';
                                        }
                                        echo '<strong>' . $this->t('idpname_' . $idpentry['entityid']) . '</strong>';
                                        if (!empty($idpentry['description'])) {
                                            echo '	<small>' . htmlspecialchars($this->t('idpdesc_' . $idpentry['entityid'])) . '</small>';
                                        }
                                        echo '</button></div>';
                                    }
                            }
			                echo '</div>';
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
