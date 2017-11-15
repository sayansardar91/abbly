<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/adapters/jquery.js"></script>
<div class="row" >
    <div class="col-lg-12">
        <form method="post" action="">
            <input type="hidden" id="id" name="id" value="1"/>
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
                                        data = CKEDITOR.instances.wordpad.getData();
                                        val_id = $('#id').val();
                                        $.ajax({
                                            method: "POST",
                                            url: "action.php?action=add_word",
                                            data: {id: val_id,file_name:'Notification', file_content: data}
                                        }).done(function (msg) {
                                            
                                            location.reload(alert(msg));
                                            getWordPad();
                                        });
                                    }
                                });
                        editor.ui.addButton('Save', {label: 'Save', command: 'save', toolbar: 'document,10'});
                    }
                }
            </script>
        </form>

        <div class="row">&nbsp;</div>
    </div><!-- /.col-->
</div>
<script>
    $(document).ready(function () {
        getWordPad();
    });

    function getWordPad(){
       $.getJSON("action.php?action=get_wordpad", function (data) {
            $.each(data, function (index) {
                if (data[index].id == '1') {
                    CKEDITOR.instances.wordpad.setData(data[index].file_content);
                }
            });
        });
    }
</script>			