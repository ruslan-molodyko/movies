<script>

	$(function(){

		var availableTags = <?=$data['stars_obj']?>;
	
		var gl = {count:0,
				  container:$('.block-add-star'),
				  btnAddStar:$('#add-star'),
				  btnDelStar:$('#del-star'),
		};
		var addInput = function(container,count){
			container.append('<span class="item-el"><input type="text" name="star['+count+']" class="star-input" placeholder="#'+(count+1)+' актер"></span>');
		}		
		var delInput = function(container,count){
			container.find('.star-input[name="star['+count+']"]').parent().remove();
		}
		var bindAvtCom = function(count){
			 $('.star-input[name="star['+count+']"]').autocomplete({source: availableTags});
		}
		gl['btnAddStar'].click(function(){
			var count = ++gl['count'];
			addInput(gl['container'],count);
			bindAvtCom(count);
		});
		gl['btnDelStar'].click(function(){
			if(gl['count']==0) return;
			var count = gl['count']--;
			delInput(gl['container'],count);
		});
		bindAvtCom(0);
	});

</script>

<div class="menu-title">Добавить фильм</div>
<div class="grid">
<form action="?controller=movie&action=add" method="POST">
<div class="add-block col-add grid">
<div class="col1-first">Название</div><div class="col1-second"><input type="text" name="title" required></div>
<div class="col1-first">Год</div><div class="col1-second"><input type="text" name="year" required></div>
<div class="col1-first">Формат</div>
<div class="col1-second">
<select name="format">
	<option>VHS</option>
	<option>DVD</option>
	<option>Blu-Ray</option>
</select>
</div>
</div>
<div class="add-block col-add grid">
<div class="col1-first">Актеры</div>
<div class="block-add-star">
	<input type="text" name="star[0]" class="star-input" placeholder="#1 актер">
</div>

<div class="col1-first">
	<input type="button" id="add-star" value="Добавить актера">
</div>
<div class="col1-first">
	<input type="button" id="del-star" value="Удалить актера">
</div>
</div>
<div class="add-block col-add grid" style="width: 94%;margin-top: 0;">
<div class="col1-first"><input type="submit" value="Добавить фильм"></div>
</div>
</form>
</div>