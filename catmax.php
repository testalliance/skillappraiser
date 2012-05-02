<?php
require_once('dbconfig.php');

$result = MySQL_QUERY("SELECT * FROM pr_categories");
WHILE($arr_cats = MySQL_FETCH_ARRAY($result))
{
	$catmax = 0;
	$res_skills = MySQL_QUERY("SELECT * FROM pr_skills WHERE skill_category = '".$arr_cats["category_ID"]."'");
	WHILE($arr_skills = MySQL_FETCH_ARRAY($res_skills))
	{
		$res_points = MySQL_QUERY("SELECT * FROM pr_ranklevel WHERE ranklevel_rank = '".$arr_skills["skill_rank"]."' AND ranklevel_level = '5'");
		$arr_points = MySQL_FETCH_ARRAY($res_points);
		$sp = $arr_points["ranklevel_sp"];
		$catmax += $sp;
	}
	MySQL_QUERY("UPDATE pr_categories SET category_max = '".$catmax."' WHERE category_ID = '".$arr_cats["category_ID"]."'");
	
}
?>