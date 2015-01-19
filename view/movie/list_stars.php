<div class="body-list">
<div class="tr-bold">
<div class="item" style="width:54%;text-align:left;padding-left:20px;">
Имя
</div>
<div class="item" style="width:13%;">
</div>
</div>
<?php foreach($data['array_obj'] as $v): ?>
<div class="tr">
<div class="item" style="width:55%;text-align:left;padding-left:20px;">
<a href="?controller=star&action=show&id=<?=$v->id?>"><?=$v->first_name?> <?=$v->last_name?></a>
</div>
<div class="item" style="width:35%;">
<a href="?controller=moviestar&action=delete&id=<?=$v->id_bind?>">Удалить из фильма</a>
</div>
</div>
<?php endforeach; ?>
</div>