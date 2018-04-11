$.fn.editable.defaults.mode = 'popup';

function editable() {
    $('.todoEditable').editable({
        url: '/edit'
    });
}
$(document).ready(function() {
   editable();
});

$('#todoForm').on('submit', function (e) {
    e.preventDefault();
    var item = $('#item').val();
    $.ajax({
        type: "POST",
        url: "/add",
        data: {item : item},
        success: function (data) {
            if(data) {
                $('#todoList').append("<li><div class='todoItem'><h2 data-pk ="+ data +" class ='todoEditable'>" + item + "</h2><input type='file' class = 'loadFile' id="+ data +" name='picture'></div><input type='text' name='tag'>&nbsp;<button class=''>Добавить тег</button></li>");
                editable();
            } else {
                $('#todoList').append("<li><div class='error'>Ошибка сервера. Попробуйте позже</div></li>")
            }
        }
    });
});

$('.loadFile').on('change', function (e) {
    e.preventDefault();
    var file = this.files[0];
    var node = $(this).closest( "div" );
    var img  = node.next( "div" );

    var data = new FormData();
    var id   = $(this).attr('id');

    data.append("picture", file);
    data.append("id", id);
    $(this).val("");

    $.ajax({
        type: "POST",
        url: "/load",
        data: data,
        processData: false,
        contentType: false,
        success: function (data) {
            if(data){
                img.remove();
                node.append("<div class='image'><a target='_blank' href="+data+"><img height='150' width='150' src ="+ data +"></a> <i class='fa fa-close'></i></div>")
            } else{
                node.append("<div class='error'>Неверный формат файла (поддерживаются .jpeg и .png)</div>")
            }
        }
    });
});

$('.addTag').on('click', function () {
    var tag     = $(this).prev('input').val();
    var taskId  = $(this).closest('li').find('h2').attr('data-pk');
    var list    = $(this).closest('li').find('.tagList');

    $(this).prev('input').val("");

    $.ajax({
        type: "POST",
        url: "/tag",
        data: {id: taskId, tag :tag},
        success: function (data) {
            console.log(data);
            if(data){
                var obj = JSON.parse(data);
                list.append("<span class='tagName'><a href='/filter/?id=" + obj.tag_id+ "'>"+ obj.tag_name + "</a>");
            } else {
                list.append("<div class='error'>Ошибка сервера. Попробуйте позже</div>")
            }
        }
    });

});

$(document).on('click','.fa-close', function () {
    var id = $(this).closest('li').find('input').attr('id');
    $.ajax({
        type: "POST",
        url: "/del",
        data: {id: id}
    });
    $(this).parent().remove();
});