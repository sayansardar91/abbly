<?php 
	$allow = array(1,2);
	if(!in_array($_SESSION['type'], $allow)){
		echo "<script>alert('You are not allowed to access this page.');</script>";
		echo "<script>window.location = '/index.php?pg=home'</script>";
	}
?>
<style>
    div.thumb {
        margin: 3px;
        border: 1px solid #A0ACC0;
        height: auto;
        float: left;
        text-align: center;
    }
    .thumb img{
        display: inline;
        margin: 5px;
        border: 1px solid #A0ACC0;
    }
    .thumb a:hover img {border: 1px solid black;}
    .photocattitle {text-align: center; font-weight: bold;}
    .phototitle {
        text-align: center;
        font-weight: normal;
        width: 100px;
        margin: 0 3px 3px 3px;
    } 
</style>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/adapters/jquery.js"></script>
<div class="row" >
    <div class="col-lg-12">
        <form method="post" action="">
            <input type="hidden" id="id" name="id" value=""/>
            <input type="hidden" id="file_name" name="file_name" value=""/>
            <textarea name="wordpad" id="wordpad"></textarea>
            <script>

                var filename, data;
                CKEDITOR.replace('wordpad');
                CKEDITOR.plugins.registered['save'] = {
                    init: function (editor) {
                        var command = editor.addCommand('save',
                                {
                                    modes: {wysiwyg: 1, source: 1},
                                    exec: function (editor) {
                                        var id_val = $('#id').val();
                                        if (id_val === "") {
                                            filename = prompt("Please enter a File Name", "");
                                            data = CKEDITOR.instances.wordpad.getData();
                                            $.ajax({
                                                method: "POST",
                                                url: "action.php?action=add_word",
                                                data: {file_name: filename, file_content: data}
                                            }).done(function (msg) {
                                                location.reload(alert(msg));
                                            });
                                        }else{
                                            data = CKEDITOR.instances.wordpad.getData();
                                            $.ajax({
                                                method: "POST",
                                                url: "action.php?action=add_word",
                                                data: {id: $('#id').val(),file_name: $('#file_name').val(), file_content: data}
                                            }).done(function (msg) {
                                                location.reload(alert(msg));
                                            });
                                        }
                                    }
                                });
                        editor.ui.addButton('Save', {label: 'Save', command: 'save', toolbar: 'document,10'});
                    }
                }

            </script>
        </form>
        <div class="row">&nbsp;</div>
        <div class="row text-center">
            <div class="col-md-12" style="margin-left: 15px" id="file_content">

            </div>
        </div>
        <div class="row">&nbsp;</div>
    </div><!-- /.col-->
</div>
<script>
    $(document).ready(function () {
        var html;
        $.getJSON("action.php?action=get_wordpad", function (data) {
            $.each(data, function (index) {
                if (data[index].id !== '1') {
                    html = '<div class="thumb">\n\
                            <img src="../../images/document.png" alt="Sample Image" width="100" height="100">\n\
                            <div class="phototitle">\n\
                                <i data="' + data[index].id + '" class="status_file btn btn-success" style="width:100px;margin-left:2px;">' + data[index].file_name + '</i>\n\
                                <i data="' + data[index].id + '" class="status_delete btn btn-danger" style="width:100px;margin-left:2px;margin-top:5px;">Delete</i>\n\
                            </div>\n\
                        </div>';
                    $('#file_content').append(html);
                }

            });
        });
    });
    $(document).on('click', '.status_file', function () {
        var current_element = $(this);
        var data_val = $(current_element).attr('data');
        $.getJSON("action.php?action=get_file",{id: data_val}, function (data) {
            $('#id').val(data[0]['id']);
            $('#file_name').val(data[0]['file_name']);
            CKEDITOR.instances.wordpad.setData(data[0]['file_content']);
        });
    });
    $(document).on('click', '.status_delete', function () {
        var current_element = $(this);
        var data_val = $(current_element).attr('data');
        if (confirm("Are you sure to delete this file ?")) {
            $.ajax({method: "POST", url: "action.php?action=del_wordpad", data: {id: data_val}, success: function (result) {
                    window.location.href = 'index.php?pg=wordpad';
                }});
        }
    });
</script>