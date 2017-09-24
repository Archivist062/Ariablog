
<div class="row" style="background-color:#050505;">
	<div class="col-lg-8 col-lg-offset-2">
		<div class="row">
			<div style="text-align:center;color:#D4D4D9;" class="col-lg-4 col-lg-offset-4">
				<img src="img/logo.png" alt=""/>
			</div>
			<div style="text-align:center;color:#D4D4D9;" class="col-lg-6 col-lg-offset-3 sitename">
				<h1>AriaBlog v1.1</h1>
			</div>
		</div>
		<div >
			<h1 style="display:none;"><?= $site_name ?></h1>
			<div style="background-color:#3f564e;"></div>
			<ul style="" class="menu">
				<?php LoadMenu($basepath); ?>
				<?php if(!UserCo()){LoadForm('Auth');}else{echo "Hello ".$_SESSION['username'];} ?>
			</ul>
		</div>
	</div>
</div>
	