<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-5-19
 * Time: 下午4:09
 */

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@app/web');
\app\assets\SidebarAsset::register($this);
?>
<script>
    $(function () {



        $('#menu-toggle-2').click(function (e) {
            // e.preventDefault();
            $("#wrapper").toggleClass("toggled-2");
            $('#menu ul').hide();
        })

        //菜单点击
        $('a',$('#menuSideBar')).on('click', function(e) {
            e.stopPropagation();
            var li = $(this).closest('li');
            var menuId = $(li).attr('mid');
            var url = $(li).attr('funurl');
            var title = $(this).text();
            $('#page-content-wrapper').bTabsAdd(menuId,title,url);

        });

        //初始化
        $('#page-content-wrapper').bTabs();
    });
</script>


<nav class="navbar navbar-default no-margin">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header fixed-brand">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" id="menu-toggle">
            <span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
        </button>
        <a class="navbar-brand" href="javascript:void(0);"><i class="fa fa-rocket fa-4"></i> ACCV</a>
    </div>
    <!-- navbar-header-->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li class="active">
                <button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2"><span
                            class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
                </button>
            </li>
        </ul>
    </div>

</nav>
<div id="wrapper" style="height: 100%">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav nav-pills nav-stacked" id="menuSideBar">
            <li class="active">
                <a href="javascript:void(0);"><span class="fa-stack fa-lg pull-left"><i class="fa fa-dashboard fa-stack-1x "></i></span>
                    首页</a>
            </li>

            <li  mid="tab1" funurl="/music-arrange/">
                    <a href="javascript:void(0);">
                     <span class="fa-stack fa-lg pull-left">
                        <i class="fa fa-server fa-stack-1x "></i>
                    </span>播期列表</a>
            </li>
            <li  mid="tab2" funurl="/music-library/">
                <a href="javascript:void(0);">
                     <span class="fa-stack fa-lg pull-left">
                        <i class="fa fa-music fa-stack-1x "></i>
                    </span>音乐库</a>
            </li>
            <li  mid="tab3" funurl="/music-store/">
                <a href="javascript:void(0);">
                    <span class="fa-stack fa-lg pull-left">
                        <i class="fa fa-cart-plus fa-stack-1x "></i>
                    </span>门店信息</a>
            </li>
            <li  mid="tab4" funurl="/music-device/">
                <a href="javascript:void(0);">
                    <span class="fa-stack fa-lg pull-left">
                        <i class="fa fa-wrench fa-stack-1x "></i>
                    </span>设备信息</a>
            </li>
            <li  mid="tab5" funurl="/music-arrange-device/">
                <a href="javascript:void(0);">
                    <span class="fa-stack fa-lg pull-left">
                        <i class="fa fa-cloud-download fa-stack-1x "></i>
                    </span>音乐播控</a>
            </li>
        </ul>
    </div>

    <div id="page-content-wrapper" style="height: 100%;overflow: hidden" >

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active noclose"><a href="#bTabs_navTabsMainPage"
                                                                          data-toggle="tab">首页</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="bTabs_navTabsMainPage">
                            <div class="page-header">
                                <h2 style="font-size: 31.5px;text-align: center;font-weight: normal;">欢迎使用</h2>
                            </div>
                            <div style="text-align: center;font-size: 20px;line-height: 20px;"> Welcome to use bTabs
                                plugin!
                            </div>
                        </div>
                    </div>
    </div>

</div>



