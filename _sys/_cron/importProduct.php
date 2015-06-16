<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include_once('cron_define.php');

$infile = 'productssample.csv';
$ch = new cronHelper(true);
$FH = fopen($infile, "r");
$desl_str = "trancate " . _DB_PF_ . "products";
$inStr = "insert into " . _DB_PF_ . "products (category,name,description,code,group_id,price,min_order,max_order,gst_free,priority)"
        . " values (?,?,?,?,?,?,?,?,?,?)";
$ch->db->update($desl_str);
while($data = fgetcsv($FH)) {
    $ch->db->update($inStr, array($data[4], $data[2], $data[3], $data[1], $data[6], $data[7], $data[10], $data[11], $data[24], $data[5]));
}

fclose($FH);
exit;