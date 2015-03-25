<?php

session_start();

function getpdo()
{
	try{
		$pdo = new PDO('sqlite:blog.sqlite');
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
	} catch(Exception $e) {
		echo "Impossible d'accéder à la base de données SQLite : ".$e->getMessage();
		die();
	}
	return $pdo;
}

function cfgget($key)
{
	$stmt = getpdo()->prepare("SELECT value FROM config WHERE key = :key");
	$stmt->execute(array('key' => $key));
	$res = $stmt->fetchAll();
	return $res[0]['value'];
}


/********************************************************************************************/
/************************** VO DEPRECATED FUNCTIONS *****************************************/
/********************************************************************************************/


	function Load($page)
	{
		$stmt = getpdo()->prepare("SELECT page_id,page_title,page_content FROM Page WHERE page_title = :title ;");
		$stmt->execute(array('title' => $page));
		$res= $stmt->fetchAll();
		return $res;
	}
	
	function LoadPosts($page)
	{
		$limit =intval(cfgget("post_per_page"));
		$offset = 0;
		if(isset($_GET['nb']))
		{
			$offset = ($_GET['nb'] -1)*$limit;
		}
		$stmt = getpdo()->prepare("
		SELECT *
		FROM Post
		WHERE post_id IN
		(
			SELECT post_id
			FROM 
			(
				SELECT post_id, COUNT(post_id) AS CPT
				FROM Post_Have_Hashtag JOIN Page_Displays_Hashtag
					ON Post_Have_Hashtag.hashtag_id = Page_Displays_Hashtag.hashtag_id
				WHERE page_id = 1
				GROUP BY post_id
			)
			WHERE CPT in 
			(
				SELECT MAX(CPT) 
				FROM 
				(
					SELECT COUNT(post_id) AS CPT
					FROM Post_Have_Hashtag JOIN Page_Displays_Hashtag
						ON Post_Have_Hashtag.hashtag_id = Page_Displays_Hashtag.hashtag_id
					WHERE page_id = (SELECT page_id FROM Page WHERE page_title = :page)
					GROUP BY post_id
				)
			)
		)
		ORDER BY post_id DESC
		LIMIT :limit OFFSET :offset
		");
		$stmt->execute(array(
			'page' => $page,
			'limit' => $limit,
			'offset' => $offset
		));
		$res= $stmt->fetchAll();
		
		foreach($res as $inv_post)
		{
			$post_id = $inv_post["post_id"];
			$post_title= $inv_post["post_title"];
			$post_date= $inv_post["post_date"];
			$post_content= $inv_post["post_content"];
			include "layout/post.php";
		}
	
	}
	
	function LoadAllPosts()
	{
		
		$limit = intval( cfgget("post_per_page"));
		$offset = 0;
		if(isset($_GET['nb']))
		{
			$offset = ($_GET['nb'] -1)*$limit;
		}
		$stmt = getpdo()->prepare("
		SELECT *
		FROM Post
		ORDER BY post_id DESC
		LIMIT :limit OFFSET :offset ;");
		$stmt->execute(array(
			'limit' => $limit,
			'offset' => $offset
		));
		$res= $stmt->fetchAll();
		
		$areposts = false;
		foreach($res as $inv_post)
		{
			$post_id = $inv_post["post_id"];
			$post_title= $inv_post["post_title"];
			$post_date= $inv_post["post_date"];
			$post_content= $inv_post["post_content"];
			include "layout/post.php";
			$areposts = true;
		}
		if($areposts == false)
		{
			//include "layout/404.php";
		}
	
	}
	
	function LoadMenu($menu_link_base = "index.php")
	{
		
		$menu_title = "Accueil";
		$menu_link = $menu_link_base;
		
		include "layout/menuitem.php";
	
		$stmt = getpdo()->prepare("SELECT page_title FROM page");
		$stmt->execute();
		$res = $stmt->fetchAll();
		foreach($res as $pageproof)
		{
			$menu_title = $pageproof['page_title'];
			$menu_link = $menu_link_base."?page=".htmlspecialchars($menu_title);
			include "layout/menuitem.php";
		}
	}
	
	function LoadHeader($basepath = "index.php")
	{
		$site_name = cfgget("site_name");
		include "layout/header.php";
	}
	
	
/********************************************************************************************/
/************************** V1 all new functions ********************************************/
/********************************************************************************************/
	
	function LoadItem($type,$id=null,$nb = null,$paged = 0)
	{
		if($nb == null)
		{
			$nb = cfgget(strtolower($type).'_nb');
		}

		$nb_additions = " ORDER BY ".htmlspecialchars(strtolower($type))."_id DESC LIMIT ".htmlspecialchars($nb)." OFFSET ".htmlspecialchars($paged*$nb)." ";

		if($id == null)
		{
			$stmt = getpdo()->prepare("SELECT * FROM ".htmlspecialchars($type).$nb_additions.";");
			$stmt->execute();
			$res = $stmt->fetchAll();
			foreach ($res as $value) {
				$Aria = $value;
				include "layout/".$type.".php";
			}
		}
		else
		{
			if(is_array($id))
			{
			$i=0
				foreach($nbid in $id)
				{
					$i=$i+1;
					if($i<($nb+$paged*$nb) && $i>($paged*$nb))
					{
						LoadItem($type,$nbid,1);
					}
				}
			}
			else
			{
				$stmt = getpdo()->prepare("SELECT * FROM ".htmlspecialchars($type)." WHERE ".strtolower($type)."_id = :id ".$nb_additions.";");
				$stmt->execute(array(
						'id' => $id
					));
				$res = $stmt->fetchAll();
				$Aria = $res[0];
				include "layout/".$type.".php";
			}
		}
	}
	
	function PageBuild()
	{
		if(isset($_GET["Form"]))
		{
			include "generators/".$_GET["Form"].".php";
		}
		if(!isset($_GET['AV']))
		{
			{ // V0 Behaviour
				LoadHeader();
				$paginator = 1;
				if(isset($_GET['nb']))
				{
					$paginator = $_GET['nb'];
				}
				if(isset($_GET["page"]))
				{
					$res = Load($_GET["page"]);
					$page_id = $res[0]['page_id'];
					$page_title = $res[0]['page_title'];
					$page_content = $res[0]['page_content'];
					include "layout/page.php";
				}
				else
				{
					include "layout/home.php";
				}
			}
		}
		else
		{
			switch($_GET['AV'])
			{
				case 1: // V1 Behaviour
				{
					if(isset($_GET['item']))
					{
						$item = $_GET['item'];
					}
					else
					{
						$item = null;
					}
					
					if(isset($_GET['item_id']))
					{
						$item_id = $_GET['item_id'];
					}
					else
					{
						$item_id = null;
					}
					
					if(isset($_GET['item_nb']))
					{
						$item_nb = $_GET['item_nb'];
					}
					else
					{
						$item_nb = null;
					}
					
					if(isset($_GET['item_page']))
					{
						$item_page = $_GET['item_page'];
					}
					else
					{
						$item_page = 0;
					}

					LoadItem($item,$item_id,$item_nb,$item_page);
				}
				default:
				{

				}
			}
		}
	}	
	

	function LoadForm($form)
	{
		$form_target = "index.php?Form=".$form;
		include "layout/".$form.".php";
	}
	
	// TODO
	function FieldsBuild($fgen,$clauses)
	{
		include "generators/Fields/".$fgen.".php";
	}

	// TODO
	function SelectSQL($clauses)
	{
		$var = "SELECT ";
		if(!isset($clauses["fields"]))
		{
			$var .= "* ";
		}
		else
		{
			$first = true;
			foreach($clauses["fields"] as $field)
			{
				if(!$first)
				{
					$var .= ", ";
				}
				else
				{
					$first =false;
				}
				
				$var .= $field;
			}
		}
		
		
		return $var;
	}

/********************************************************************************************/
/********************************************************************************************/
/********************************************************************************************/

	function UserCo()
	{
		return ($_SESSION['username'] != 'anonymous')?true:false;
	}

	function UserIn($group)
	{
		$stmt = getpdo()->prepare("SELECT 1 FROM (User JOIN User_In_Group ON User.user_id = User_In_Group.user_id) AS IdLnk INNER JOIN AGroup ON IdLnk.group_id = AGroup.group_id WHERE user_name = :username AND group_name = :group;");
		$stmt->execute(
			array(
				'username' => $_SESSION['username'],
				'group' => $group
			)
		);
		if(count($stmt->fetchAll()) != 0)
		{
			return true;
		}
		return false;
	}

	function Auth($username, $password)
	{
		$stmt = getpdo()->prepare("SELECT 1 FROM User WHERE user_name = :username AND user_password = :password;");
		$stmt->execute(
			array(
				'username' => $username,
				'password' => $password
			)
		);
		if(count($stmt->fetchAll()) == 1)
		{
			$_SESSION['username'] = $username;
		}
				
	}
	
	

	function Build($mode)
	{
		PageBuild();
		
	}



/********************************************************************************************/
/********************************************************************************************/
/********************************************************************************************/


if(!isset($_SESSION['username']))
{
	$_SESSION['username'] = "anonymous";
}

$sup_page_title = "Ariablog";

if(isset($_GET['page']))
{
	$sup_page_title = $_GET['page'];
}
elseif(isset($_GET['post_id']))
{
	if(is_integer($_GET['post_id'])) 
	{
		$stmt = getpdo()->prepare("SELECT post_title FROM Post WHERE post_id = :post_id");
		$stmt->execute(array('post_id' => $_GET['post_id']));
		$res = $stmt->fetchAll();
		$sup_page_title = $res[0]['post_title'];
	}
	else
	{
	$sup_page_title = "ERROR";
	}
}
else
{
	$sup_page_title = cfgget("site_name");
}


