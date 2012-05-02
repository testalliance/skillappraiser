<?php

SESSION_START();
require_once('dbconfig.php');

function encode($string,$key) {
	$key = sha1($key);
	$strLen = strlen($string);
	$keyLen = strlen($key);
	
	for ($i = 0; $i < $strLen; $i++) {
		$ordStr = ord(substr($string,$i,1));
		if ($j == $keyLen) { $j = 0; }
		$ordKey = ord(substr($key,$j,1));
		$j++;
		$hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
	}
	return $hash;
}

function decode($string,$key) {
	$key = sha1($key);
	$strLen = strlen($string);
	$keyLen = strlen($key);

	for ($i = 0; $i < $strLen; $i+=2) {
		$ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
		if ($j == $keyLen) { $j = 0; }
		$ordKey = ord(substr($key,$j,1));
		$j++;
		$hash .= chr($ordStr - $ordKey);
	}
	return $hash;
}

function skilladd($skillID, $level = 1)
{
	$funcresult = "";
	$query = "SELECT * FROM pr_skills WHERE skill_ID = ".$skillID."";
	$res_skill = MySQL_QUERY($query);
	$arr_skill = MySQL_FETCH_ARRAY($res_skill);
	//Add it's prereqs
	$query = "SELECT * FROM pr_prereq WHERE prereq_skill = ".$skillID."";
	$res_req = MySQL_QUERY($query);
	while($arr_req = MySQL_FETCH_ARRAY($res_req)) {
		$funcresult .= skilladd($arr_req["prereq_reqskill"],$arr_req["prereq_reqlevel"]);
	}

	//Add this skill
	if(!isset($_SESSION["skilllvl"][$skillID])) {
		$funcresult .= ("<TR><TD>".$skillID.":</TD>");
		$_SESSION["skilllvl"][$skillID] = $level;
		$query = "SELECT * FROM pr_skills WHERE skill_ID = ".$skillID."";
		$res_skill = MySQL_QUERY($query);
		$arr_skill = MySQL_FETCH_ARRAY($res_skill);
		$funcresult .= ("<TD>ADDED:</TD><TD>SKILL</TD><TD>".$arr_skill["skill_name"]."</TD><TD>level ".$level."</TD></TR>");
		$_SESSION["skillchange"][$skillID] = 1;
	} elseif($_SESSION["skilllvl"][$skillID] < $level) {
		$funcresult .= ("<TR><TD>".$skillID.":</TD>");
		$_SESSION["skilllvl"][$skillID] = $level;
		$query = "SELECT * FROM pr_skills WHERE skill_ID = ".$skillID."";
		$res_skill = MySQL_QUERY($query);
		$arr_skill = MySQL_FETCH_ARRAY($res_skill);
		$funcresult .= ("<TD>CHANGED:</TD><TD>SKILL</TD><TD>".$arr_skill["skill_name"]."</TD><TD>level ".$level."</TD></TR>");
		if(!isset($_SESSION["skillchange"][$skillID])) {
			$_SESSION["skillchange"][$skillID] = 2;
		}
	}

	return($funcresult);
}

function skilldel($skillID) {
	$funcresult = "";
	$query = "SELECT * FROM pr_skills WHERE skill_ID = ".$skillID."";
	$res_skill = MySQL_QUERY($query);
	$arr_skill = MySQL_FETCH_ARRAY($res_skill);
	//Del it's prereqs
	$query = "SELECT * FROM pr_prereq WHERE prereq_reqskill = ".$skillID."";
	$res_req = MySQL_QUERY($query);
	while($arr_req = MySQL_FETCH_ARRAY($res_req)) {
		if(isset($_SESSION["skilllvl"][$arr_req["prereq_skill"]])) {
			$funcresult .= skilldel($arr_req["prereq_skill"]);
		}
		$_POST["override"][$arr_req["prereq_skill"]] = 1;
	}
	$funcresult .= ("<TR><TD>".$skillID.":</TD>");

	//Del this skill
	unset($_SESSION["skilllvl"][$skillID]);
	$query = "SELECT * FROM pr_skills WHERE skill_ID = ".$skillID."";
	$res_skill = MySQL_QUERY($query);
	$arr_skill = MySQL_FETCH_ARRAY($res_skill);
	$funcresult .= ("<TD>REMOVED:</TD><TD>SKILL</TD><TD>".$arr_skill["skill_name"]."</TD><TD></TD></TR>");
	return($funcresult);
}

function skillchange($skillID, $level) {
	$funcresult = "";
	$query = "SELECT * FROM pr_skills WHERE skill_ID = ".$skillID."";
	$res_skill = MySQL_QUERY($query);
	$arr_skill = MySQL_FETCH_ARRAY($res_skill);
	//Del it's prereqs
	$query = "SELECT * FROM pr_prereq WHERE prereq_reqskill = ".$skillID." AND prereq_reqlevel > ".$level."";
	$res_req = MySQL_QUERY($query);
	while($arr_req = MySQL_FETCH_ARRAY($res_req)) {
		if(isset($_SESSION["skilllvl"][$arr_req["prereq_skill"]])) {
			$funcresult .= skilldel($arr_req["prereq_skill"]);
		}
		$_POST["override"][$arr_req["prereq_skill"]] = 1;
	}
	$funcresult .= ("<TR><TD>".$skillID.":</TD>");

	//Del this skill
	$query = "SELECT * FROM pr_skills WHERE skill_ID = ".$skillID."";
	$res_skill = MySQL_QUERY($query);
	$arr_skill = MySQL_FETCH_ARRAY($res_skill);
	$funcresult .= ("<TD>CHANGED:</TD><TD>SKILL</TD><TD>".$arr_skill["skill_name"]."</TD><TD>level ".$level."</TD></TR>");
	if(!isset($_SESSION["skillchange"][$skillID])){
		$_SESSION["skillchange"][$skillID] = 2;
	}

	return($funcresult);
}


function certificateadd($certificateID)
{
	$funcresult = "";
	$query = "SELECT * FROM pr_certificates WHERE certificate_ID = ".$certificateID."";
	$res_certificate = MySQL_QUERY($query);
	$arr_certificate = MySQL_FETCH_ARRAY($res_certificate);
	//Add it's prereqs
	$query = "SELECT * FROM pr_certreq WHERE certreq_certificate = ".$certificateID."";
	$res_req = MySQL_QUERY($query);
	while($arr_req = MySQL_FETCH_ARRAY($res_req)) {
		$funcresult .= certificateadd($arr_req["certreq_requirement"]);
	}
	$query = "SELECT * FROM pr_certskills WHERE certskill_certificate = ".$certificateID."";
	$res_req = MySQL_QUERY($query);
	while($arr_req = MySQL_FETCH_ARRAY($res_req)) {
		$funcresult .= skilladd($arr_req["certskill_skill"],$arr_req["certskill_level"]);
	}
	if($funcresult != '') {
		$funcresult .= ("<TR><TD>".$certificateID.":</TD>");
		$funcresult .= ("<TD>ADDED:</TD><TD>CERTIFICATE</TD><TD>".$arr_certificate["certificate_name"]."</TD><TD>");
		if($arr_certificate["certificate_grade"]==1)$funcresult .= ("Basic");
		if($arr_certificate["certificate_grade"]==2)$funcresult .= ("Standard");
		if($arr_certificate["certificate_grade"]==3)$funcresult .= ("Advanced");
		if($arr_certificate["certificate_grade"]==5)$funcresult .= ("Elite");
		$funcresult .= ("</TD></TR>");
	}
	return($funcresult);
}

function getmodID($itemname) {
	/*
	182 reqskill1
	183 reqskill2
	184 reqskill3

	277 level1
	278 level2
	279 level3
	*/
	$query = "SELECT * FROM invTypes WHERE typeName = \"".$itemname."\"";
	$res_item = MySQL_QUERY($query);
	if($arr_item = MySQL_FETCH_ARRAY($res_item)) {
		return($arr_item["typeID"]);
	}
	return(0);
}

function getskill($itemID,$type) {
	/*
	182 reqskill1
	183 reqskill2
	184 reqskill3

	277 level1
	278 level2
	279 level3
	*/

	$query = "SELECT * FROM dgmTypeAttributes WHERE typeID = '".$itemID."' AND attributeID = '".$type."'";
	$res_att = MySQL_QUERY($query);
	if($arr_att = MySQL_FETCH_ARRAY($res_att)) {
		return($arr_att["valueInt"]);
	}
	return(0);
}
?>