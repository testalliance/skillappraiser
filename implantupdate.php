<?
MySQL_CONNECT("localhost","Username","Password");
MySQL_SELECT_DB("DataBase");

MySQL_QUERY("UPDATE pr_implants SET implant_attribute = 3");
MySQL_QUERY("UPDATE pr_implants SET implant_attribute = 1 WHERE implant_name LIKE '%Limited%'");
MySQL_QUERY("UPDATE pr_implants SET implant_attribute = 2 WHERE implant_name LIKE '%Limited%' AND implant_name LIKE '% - Beta%'");
MySQL_QUERY("UPDATE pr_implants SET implant_attribute = 3 WHERE implant_name LIKE '% - Basic%'");
MySQL_QUERY("UPDATE pr_implants SET implant_attribute = 4 WHERE implant_name LIKE '% - Standard%'");
MySQL_QUERY("UPDATE pr_implants SET implant_attribute = 5 WHERE implant_name LIKE '% - Improved%'");
MySQL_QUERY("UPDATE pr_implants SET implant_attribute = 2 WHERE implant_name LIKE '%Low-Grade%'");
?>