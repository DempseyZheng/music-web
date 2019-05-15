<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p >admin</p>
                <p style="color: #00a7d0">系统管理员</p>
            </div>
        </div>

        <!-- search form -->
<!--        <form action="#" method="get" class="sidebar-form">-->
<!--            <div class="input-group">-->
<!--                <input type="text" name="q" class="form-control" placeholder="Search..."/>-->
<!--              <span class="input-group-btn">-->
<!--                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>-->
<!--                </button>-->
<!--              </span>-->
<!--            </div>-->
<!--        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => '菜单', 'options' => ['class' => 'header']],
                    ['label' => '播期列表', 'icon' => 'circle-o', 'url' => ['/music-arrange/index']],
                    ['label' => '音乐库', 'icon' => 'circle-o', 'url' => ['/music-library/index']],
                    ['label' => '门店信息', 'icon' => 'circle-o', 'url' => ['/music-store/index']],
                    ['label' => '设备信息', 'icon' => 'circle-o', 'url' => ['/music-device/index']],
                    ['label' => '音乐播控', 'icon' => 'circle-o', 'url' => ['/music-arrange-device/index']],

//                    [
//                        'label' => 'Some tools',
//                        'icon' => 'share',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
//                        ],
//                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
