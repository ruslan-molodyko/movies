<div class="menu-title">Список актеров</div>
<div class="find-block">
<form action="<?=$this->getCurrentUri()?>" method="GET">
<?php if(isset($_GET['like'])&&!empty($_GET['like'])): ?>
	<a href="?controller=star&action=list&like=">Очистить (<?=$_GET['like']?>)</a>
<?php endif; ?>
<input type="text" placeholder="Искать актера" name="like">
<input type="hidden" name="controller" value="<?=isset($_GET['controller'])?$_GET['controller']:''?>">
<input type="hidden" name="action" value="<?=isset($_GET['action'])?$_GET['action']:''?>">
<input type="hidden" name="order" value="<?=isset($_GET['order'])?$_GET['order']:''?>">
<input type="submit" value="Искать">
</form>
</div>
<div class="body-list">
<div class="tr-bold">
<div class="item" style="width:54%;text-align:left;padding-left:20px;">
Имя <a href="?controller=star&action=list&order=<?=isset($_GET['order'])?!$_GET['order']:'1'?><?=isset($_GET['like'])?'&like='.$_GET["like"]:''?>">Сортировать</a>
</div>
<div class="item" style="width:13%;">
</div>
</div>
<?php foreach($data['array_obj'] as $v): ?>
<div class="tr">
<div class="item" style="width:75%;text-align:left;padding-left:20px;">
<a href="?controller=star&action=show&id=<?=$v->id?>"><?=$v->first_name?> <?=$v->last_name?></a>
</div>
<div class="item" style="width:13%;">
<a href="?controller=star&action=delete&id=<?=$v->id?>">Удалить</a>
</div>
</div>
<?php endforeach; ?>
</div>