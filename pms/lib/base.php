<?php
/*
 * The-Di-Lab coding lib
 * www.the-di-lab.com
 */
require_once 'database.php';
class Base {
	protected $_name=null;
	protected $_primaryKey='id';
	protected $_parentId='parent_id';
	protected $_tbl=null;
	
	private $_database=null;	
	private $_sql=null;	
	
    public function __construct(){    		
            $this->_database = Database::singleton();
    }
	
	public function save($model) {
		$fields = array_keys($model);
		$values = array_values($model);		
		//get fields		
		if(sizeof($fields)!=0){
			$sqlFids = implode(',',$fields);		
		}
		//get values
		for($i=0;$i<sizeof($values);$i++){
				if($i==0){
					//$sqlValues = '"'.htmlspecialchars($values[$i], ENT_QUOTES).'"';
					$sqlValues = '"'.strip_tags($values[$i], "<b>").'"';
				}else {
					//$sqlValues =$sqlValues. ','.'"'.htmlspecialchars($values[$i], ENT_QUOTES).'"';
					$sqlValues =$sqlValues. ','.'"'.strip_tags($values[$i], "<b>").'"';
				}
		}		
		$this->_sql = 'INSERT INTO '.$this->getTbl().' ('.$sqlFids.') VALUES ('.$sqlValues.') ';
		//execute command		
		if($this->_database->query($this->_sql)){
			return true;
		}else {
			return false;
		}
	}
				
	public function getLastInsertId(){
			return mysql_insert_id();
	}
	
	public function update($model) {
		//get sql
		if(null==$model[$this->_primaryKey]){
			echo 'Missing Primary Key for this model';
		}else {
			$this->_sql = 'UPDATE '.$this->getTbl().' SET ';
			foreach($model as $cFid => $val){
					if($this->_primaryKey!=$cFid){
						$this->_sql = $this->_sql .$cFid.'='.'"'.htmlspecialchars($val, ENT_QUOTES).'",';
					}					
			}			
			$this->_sql =substr($this->_sql,0,strlen($this->_sql)-1);
			$this->_sql = $this->_sql .' WHERE '.$this->_primaryKey.' = '.$model[$this->_primaryKey];
		}
		//execute command		
		if($this->_database->query($this->_sql)){
			return true;
		}else {
			return false;
		}
	}

	public function find($conditions=null,$fields=null,$order=null) { 
		//get fields
		if($fields==null){
			$sqlFids ='*';
		}else {
			$sqlFids = implode(',',$fields);			
		}
		//get conditions
		$sqlConditions='';
		if( null!=$conditions){
			foreach($conditions as $cFid => $val){ 
				$sqlConditions .= ' AND ' .$cFid.' '.$val;
			}			
		}		
		//get order
		$orderBy = '';
		if(null!=$order){
				$orderBy = ' ORDER BY ';
			foreach($order as $key=>$value){
				$orderBy = $orderBy.$key.' '.$value.' AND';
			}
				$orderBy = substr($orderBy,0,strlen($orderBy)-3);
		}
		$this->_sql ='SELECT '.$sqlFids.' FROM '.$this->getTbl(). ' WHERE  1 = 1 '.$sqlConditions.' '.$orderBy;     
		
		$result = $this->_database->query($this->_sql);        
        return $this->__formatData($result);
	}
	
	public function delete($model){
		//get sql statement
		if(null==$model[$this->_primaryKey]){
			echo 'Missing Primary Key for this model';
		}else{
			$this->_sql = 'DELETE FROM '.$this->getTbl().' WHERE '.$this->_primaryKey.' = '.$model[$this->_primaryKey];
		}		
		//execute command		
		if($this->_database->query($this->_sql)){
			return true;
		}else {
			return false;
		}
	}
	//find threaded of a particular parent
	public function findThreads($conditions=null,$fields=null,$order=null){
		$parents = $this->find($conditions,$fields,$order);
		foreach($parents as &$parent){				
			 $this->__findChildren($parent,$fields,$order);
		}
		return $parents;
	}	
	
	public function query($sql){
		$this->_sql =$sql;
		return $this->_database->query($this->_sql);
	}
	
	protected function __findChildren(&$parent,$fields=null,$order=null){
			$children = $this->find(array(($this->_parentId)=>'='.$parent[$this->_name][$this->_primaryKey]),$fields,$order);
			
			if(is_array($children)&&sizeof($children)!=0){				
				foreach ($children as &$child){
					$this->__findChildren($child,$fields,$order);	
				}
				$parent['Children'] = $children;			
			}else {
				return;
			}
	}
		
	public function __formatData($result){
		$data= array();
		while ($row = mysql_fetch_assoc($result)) {
		   $data[][$this->_name]=$row;
		}
		if(sizeof($data)==0){
			return null;
		}else {
			return $data;
		}
		
	}
			
	private function __cleanInput($dirty){
		if (get_magic_quotes_gpc()) {
			$clean = mysql_real_escape_string(stripslashes($dirty));
		}else{
			$clean = mysql_real_escape_string($dirty);
		}
		return $clean;
	}

	public function getTbl(){
		return $this->_tbl;
		//return strtolower($this->_name).'s';
	}	
		
	public function debugSql(){
		return $this->_sql;
	}

}
?>
