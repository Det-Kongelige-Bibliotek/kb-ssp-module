<?php
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Log ind - Det Kgl. Bibliotek</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- REX Bootstrap 3.0 .css -->
    <!--link href="https://rex.kb.dk/primo_library/libweb/sites/kb/KGL/css/bootstrap.css" rel="stylesheet"-->
    <link type="text/css" rel="stylesheet" href=<?php echo SimpleSAML_Module::getModuleURL('KB/css/bootstrap.css'); ?> />
    <link type="text/css" rel="stylesheet" href="<?php echo SimpleSAML_Module::getModuleURL('KB/css/font-awesome.min.css'); ?>" />

    <link type="text/css" rel="stylesheet" href="<?php echo SimpleSAML_Module::getModuleURL('KB/css/newStyle.css'); ?>" />
    <link rel="icon" href="<?php echo SimpleSAML_Module::getModuleURL('KB/images/responsive/favicon.png'); ?>" type="image/png" />

    <!-- REX Jquery .js -->
    <script src="https://rex.kb.dk/primo_library/libweb/javascript/jquery/jquery-1.8.3.min.js"></script>

    <!-- REX Bootstrap 3.0 .js -->
    <script type="text/javascript" src="https://rex.kb.dk/primo_library/libweb/sites/kb/KGL/javascript/bootstrap/alert.js"></script>
    <script type="text/javascript" src="https://rex.kb.dk/primo_library/libweb/sites/kb/KGL/javascript/bootstrap/collapse.js"></script>
    <script type="text/javascript" src="https://rex.kb.dk/primo_library/libweb/sites/kb/KGL/javascript/bootstrap/dropdown.js"></script>


    <!--[if lt IE 9]>
        <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script  src="/cas/js/respond-min.js"></script>
    <![endif]-->
    <style type="text/css">
        .info{
            background:#38555f;
            color:#FFF;
        }
        .info a{

        }
    </style>


</head>
<body onload='setFocusToTextBox()'>


<div id="header-navbar" class="navbar navbar-default navbar-static-top navbar-inverse" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand hidden-xs hidden-sm" href='http://www.kb.dk/da' title="Det Kgl. Bibliotek">
                <!--img src='images/responsive/da/logo.png' height="48" alt="Det Kgl. Bibliotek"-->
                <img src="<?php echo SimpleSAML_Module::getModuleURL('KB/images/responsive/logo_inverse.png'); ?>" height="50px" alt="Det Kgl. Bibliotek">

            </a>
            <a class="navbar-brand visible-xs visible-sm" href='http://www.kb.dk/da' title="Det Kgl. Bibliotek">
                <img src="<?php echo SimpleSAML_Module::getModuleURL('KB/images/responsive/logo.png'); ?>" height="24" alt="Det Kgl. Bibliotek">
            </a>
        </div>

       <!-- en_US -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php
                            $languages = $this->getLanguageList();
                            if ( count($languages) > 1 ) {
                                echo '<div id="languagebar">';
                                $langnames = array(
                                    'da' => 'Dansk',
                                    'en' => 'English',
                                );
                                $textarray = array();
                                foreach ($languages AS $lang => $current) {
                                    $lang = strtolower($lang);
                                    if ($current) {
                                        $textarray[] = $langnames[$lang];
                                    } else {
                                        $textarray[] = '<a href="' . htmlspecialchars(\SimpleSAML\Utils\HTTP::addURLParameters(\SimpleSAML\Utils\HTTP::getSelfURL(), array($this->getTranslator()->getLanguage()->getLanguageParameterName() => $lang))) . '">' .
                                            $langnames[$lang] . '</a>';
                                    }
                                }
                                echo join(' | ', $textarray);
                            }
                        ?>
                    </li>
            </ul>
        </div>
    </div>
</div>

