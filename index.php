<?php
$browser = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
		if(strpos($browser, "EVE-IGB")>0)
		{
$ingame = 1;
}else{
$ingame = 0;
}
include("appraiser.php");
include("func.php");
if($ingame)
{

}
?>
<HTML>
<HEAD>
<TITLE><?=$title?></TITLE>
<script language="JavaScript">
function toggle(obj) {
	var el = document.getElementById(obj);
	if ( el.style.display != 'none' ) {
		el.style.display = 'none';
	}
	else {
		el.style.display = '';
	}
	var el = document.getElementById(obj+"_plus");
	if ( el.style.display != 'none' ) {
		el.style.display = 'none';
	}
	else {
		el.style.display = '';
	}
	var el = document.getElementById(obj+"_minus");
	if ( el.style.display != 'none' ) {
		el.style.display = 'none';
	}
	else {
		el.style.display = '';
	}
}</script>
<style type="text/css">
table {font-family:verdana; font-size:11px; background-color:#2c2c38; color:#ffffff;}
a:link {color:#ffa500;text-decoration:none;}      /* unvisited link */
a:visited {color:#967524;text-decoration:none;}  /* visited link */
a:hover {color:#ffa500;text-decoration:underline;}  /* mouse over link */
a:active {color:#967524;text-decoration:none;}  /* selected link */
.lineonhover { text-decoration:none; }
.lineonhover:hover { text-decoration:underline; }
</style>
</HEAD>
<BODY STYLE="background-color:#000000;">
<DIV STYLE="font-family:verdana; font-size:11px; border:solid white 1px; background-color:#2c2c38; color:#ffffff; width:80%; position:absolute; left:50%; top:10%; margin-left:-40%;">
<DIV STYLE="padding:1%; margin:0%; border-bottom:solid white 1px; background-color:#4d4d57;">
<CENTER><SPAN STYLE="font-size:36px;font-family:Kristen ITC;">EVE Character Appraiser</SPAN></CENTER>
</DIV>
<DIV STYLE="padding:2%; border-bottom:solid white 1px;">
<B>Introduction</B><P>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-6513671326664703";
/* Gemblog */
google_ad_slot = "0079377625";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script><BR><BR><P>
This is the EVE Character Appraiser, created and maintained by Gemberslaafje. Are you interested in selling your character, or just curious what you could get for your most prized posession? Try it out!<BR>
<?=$introduction?>
</DIV>
<DIV STYLE="padding:2%; border-bottom:solid white 1px;"><script type="text/javascript"><!--
google_ad_client = "ca-pub-6513671326664703";
/* Gemblog */
google_ad_slot = "0079377625";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script><BR><BR>
<B>Things worth mentioning</B><P>
This tool is absolutely free. However, that doesn’t mean I wouldn’t like a donation if you like this tool! So please don’t hesitate to send a few ISK to
<?
if($ingame)
{
print("<a href=# onclick=\"CCPEVE.showInfo(1377, 1199002469)\">Gemberslaafje</a>");
}else{
print("Gemberslaafje");
}
?>, it will be greatly appreciated.<BR>
Donators: Exopolitics, Rue Tomac<BR>
Special Thanks to: Durantis, Rivendark, Samuel Backet, KentOnline and Crime Zero for their help in improving and debugging the tool.<P>

You prefer a REAL appraiser? Try <a target=_BLANK href="http://www.eveonline.com/ingameboard.asp?a=topic&threadID=959650">Durantis’s post</A>! Also free and even more reliable! Maybe just a little slower ;)
</DIV>
<DIV STYLE="padding:2%; border-bottom:solid white 1px;">
<CENTER><SPAN STYLE="font-size:20px"><?=$charname?></SPAN><P>
<TABLE STYLE="font-family:verdana; font-size:11px; background-color:#2c2c38; color:#ffffff;">
<TR><TD STYLE="padding:2%;text-align:right;width:280px;">
<img style="height:100px; border:solid white 1px;" src="http://image.eveonline.com/Character/<?=$charid?>_256.jpg">
</TD><TD STYLE="padding:2%;width:280px;">
<B>Character Specials:</B><P>
<?=$charspecials?>
</TD></TR>
<TR><TD STYLE="padding:2%; text-align:right;">
<?=$finalSP?> SP x <?=$avgspvalue?> ISK = 
</TD><TD STYLE="border:solid white 1px;">
<SPAN STYLE="padding:2%; font-size:20px;"><?=$finalvalue?> ISK</SPAN>
</TD></TR>
</TABLE></CENTER>
</DIV>
<DIV STYLE="padding:2%; border-bottom:solid white 1px;">
<B>Skill Breakdown</B><P>
<?=$skillbreakdown?>
</DIV>
<DIV STYLE="padding:2%; border-bottom:solid white 1px;">
<B>Skill Details</B><P>
<?=$skilldetails?>
</DIV>
<FORM METHOD=POST><b>Key to save/load this character:</B>
<TEXTAREA STYLE="width:100%; height:100;" TYPE=TEXT NAME=hash><?=encode($skilllisttoencode,"secret key")?></TEXTAREA><BR>
<B>You can use this key in the <a href=http://gemblog.nl/assembler/>EVE Character Assembler</A></B>
</FORM><script type="text/javascript"><!--
google_ad_client = "ca-pub-6513671326664703";
/* Gemblog */
google_ad_slot = "0079377625";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script><BR><BR>
</DIV>
</BODY>
</HTML>