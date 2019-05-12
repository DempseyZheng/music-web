function uploadArray(dataArr) {
    if (dataArr.length === 0) {

        return;
    }
    if (dataArr.length === 1) {
        dataArr[0].submit();
        return;
    }
    var fileUp=$('#fileupload');
    var btnUp=$('#upload_btn');
    fileUp.attr('disabled', true);
    btnUp.attr('disabled', true);

    var index = 1;
    dataArr[0].submit();
    var setIntervalId = setInterval(function () {
        if (index === dataArr.length) {
            clearInterval(setIntervalId);
            // console.log('上传完成');
            dataArr.length=0;
            fileUp.attr('disabled',false);
            btnUp.attr('disabled',false);
            return;
        }

        dataArr[index].submit();

        index++;
    }, 500);
}
$(function () {
    $('#btn_submit').click(function () {
        uploadArray(dataArr);

    });
    $('#btn_resubmit').click(function () {
        if (failArr.length===0){
            return;
        }
        var copy=failArr.slice();
        failArr.length=0;

        $('#files').empty();
$.each(copy,function (index, data) {
    data.context = $('<div/>').appendTo('#files');
    $.each(data.files, function (index, file) {
        var node = $('<div class="row "/>');
        var left = $('<div class="col-md-6"/>');
        $('<span/>').text(file.name).appendTo(left);
        left.appendTo(node);
        var right = $('<div class="col-md-4"/>');
        $('<button />').text('上传').addClass('btn btn-primary')
            .appendTo(right)
            .click(function () {
                $(this).text('上传中...');
                data.submit();
            });
        var progress = $('<div class="col-md-2 progress" style="padding: 0" />');
        $('<div class="progress-bar progress-bar-success" id="progress"/>').appendTo(progress);
        progress.appendTo(node);
        right.appendTo(node);
        node.appendTo(data.context);

    });
})



        uploadArray(copy);

    });
    $('#jqUploadModel').on('show.bs.modal', function () {
        isSuccess=false;
        failArr.length=0;
        dataArr.length=0;
        $('#files').empty();
        $('#progress .progress-bar').css(
            'width',
            0 + '%'
        );
    });
    $('#jqUploadModel').on('hide.bs.modal', function () {
        if (isSuccess) {
        window.location.reload();
        }
    });

var dataArr = [];
    var failArr = [];
    var isSuccess=false;
$('#fileupload').fileupload({
    dataType: 'json',
    fail: function (e, data) {
        failArr.push(data);
        console.log("fail");
        console.log(data);
        console.log(e);
        var p = $('<p/>');
        p.text('上传失败:').addClass('text-danger').replaceAll($(data.context).children('.row').children('.col-md-4').find('button'));
        var error = $('<span class="text-danger"/>').text(data.errorThrown);
        p.append(error);
    },
    progress: function (e, data) {
        // console.log(data);
        var progress = parseInt(data.loaded / data.total * 100, 10);
        var row = $(data.context).children('.row');
        var proDiv = row.children('.progress');
        var pro = proDiv.children('.progress-bar');
        pro.css(
            'width',
            progress + '%'
        );
    },
    add: function (e, data) {
        dataArr.push(data);
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<div class="row "/>');
            var left = $('<div class="col-md-6"/>');
            $('<span/>').text(file.name).appendTo(left);
            left.appendTo(node);
            var right = $('<div class="col-md-4"/>');
            $('<button />').text('上传').addClass('btn btn-primary')
                .appendTo(right)
                .click(function () {
                    $(this).text('上传中...');
                    data.submit();
                });
            var progress = $('<div class="col-md-2 progress" style="padding: 0" />');
            $('<div class="progress-bar progress-bar-success" id="progress"/>').appendTo(progress);
            progress.appendTo(node);
            right.appendTo(node);
            node.appendTo(data.context);

        });

    },
    done: function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.error) {
                var p = $('<p/>');
                p.text('上传失败:').addClass('text-danger').replaceAll($(data.context.children()[index]).find('button'));
                var error = $('<span class="text-danger"/>').text(file.error);

                p.append(error);
            } else {
                isSuccess=true;
                $('<p/>').text('上传成功').replaceAll($(data.context.children()[index]).find('button'));
            }
        });

    }
}).prop('disabled', !$.support.fileInput)
    .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
