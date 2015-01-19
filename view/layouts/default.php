<html>
<head>
<title><?=App::get('app_name')?>
</title>
<meta charset="utf-8">
<script src="/public/js/jquery.js"></script>
<script src="/public/js/jquery-ui.min.js"></script>
<script src="/public/js/jquery.form.min.js"></script>
<link rel="stylesheet" href="/public/css/jquery-ui.min.css">
<link rel="stylesheet" href="/public/css/user.css">
</head>
<body>
<div class="grid container">
<div class="col-header"><span><a href="/"><?=App::get('app_name')?></a></span></div>
<div class="col-left-menu">
<div class="menu-title">Меню</div>
<div class="menu-item"><a href="?controller=movie&action=list">Список фильмов</a></div>
<div class="menu-item"><a href="?controller=star&action=list">Список актеров</a></div>
<div class="menu-item"><a href="?controller=movie&action=add">Добавить фильм</a></div>
<div class="menu-item"><a href="?controller=star&action=add">Добавить актера</a></div>
<div class="menu-item"><a href="?controller=parse&action=index">Добавить документ</a></div>
</div>
<div class="col-content">
<?php if(isset($_GET['feedback'])&&$_GET['feedback']):?>
<div class="add-feadback"><?=$_GET['feedback']?></div>
<?php endif; ?>
<?=$content?>
</div>
<div class="col-footer"><?=App::get('app_name')?></div>
</div>
</body>
</html>