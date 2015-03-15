<?php
	$stmt = getpdo()->prepare("SELECT  group_name FROM TreeMe INNER JOIN AGroup ON TreeMe.group_id = AGroup.group_id WHERE treeme_id = :id;");
	$stmt->execute(
		array(
			'id' => $Aria["treeme_id"]
		)
	);
	$group = $stmt->fetchAll()[0]["group_name"];
	if(UserIn($group))
	{
?>
<div id="TreeMeData">		
		<?= $Aria["TreeData"]?>
</div>
<?php
	}

?>
<script type="text/javascript" src="js/treeme.js">

</script>
<div id="TreeDisplay"></div>
<div id="ContentDisplay"></div>