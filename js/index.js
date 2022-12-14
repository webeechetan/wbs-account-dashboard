$(document).ready(function () {
    let content_editor;
    ClassicEditor
        .create(document.querySelector('#description'), {
            ckfinder: {
                uploadUrl: 'upload.php',  
            },
            toolbar: {
                items: [
                    'heading', '|',
                    'fontfamily', 'fontsize', '|',
                    'alignment', '|',
                    'fontColor', 'fontBackgroundColor', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                    'link', '|',
                    'outdent', 'indent', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'code', 'codeBlock', '|',
                    'insertTable', '|',
                    'uploadImage', 'blockQuote', '|',
                    'undo', 'redo'
                ],
                shouldNotGroupWhenFull: true
            }
            
        })
        .then(editor => { 
            content_editor = editor;
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
        let content = $(this).parent().parent().parent().find('.sow-content').html();
        $(".view_modal_content").html(content);
        let title = $(this).data('title');
        $('#view_modal_title').html(title);
        $("#viewmodal").modal('show');
    });


    $(".sow-content").each(function (e) {
        let table = $(this).find('table');
        table.addClass('table table-bordered');
    });   
        
});

function viewByRecentDate(d){
    var url = 'https://webeetest.org/wbs-account-dashboard/view-log-by-date.php?id=' + d;
    location.href = url;
}


