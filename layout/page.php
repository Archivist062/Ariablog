<?php
	// V1 Tweaks for V0
	if(!isset($page_title))
	{
		$page_title = $Aria["page_title"];
		$page_content = $Aria["page_content"];
		$page_id = $Aria["page_id"];

	}
?>
<div id="page" class="row">
	<div class="col-lg-8 col-lg-offset-2">

		<h2><?= $page_title ?></h2>
		<div><?= $page_content?></div>
		<div>
		<?php LoadPosts($page_title) ?>
		</div>
	</div>
</div>
<?php
	// V1 Tweaks for V0
	if(isset($page_title))
	{
		unset($page_title);
		unset($page_content);
		unset($page_id);

	}
?>