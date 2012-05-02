<?php
include("appraiser.php");
?>
<HTML>
<HEAD>
<TITLE><?=$title?></TITLE>
</HEAD>
<BODY STYLE="background-color:#000000;">
<DIV STYLE="font-family:verdana; font-size:11px; border:solid white 1px; background-color:#2c2c38; color:#ffffff; width:80%; position:absolute; left:50%; top:10%; height:80%; margin-left:-40%;">
<DIV STYLE="padding:1%; margin:0%; border-bottom:solid white 1px; background-color:#4d4d57;">
<CENTER><SPAN STYLE="font-size:36px;font-family:Kristen ITC;">EVE Character Appraiser</SPAN></CENTER>
</DIV>
<DIV STYLE="padding:2%; border-bottom:solid white 1px;">
<B>Introduction</B><P>
This is the EVE Character Appraiser, created and maintained by Gemberslaafje. Are you interested in selling your character, or just curious what you could get for your most prized posession? Try it out!<BR>
<?=$introduction?>
</DIV>
<DIV STYLE="padding:2%; border-bottom:solid white 1px;">
<B>Things worth mentioning</B><P>
This tool is absolutely free. However, that doesn’t mean I wouldn’t like a donation if you like this tool! So please don’t hesitate to send a few ISK to Gemberslaafje, it will be greatly appreciated.<BR>
Donators: Exopolitics<BR>
Special Thanks to: Durantis, Rivendark, Samuel Backet and KentOnline for their help in improving and debugging the tool.<P>

You prefer a REAL appraiser? Try <a target=_BLANK href="http://www.eveonline.com/ingameboard.asp?a=topic&threadID=959650">Durantis’s post</A>! Also free and even more reliable! Maybe just a little slower ;)
</DIV>
<DIV STYLE="padding:2%; border-bottom:solid white 1px;">
<CENTER><SPAN STYLE="font-size:20px"><?=$charname?></SPAN><P>
<TABLE STYLE="font-family:verdana; font-size:11px; background-color:#2c2c38; color:#ffffff;">
<TR><TD STYLE="padding:2%;text-align:right;">
<img style="height:100px; border:solid white 1px;" src="http://img.eve.is/serv.asp?s=256&c=<?=$charid?>">
</TD><TD STYLE="padding:2%;">
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
</DIV>
</BODY>
</HTML>