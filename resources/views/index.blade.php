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

<div class="navbar">
    <a href="" ui-sref="home">首页</a>
    <a href="" ui-sref="login">登录</a>
</div>

<div>
<div ui-view=""></div>
</div>

</body>
<script type="text/ng-template" id="home.tpl">
<div>
    <h1>首页</h1>
    on index
</div>
</script>
<script type="text/ng-template" id="login.tpl">
<div>
    <h1>登录</h1>
     to login
</div>
</script>
</html>