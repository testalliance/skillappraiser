<?php
MySQL_CONNECT("localhost","Username","Password");
MySQL_SELECT_DB("DataBase");

for($rank = 1; $rank < 30; $rank++)
{
$level[1] = 250*$rank;
$level[2] = 1414*$rank;
$level[3] = 8000*$rank;
$level[4] = 45255*$rank;
$level[5] = 256000*$rank;
for($lvl = 1; $lvl < 6; $lvl++)
{
$query = "INSERT INTO pr_ranklevel(ranklevel_rank, ranklevel_level, ranklevel_sp)VALUES(".$rank.",".$lvl.",".$level[$lvl].")";
MySQL_QUERY($query) OR DIE(mySQL_ERROR());
}
}
?>