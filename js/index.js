$(document).ready(function () {
    let content_editor;
    ClassicEditor
        .create(document.querySelector('#description'), {
            ckfinder: {
                uploadUrl: 'upload.php',
            }
        })
        .then(editor => {
            content_editor = editor;
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });

    $(".open_modal").click(function () {
        let field = $(this).data('field');
        let title = $(this).data('title');
        $("#modal_title").html(title);
        $("#edit_modal").modal('show');
        $("#field_name").val(field);
        let content = $("#" + field).html();
        content_editor.setData(content);
    });



    $(".open_view_modal").click(function () {
        
        
        $("#viewmodal").modal('show');
        
    });


});
