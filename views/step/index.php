<?php

$this->title = '分步式用户注册表单UI界面设计';
\app\assets\StepAsset::register($this);
?>


<div id="wizard">

        <h2 class="fs-title">创建你的账号</h2>
        <section>

            <form class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Remember me
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Sign in</button>
                    </div>
                </div>
            </form>
        </section>

        <h2 class="fs-title">填写社交账号</h2>
        <section>
            <h3 class="fs-subtitle">填写你的常用社交网络账号</h3>
            <input type="text" name="x-weibo" placeholder="新浪微博"/>
            <input type="text" name="t-weibo" placeholder="腾讯微博"/>
            <input type="text" name="qq" placeholder="腾讯QQ"/>
            <input type="button" name="previous" class="previous action-button" value="Previous"/>
            <input type="button" name="next" class="next action-button" value="Next"/>
        </section>

        <h2 class="fs-title">个人详细信息</h2>
        <section>
            <h3 class="fs-subtitle">个人详细信息是保密的，不会被泄露</h3>
            <input type="text" name="fname" placeholder="昵称"/>
            <input type="text" name="lname" placeholder="姓名"/>
            <input type="text" name="phone" placeholder="电话号码"/>
            <textarea name="address" placeholder="家庭住址"></textarea>
            <input type="button" name="previous" class="previous action-button" value="Previous"/>
            <input type="submit" name="submit" class="submit action-button" value="Submit"/>
        </section>

</div>

<script>
    $(function () {
        $("#wizard").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            labels: {
                cancel: "取消",
                current: "current step:",
                pagination: "Pagination",
                finish: "保存",
                next: "下一步",
                previous: "上一步",
                loading: "Loading ..."
            },
            onFinished: function (event, currentIndex) {
                console.log(event);
             location.reload();
            }
        });
    });
</script>


