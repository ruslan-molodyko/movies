<div class="menu-title">Добавить фильм</div>
<div class="grid">
<div class="add-block col-add grid">
<form action="?controller=star&action=add" method="POST">
<div class="col1-first">Имя</div><div class="col1-second"><input type="text" name="first_name" required></div>
<div class="col1-first">Фамилия</div><div class="col1-second"><input type="text" name="last_name" required></div>
</div>
<div class="add-block col-add grid">
<div class="col1-first">Фильмы</div>
<div class="block-add-star">
		<select size="6" multiple name="movie[]">
		<?php foreach($data['movies_obj'] as $v): ?>
		<option value="<?=$v->id?>"><?=$v->title?></option>
		<?php endforeach; ?>
		</select>
</div>
</div>
<div class="add-block col-add grid" style="width: 94%;margin-top: 0;">
<div class="col1-first"><input type="submit" value="Добавить актера"></div>
</div>
</form>
</div>