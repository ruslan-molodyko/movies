<div class="body-list">
<div class="tr-bold">
<div class="item" style="width:35%;text-align:left;padding-left:10px;">
Название фильма
</div>
<div class="item" style="width:13%;">
Год
</div>
<div class="item" style="width:12%;">
Формат
</div>
<div class="item" style="width:34%;">
</div>
</div>
<?php foreach($data['array_obj'] as $v): ?>
<div class="tr">
<div class="item" style="width:35%;text-align:left;padding-left:10px;">
<a href="?controller=movie&action=show&id=<?=$v->id?>"><?=$v->title?></a>
</div>
<div class="item" style="width:13%;">
<?=$v->year?>
</div>
<div class="item" style="width:12%;">
<?=$v->format?>
</div>
<div class="item" style="width:34%;">
<a href="?controller=moviestar&action=delete&id=<?=$v->id_bind?>">Удалить из фильма</a>
</div>
</div>
<?php endforeach; ?>
</div>