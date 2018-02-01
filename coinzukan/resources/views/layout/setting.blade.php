<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Coinzukan">
    <meta name="author" content="">
    <title>CoinZuKan Seting</title>
    <link href="admin_asset/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="admin_asset/dist/css/sb-admin-2.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">CoinZukan - Setting</a>
            </div>
        </nav>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">CoinZukan
                            <small>Setting</small>
                        </h1>
                        @if(\Session::has('messages'))
                            <div class="alert alert-success">
                                {{ \Session::get('messages') }}
                            </div>
                        @endif
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                        <form action="" method="POST">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                            <div class="form-group">
                                <label>Version</label>
                                <input style="width: 250px" class="form-control" name="version" type="number" step="0.1" maxlength="3" value="{{ isset($setting['version']) ? $setting['version'] : '' }}"/>
                            </div>

                            <div class="form-group">
                                <label>Messages</label>
                                <input class="form-control" name="messages" maxlength="191" value="{{ isset($setting['messages']) ? $setting['messages'] :'' }}" />
                            </div>

                            <div class="form-group">
                                <label>Intro</label>
                                <textarea class="form-control tinymce" rows="15" name="TermsAndPrivacy">
                                    {{ isset($setting['TermsAndPrivacy']) ? $setting['TermsAndPrivacy'] : '' }}
                                </textarea>
                            </div>

                            <button type="submit" class="btn btn-default">Update</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>

    <script type="text/javascript" src="admin_asset/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript">
        tinyMCE.init({
            // General options
            mode : "textareas",
            editor_selector:'tinymce',
            width:1000,
            height:350,
            theme : "advanced",
            plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

            //G?I KCFINDER
            file_browser_callback: 'openKCFinder',
            // Theme options
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,
            // Skin options
            skin : "o2k7",
            skin_variant : "silver",

            language : 'en',

            // Example content CSS (should be your site CSS)
            content_css : "",

            // C?u hình d? font-size to hon
            setup : function(ed){
                ed.onInit.add(function(ed){
                    ed.getDoc().body.style.fontSize = '11px';
                });
            },

            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "lists/template_list.js",
            external_link_list_url : "lists/link_list.js",
            external_image_list_url : "lists/image_list.js",
            media_external_list_url : "lists/media_list.js",

            template_replace_values : {
                username : "Some User",
                staffid : "991234"
            },
            // Link c?a chính nó
            // C?u hình link th?c
            relative_urls : 0,
            remove_script_host : 0,
        });
        function openKCFinder(field_name, url, type, win) {
            tinyMCE.activeEditor.windowManager.open({
                file: 'admin_asset/plugins/kcfinder/browse.php?opener=tinymce&lang=vi&type=' + type,
                title: 'KCFinder',
                width: 700,
                height: 500,
                resizable: true,
                inline: true,
                close_previous: false,
                popup_css: false
            }, {
                window: win,
                input: field_name
            });
            return false;
        }


    </script>
    <!-- /TinyMCE -->

</body>

</html>
