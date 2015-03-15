
<div style="background-color:#000;">
	<div class="row">
		<div>
			<img class="column large-3" src="img/logo.png" alt=""/>
			<h1 class="column large-9 sitename">Ludovic 'Zenohate' Lagouardette</h1>
		</div>
	</div>
</div>
	<div style="width:100%;background-color:#90a6b0;">
		<h1 style="display:none;"><?= $site_name ?></h1>
		<div style="background-color:#3f564e;padding"></div>
		<ul style="" class="menu">
			<?php LoadMenu($basepath); ?>
			<?php if(!UserCo()){LoadForm('Auth');}else{echo "Hello ".$_SESSION['username'];} ?>
		</ul>
	</div>