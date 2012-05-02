<?php

MySQL_CONNECT("localhost","Username","Password");
MySQL_SELECT_DB("DataBase");
$result = MySQL_QUERY("SELECT * FROM pr_skills WHERE skill_price = 0");
if($result > 0)
{
	print("<HTML><HEAD><meta http-equiv=\"refresh\" content=\"0\"></HEAD></HTML>");
}
$x = 0;
WHILE($arr_skills = MySQL_FETCH_ARRAY($result))
{
	$priceinfo = file("http://api.eve-central.com/api/marketstat?typeid=".$arr_skills["skill_ID"]."");
	foreach($priceinfo as $line)
	{
		//print($line."<BR>");
		if(strpos($line, "median>")>0)
		{
			$tmp = substr($line,8);
			$end = strpos($tmp,".");
			$price = substr($tmp,0,$end);
			//print($arr_skills["skill_name"].": ".$price);
			MySQL_QUERY("UPDATE pr_skills SET skill_price = '".$price."' WHERE skill_ID = '".$arr_skills["skill_ID"]."'");
			break;
		}
	}
	$x++;
	if($x > 10)
	{
		die();
	}
}

?>