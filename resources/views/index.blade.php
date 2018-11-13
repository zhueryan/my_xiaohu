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
    <div class="home container">
        注册
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi consectetur dolor dolore, eaque enim et explicabo ipsum iure iusto maxime modi molestias optio reiciendis repudiandae sunt tenetur voluptatum. Maiores, rerum?
        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab cumque ea exercitationem fuga incidunt itaque,
            laborum maiores minima perferendis perspiciatis porro quaerat quos, rem totam velit. Cupiditate enim
            laudantium totam.
        </div>
        <div>Alias corporis cum delectus, deserunt dignissimos dolor dolore fugit impedit minima molestiae molestias,
            nam nihil nulla perferendis porro quibusdam quidem rerum saepe similique tempore totam veritatis
            voluptatibus. Adipisci, ipsa, rem.
        </div>
        <div>Accusantium alias animi assumenda beatae commodi, consequuntur distinctio enim error, eveniet in ipsum
            necessitatibus omnis quas quia quidem temporibus voluptatem voluptatibus voluptatum. Ex facilis nobis odit
            quisquam ratione, sint vitae.
        </div>
        <div>Animi assumenda culpa fugiat perferendis porro quasi. Amet, blanditiis eos iure odit omnis reiciendis
            repellendus ullam. Cupiditate eligendi est explicabo facere facilis laudantium nisi non, obcaecati optio
            praesentium repellendus repudiandae!
        </div>
        <div>Corporis debitis laborum placeat praesentium sequi. Adipisci alias, dolore earum, eius esse illo labore
            laboriosam neque omnis provident qui, recusandae rem vel. Beatae cum dolores expedita facere laboriosam
            laborum tempora!
        </div>
        <div>Blanditiis dolores facilis ipsum mollitia neque numquam possimus repudiandae voluptates! Aspernatur
            deserunt dignissimos dolore ea eos laudantium modi molestiae, optio reiciendis reprehenderit sit voluptate!
            Blanditiis est ipsum maiores reiciendis veritatis.
        </div>
        <div>A ab aliquid amet aspernatur, blanditiis commodi consequuntur, deleniti deserunt, eaque laboriosam
            perferendis porro possimus repudiandae vel veniam. Commodi culpa dignissimos doloremque fugiat libero optio
            placeat quam reprehenderit ullam ut.
        </div>
        <div>Dolor enim fuga id iusto natus officiis possimus quisquam, temporibus voluptatem voluptatum! Animi
            asperiores ea eos, illo impedit inventore, magni pariatur quasi rem repellat sequi similique, sit soluta ut
            vel?
        </div>
    </div>
</script>
</html>