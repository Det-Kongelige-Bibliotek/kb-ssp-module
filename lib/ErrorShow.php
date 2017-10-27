<?php
class sspmod_KB_ErrorShow {

    public static function show($config=null, $data=null) {
        if (in_array($data['errorCode'],array("CONFIGERROR","REMOTEATTRNOVALUE","TOOMANYUSERS"))) {
            $t = new SimpleSAML_XHTML_Template($config, 'KB:error.php');
            $t->data = array_merge($t->data, $data);
            $t->show();
        } else {
            $t = new SimpleSAML_XHTML_Template($config, 'error.php', 'errors');
            $t->data = array_merge($t->data, $data);
            $t->show();
        }

    }
}
