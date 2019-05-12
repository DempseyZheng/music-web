<script>
    function queryName() {

        var table = $('#table');

        table.bootstrapTable('refresh', {
            // url: '/site/table',
            query: {queryName: $('#device_name_input').val()},
            pageNumber: 1
        });
    }

    function queryNo() {
        $('#table').bootstrapTable('refresh', {
            // url: '/site/table',
            query: {queryNo: $('#device_no_input').val()},
            pageNumber: 1
        });
    }
</script>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    查询窗口
                </h4>
            </div>
            <div class="modal-body">
<!--                <span id="model_value" hidden></span>-->
                <span id="model_id" hidden></span>
                <span id="model_type" hidden></span>
                <div class="form-group" style="margin-bottom: 20px">
                    <label>编号:</label>
                    <div class="input-group">
                        <input type="text" id="device_no_input" class="form-control" aria-required="true">
                        <span onclick="queryNo()" class="input-group-addon" style="cursor:pointer;">
                            <span class="glyphicon glyphicon-search"></span>
                        </span>
                    </div>
                    <label>名称:</label>
                    <div class="input-group">
                        <input type="text" id="device_name_input" class="form-control" aria-required="true">
                        <span onclick="queryName()" class="input-group-addon" style="cursor:pointer;">
                            <span class="glyphicon glyphicon-search"></span>
                        </span>

                    </div>
                </div>
                <table id="table"></table>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
