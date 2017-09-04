<?php
	// V1 Tweaks for V0
	if(!isset($post_title))
	{
		$post_title = $Aria["post_title"];
		$post_content = $Aria["post_content"];
		$post_id = $Aria["post_id"];
		$post_date = $Aria["post_date"];

	}
?>
<div style="width:100%;padding-top:4px;background: linear-gradient(to bottom, rgba(16,16,16,255), rgba(128,128,128,0));"></div>
<div>
	<a href="index.php?item=post&item_id=<?= $post_id ?>&AV=1&item_nb=1"><h3><?= $post_title ?></h3></a>
	<div class="caption"><?= date(DATE_RSS,$post_date) ?></div>
	<div><?= $post_content ?></div>
</div>
<?php
	// V1 Tweaks for V0
	if(isset($post_title))
	{
		unset($post_title);
		unset($post_content);
		unset($post_id);
		unset($post_date);

	}
?>