<?php
$browser = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
		if(strpos($browser, "EVE-IGB")>0)
		{
$ingame = 1;
}else{
$ingame = 0;
}
MySQL_CONNECT("localhost","Username","Password");
MySQL_SELECT_DB("DataBase");

if(isset($_POST["test"]))
{
if(substr($_POST["test"],0,strlen("http://eveboard.com/pilot/"))=="http://eveboard.com/pilot/")
{
$contents = file ( $_POST["test"]);
$spnext = 0;
$secnext = 0;
$implantpart = 0;
foreach($contents as $line)
{
if($spnext == 1)
{
$tmp = substr($line,47);
$end = strpos($tmp," of");
$sp = substr($tmp,0,$end);
$sp = str_replace(",","",$sp);
//print($name.": ".$sp."<BR>");
$result = MySQL_QUERY("SELECT * FROM pr_skills WHERE skill_name = '".$name."'");
$array = MySQL_FETCH_ARRAY($result);
$ID = $array["skill_ID"];
$skill[$ID] = $sp;
//print($ID.": ".$sp."<BR>");
$spnext = 0;
}
if(strpos($line, "http://avatars.eve-search.com/")>0 && (!isset($charid) || empty($charid)))
{
$start = strpos($line,"http://avatars.eve-search.com/");
$tmp = substr($line,$start+41);
$end = strpos($tmp,"&amp;");
$charid = substr($tmp,0,$end);
}
if(strpos($line, "height=\"20\" colspan=\"2\" align=\"left\" bgcolor=\"#292929\" class=\"title\">")>0)
{
$start = strpos($line,">");
$tmp = substr($line,$start+1);
$end = strpos($tmp,"<");
$charname = substr($tmp,0,$end);

}
if(strpos($line, "<td height=\"20\" class=\"dotted\" style=\"\">")>0)
{
$tmp = substr($line,70);
$end = strpos($tmp," /");
$name = substr($tmp,0,$end);
$spnext = 1;
}
if(strpos($line, "<strong>Implants</strong>")>0)
{
$implantpart = 1;
}
if($implantpart == 1)
{
if(strpos($line, "align=\"left\" bgcolor=\"#000000\" class=\"size10\">")>0)
{
$start = strpos($line,">");
$tmp = substr($line,$start+1);
$end = strpos($tmp,"(");
$implantname = substr($tmp,0,$end);
if(!empty($implantname))
{
$implantlist[$implantamount]=$implantname;
//print("<HR>".$implantname."<HR>");
$implantamount++;
}
}
}
if(strpos($line, "<strong>Training</strong>")>0)
{
$implantpart = 0;
}

if(strpos($line, "<td height=\"20\" class=\"dotted\" style=\"\"><span style=\"color: #FFCC00;\">")>0)
{
$tmp = substr($line,100);
$end = strpos($tmp," /");
$name = substr($tmp,0,$end);
$spnext = 1;
}
if($secnext == 1)
{
$tmp = substr($line,53);
$end = strpos($tmp,"<");
$secstatus = substr($tmp,0,$end);
$secnext = 0;
}
if(strpos($line, "Security Status")>0)
{
$secnext = 1;
}
}
}else{
unset($_POST["test"]);
}
}

//First check for POST and GET values
if(isset($_POST["userID"]))
{
	if(isset($_POST["characterID"]))
	{
		$phase = 3;	
	}else{
		$phase = 2;
	}
}else{
	$phase = 1;
}
if(isset($_POST["test"]))
{
$phase = 3;
}
if($phase == 1)
{
	include("GemberslaafjeContent.php");
}
if($phase == 2)
{

}
if($phase == 3)
{
	$contents = file ( "http://api.eve-online.com/char/CharacterSheet.xml.aspx?userID=".$_POST["userID"]."&apiKey=".$_POST["apiKey"]."&characterID=".$_POST["characterID"]."" );
	$contents2 = file ( "http://api.eve-online.com/eve/CharacterInfo.xml.aspx?userID=".$_POST["userID"]."&apiKey=".$_POST["apiKey"]."&characterID=".$_POST["characterID"]."" );
}

if($phase == 1 )
{
	$charname = "Gemberslaafje";
	$charid = "1199002469";
}
if($phase == 3 && !isset($_POST["test"]))
{
	if($_POST["characterID"]== $_POST["cID1"])
	{
		$charname = $_POST["cName1"];
		$charid = $_POST["cID1"];
	}
	if($_POST["characterID"]== $_POST["cID2"])
	{
		$charname = $_POST["cName2"];
		$charid = $_POST["cID2"];
	}
	if($_POST["characterID"]== $_POST["cID3"])
	{
		$charname = $_POST["cName3"];
		$charid = $_POST["cID3"];
	}
}

if($phase == 1)
{
	$title = "EVE Character Appraiser";
}
if($phase == 2)
{
	$title = "EVE Character Appraiser - Please select your character";
}
if($phase == 3)
{
	$title = "EVE Character Appraiser - ".$charname;
}

if($phase == 1 || $phase == 3)
{
$result = MySQL_QUERY("SELECT * FROM pr_counter");
$array = MySQL_FETCH_ARRAY($result);
$count = $array["counter"];
	$introduction = "Fill out the form below to find out what you are worth. It’s completely free, and your API key will not be stored at all.<P>
		<FORM METHOD=POST><TABLE STYLE=\"width:70%;\">
		<TR><TD STYLE=\"width:30%; font-family:verdana; font-size:11px; background-color:#2c2c38; color:#ffffff;\">
		<TABLE STYLE=\"font-family:verdana; font-size:11px; background-color:#2c2c38; color:#ffffff;\">
		<TR><TD>User ID</TD><TD><INPUT TYPE=text NAME=userID></TD></TR>\n
		<TR><TD>API Key</TD><TD><INPUT TYPE=text NAME=apiKey></TD></TR>\n
		<TR><TD></TD><TD><INPUT TYPE=SUBMIT VALUE=\"Appraise me!\"></TD></TR>\n
		</TABLE></FORM>
		</TD><TD STYLE=\"font-family:verdana; font-size:11px; background-color:#2c2c38; color:#ffffff;\">
		You can find your user ID and API key at:<BR>
		<A target=_BLANK href=http://www.eveonline.com/api/default.asp>http://www.eveonline.com/api/default.asp</A>
		</TD></TR>\n
		</TABLE>Already appraised ".$count." characters!<BR>";
		$query = "SELECT COUNT(*) AS mycount FROM pr_latest";
		$result = MySQL_QUERY($query);
		$arr_latest = MySQL_FETCH_ASSOC($result);
		$unique = $arr_latest['mycount'];
		$introduction .= $unique." unique Character ID's in the database.<P>";
		$introduction .= "TOP 3 MOST VALUE FOR ISK:<BR>";
		$introduction .= "<TABLE><TR>";
		$query = "SELECT * FROM pr_latest ORDER BY latest_avgvalue DESC LIMIT 3";
		$result = MySQL_QUERY($query);
		$rank = 1;
		WHILE($arr_latest = MySQL_FETCH_ARRAY($result))
		{
			if($arr_latest["latest_name"]=="")
			{
				$idtoname = file ( "http://api.eve-online.com/eve/CharacterName.xml.aspx?ids=".$arr_latest["latest_ID"] );
				foreach($idtoname as $line)
				{
					if(strpos($line, "<row ")>0)
					{

						$start = strpos($line,"name=");
						$tmp = substr($line,$start+6);
						$end = strpos($tmp, "\"");
						$newcharname = substr($tmp,0,$end);
						MySQL_QUERY("UPDATE pr_latest SET latest_name = '".$newcharname."' WHERE latest_ID = '".$arr_latest["latest_ID"]."'");
						$arr_latest["latest_name"] = $newcharname;
						break;
					}
				}
			}
			$topcharname[$rank] = $arr_latest["latest_name"];
			$topcharid[$rank] = $arr_latest["latest_ID"];
			$topcharvalue[$rank] = $arr_latest["latest_avgvalue"];
			$rank++;
		}
		$introduction .= "<TD><CENTER><img width=75 src=\"http://image.eveonline.com/Character/".$topcharid[2]."_256.jpg\"><BR>2. ".$topcharname[2]."<BR>(".$topcharvalue[2]." ISK PER SP)</CENTER></TD>";
		$introduction .= "<TD><CENTER><img width=100 src=\"http://image.eveonline.com/Character/".$topcharid[1]."_256.jpg\"><BR>1. ".$topcharname[1]."<BR>(".$topcharvalue[1]." ISK PER SP)</CENTER></TD>";
		$introduction .= "<TD><CENTER><img width=50 src=\"http://image.eveonline.com/Character/".$topcharid[3]."_256.jpg\"><BR>3. ".$topcharname[3]."<BR>(".$topcharvalue[3]." ISK PER SP)</CENTER></TD>";
		$introduction .= "</TR></TABLE>";
		$introduction .= "<P><B>Latest 10 mugshots appraised:</B><BR>";

		$query = "SELECT * FROM pr_latest ORDER BY latest_timestamp DESC LIMIT 10";
		$result = MySQL_QUERY($query);
		while($arr_latest = MySQL_FETCH_ARRAY($result))
		{
			$introduction.="<img style=\"border:solid white 1px;\" src=\"http://image.eveonline.com/Character/".$arr_latest["latest_ID"]."_64.jpg\">";
		}
		$introduction.="<P><b>EVEBOARD appraiser</B><P>";
		$introduction.="You can now appraise characters from EVEBoard. Please include the FULL URL in the next form:<P><FORM METHOD=POST>";
		$introduction.="URL: <INPUT TYPE=text NAME=test><INPUT TYPE=SUBMIT VALUE='Appraise him!'></FORM>";
}
if($phase == 2)
{
	//Load API characters file 
	$contents = file ( "http://api.eve-online.com/account/Characters.xml.aspx?userID=".$_POST["userID"]."&apiKey=".$_POST["apiKey"]."" );
	$introduction = "Choose the character you want to appraise:<BR>Nothing to choose from? Your userID or api Key was propably wrong! Use the Back button to try again...<BR><FORM METHOD=POST><SELECT NAME='characterID'>";
	$t = 0;
	foreach($contents as $line)
	{
		if(strpos($line, "row name=")>0)
		{
			//parse this line.
			$tmp = substr($line,17);
			$end = strpos($tmp,"\"");
			$name = substr($tmp,0,$end);
			$start = strpos($line,"characterID=");
			$tmp = substr($line,$start+13);
			$end = strpos($tmp, "\"");
			$ID = substr($tmp,0,$end);
			$introduction .= "<OPTION VALUE='".$ID."'>".$name."</OPTION>";
			$cID[$t] = $ID;
			$cName[$t] = $name;
			$t++;
		}
	}
	$introduction .= "</SELECT>";
	$introduction .= "<INPUT TYPE=HIDDEN NAME=cID1 VALUE='".$cID[0]."'>";
	$introduction .= "<INPUT TYPE=HIDDEN NAME=cID2 VALUE='".$cID[1]."'>";
	$introduction .= "<INPUT TYPE=HIDDEN NAME=cID3 VALUE='".$cID[2]."'>";
	$introduction .= "<INPUT TYPE=HIDDEN NAME=cName1 VALUE='".$cName[0]."'>";
	$introduction .= "<INPUT TYPE=HIDDEN NAME=cName2 VALUE='".$cName[1]."'>";
	$introduction .= "<INPUT TYPE=HIDDEN NAME=cName3 VALUE='".$cName[2]."'>";
	$introduction .= "<INPUT TYPE=HIDDEN NAME=userID VALUE='".$_POST["userID"]."'>";
	$introduction .= "<INPUT TYPE=HIDDEN NAME=apiKey VALUE='".$_POST["apiKey"]."'>";
	$introduction .= "<INPUT TYPE=SUBMIT VALUE='Lets go!'></FORM>";
}
if($phase == 3)
{
	mySQL_QUERY("UPDATE pr_counter SET counter = counter + 1");
}
if($phase == 1 || $phase == 3)
{
if(!isset($_POST["test"]))
{	foreach($contents2 as $line)
	{
		if(strpos($line, "<securityStatus>")>0)
		{
			$tmp = substr($line,20);
			$end = strpos($tmp,"<");
			$secstatus = substr($tmp,0,$end);
			break;
		}
	}

	foreach($contents as $line)
	{
		if(strpos($line, "<augmentatorName>")>0)
		{
			$tmp = substr($line,25);
			$end = strpos($tmp,"<");
			$implant = substr($tmp,0,$end);
			$implantlist[$implantamount] = $implant;
			$implantamount++;
		}
		if(strpos($line, "row typeID=")>0)
		{
			$tmp = substr($line,19);
			$end = strpos($tmp,"\"");
			$ID = substr($tmp,0,$end);
			$start = strpos($line,"skillpoints=");
			$tmp = substr($line,$start+13);
			$end = strpos($tmp, "\"");
			$points = substr($tmp,0,$end);
			$skill[$ID] = $points;
		}
	}
}
	foreach($skill as $id => $points)
	{
		$res_skills = MySQL_QUERY("SELECT * FROM pr_skills WHERE skill_ID = ".$id."");
		$arr_skills = MySQL_FETCH_ARRAY($res_skills);
		
		$res_categories = MySQL_QUERY("SELECT * FROM pr_categories WHERE category_ID = ".$arr_skills["skill_category"]."");
		$arr_categories = MySQL_FETCH_ARRAY($res_categories);

		$categories[$arr_skills["skill_category"]] += $points;
		$categoriesperc[$arr_skills["skill_category"]] += ($points/$arr_categories["category_max"]);
		$skilllist[$id] = $arr_skills["skill_name"];
		$catlist[$id] = $arr_skills["skill_category"];
		$skillpts[$id] = $points;
		$bookprice[$id] = $arr_skills["skill_price"];
		if($arr_skills["skill_category"] == 4 || $arr_skills["skill_category"] == 5 || $arr_skills["skill_category"] == 6 || $arr_skills["skill_category"] == 7 || $arr_skills["skill_category"] == 8 || $arr_skills["skill_category"] == 9 || $arr_skills["skill_category"] == 21)
		{
			$combat += ($points/$arr_categories["category_max"]);
		}
		if($arr_skills["skill_category"] == 12 || $arr_skills["skill_category"] == 13 || $arr_skills["skill_category"] == 14 || $arr_skills["skill_category"] == 15 || $arr_skills["skill_category"] == 16 || $arr_skills["skill_category"] == 17 || $arr_skills["skill_category"] == 18 || $arr_skills["skill_category"] == 22)
		{
			$industry += ($points/$arr_categories["category_max"]);
		}
		$baseprice += $arr_skills["skill_price"];
	}
	for($cats = 0; $cats < 50; $cats++)
	{
		if(!isset($categories[$cats]))
		{
			$categories[$cats]=1;
		}
	}
	if($secstatus >= 2.5)$secval = 1.01;
	if($secstatus >= 0 && $secstatus < 2.5)$secval = 1.00;
	if($secstatus >= -2 && $secstatus < 0)$secval = 0.99;
	if($secstatus >= -4 && $secstatus < -2)$secval = 0.98;
	if($secstatus >= -6 && $secstatus < -4)$secval = 0.96;
	if($secstatus >= -8 && $secstatus < -6)$secval = 0.94;
	if($secstatus >= -10 && $secstatus < -8)$secval = 0.90;
	$combatpart = $combat / ($combat + $industry);
	$industrypart = $industry / ($combat + $industry);
	$PvPpart = $categoriesperc[4] / ($categoriesperc[4]+$categoriesperc[5]);
	$PvEpart = $categoriesperc[5] / ($categoriesperc[4]+$categoriesperc[5]);
	$Caldaripart = $categoriesperc[6] / ($categoriesperc[6]+$categoriesperc[7]+$categoriesperc[8]+$categoriesperc[9]);
	$Gallentepart = $categoriesperc[7] / ($categoriesperc[6]+$categoriesperc[7]+$categoriesperc[8]+$categoriesperc[9]);
	$Amarrpart = $categoriesperc[8] / ($categoriesperc[6]+$categoriesperc[7]+$categoriesperc[8]+$categoriesperc[9]);
	$Minmatarpart = $categoriesperc[9] / ($categoriesperc[6]+$categoriesperc[7]+$categoriesperc[8]+$categoriesperc[9]);

	$minhaulpart = ($categoriesperc[12]+$categoriesperc[13]) / ($categoriesperc[12]+$categoriesperc[13]+$categoriesperc[14]+$categoriesperc[15]+$categoriesperc[16]+$categoriesperc[17]);
	$resmanupart = ($categoriesperc[14]+$categoriesperc[15]) / ($categoriesperc[12]+$categoriesperc[13]+$categoriesperc[14]+$categoriesperc[15]+$categoriesperc[16]+$categoriesperc[17]);
	$tradepart = ($categoriesperc[16]) / ($categoriesperc[12]+$categoriesperc[13]+$categoriesperc[14]+$categoriesperc[15]+$categoriesperc[16]+$categoriesperc[17]);
	$planetpart = ($categoriesperc[17]) / ($categoriesperc[12]+$categoriesperc[13]+$categoriesperc[14]+$categoriesperc[15]+$categoriesperc[16]+$categoriesperc[17]);

	$combatprice = 250 * (1-((1 - $combatpart)/2));
	$industryprice = 250 * (1-((1 - $industrypart)/2));

	$pricecat[1] = 375;
	$pricecat[2] = 225;
	$pricecat[3] = 225;
	$pricecat[4] = $combatprice * (1-((1 - $PvPpart)/2));
	$pricecat[5] = $combatprice * (1-((1 - $PvEpart)/2));
	$pricecat[6] = $combatprice * (1-((1 - $Caldaripart)/3));
	$pricecat[7] = $combatprice * (1-((1 - $Gallentepart)/3));
	$pricecat[8] = $combatprice * (1-((1 - $Amarrpart)/3));
	$pricecat[9] = $combatprice * (1-((1 - $Minmatarpart)/3));
	$pricecat[10] = 250;
	$pricecat[11] = 250;
	$pricecat[12] = $industryprice * (1-((1 - $minhaulpart)/3));
	$pricecat[13] = $industryprice * (1-((1 - $minhaulpart)/3));
	$pricecat[14] = $industryprice * (1-((1 - $resmanupart)/3));
	$pricecat[15] = $industryprice * (1-((1 - $resmanupart)/3));
	$pricecat[16] = $industryprice * (1-((1 - $tradepart)/3));
	$pricecat[17] = $industryprice * (1-((1 - $planetpart)/3));
	$pricecat[18] = $industryprice;
	$pricecat[19] = 225;
	$pricecat[20] = 250;
	$pricecat[21] = $combatprice;
	$pricecat[22] = $industryprice;
	$pricecat[23] = 225;
	$pricecat[24] = 225;
	$pricecat[25] = 225;
	$pricecat[26] = 225;
	$pricecat[27] = 225;
	$pricecat[28] = 225;
	$implanttotalprice = 0;

	$totprice = 0;
	$totsp = 0;
	$lvl5cruiser = 0.98;
	$amacruiser = 0;
	$galcruiser = 0;
	$mincruiser = 0;
	$calcruiser = 0;

	if($skillpts[3332]==1280000)
	{
		$lvl5cruiser+=0.02;
		$galcruiser = 1;
	}
	if($skillpts[3333]==1280000)
	{
		$lvl5cruiser+=0.02;
		$mincruiser = 1;
	}
	if($skillpts[3334]==1280000)
	{
		$lvl5cruiser+=0.02;
		$calcruiser = 1;
	}
	if($skillpts[3335]==1280000)
	{
		$lvl5cruiser+=0.02;
		$amacruiser = 1;
	}
	if($lvl5cruiser < 1) $lvl5cruiser = 1;
	if($implantamount > 0)
	{
		$implanttext = "<TABLE WIDTH=600 STYLE=\"font-family:verdana; font-size:11px; background-color:#2c2c38; color:#ffffff;\"><TR><TD ALIGN=center><B>Implant</B></TD><TD ALIGN=center><B>Value</B></TD></TR>\n";
		foreach($implantlist as $implant)
		{
			$res_implants = MySQL_QUERY("SELECT * FROM pr_implants WHERE implant_name = '".$implant."'");
			$arr_implants = MySQL_FETCH_ARRAY($res_implants);
			$implanttotalprice += $arr_implants["implant_price"];
			$implanttext .= "<TR><TD>".$implant."</TD><TD ALIGN=right>".number_format ($arr_implants["implant_price"], 2 , '.' , ',' )." ISK</TD></TR>\n";
		}
		$implanttext .= "</TABLE>";
	}
	$skilllisttoencode = chr(134);
	$skilltext = "<TABLE WIDTH=600 STYLE=\"font-family:verdana; font-size:11px; background-color:#2c2c38; color:#ffffff;\"><TR><TD><b>Category</b></TD><TD ALIGN=center><b>Skill Points</B></TD><TD ALIGN=center><b>Of Total</b></TD><TD ALIGN=center><b>Price</b></TD></TR>\n";
	if($_GET["sort"]=="SP" || !isset($_GET["sort"]))
	{
		foreach($categories as $id => $points)
		{
			if($points > 1)
			{
				$catprice[$id] = $points * $pricecat[$id];
			}
		}
		arsort($catprice);
		asort($skilllist);
		$grandtotalsp = 0;
		foreach($catprice as $id => $price)
		{
			if($categories[$id] > 1)
			{
				$res_categories = MySQL_QUERY("SELECT * FROM pr_categories WHERE category_ID = ".$id."");
				$arr_categories = MySQL_FETCH_ARRAY($res_categories);
				$grandtotalsp += $arr_categories["category_max"];
				$points = $categories[$id];
				$totprice += $price;
				$totsp += $points;
				$skilltext .= "<TR><TD onmouseover=\"this.style.textDecoration='underline'\" onmouseout=\"this.style.textDecoration='none'\" style=\"cursor:pointer\" onclick=\"toggle('cat".$id."')\"><span id='cat".$id."_minus' style=\"display:none;\"> - </span><span id='cat".$id."_plus'> + </span>".$arr_categories["category_name"]."</TD><TD ALIGN=right>".number_format ($points, 2 , '.' , ',' )." SP</TD><TD ALIGN=right>(".number_format (($points/$arr_categories["category_max"])*100, 2 , '.' , ',' )." %)</TD><TD ALIGN=right>".number_format ($price, 2 , '.' , ',' )." ISK</TD></TR>\n<TR id='cat".$id."' style=\"display:none;\"><TD COLSPAN=4><CENTER><TABLE WIDTH=90% STYLE=\"font-size:10px;\"><TR><TD><b>Skill</B></TD><TD ALIGN=center><b>SkillPoints</b></TD><TD ALIGN=center><B>Skill Book Price</B></TD></TR>\n";
				foreach($skilllist as $sid => $name)
				{
					if($catlist[$sid]==$id)
					{
						$level = 0;
						$result = MySQL_QUERY("SELECT * FROM pr_skills WHERE skill_ID = ".$sid."");
						$arr_skill = MySQL_FETCH_ARRAY($result);
						$res2 = MySQL_QUERY("SELECT * FROM pr_ranklevel WHERE ranklevel_rank = '".$arr_skill["skill_rank"]."' AND ranklevel_sp <= ".($skillpts[$sid] + 5)." ORDER BY ranklevel_sp DESC");
						$arr_rank = MySQL_FETCH_ARRAY($res2);
						if(isset($arr_rank["ranklevel_level"]))
						{
						$level = $arr_rank["ranklevel_level"];
						}
						if($ingame)
						{
							$skilltext .= "<TR><TD onmouseover=\"this.style.textDecoration='underline'\" onmouseout=\"this.style.textDecoration='none'\" style=\"cursor:pointer\" onclick=\"CCPEVE.showInfo(".$sid.")\">- ".$name."(Level ".$level.")</TD><TD ALIGN=right>".number_format ($skillpts[$sid], 2 , '.' , ',' )." SP</TD><TD ALIGN=right>".number_format ($bookprice[$sid], 2 , '.' , ',' )." ISK</TD></TR>\n";
						}else{
							$skilltext .= "<TR><TD>- ".$name."(Level ".$level.")</TD><TD ALIGN=right>".number_format ($skillpts[$sid], 2 , '.' , ',' )." SP</TD><TD ALIGN=right>".number_format ($bookprice[$sid], 2 , '.' , ',' )." ISK</TD></TR>\n";
						}
						$value1 = $sid / 256;
						$value2 = $sid % 256;
						$value3 = $level;
						$skilllisttoencode .= chr($value1).chr($value2).chr($value3);
					}
				}
				$skilltext .= "</TABLE></CENTER></TD></TR>\n";
			}
		}
	}
	if($_GET["sort"]=="cat")
	{
		asort($skilllist);
		$res_categories = MySQL_QUERY("SELECT * FROM pr_categories ORDER BY category_name");
		WHILE($arr_categories = MySQL_FETCH_ARRAY($res_categories))
		{
			$id = $arr_categories["category_ID"];
			$name = $arr_categories["category_name"];
			$points = $categories[$id];
			if($points > 1)
			{
				$price = $points * $pricecat[$id];
				$totprice += $price;
				$totsp += $points;
				$skilltext .= "<TR><TD style=\"cursor:pointer\" onclick=\"toggle('cat".$id."')\">".$arr_categories["category_name"]."</TD><TD ALIGN=right>".number_format ($points, 2 , '.' , ',' )." SP</TD><TD ALIGN=right>".number_format ($price, 2 , '.' , ',' )." ISK</TD></TR>\n<TR id='cat".$id."' style=\"display:none;\"><TD COLSPAN=3><HR><TABLE WIDTH=100%><TR><TD><b>Skill</B></TD><TD ALIGN=center><b>SkillPoints</b></TD><TD ALIGN=center><B>Skill Book Price</B></TD></TR>\n";
				foreach($skilllist as $sid => $name)
				{
					if($catlist[$sid]==$id)
					{
						$skilltext .= "<TR><TD>- ".$name."</TD><TD ALIGN=right>".number_format ($skillpts[$sid], 2 , '.' , ',' )." SP</TD><TD ALIGN=right>".number_format ($bookprice[$sid], 2 , '.' , ',' )." ISK</TD></TR>\n";
					}
				}
				$skilltext .= "<HR></TABLE></TD></TR>\n";
			}
		}
	}

	$lazysp = $totsp;
	$spdecline = 1.04;
	if($totsp < 70000000)
	{
		while($lazysp > 0)
		{
			$spdecline -= 0.02;
			$lazysp -= 10000000;
		}
		if($spdecline > 1)$spdecline = 1;
	}else{
		$spdecline = 1.00;
		$lazysp -= 70000000;
		while($lazysp > 0)
		{
			$spdecline += 0.01;
			$lazysp -= 1500000;
		}
	}
	$skilltext .= "<TR><TD></TD><TD></TD><TD><HR></TD><TD><HR></TD></TR>\n";
	$skilltext .= "<TR><TD>Basic Total Value: </TD><TD ALIGN=right>".number_format ($totsp, 2 , '.' , ',' )." SP</TD><TD ALIGN=right>(".number_format (($totsp/$grandtotalsp)*100, 2 , '.' , ',' )." %)</TD><TD ALIGN=right>".number_format ($totprice, 2 , '.' , ',' )." ISK</TD></TR>\n";
	$skilltext .= "<TR><TD>Base Skillbook Price: </TD><TD></TD><TD></TD><TD ALIGN=right>".number_format ($baseprice, 2 , '.' , ',' )." ISK</TD></TR>\n";
	if($implanttotalprice > 0)$skilltext .= "<TR><TD>Implants: </TD><TD></TD><TD></TD><TD ALIGN=right>".number_format ($implanttotalprice, 2 , '.' , ',' )." ISK</TD></TR>\n";
	if($spdecline > 1)$skilltext .= "<TR><TD>>70m SP Modifier: </TD><TD></TD><TD></TD><TD ALIGN=right>".number_format ((($baseprice + $totprice)*$spdecline) - ($baseprice + $totprice), 2 , '.' , ',' )." ISK</TD></TR>\n";
	if($spdecline < 1)$skilltext .= "<TR><TD>>20m <70m SP Modifier: </TD><TD></TD><TD></TD><TD ALIGN=right>".number_format ((($baseprice + $totprice)*$spdecline) - ($baseprice + $totprice), 2 , '.' , ',' )." ISK</TD></TR>\n";
	if($lvl5cruiser > 1)$skilltext .= "<TR><TD>Level 5 Cruiser Modifier: </TD><TD></TD><TD></TD><TD ALIGN=right>".number_format ((($baseprice + $totprice)*$lvl5cruiser) - ($baseprice + $totprice), 2 , '.' , ',' )." ISK</TD></TR>\n";
	if($secval > 1)$skilltext .= "<TR><TD>High Sec Status Modifier: </TD><TD></TD><TD></TD><TD ALIGN=right>".number_format ((($baseprice + $totprice)*$secval) - ($baseprice + $totprice), 2 , '.' , ',' )." ISK</TD></TR>\n";
	if($secval < 1)$skilltext .= "<TR><TD>Pirate Modifier: </TD><TD></TD><TD></TD><TD ALIGN=right>".number_format ((($baseprice + $totprice)*$secval) - ($baseprice + $totprice), 2 , '.' , ',' )." ISK</TD></TR>\n";

	$skilltext .= "<TR><TD></TD><TD></TD><TD></TD><TD><HR></TD></TR>\n";
	$skilltext .= "<TR><TD>Total Value: </TD><TD></TD><TD ALIGN=right></TD><TD ALIGN=right>".number_format ((((($baseprice + $totprice)*$secval)*$lvl5cruiser)*$spdecline) + $implanttotalprice, 2 , '.' , ',' )." ISK</TD></TR>\n</TABLE>";

	$finalSP = number_format ($totsp, 2 , '.' , ',' );

	$finalvalue = number_format ((((($baseprice + $totprice)*$secval)*$lvl5cruiser)*$spdecline) + $implanttotalprice, 2 , '.' , ',' );
	$avgspvalue = number_format (((((($baseprice + $totprice)*$secval)*$lvl5cruiser)*$spdecline) + $implanttotalprice)/$totsp, 2 , '.' , ',' );
	if(isset($_POST["characterID"])|| isset($_POST["test"]))
	{
		$query_latestcheck = "SELECT * FROM pr_latest WHERE latest_ID = '".$charid."';";
		$res_latestcheck = MySQL_QUERY($query_latestcheck);
		$indatabase = MySQL_NUM_ROWS($res_latestcheck);
		if(!$indatabase)
		{
		if($totsp > 1000000)
		{
			$query = "INSERT INTO pr_latest(latest_ID, latest_timestamp, latest_avgvalue)VALUES(".$charid.",".time().",'".$avgspvalue."')";
			MySQL_QUERY($query);
		}else{
			$query = "INSERT INTO pr_latest(latest_ID, latest_timestamp, latest_avgvalue)VALUES(".$charid.",".time().",'0')";
			MySQL_QUERY($query);
		}
		}else{
		if($totsp > 1000000)
		{
			$query = "UPDATE pr_latest SET latest_timestamp = ".time().", latest_avgvalue = '".$avgspvalue."' WHERE latest_ID = '".$charid."'";
			MySQL_QUERY($query);
		}else{
			$query = "UPDATE pr_latest SET latest_timestamp = ".time().", latest_avgvalue = '0' WHERE latest_ID = '".$charid."'";
			MySQL_QUERY($query);
		}
		}
	}
	$skillbreakdown = "";
	$skillbreakdown .= "Combat: ".number_format ($combatpart * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($combatprice, 2 , '.' , ',' ).") <BR><BR>";
	$skillbreakdown .= "PvP: ".number_format (($PvPpart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[4], 2 , '.' , ',' ).") <BR>";
	$skillbreakdown .= "PvE: ".number_format (($PvEpart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[5], 2 , '.' , ',' ).") <BR><BR>";
	$skillbreakdown .= "Caldari: ".number_format (($Caldaripart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[6], 2 , '.' , ',' ).") <BR>";
	$skillbreakdown .= "Gallente: ".number_format (($Gallentepart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[7], 2 , '.' , ',' ).") <BR>";
	$skillbreakdown .= "Amarr: ".number_format (($Amarrpart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[8], 2 , '.' , ',' ).") <BR>";
	$skillbreakdown .= "Minmatar: ".number_format (($Minmatarpart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[9], 2 , '.' , ',' ).") <BR><BR>";
	
	$skillbreakdown .= "Industry: ".number_format ($industrypart * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($industryprice, 2 , '.' , ',' ).") <BR><BR>";
	$skillbreakdown .= "Mining/Hauling: ".number_format (($minhaulpart * $industrypart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[12], 2 , '.' , ',' ).") <BR>";
	$skillbreakdown .= "Research/Manufacturing: ".number_format (($resmanupart * $industrypart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[14], 2 , '.' , ',' ).") <BR>";
	$skillbreakdown .= "Trade: ".number_format (($tradepart * $industrypart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[16], 2 , '.' , ',' ).") <BR>";
	$skillbreakdown .= "Planetary Interaction: ".number_format (($planetpart * $industrypart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[17], 2 , '.' , ',' ).") <BR>";
	
	$charspecials = "";
	if($combatpart > $industrypart)
	{
		$charspecials .= number_format ($combatpart * 100, 2 , '.' , ',' )."% Combat<BR>";
		$charspecials .= number_format ($industrypart * 100, 2 , '.' , ',' )."% Industry<BR>";
	}else{
		$charspecials .= number_format ($industrypart * 100, 2 , '.' , ',' )."% Industry<BR>";
		$charspecials .= number_format ($combatpart * 100, 2 , '.' , ',' )."% Combat<BR>";
	}
	if($lvl5cruiser > 1)
	{
		$charspecials .= "Can fly T2 ";
		$andsign = 0;
		if($amacruiser == 1){$charspecials .= "Amarr "; $andsign = 1;}
		if($galcruiser == 1){if($andsign == 1)$charspecials.="& ";$charspecials .= "Gallente "; $andsign = 1;}
		if($mincruiser == 1){if($andsign == 1)$charspecials.="& ";$charspecials .= "Minmatar "; $andsign = 1;}
		if($calcruiser == 1){if($andsign == 1)$charspecials.="& ";$charspecials .= "Caldari "; $andsign = 1;}
		$charspecials .= "Cruisers!<BR>";
	}
	if($secstatus >= 2.5)$charspecials .= "Has high sec status!<BR>";
	if($secstatus >= 0 && $secstatus < 2.5)$charspecials .= "Has normal sec status.<BR>";
	if($secstatus >= -2 && $secstatus < 0)$charspecials .= "Has unfortunate sec status..<BR>";
	if($secstatus >= -4 && $secstatus < -2)$charspecials .= "Has low sec status..<BR>";
	if($secstatus >= -6 && $secstatus < -4)$charspecials .= "Has very low sec status..<BR>";
	if($secstatus >= -8 && $secstatus < -6)$charspecials .= "Has appauling sec status..<BR>";
	if($secstatus >= -10 && $secstatus < -8)$charspecials .= "Is a full-time pirate.<BR>";
	$query = "SELECT * FROM pr_latest WHERE latest_avgvalue > 0 ORDER BY latest_avgvalue DESC";
	$result = MySQL_QUERY($query);
	$total = MySQL_NUM_ROWS($result);
	$place = 1;
	while($arr_latest = MySQL_FETCH_ARRAY($result))
	{
		if($arr_latest["latest_avgvalue"]==$avgspvalue)
		{
			$charspecials .= "Has rank ".$place." (out of ".$total.") in ISK per SP!";
			break;
		}
		$place++;
	}


	$skilldetails = $implanttext."<BR><BR>".$skilltext;

}
?>