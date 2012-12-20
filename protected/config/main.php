<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
    'basePath'          => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'              => 'Fad cms',
    'defaultController' => 'page/default/show',
    #'homeLink'         => '/',
    'sourceLanguage'    => 'en',
    'language'          => 'ru',
    // preloading 'log' component
    'preload'           => array('log', 'bootstrap'),
    // autoloading model and component classes
    'import'            => array(
        'application.components.*',
        'application.modules.user.models.*',
        'application.modules.menu.models.*',
    ),
    'modules'           => array('user', 'menu', 'page', 'news', 'contact', 'gallery', 'blog', 'social', 'comment', 'sitemap', 'admin', 'rights'),
    // application components
    'components'        => array(
        'user'          => array(
            'class'          => 'RWebUser',
            'loginUrl'       => '/user/account/login',
            'allowAutoLogin' => true, // enable cookie-based authentication
        ),
        'image'         => array(
            'class'  => 'ext.image.CImageComponent', #'application.helpers.image.CImageComponent',
            'driver' => 'GD', // GD or ImageMagick
            #'params' => array('directory' =>'/opt/local/bin'),// ImageMagick setup path
        ),
        'clientScript'  => array(
            'packages' => array(
                'jquery'    => array(
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/jquery/1.7/',
                    'js'      => array('jquery.min.js'),
                ),
                'jquery.ui' => array(
                    'baseUrl' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/',
                    'js'      => array('jquery-ui.min.js'),
                ),
            ),
        ),
        'widgetFactory' => array(
            'widgets' => array(
                'TinyMce'        => array(
                    'compressorRoute'    => 'tinyMce/compressor',
                    'spellcheckerUrl'    => 'http://speller.yandex.net/services/tinyspell?options=15',
                    'fileManager'        => array(
                        'class'          => 'ext.elFinder.TinyMceElFinder',
                        'connectorRoute' => 'elfinder/connector',
                    ),
                    'settings'           => array(
                        'doctype'                           => '<!DOCTYPE html>',
                        'extended_valid_elements'           => 'iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width],input[name|value|id|type|placeholder|required]',
                        'body_class'                        => 'container-fluid',
                        'width'                             => '100%',
                        'plugins'                           => 'autolink,lists,pagebreak,layer,table,save,advimage,advlink,inlinepopups,insertdatetime,media,searchreplace,contextmenu,paste,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist',
                        'theme_advanced_buttons1'           => 'save,|,undo,redo,|,pastetext,pasteword,|,formatselect,fontsizeselect,forecolor,|,bold,italic,strikethrough,|,justifyleft,justifycenter,justifyright,|,bullist,|,anchor,link,unlink,|,image,|,spellchecker',
                        'theme_advanced_buttons2'           => 'code,|,fullscreen,visualaid,|,removeformat,cleanup,|,styleselect,fontselect,backcolor,|,underline,sub,sup,|,justifyfull,outdent,indent,|,numlist,|,blockquote,hr,pagebreak,|,media',
                        'theme_advanced_buttons3'           => '',
                        'theme_advanced_buttons4'           => '',
                        'theme_advanced_toolbar_location'   => 'top',
                        'theme_advanced_toolbar_align'      => 'left',
                        'external_link_list_url'            => '/page/default/MceListUrl',
                        'relative_urls'                     => false,
                        'pagebreak_separator'               => '<cut>',
                        'apply_source_formatting'           => true,
                        'spellchecker_word_separator_chars' => '\\s!"#$%&()*+,./:;<=>?@[\]^_{|}\xa7\xa9\xab\xae\xb1\xb6\xb7\xb8\xbb\xbc\xbd\xbe\u00bf\xd7\xf7\xa4\u201d\u201c',
                        'setup'                             => 'js:function (a){a.addCommand("mceSpellCheckRuntime",function(){t=a.plugins.spellchecker;t.mceSpellCheckRuntimeTimer&&window.clearTimeout(t.mceSpellCheckRuntimeTimer);t.mceSpellCheckRuntimeTimer=window.setTimeout(function(){t._done();t._sendRPC("checkWords",[t.selectedLang,t._getWords()],function(c){0<c.length&&(t.active=1,t._markWords(c),a.nodeChanged())})},4E3)});a.onKeyUp.add(function(a,b){(13==b.keyCode||190==b.keyCode||191==b.keyCode)&&a.execCommand("mceSpellCheckRuntime")})}',
                    ),
                ),
                'CJuiDatePicker' => array( // where <WidgetName> is the name of the JUI Widget (Tabs, DatePicker, etc.). Each CJuiWidget used must be declared
                    'scriptUrl'      => '//ajax.googleapis.com/ajax/libs/jqueryui/1.8',
                    'i18nScriptFile' => 'i18n/jquery-ui-i18n.min.js',
                    'themeUrl'       => '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes',
                ),
            ),
        ),
        'urlManager'    => array(
            'urlFormat'      => 'path',
            'urlSuffix'      => '/',
            'showScriptName' => false,
            'cacheID'        => 'cache',
            'rules'          => array_merge(
                require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'urlRules.php'),
                array(
                    'gallery'                                                    => 'gallery/default/list',
                    'album/<slug:[\w\_-]+>'                                      => 'gallery/photo/album',
                    'page/<slug:[\w\_-]+>'                                       => 'page/default/show',
                    'news/show/<slug:[\w\_-]+>'                                  => 'news/default/show',
                    'blog/show/<slug:[\w\_-]+>'                                  => 'blog/default/show',
                    'blog/post/tag/<tag>'                                        => 'blog/post/tag',
                    'sitemap.xml'                                                => 'sitemap/default/index/format/xml',
                    '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'        => '<module>/<controller>/<action>',
                    '<module:\w+>/<controller:\w+>/<action:\w+>/<slug:[\w\_-]+>' => '<module>/<controller>/<action>',
                    '<module:\w+>/<controller:\w+>/<action:\w+>'                 => '<module>/<controller>/<action>',
                    '<controller:\w+>/<id:\d+>'                                  => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>'                     => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'                              => '<controller>/<action>',
                )
            ),
        ),
        'authManager'   => array(
            'class'           => 'RDbAuthManager',
            #default is Auth#'defaultRoles' => array('Guest'),
            'itemTable'       => '{{auth_item}}',
            'itemChildTable'  => '{{auth_item_child}}',
            'assignmentTable' => '{{auth_assignment}}',
            'rightsTable'     => '{{rights}}',
        ),
        'errorHandler'  => array(
            'errorAction' => 'site/error', // use 'site/error' action to display errors
        ),
        'cache'         => array(
            'class' => 'CFileCache',
        ),
        'log'        => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
            ),
        ),
        'bootstrap'     => array(
            'class'           => 'ext.bootstrap.components.Bootstrap',
            'enableBootboxJS' => false
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    /*'params' => array(

    ),*/
);
