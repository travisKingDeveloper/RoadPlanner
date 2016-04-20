<?php
require_once '../admin/node_m.php';
//Base Testing case
	$node = new Node();
	
	//save
	$i['Node']['name']='test1';
	$i['Node']['url']='tests1';
	//$node->save($i['Node']);
	
	//get last insert Id
	//echo $node->getLastInsertId();
	
	//update
	$i['Node']['id']=7;
	$i['Node']['name']='test2';
	$i['Node']['url']='tests2';
	//$node->update($i['Node']);
	
	
	//find
	//$result = $node->find(array('id'=>'=1'),null,array('id'=>'ASC'));
	//print_r($result);
	//echo $node->debugSql();
	//delete
	
	//find
	//$result = $node->findThreads(array('id'=>'=1'));
	//echo '<br/>';
	//echo '<br/>';
	//print_r($result);
	//$i['Node']['id']=4;	
	
	//$node->delete($i['Node']);
	
?>
