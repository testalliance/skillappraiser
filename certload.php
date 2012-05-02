<?php
require_once('dbconfig.php');

$contents = file ( "http://api.eve-online.com/eve/CertificateTree.xml.aspx" );
//print("<!--");
$rowsetdepth = 0;
foreach($contents as $line)
{
	if(strpos($line, "/rowset>")>0)
	{
		print("minmin<BR>");
		$rowsetdepth--;
	}
	if(strpos($line, "<rowset ")>0)
	{
		if(!(strpos($line, "/")>0))
		{
			print("plusplus<BR>");
			$rowsetdepth++;
		}
	}
	if($rowsetdepth == 1)
	{
		if(strpos($line, "row categoryID=")>0)
		{
			$start = strpos($line,"categoryID=");
			$tmp = substr($line,$start+12);
			$end = strpos($tmp, "\"");
			$catID = substr($tmp,0,$end);

			$start = strpos($line,"categoryName=");
			$tmp = substr($line,$start+14);
			$end = strpos($tmp, "\"");
			$catname = substr($tmp,0,$end);
			$query = "INSERT INTO pr_certcats(certcat_ID, certcat_name)values('".$catID."','".$catname."')";
			MySQL_QUERY($query);
			print($query);
		}
	}
	if($rowsetdepth == 2)
	{
		if(strpos($line, "row classID=")>0)
		{
			$start = strpos($line,"className=");
			$tmp = substr($line,$start+11);
			$end = strpos($tmp, "\"");
			$certname = substr($tmp,0,$end);
		}
	}
	if($rowsetdepth == 3)
	{
		if(strpos($line, "row certificateID=")>0)
		{
			$start = strpos($line,"certificateID=");
			$tmp = substr($line,$start+15);
			$end = strpos($tmp, "\"");
			$certID = substr($tmp,0,$end);
			$start = strpos($line,"grade=");
			$tmp = substr($line,$start+7);
			$end = strpos($tmp, "\"");
			$certgrade = substr($tmp,0,$end);
			$query = "UPDATE pr_certificates SET certificate_category = '".$catID."' WHERE certificate_ID = '".$certID."'";
			MySQL_QUERY($query);
			print($query."<BR>");
			$query = "INSERT INTO pr_certificates(certificate_ID, certificate_name, certificate_grade)values('".$certID."','".$certname."','".$certgrade."')";
			//MySQL_QUERY($query);
			print($query."<BR>");
		}
	}
	if($rowsetdepth == 4)
	{
		if(strpos($line, "row typeID=")>0)
		{
			$start = strpos($line,"typeID=");
			$tmp = substr($line,$start+8);
			$end = strpos($tmp, "\"");
			$reqskillID = substr($tmp,0,$end);
			$start = strpos($line,"level=");
			$tmp = substr($line,$start+7);
			$end = strpos($tmp, "\"");
			$reqskilllevel = substr($tmp,0,$end);
			$query = "INSERT INTO pr_certskills(certskill_certificate, certskill_skill, certskill_level)values('".$certID."','".$reqskillID."','".$reqskilllevel."')";
			//MySQL_QUERY($query);
			print($query."<BR>");
		}
		if(strpos($line, "row certificateID=")>0)
		{
			$start = strpos($line,"certificateID=");
			$tmp = substr($line,$start+15);
			$end = strpos($tmp, "\"");
			$reqcertID = substr($tmp,0,$end);
			$query = "INSERT INTO pr_certreq(certreq_certificate, certreq_requirement)values('".$certID."','".$reqcertID."')";
			//MySQL_QUERY($query);
			print($query."<BR>");
		}
	}


}


//print("-->");
?>