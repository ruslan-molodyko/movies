<div class="menu-title">Фильм</div>
<div>
<br>
<div class="body-list">
	<div>Фильм: <strong><?=$data['obj'][0]->title?></strong></div>
	<div>Год: <strong><?=$data['obj'][0]->year?></strong></div>
	<div>Формат: <strong><?=$data['obj'][0]->format?></strong></div>
</div>
<br>
<div class="menu-title">Список актеров</div>
<?=$data['out_star_list']?>
</div>