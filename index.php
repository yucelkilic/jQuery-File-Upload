<!DOCTYPE HTML>
<!--
/*
 * jQuery File Upload Plugin Demo
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */
-->
<html lang="en">
<head>
<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<meta charset="utf-8">
<title>SınavMatiko</title>
<meta name="description" content="File Upload widget with multiple file selection, drag&amp;drop support, progress bars, validation and preview images, audio and video for jQuery. Supports cross-domain, chunked and resumable file uploads and client-side image resizing. Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports standard HTML form file uploads.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap styles -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="css/style.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="css/jquery.fileupload.css">
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-fixed-top .navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">SınavMatik</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="http://yucelkilic.com/contact/">İletişim</a></li>
                <li><a href="http://yucelkilic.com/">Yücel KILIÇ</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <h1>SınavMatik Test Oluşturucu</h1>
    <ul class="nav nav-tabs">
        <li class="active"><a href="index.php">SınavMatik</a></li>
    </ul>
    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="index.php" method="POST" enctype="multipart/form-data">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <!-- <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript> -->
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <br>
        <div>
            <label class="mr-sm-2" for="inlineFormCustomSelect">Ders Seçiniz:</label>
            <select class="selectpicker" width="fit" name="ders" id="ders">
              <option selected>Matematik</option>
              <option value="Fizik">Fizik</option>
              <option value="Kimya">Kimya</option>
              <option value="Biyoloji">Biyoloji</option>
              <option value="Türkçe">Türkçe</option>
              <option value="Tarih">Tarih</option>
              <option value="Coğrafya">Coğrafya</option>
              <option value="Felsefe">Felsefe</option>
            </select>
        </div>
        <br>
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Soru ekle...</span>
                    <input id="fileupload" type="file" name="files[]" multiple>
                </span>
                <button id="tumunuyukle" type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Tümünü Yükle</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>İptal et</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Sil</span>
                </button>
                <input type="checkbox" class="toggle">
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <br>
            <div class="form-group">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary pull-left" name="olustur">
                          <i class="glyphicon glyphicon-flag"></i>
                          <span>PDF Oluştur</span>
                </button>
              </div>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    </form>
   
    
    <?php

        if (isset($_POST['olustur'])) {
            $ders = $_POST['ders'];
            if (file_exists("test.tex")) {
                unlink("test.tex");
            } else {
                echo "File not found.";
            }
            
            $texpath = "test.tex";
            
            $texfile = fopen($texpath, "a") or die("Unable to open file!");            
            $d = 'server/php/files/';
            foreach(glob($d.'*.{jpg,JPG,jpeg,JPEG,png,PNG}',GLOB_BRACE) as $file){
                $images[] =  basename($file);
            }
            
            $texhead = file_get_contents("texhead.txt");
            $texcontent = file_get_contents($texpath);
            if ($texhead !== $texcontent)
                file_put_contents($texpath, $texhead);
            
            fwrite($texfile, "\n\\begin{document}");
            fwrite($texfile, "\n\\begin{multicols}{2}");
            fwrite($texfile, "\n%% []\n");
            fwrite($texfile, "\n\\pagestyle{headandfoot}");
            fwrite($texfile, "\n\\firstpageheadrule");
            fwrite($texfile, "\n\\runningheadrule");
            fwrite($texfile, "\n\\firstpageheader{{$ders}}{Gözü yükseklerde olanlar için...}{\\today}");
            fwrite($texfile, "\n\\runningheader{{$ders}}{Deneme Sınavı}{\\today}");
            fwrite($texfile, "\n\\firstpagefooter{{$ders}}{\\thepage}{Diğer sayfaya geçiniz \\rightarrow}");
            fwrite($texfile, "\n\\firstpagefootrule");
            fwrite($texfile, "\n\\runningfootrule");
            fwrite($texfile, "\n\\runningfooter{{$ders}}{\\thepage}{Diğer sayfaya geçiniz \\rightarrow}");
            
            fwrite($texfile, "\n		\\begin{questions}");
            foreach($images as $image){
		fwrite($texfile, "\n
                    \\question
                    \\hspace{1cm}
                    \\raggedright
                    \\noindent
                    \\includegraphics[width=0.9\\columnwidth]{{$image}}
                    \\vspace{\stretch{1}}");                

            }
            fwrite($texfile, "\n		\\end{questions}");
            fwrite($texfile, "\n\\end{multicols}");
            fwrite($texfile, "\n\\end{document}");
            fclose($texfile);
            
            //$output = system("echo 'pass' | sudo -u ykilic /Library/TeX/texbin/pdflatex -output-directory /Users/ykilic/Sites/sinavmatik/ --interaction batchmode /Users/ykilic/Sites/sinavmatik/$texpath");
            $output = system("/Library/TeX/texbin/pdflatex --interaction batchmode $texpath");
            
            if (file_exists("test.pdf")) {
                echo "<div>";
                //echo "<object data=\"test.pdf\" type=\"application/pdf\" width=\"100%\" height=\"800px\">"; 
                //echo "<p>PDF okuyucu eklentisi yüklü olmayabilir!";
                echo "<pre>PDF dosyasını bilgisayrınıza indirin:<a href=\"test.pdf\" class=\"btn btn-info btn-sm\"><span class=\"glyphicon glyphicon-save-file\"></span>İndir</a></pre>";
                echo "</div>";
                
            } else {
                echo "Dosya bulunamadı.";
            }
       
       
        } else {
            //echo "The time is " . date('Y/m/d H:i:s');
        }
    ?>
    <br>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Önemli Notlar</h3>
        </div>
        <div class="panel-body">
            <ul>
                <li>Sadece görüntü formatında (<strong>JPG, GIF, PNG</strong>) dosya yükleyiniz.</li>
                <li>Sorularınız yüklendikten sonra oluşan testinizi PDF formatında indirebilirsiniz.</li>
            </ul>
        </div>
    </div>
</div>
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">İşleniyor...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Yükle</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>İptal</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Sil</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>İptal</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
</body>
</html>
