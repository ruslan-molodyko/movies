<div class="menu-title">Актер</div>
<div>
<br>
<div class="body-list">
	<div>Имя: <strong><?=$data['obj'][0]->first_name?></strong></div>
	<div>Фамилия: <strong><?=$data['obj'][0]->last_name?></strong></div>
</div>
<br>
<div class="menu-title">Список фильмов</div>
<?=$data['out_movie_list']?>
</div>