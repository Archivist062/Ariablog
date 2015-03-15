<?= on_admin('
<div class="row">
	<div class="small-2 -centered columns" style="font-size:200%">Entrez le nouvel element</div>
</div>
<form class="row" action="admin.php?newmenu=1" method="POST" id="form">
	<input class="small-2 small-centered columns" type="text" name="page_title" placeholder="Title"/><br/>
	<textarea class="small-2 small-centered columns" form="form" name="page_content" placeholder="Content"></textarea><br/>
	<input class="small-push-1 small-1 small-centered columns" type="submit" name="confirm" value="Send"/>
</form>'); ?>