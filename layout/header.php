
<div class="row" style="background-color:#22222b;">
	<div class="col-lg-8 col-lg-offset-2 col-md-12 col-sm-12 ">
		<div class="row">
			<div style="text-align:center;color:#D4D4D9" class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-12">
				<img style="max-height:40%;" src="img/Logo.png" alt=""/>
			</div>
			<div style="text-align:center;color:#D4D4D9;" class="col-lg-6 col-lg-offset-3 sitename col-md-8 col-md-offset-2 col-sm-12">
				<h1>AriaBlog v1.1</h1>
			</div>
		</div>
		<div >
			<h1 style="display:none;"><?= $site_name ?></h1>
			<div style="background-color:#3f564e;"></div>
			<div style="" class="menu row">
				<?php LoadMenu($basepath); ?>
				<!--<?php if(!UserCo()){LoadForm('Auth');}else{echo "Hello ".$_SESSION['username'];} ?>-->
			</div>
		</div>
	</div>
</div>
	