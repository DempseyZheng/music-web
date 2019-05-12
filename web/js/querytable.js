var queryType;
$(function () {
    initTable( onDbClick);
});
function onDbClick(row) {
    // var msg = row.musicNo;

    $('#' + $('#model_id').text()).val(getDbClickMsg(row,queryType));
    $('#myModal').modal('hide');
}
function initTable( onDbClick) {
    $('#table').bootstrapTable({
        // url: initParams.url, //请求地址
        method: 'GET', //请求
        // editable: initParams.editable,
        striped: true,
        cache: false,
        pagination: true,
        sortable: true,
        showHeader: true,
        showRefresh: false,
        clickToSelect: true,
        search: false,
        sidePagination: "server", //客户端client   服务端server
        pageNumber: 1,
        pageList: [5, 15],
        queryParams: function (params) {
            return {
                offset: params.offset,  //页码
                limit: params.limit,   //页面大小
                queryNo: $('#device_no_input').val(),
                queryName: $('#device_name_input').val(),
            };
        },

        // columns: initParams.columns,
        onDblClickRow: onDbClick
    });
}
function onSearch(obj,type) {
    // console.log(type);
    queryType=type;
    var input = $(obj).parent().find('.form-control');

    $('#model_id').text(input.attr('id'));
    $('#device_name_input').val('');
    $('#device_no_input').val('');

  refreshQueryTable(type);

    $('#myModal').modal('show');
}
