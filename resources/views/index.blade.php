<!DOCTYPE html>
<html lang="en" ng-app="xiaohu">
<head>
    <meta charset="UTF-8">
    <title>晓乎</title>
    <link rel="stylesheet" href="/node_modules/normalize.css/normalize.css">
    <link rel="stylesheet" href="/css/base.css">
    <script src="/node_modules/jquery/dist/jquery.js"></script>
    <script src="/node_modules/angular/angular.js"></script>
    <script src="/node_modules/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="/js/base.js"></script>

</head>
<body>

<div class="navbar clearfix">
    <div class="container">
        <div class="fl">
            <div class="navbar-item brand">晓乎</div>
            <div class="navbar-item">
                <input type="text">
            </div>

        </div>
        <div class="fr">
            <a ui-sref="home" class="navbar-item">首页</a>
            <a ui-sref="login" class="navbar-item">登陆</a>
            <a ui-sref="signup" class="navbar-item">注册</a>
        </div>
    </div>
</div>

<div class="page">
<div ui-view=""></div>
</div>

</body>
{{-- .page .home --}}
<script type="text/ng-template" id="home.tpl">
<div class="home container">
    首页
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi consectetur dolor dolore, eaque enim et explicabo ipsum iure iusto maxime modi molestias optio reiciendis repudiandae sunt tenetur voluptatum. Maiores, rerum?
</div>
</script>
{{-- .page .login --}}
<script type="text/ng-template" id="login.tpl">
    <div class="home container">
        登陆
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi consectetur dolor dolore, eaque enim et explicabo ipsum iure iusto maxime modi molestias optio reiciendis repudiandae sunt tenetur voluptatum. Maiores, rerum?
        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet beatae, commodi corporis debitis dolor
            ducimus eligendi esse expedita ipsa iure libero modi praesentium, quaerat recusandae sit soluta veniam vitae
            voluptatibus!
        </div>
        <div>Assumenda distinctio dolorem eos error eveniet libero quaerat recusandae sint! Accusantium aut dolores,
            eaque eius eveniet ex exercitationem explicabo harum impedit ipsa libero magnam molestiae nam natus odit
            saepe sequi.
        </div>
        <div>Amet autem cumque deleniti facere necessitatibus officia, omnis praesentium sunt suscipit? Accusamus
            consequatur distinctio dolor dolore eos id ipsa ipsum itaque magnam, minima neque odio officia optio,
            tempora vel voluptate.
        </div>
        <div>Aspernatur cum, cumque cupiditate explicabo fugit illum inventore ipsum iusto laborum magnam neque nihil
            nulla obcaecati odio officiis praesentium provident quo recusandae saepe sapiente sint sunt suscipit
            voluptates. Ad, autem!
        </div>
        <div>Ad dignissimos laudantium libero non odit officia, qui quia quo. Accusantium architecto cumque debitis
            dicta ducimus ea enim illum molestias necessitatibus nihil officiis porro praesentium reiciendis sit tempore
            veritatis, voluptatem?
        </div>
    </div>
</script>
<script type="text/ng-template" id="signup.tpl">
    <div ng-controller="SignupController" class="signup container">
        <div class="card">
            <h1>注册</h1>
            [: User.signup_data :]
            <form name="signup_form" ng-submit="User.signup()">
                <div class="input-group">
                    <lable>用户名：</lable>
                    <input name="username"
                           ng-minlength="4"
                           ng-maxlength="24"
                           ng-model="User.signup_data.username"
                           ng-model-options="{debounce:300}"
                           type="text"
                           required
                    >
                </div>
                <div ng-if="signup_form.username.$touched"
                     class="input-error-set">
                    <div ng-if="signup_form.username.$error.required">
                        用户名为必填项
                     </div>
                    <div ng-if="signup_form.username.$error.maxlength ||
                            signup_form.username.$error.minlength
                            ">
                        用户名长度需在4至24之间
                    </div>
                    <div ng-if="User.signup_username_exists">
                        用户名已存在
                    </div>
                    <div></div>
                </div>
                <div class="input-group">
                    <lable>密码：</lable>
                    <input name="password"
                           ng-model="User.signup_data.password"
                           type="password"
                           ng-minlength="6"
                           ng-maxlength="255"
                           required
                    >
                </div>
                <div ng-if="signup_form.password.$touched" class="input-error-set">
                    <div ng-if="signup_form.password.$error.required">
                        密码为必填项
                    </div>
                    <div ng-if="signup_form.password.$error.maxlength ||
                            signup_form.password.$error.minlength">
                        密码长度需在6至255之间
                    </div>

                    <div></div>
                </div>
                <button type="sumit" ng-disabled="signup_form.$invalid">注册</button>
            </form>
        </div>
    </div>
</script>
</html>