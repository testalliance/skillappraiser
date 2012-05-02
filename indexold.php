<HTML>
<HEAD>
<script language="JavaScript">
function toggle(obj) {
	var el = document.getElementById(obj);
	if ( el.style.display != 'none' ) {
		el.style.display = 'none';
	}
	else {
		el.style.display = '';
	}
}</script>
</HEAD>
<BODY>
<?php
MySQL_CONNECT("localhost","Username","Password");
MySQL_SELECT_DB("DataBase");

/*
Load character skillpoints from API
Add base price of skill books.
Put skills in categories.
Category:
1 Learning * 0.25 bil
2 Core * 0.25 bil
3 Drones * 0.25 bil
10 Jump * 0.25 bil
11 Cap * 0.25 bil
19 Corp * 0.25 bil
20 Zero * 0.25 bil

{ 21 Combat
5 PVE <-> 4 PVP
+
6 Cal <-> 9 Min <-> 8 Ama <-> 7 Gal
}
<->
{ 22 Industry
[
12 Mining + 13 Hauling
<->
14 Research + 15 Manufacturing
<->
16 Trade
<->
17 Planetary Interaction
]
+
18 JF/Rorq
}

For each <-> check what percentage each is and split the 0.25 bil.
e.g.
100% PVP 0% PVE = 0.25 bil on PVP
75% 25% = 0.19 - 0.06 bil
etc.
*/
$implantamount = 0;
if(isset($_GET["test"]))
{
$contents = file ( "http://eveboard.com/pilot/".$_GET["test"]);
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
}
if(!isset($_POST["userID"]))
{
$content = "<?xml version='1.0' encoding='UTF-8'?>
<eveapi version=\"2\">
  <currentTime>2010-11-12 10:26:25</currentTime>
  <result>
    <characterID>1199002469</characterID>
    <name>Gemberslaafje</name>
    <DoB>2007-04-13 17:47:00</DoB>
    <race>Minmatar</race>
    <bloodLine>Brutor</bloodLine>
    <ancestry>Slave Child</ancestry>
    <gender>Male</gender>
    <corporationName>Vivicide</corporationName>
    <corporationID>362749823</corporationID>
    <allianceName>Asomat Drive Yards</allianceName>
    <allianceID>449239513</allianceID>
    <cloneName>Clone Grade Pi</cloneName>
    <cloneSkillPoints>54600000</cloneSkillPoints>
    <balance>47489625.29</balance>
    <attributeEnhancers />
    <attributes>
      <intelligence>5</intelligence>
      <memory>5</memory>
      <charisma>5</charisma>
      <perception>12</perception>
      <willpower>12</willpower>
    </attributes>
    <rowset name=\"skills\" key=\"typeID\" columns=\"typeID,skillpoints,level,unpublished\">
      <row typeID=\"3433\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"25719\" skillpoints=\"13782\" level=\"2\" />
      <row typeID=\"3333\" skillpoints=\"1280000\" level=\"5\" />
      <row typeID=\"12203\" skillpoints=\"362039\" level=\"4\" />
      <row typeID=\"22761\" skillpoints=\"1536000\" level=\"5\" />
      <row typeID=\"3430\" skillpoints=\"24000\" level=\"3\" />
      <row typeID=\"28615\" skillpoints=\"181020\" level=\"4\" />
      <row typeID=\"25811\" skillpoints=\"7072\" level=\"2\" />
      <row typeID=\"25810\" skillpoints=\"7072\" level=\"2\" />
      <row typeID=\"23566\" skillpoints=\"40000\" level=\"3\" />
      <row typeID=\"12484\" skillpoints=\"7072\" level=\"2\" />
      <row typeID=\"12485\" skillpoints=\"7072\" level=\"2\" />
      <row typeID=\"20327\" skillpoints=\"1750\" level=\"1\" />
      <row typeID=\"19922\" skillpoints=\"1250\" level=\"1\" />
      <row typeID=\"22043\" skillpoints=\"362039\" level=\"4\" />
      <row typeID=\"21610\" skillpoints=\"362039\" level=\"4\" />
      <row typeID=\"21611\" skillpoints=\"407294\" level=\"4\" />
      <row typeID=\"27911\" skillpoints=\"2000\" level=\"1\" />
      <row typeID=\"21803\" skillpoints=\"11314\" level=\"2\" />
      <row typeID=\"20533\" skillpoints=\"112000\" level=\"3\" />
      <row typeID=\"20525\" skillpoints=\"3000\" level=\"1\" />
      <row typeID=\"3304\" skillpoints=\"4243\" level=\"2\" />
      <row typeID=\"28879\" skillpoints=\"2829\" level=\"2\" />
      <row typeID=\"3439\" skillpoints=\"24000\" level=\"3\" />
      <row typeID=\"28073\" skillpoints=\"181020\" level=\"4\" />
      <row typeID=\"3340\" skillpoints=\"5657\" level=\"2\" />
      <row typeID=\"3343\" skillpoints=\"5657\" level=\"2\" />
      <row typeID=\"28164\" skillpoints=\"4243\" level=\"2\" />
      <row typeID=\"20312\" skillpoints=\"7072\" level=\"2\" />
      <row typeID=\"12487\" skillpoints=\"7072\" level=\"2\" />
      <row typeID=\"12096\" skillpoints=\"1536000\" level=\"5\" />
      <row typeID=\"3405\" skillpoints=\"8000\" level=\"3\" />
      <row typeID=\"3306\" skillpoints=\"768000\" level=\"5\" />
      <row typeID=\"23069\" skillpoints=\"16971\" level=\"2\" />
      <row typeID=\"23594\" skillpoints=\"7072\" level=\"2\" />
      <row typeID=\"11084\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"19921\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"26252\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"16069\" skillpoints=\"512000\" level=\"5\" />
      <row typeID=\"26261\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"26257\" skillpoints=\"4243\" level=\"2\" />
      <row typeID=\"26260\" skillpoints=\"4243\" level=\"2\" />
      <row typeID=\"26259\" skillpoints=\"4243\" level=\"2\" />
      <row typeID=\"26258\" skillpoints=\"4243\" level=\"2\" />
      <row typeID=\"26256\" skillpoints=\"4243\" level=\"2\" />
      <row typeID=\"26255\" skillpoints=\"4243\" level=\"2\" />
      <row typeID=\"26254\" skillpoints=\"4243\" level=\"2\" />
      <row typeID=\"26253\" skillpoints=\"4243\" level=\"2\" />
      <row typeID=\"3551\" skillpoints=\"8000\" level=\"3\" />
      <row typeID=\"25863\" skillpoints=\"768000\" level=\"5\" />
      <row typeID=\"3338\" skillpoints=\"11314\" level=\"2\" />
      <row typeID=\"16591\" skillpoints=\"386681\" level=\"4\" />
      <row typeID=\"12365\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"3356\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"3357\" skillpoints=\"45255\" level=\"4\" />
      <row typeID=\"11566\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"12366\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"12367\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"16548\" skillpoints=\"8000\" level=\"3\" />
      <row typeID=\"16549\" skillpoints=\"36632\" level=\"3\" />
      <row typeID=\"16546\" skillpoints=\"8000\" level=\"3\" />
      <row typeID=\"19759\" skillpoints=\"181020\" level=\"4\" />
      <row typeID=\"3335\" skillpoints=\"226275\" level=\"4\" />
      <row typeID=\"24568\" skillpoints=\"452549\" level=\"4\" />
      <row typeID=\"11207\" skillpoints=\"1536000\" level=\"5\" />
      <row typeID=\"28656\" skillpoints=\"80000\" level=\"3\" />
      <row typeID=\"11083\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"12204\" skillpoints=\"226275\" level=\"4\" />
      <row typeID=\"12205\" skillpoints=\"2000\" level=\"1\" />
      <row typeID=\"24562\" skillpoints=\"3500\" level=\"1\" />
      <row typeID=\"3420\" skillpoints=\"181020\" level=\"4\" />
      <row typeID=\"3419\" skillpoints=\"768000\" level=\"5\" />
      <row typeID=\"3422\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"21059\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"3417\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3421\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"3427\" skillpoints=\"512000\" level=\"5\" />
      <row typeID=\"21603\" skillpoints=\"326608\" level=\"4\" />
      <row typeID=\"3328\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"3341\" skillpoints=\"5657\" level=\"2\" />
      <row typeID=\"12099\" skillpoints=\"271530\" level=\"4\" />
      <row typeID=\"3331\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"25739\" skillpoints=\"11314\" level=\"2\" />
      <row typeID=\"3411\" skillpoints=\"24000\" level=\"3\" />
      <row typeID=\"3412\" skillpoints=\"768000\" level=\"5\" />
      <row typeID=\"20314\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"21071\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"12442\" skillpoints=\"5657\" level=\"2\" />
      <row typeID=\"12441\" skillpoints=\"512000\" level=\"5\" />
      <row typeID=\"3322\" skillpoints=\"24000\" level=\"3\" />
      <row typeID=\"3323\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"27902\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"22809\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"22808\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"22807\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"22806\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"3348\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3301\" skillpoints=\"8000\" level=\"3\" />
      <row typeID=\"3303\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3316\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"3330\" skillpoints=\"512000\" level=\"5\" />
      <row typeID=\"3359\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"28609\" skillpoints=\"271530\" level=\"4\" />
      <row typeID=\"11446\" skillpoints=\"226275\" level=\"4\" />
      <row typeID=\"12383\" skillpoints=\"24000\" level=\"3\" />
      <row typeID=\"20315\" skillpoints=\"7072\" level=\"2\" />
      <row typeID=\"20342\" skillpoints=\"1280000\" level=\"5\" />
      <row typeID=\"3332\" skillpoints=\"7072\" level=\"2\" />
      <row typeID=\"3339\" skillpoints=\"2048000\" level=\"5\" />
      <row typeID=\"3456\" skillpoints=\"1280000\" level=\"5\" />
      <row typeID=\"24241\" skillpoints=\"29337\" level=\"3\" />
      <row typeID=\"19761\" skillpoints=\"226275\" level=\"4\" />
      <row typeID=\"19760\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"3300\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3302\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3310\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"3311\" skillpoints=\"512000\" level=\"5\" />
      <row typeID=\"3319\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3320\" skillpoints=\"8000\" level=\"3\" />
      <row typeID=\"3321\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"3327\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3329\" skillpoints=\"512000\" level=\"5\" />
      <row typeID=\"3374\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3375\" skillpoints=\"45255\" level=\"4\" />
      <row typeID=\"3379\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3386\" skillpoints=\"8000\" level=\"3\" />
      <row typeID=\"3402\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3413\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3416\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3424\" skillpoints=\"512000\" level=\"5\" />
      <row typeID=\"3425\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"3426\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3431\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3449\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3450\" skillpoints=\"45255\" level=\"4\" />
      <row typeID=\"3453\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"3455\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"12386\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"12387\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"3393\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3392\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3326\" skillpoints=\"226275\" level=\"4\" />
      <row typeID=\"3325\" skillpoints=\"5657\" level=\"2\" />
      <row typeID=\"3452\" skillpoints=\"181020\" level=\"4\" />
      <row typeID=\"3315\" skillpoints=\"181020\" level=\"4\" />
      <row typeID=\"3317\" skillpoints=\"226275\" level=\"4\" />
      <row typeID=\"3428\" skillpoints=\"512000\" level=\"5\" />
      <row typeID=\"3324\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"3305\" skillpoints=\"768000\" level=\"5\" />
      <row typeID=\"3451\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"3318\" skillpoints=\"512000\" level=\"5\" />
      <row typeID=\"3312\" skillpoints=\"118929\" level=\"4\" />
      <row typeID=\"3429\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3437\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3436\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"12201\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"12486\" skillpoints=\"147103\" level=\"3\" />
      <row typeID=\"3418\" skillpoints=\"768000\" level=\"5\" />
      <row typeID=\"23618\" skillpoints=\"7072\" level=\"2\" />
      <row typeID=\"23606\" skillpoints=\"45255\" level=\"4\" />
      <row typeID=\"12305\" skillpoints=\"8000\" level=\"3\" />
      <row typeID=\"3441\" skillpoints=\"115103\" level=\"3\" />
      <row typeID=\"3442\" skillpoints=\"1280000\" level=\"5\" />
      <row typeID=\"3349\" skillpoints=\"2829\" level=\"2\" />
      <row typeID=\"24613\" skillpoints=\"11314\" level=\"2\" />
      <row typeID=\"24311\" skillpoints=\"19799\" level=\"2\" />
      <row typeID=\"11579\" skillpoints=\"271530\" level=\"4\" />
      <row typeID=\"12095\" skillpoints=\"181020\" level=\"4\" />
      <row typeID=\"12097\" skillpoints=\"16000\" level=\"3\" />
      <row typeID=\"3435\" skillpoints=\"768000\" level=\"5\" />
      <row typeID=\"3394\" skillpoints=\"512000\" level=\"5\" />
      <row typeID=\"3423\" skillpoints=\"90510\" level=\"4\" />
      <row typeID=\"3454\" skillpoints=\"226275\" level=\"4\" />
      <row typeID=\"24242\" skillpoints=\"45255\" level=\"4\" />
      <row typeID=\"3378\" skillpoints=\"123900\" level=\"4\" />
      <row typeID=\"3376\" skillpoints=\"45255\" level=\"4\" />
      <row typeID=\"3377\" skillpoints=\"256000\" level=\"5\" />
      <row typeID=\"3337\" skillpoints=\"2048000\" level=\"5\" />
      <row typeID=\"3308\" skillpoints=\"840538\" level=\"4\" />
      <row typeID=\"3432\" skillpoints=\"512000\" level=\"5\" />
      <row typeID=\"12208\" skillpoints=\"226275\" level=\"4\" />
      <row typeID=\"3309\" skillpoints=\"1280000\" level=\"5\" />
      <row typeID=\"12202\" skillpoints=\"226275\" level=\"4\" />
      <row typeID=\"12376\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"12385\" skillpoints=\"135765\" level=\"4\" />
      <row typeID=\"3443\" skillpoints=\"8000\" level=\"3\" />
      <row typeID=\"12093\" skillpoints=\"181020\" level=\"4\" />
      <row typeID=\"3342\" skillpoints=\"5657\" level=\"2\" />
      <row typeID=\"3355\" skillpoints=\"8000\" level=\"3\" />
      <row typeID=\"3434\" skillpoints=\"24000\" level=\"3\" />
      <row typeID=\"3363\" skillpoints=\"8000\" level=\"3\" />
      <row typeID=\"11584\" skillpoints=\"24000\" level=\"3\" />
      <row typeID=\"3334\" skillpoints=\"1280000\" level=\"5\" />
    </rowset>
    <rowset name=\"certificates\" key=\"certificateID\" columns=\"certificateID\">
      <row certificateID=\"44\" />
      <row certificateID=\"282\" />
      <row certificateID=\"5\" />
      <row certificateID=\"19\" />
      <row certificateID=\"12\" />
      <row certificateID=\"6\" />
      <row certificateID=\"20\" />
      <row certificateID=\"13\" />
      <row certificateID=\"53\" />
      <row certificateID=\"65\" />
      <row certificateID=\"165\" />
      <row certificateID=\"161\" />
      <row certificateID=\"169\" />
      <row certificateID=\"180\" />
      <row certificateID=\"195\" />
      <row certificateID=\"181\" />
      <row certificateID=\"198\" />
      <row certificateID=\"196\" />
      <row certificateID=\"199\" />
      <row certificateID=\"197\" />
      <row certificateID=\"68\" />
      <row certificateID=\"128\" />
      <row certificateID=\"121\" />
      <row certificateID=\"114\" />
      <row certificateID=\"69\" />
      <row certificateID=\"129\" />
      <row certificateID=\"32\" />
      <row certificateID=\"133\" />
      <row certificateID=\"200\" />
      <row certificateID=\"115\" />
      <row certificateID=\"117\" />
      <row certificateID=\"119\" />
      <row certificateID=\"122\" />
      <row certificateID=\"347\" />
      <row certificateID=\"124\" />
      <row certificateID=\"126\" />
      <row certificateID=\"1\" />
      <row certificateID=\"9\" />
      <row certificateID=\"15\" />
      <row certificateID=\"177\" />
      <row certificateID=\"186\" />
      <row certificateID=\"187\" />
      <row certificateID=\"204\" />
      <row certificateID=\"50\" />
      <row certificateID=\"61\" />
      <row certificateID=\"192\" />
      <row certificateID=\"189\" />
      <row certificateID=\"183\" />
      <row certificateID=\"93\" />
      <row certificateID=\"39\" />
      <row certificateID=\"2\" />
      <row certificateID=\"10\" />
      <row certificateID=\"178\" />
      <row certificateID=\"16\" />
      <row certificateID=\"135\" />
      <row certificateID=\"139\" />
      <row certificateID=\"46\" />
      <row certificateID=\"146\" />
      <row certificateID=\"311\" />
      <row certificateID=\"153\" />
      <row certificateID=\"332\" />
      <row certificateID=\"3\" />
      <row certificateID=\"72\" />
      <row certificateID=\"47\" />
      <row certificateID=\"333\" />
      <row certificateID=\"79\" />
      <row certificateID=\"86\" />
      <row certificateID=\"27\" />
      <row certificateID=\"296\" />
      <row certificateID=\"33\" />
      <row certificateID=\"314\" />
      <row certificateID=\"160\" />
      <row certificateID=\"26\" />
      <row certificateID=\"293\" />
      <row certificateID=\"11\" />
      <row certificateID=\"208\" />
      <row certificateID=\"73\" />
      <row certificateID=\"77\" />
      <row certificateID=\"80\" />
      <row certificateID=\"87\" />
      <row certificateID=\"294\" />
      <row certificateID=\"295\" />
      <row certificateID=\"297\" />
      <row certificateID=\"173\" />
      <row certificateID=\"84\" />
      <row certificateID=\"24\" />
      <row certificateID=\"30\" />
      <row certificateID=\"36\" />
      <row certificateID=\"42\" />
      <row certificateID=\"212\" />
      <row certificateID=\"308\" />
      <row certificateID=\"326\" />
      <row certificateID=\"344\" />
      <row certificateID=\"362\" />
      <row certificateID=\"7\" />
      <row certificateID=\"8\" />
      <row certificateID=\"21\" />
      <row certificateID=\"64\" />
      <row certificateID=\"201\" />
      <row certificateID=\"202\" />
      <row certificateID=\"62\" />
      <row certificateID=\"48\" />
      <row certificateID=\"51\" />
      <row certificateID=\"54\" />
      <row certificateID=\"57\" />
      <row certificateID=\"58\" />
      <row certificateID=\"59\" />
      <row certificateID=\"348\" />
      <row certificateID=\"349\" />
      <row certificateID=\"66\" />
      <row certificateID=\"55\" />
      <row certificateID=\"4\" />
    </rowset>
    <rowset name=\"corporationRoles\" key=\"roleID\" columns=\"roleID,roleName\" />
    <rowset name=\"corporationRolesAtHQ\" key=\"roleID\" columns=\"roleID,roleName\" />
    <rowset name=\"corporationRolesAtBase\" key=\"roleID\" columns=\"roleID,roleName\" />
    <rowset name=\"corporationRolesAtOther\" key=\"roleID\" columns=\"roleID,roleName\" />
    <rowset name=\"corporationTitles\" key=\"titleID\" columns=\"titleID,titleName\" />
  </result>
  <cachedUntil>2010-11-12 10:41:25</cachedUntil>
</eveapi>";
$content2 = "<eveapi version=\"2\">
  <currentTime>2010-11-19 13:10:10</currentTime>
  <result>
    <characterID>1199002469</characterID>
    <characterName>Gemberslaafje</characterName>
    <race>Minmatar</race>
    <bloodline>Brutor</bloodline>
    <skillPoints>45822457</skillPoints>
    <shipName>Death, Sr.</shipName>
    <shipTypeID>22440</shipTypeID>
    <shipTypeName>Panther</shipTypeName>
    <corporationID>362749823</corporationID>
    <corporation>Vivicide</corporation>
    <corporationDate>2010-11-16 15:53:00</corporationDate>
    <allianceID>449239513</allianceID>
    <alliance>Asomat Drive Yards</alliance>
    <allianceDate>2010-10-17 01:42:00</allianceDate>
    <securityStatus>2.19207225086343</securityStatus>";
//file ( "http://api.eve-online.com/char/CharacterSheet.xml.aspx?userID=1846718&apiKey=PzjAUsolZtWeQvfiZnYjATM9Ge90CEp6Oha3AnNDwCjILMpVPDPSx7WjbAwGZGTR&characterID=1199002469" );
$contents = explode(chr(10),$content);
$contents2 = explode(chr(10),$content2);
}else{
if(!isset($_POST["characterID"]))
{
//Load API characters file 
$contents = file ( "http://api.eve-online.com/account/Characters.xml.aspx?userID=".$_POST["userID"]."&apiKey=".$_POST["apiKey"]."" );
print("Choose the character you want to appraise:<BR>Nothing to choose from? Your userID or api Key was propably wrong! Use the Back button to try again...<BR><FORM METHOD=POST><SELECT NAME='characterID'>");
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
print("<OPTION VALUE='".$ID."'>".$name."</OPTION>");
$cID[$t] = $ID;
$cName[$t] = $name;
$t++;
}
}
print("</SELECT>");
print("<INPUT TYPE=HIDDEN NAME=cID1 VALUE='".$cID[0]."'>");
print("<INPUT TYPE=HIDDEN NAME=cID2 VALUE='".$cID[1]."'>");
print("<INPUT TYPE=HIDDEN NAME=cID3 VALUE='".$cID[2]."'>");
print("<INPUT TYPE=HIDDEN NAME=cName1 VALUE='".$cName[0]."'>");
print("<INPUT TYPE=HIDDEN NAME=cName2 VALUE='".$cName[1]."'>");
print("<INPUT TYPE=HIDDEN NAME=cName3 VALUE='".$cName[2]."'>");
print("<INPUT TYPE=HIDDEN NAME=userID VALUE='".$_POST["userID"]."'>");
print("<INPUT TYPE=HIDDEN NAME=apiKey VALUE='".$_POST["apiKey"]."'>");
print("<INPUT TYPE=SUBMIT VALUE='Lets go!'></FORM>");
//Show list of available characters to choose from.

die();
}else{
$contents = file ( "http://api.eve-online.com/char/CharacterSheet.xml.aspx?userID=".$_POST["userID"]."&apiKey=".$_POST["apiKey"]."&characterID=".$_POST["characterID"]."" );
$contents2 = file ( "http://api.eve-online.com/eve/CharacterInfo.xml.aspx?userID=".$_POST["userID"]."&apiKey=".$_POST["apiKey"]."&characterID=".$_POST["characterID"]."" );
//$contents3 = file ( "http://api.eve-online.com/char/SkillInTraining.xml.aspx?userID=".$_POST["userID"]."&apiKey=".$_POST["apiKey"]."&characterID=".$_POST["characterID"]."" );
}
}
$result = MySQL_QUERY("SELECT * FROM pr_counter");
$array = MySQL_FETCH_ARRAY($result);
$count = $array["counter"];
//print("<!--");
print("<b>WARNING; DISCLAIMER: This system is HIGHLY EXPERIMENTAL and will undergo tweaking. The accuracy is BY NO MEANS GUARANTEED.<BR>Have you done a pricecheck you think is really wrong? Tell me! contact Gemberslaafje ingame! That's the only way I can make this perfect.</b><BR>Special thanks to: Durantis, Rivendark, Samuel Backet and KentOnline.<BR>BUG: it will not yet include your currently training skill.<BR><BR>");
print("<font size=20>EVE Character appraiser</font><BR><BR>Already appraised ".$count." characters!<BR>This system will look at your skillpoints and give them a value. ");
if(!isset($_POST["userID"]))
{
print(" Wanna try it? fill out this little form! Your data will NOT be stored.<BR><BR><FORM METHOD=POST><TABLE><TR><TD>User ID</TD><TD><INPUT TYPE=text NAME=userID></TD></TR>");
print("<TR><TD>apiKey</TD><TD><INPUT TYPE=text NAME=apiKey></TD></TR>");
//print("<TR><TD>characterID</TD><TD><INPUT TYPE=text NAME=characterID></TD></TR>");
print("<TR><TD></TD><TD><INPUT TYPE=submit VALUE='Appraise my character!'></TD></TR></TABLE><BR><BR>");
}
print("You enjoying this FREE service? Consider donating to Gemberslaafje. ISKs and spare MotherShips are welcome!<BR>Donators: Exopolitics");
if(isset($content))
{
print("<BR>As an example, I present you the skill breakdown of Gemberslaafje, my main.<BR>");
}else{
if($_POST["characterID"]==$_POST["cID1"])
{
print("<BR>Appraising character <b>".$_POST["cName1"]."</b>");
mySQL_QUERY("UPDATE pr_counter SET counter = counter + 1");
}
if($_POST["characterID"]==$_POST["cID2"])
{
print("<BR>Appraising character <b>".$_POST["cName2"]."</b>");
mySQL_QUERY("UPDATE pr_counter SET counter = counter + 1");
}
if($_POST["characterID"]==$_POST["cID3"])
{
print("<BR>Appraising character <b>".$_POST["cName3"]."</b>");
mySQL_QUERY("UPDATE pr_counter SET counter = counter + 1");
}
}

if(!isset($_GET["test"]))
{
//print("<!--");
foreach($contents2 as $line)
{
//print($line);
if(strpos($line, "<securityStatus>")>0)
{
$tmp = substr($line,20);
$end = strpos($tmp,"<");
$secstatus = substr($tmp,0,$end);
break;
}
}
//print("-->");
//print("<!--");
//foreach($contents3 as $line)
//{
//print($line);
//}
//print("-->");
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
//print($line);
//parse this line.
$tmp = substr($line,19);
$end = strpos($tmp,"\"");
$ID = substr($tmp,0,$end);
$start = strpos($line,"skillpoints=");
$tmp = substr($line,$start+13);
$end = strpos($tmp, "\"");
$points = substr($tmp,0,$end);
$skill[$ID] = $points;
//print($ID.": ".$points);


}
}
//print("-->");
}
foreach($skill as $id => $points)
{
//print($id.": ".$points);
$res_skills = MySQL_QUERY("SELECT * FROM pr_skills WHERE skill_ID = ".$id."");
$arr_skills = MySQL_FETCH_ARRAY($res_skills);

$categories[$arr_skills["skill_category"]] += $points;
$skilllist[$id] = $arr_skills["skill_name"];
$catlist[$id] = $arr_skills["skill_category"];
$skillpts[$id] = $points;
$bookprice[$id] = $arr_skills["skill_price"];
if($arr_skills["skill_category"] == 4 || $arr_skills["skill_category"] == 5 || $arr_skills["skill_category"] == 6 || $arr_skills["skill_category"] == 7 || $arr_skills["skill_category"] == 8 || $arr_skills["skill_category"] == 9 || $arr_skills["skill_category"] == 21)
{
$combat += $points;
}
if($arr_skills["skill_category"] == 12 || $arr_skills["skill_category"] == 13 || $arr_skills["skill_category"] == 14 || $arr_skills["skill_category"] == 15 || $arr_skills["skill_category"] == 16 || $arr_skills["skill_category"] == 17 || $arr_skills["skill_category"] == 18 || $arr_skills["skill_category"] == 22)
{
$industry += $points;
}


$baseprice += $arr_skills["skill_price"];
//print($arr_skills["skill_name"].": ".$points."<BR>");

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
$PvPpart = $categories[4] / ($categories[4]+$categories[5]);
$PvEpart = $categories[5] / ($categories[4]+$categories[5]);
$Caldaripart = $categories[6] / ($categories[6]+$categories[7]+$categories[8]+$categories[9]);
$Gallentepart = $categories[7] / ($categories[6]+$categories[7]+$categories[8]+$categories[9]);
$Amarrpart = $categories[8] / ($categories[6]+$categories[7]+$categories[8]+$categories[9]);
$Minmatarpart = $categories[9] / ($categories[6]+$categories[7]+$categories[8]+$categories[9]);

$minhaulpart = ($categories[12]+$categories[13]) / ($categories[12]+$categories[13]+$categories[14]+$categories[15]+$categories[16]+$categories[17]);
$resmanupart = ($categories[14]+$categories[15]) / ($categories[12]+$categories[13]+$categories[14]+$categories[15]+$categories[16]+$categories[17]);
$tradepart = ($categories[16]) / ($categories[12]+$categories[13]+$categories[14]+$categories[15]+$categories[16]+$categories[17]);
$planetpart = ($categories[17]) / ($categories[12]+$categories[13]+$categories[14]+$categories[15]+$categories[16]+$categories[17]);

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

print("<HR>");
//number_format (  , 2 , '.' , ',' )
print("Combat: ".number_format ($combatpart * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($combatprice, 2 , '.' , ',' ).") <BR><BR>");
print("PvP: ".number_format (($PvPpart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[4], 2 , '.' , ',' ).") <BR>");
print("PvE: ".number_format (($PvEpart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[5], 2 , '.' , ',' ).") <BR><BR>");
print("Caldari: ".number_format (($Caldaripart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[6], 2 , '.' , ',' ).") <BR>");
print("Gallente: ".number_format (($Gallentepart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[7], 2 , '.' , ',' ).") <BR>");
print("Amarr: ".number_format (($Amarrpart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[8], 2 , '.' , ',' ).") <BR>");
print("Minmatar: ".number_format (($Minmatarpart * $combatpart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[9], 2 , '.' , ',' ).") <BR><BR>");

print("Industry: ".number_format ($industrypart * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($industryprice, 2 , '.' , ',' ).") <BR><BR>");
print("Mining/Hauling: ".number_format (($minhaulpart * $industrypart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[12], 2 , '.' , ',' ).") <BR>");
print("Research/Manufacturing: ".number_format (($resmanupart * $industrypart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[14], 2 , '.' , ',' ).") <BR>");
print("Trade: ".number_format (($tradepart * $industrypart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[16], 2 , '.' , ',' ).") <BR>");
print("Planetary Interaction: ".number_format (($planetpart * $industrypart) * 100, 2 , '.' , ',' )."% (Price per mil: ".number_format ($pricecat[17], 2 , '.' , ',' ).") <BR>");
print("<HR>");
$totprice = 0;
$totsp = 0;
$lvl5cruiser = 0.98;
if($skillpts[3332]==1280000)$lvl5cruiser+=0.02;
if($skillpts[3333]==1280000)$lvl5cruiser+=0.02;
if($skillpts[3334]==1280000)$lvl5cruiser+=0.02;
if($skillpts[3335]==1280000)$lvl5cruiser+=0.02;
if($lvl5cruiser < 1) $lvl5cruiser = 1;
print("Sec status modifier: ".($secval*100)."% <BR>");
print("Level 5 cruiser modifier: ".($lvl5cruiser*100)."%<BR>");
if($implantamount > 0)
{
print("<HR><B>Implants Found:</B><BR><BR><TABLE WIDTH=600><TR><TD ALIGN=center><B>Implant</B></TD><TD ALIGN=center><B>Value</B></TD></TR>");
foreach($implantlist as $implant)
{
$res_implants = MySQL_QUERY("SELECT * FROM pr_implants WHERE implant_name = '".$implant."'");
$arr_implants = MySQL_FETCH_ARRAY($res_implants);
$implanttotalprice += $arr_implants["implant_price"];
print("<TR><TD>".$implant."</TD><TD ALIGN=right>".number_format ($arr_implants["implant_price"], 2 , '.' , ',' )." ISK</TD></TR>");
}
print("</TABLE><HR>");
}print("<TABLE WIDTH=600><TR><TD><b>Category</b></TD><TD ALIGN=center><b>Skill Points</B></TD><TD ALIGN=center><b>Price</b></TD></TR>");
if($_GET["sort"]=="SP" || !isset($_GET["sort"]))
{
arsort($categories);
asort($skilllist);
foreach($categories as $id => $points)
{
if($points > 1)
{
$res_categories = MySQL_QUERY("SELECT * FROM pr_categories WHERE category_ID = ".$id."");
$arr_categories = MySQL_FETCH_ARRAY($res_categories);
$price = $points * $pricecat[$id];
$totprice += $price;
$totsp += $points;
print("<TR><TD style=\"cursor:pointer\" onclick=\"toggle('cat".$id."')\">".$arr_categories["category_name"]."</TD><TD ALIGN=right>".number_format ($points, 2 , '.' , ',' )." SP</TD><TD ALIGN=right>".number_format ($price, 2 , '.' , ',' )." ISK</TD></TR><TR id='cat".$id."' style=\"display:none;\"><TD COLSPAN=3><TABLE WIDTH=100%><TR><TD><b>Skill</B></TD><TD ALIGN=center><b>SkillPoints</b></TD><TD ALIGN=center><B>Skill Book Price</B></TD></TR>");
foreach($skilllist as $sid => $name)
{
if($catlist[$sid]==$id)
{
print("<TR><TD>- ".$name."</TD><TD ALIGN=right>".number_format ($skillpts[$sid], 2 , '.' , ',' )." SP</TD><TD ALIGN=right>".number_format ($bookprice[$sid], 2 , '.' , ',' )." ISK</TD></TR>");
}
}
print("</TABLE></TD></TR>");
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
print("<TR><TD style=\"cursor:pointer\" onclick=\"toggle('cat".$id."')\">".$arr_categories["category_name"]."</TD><TD ALIGN=right>".number_format ($points, 2 , '.' , ',' )." SP</TD><TD ALIGN=right>".number_format ($price, 2 , '.' , ',' )." ISK</TD></TR><TR id='cat".$id."' style=\"display:none;\"><TD COLSPAN=3><HR><TABLE WIDTH=100%><TR><TD><b>Skill</B></TD><TD ALIGN=center><b>SkillPoints</b></TD><TD ALIGN=center><B>Skill Book Price</B></TD></TR>");
foreach($skilllist as $sid => $name)
{
if($catlist[$sid]==$id)
{
print("<TR><TD>- ".$name."</TD><TD ALIGN=right>".number_format ($skillpts[$sid], 2 , '.' , ',' )." SP</TD><TD ALIGN=right>".number_format ($bookprice[$sid], 2 , '.' , ',' )." ISK</TD></TR>");
}
}
print("<HR></TABLE></TD></TR>");
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
print("<TR><TD></TD><TD><HR></TD><TD><HR></TD></TR>");
print("<TR><TD>Basic Total Value: </TD><TD ALIGN=right>".number_format ($totsp, 2 , '.' , ',' )." SP</TD><TD ALIGN=right>".number_format ($totprice, 2 , '.' , ',' )." ISK</TD></TR>");
print("<TR><TD>Base Skillbook Price: </TD><TD></TD><TD ALIGN=right>".number_format ($baseprice, 2 , '.' , ',' )." ISK</TD></TR>");
if($implanttotalprice > 0)print("<TR><TD>Implants: </TD><TD></TD><TD ALIGN=right>".number_format ($implanttotalprice, 2 , '.' , ',' )." ISK</TD></TR>");
if($spdecline > 1)print("<TR><TD>>70m SP Modifier: </TD><TD></TD><TD ALIGN=right>".number_format ((($baseprice + $totprice)*$spdecline) - ($baseprice + $totprice), 2 , '.' , ',' )." ISK</TD></TR>");
if($spdecline < 1)print("<TR><TD>>20m <70m SP Modifier: </TD><TD></TD><TD ALIGN=right>".number_format ((($baseprice + $totprice)*$spdecline) - ($baseprice + $totprice), 2 , '.' , ',' )." ISK</TD></TR>");
if($lvl5cruiser > 1)print("<TR><TD>Level 5 Cruiser Modifier: </TD><TD></TD><TD ALIGN=right>".number_format ((($baseprice + $totprice)*$lvl5cruiser) - ($baseprice + $totprice), 2 , '.' , ',' )." ISK</TD></TR>");
if($secval > 1)print("<TR><TD>High Sec Status Modifier: </TD><TD></TD><TD ALIGN=right>".number_format ((($baseprice + $totprice)*$secval) - ($baseprice + $totprice), 2 , '.' , ',' )." ISK</TD></TR>");
if($secval < 1)print("<TR><TD>Pirate Modifier: </TD><TD></TD><TD ALIGN=right>".number_format ((($baseprice + $totprice)*$secval) - ($baseprice + $totprice), 2 , '.' , ',' )." ISK</TD></TR>");

print("<TR><TD></TD><TD></TD><TD><HR></TD></TR>");
print("<TR><TD>Total Value: </TD><TD ALIGN=right></TD><TD ALIGN=right>".number_format ((((($baseprice + $totprice)*$secval)*$lvl5cruiser)*$spdecline) + $implanttotalprice, 2 , '.' , ',' )." ISK</TD></TR></TABLE>");
//print("-->");
if(isset($_POST["userID"]))
{
print("<HR>Want to appraise another character?<BR><BR><FORM METHOD=POST><TABLE><TR><TD>User ID</TD><TD><INPUT TYPE=text NAME=userID></TD></TR>");
print("<TR><TD>apiKey</TD><TD><INPUT TYPE=text NAME=apiKey></TD></TR>");
//print("<TR><TD>characterID</TD><TD><INPUT TYPE=text NAME=characterID></TD></TR>");
print("<TR><TD></TD><TD><INPUT TYPE=submit HEIGHT=20 VALUE='Appraise my character!'></TD></TR></TABLE><BR><BR>");
}

?>