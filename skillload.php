<?php
MySQL_CONNECT("localhost","Username","Password");
MySQL_SELECT_DB("DataBase");

$contents = file ( "http://api.eve-online.com/eve/SkillTree.xml.aspx" );
//print("<!--");
$inreqskill = 0;
foreach($contents as $line)
{
	if($inreqskill)
	{
		if(strpos($line, "</rowset>")>0)
		{
			$inreqskill = 0;
		}
		if(strpos($line, "row typeID=")>0)
		{
			$tmp = substr($line,27);
			$end = strpos($tmp,"\"");
			$prereq = substr($tmp,0,$end);
			$start = strpos($line,"skillLevel=");
			$tmp = substr($line,$start+12);
			$end = strpos($tmp, "\"");
			$level = substr($tmp,0,$end);
			$query = "INSERT INTO pr_prereq(prereq_skill, prereq_reqskill, prereq_reqlevel)values('".$skill."','".$prereq."','".$level."')";
			MySQL_QUERY($query);
			print($query."<BR>");
		}

	}

	if(strpos($line, "<rowset name=\"requiredSkills\"")>0)
	{
		if(strpos($line, "/")>0)
		{

		}else{
			$inreqskill = 1;
		}
	}

	{
		//$tmp = substr($line,18);
		//$end = strpos($tmp,"<");
		//$rank = substr($tmp,0,$end);
		///print($name.": ".$number." : ".$rank."<BR>");
		//MySQL_QUERY("UPDATE pr_skills SET skill_rank = '".$rank."' WHERE skill_ID = '".$number."'");

	}

	if(strpos($line, "row typeName=")>0)
	{
		//parse this line.
		//print($line);
		$tmp = substr($line,25);
		$end = strpos($tmp,"\"");
		$name = substr($tmp,0,$end);
		$start = strpos($line,"typeID=");
		$tmp = substr($line,$start+8);
		$end = strpos($tmp, "\"");
		$skill = substr($tmp,0,$end);
	}

}
//print("-->");
?>