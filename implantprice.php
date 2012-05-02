<?php
$id = 1;
MySQL_CONNECT("localhost","Username","Password");
MySQL_SELECT_DB("DataBase");

 $priceinfo = file("http://www.eve-database.com/?MGID=24&MGID2=27&MGID3=532");
 foreach($priceinfo as $line)
 {
 //print("<HR>");
 $tableexp = explode("</td>",$line);
 foreach($tableexp as $checkme)
 {
	//print($checkme."<BR>\n");
	if(strpos($checkme, "onmouseout=\"ciclose()\">")>0)
	{
 $start = strpos($checkme,"ciclose()");
 $tmp = substr($checkme,$start + 11);
 $end = strpos($tmp,"<");
 $name = substr($tmp,0,$end);
	
	}
	if(strpos($checkme, "color: #a5f699;")>0)
	{
 $start = strpos($checkme,">");
 $tmp = substr($checkme,$start+1);
 $end = strpos($tmp," M");
 print($start." ".$tmp." ".$end."<HR>");
 $price = substr($tmp,0,$end);
 $price *= 1000000;
	print("Name: ".$name." Price:".$price."<BR>");
 MySQL_QUERY("INSERT INTO pr_implants(implant_ID, implant_name,implant_price)VALUES(".$id.",'".$name."','".$price."')") or die(MySQL_ERROR());
 $id++;
	}
  }
 //print($line."<BR>");
//if(strpos($line, "median>")>0)
//{
 //$tmp = substr($line,8);
 //$end = strpos($tmp,".");
 //$price = substr($tmp,0,$end);
 //print($arr_skills["skill_name"].": ".$price);
 //MySQL_QUERY("UPDATE pr_skills SET skill_price = '".$price."' WHERE skill_ID = '".$arr_skills["skill_ID"]."'");
//break;
 }
 

?>