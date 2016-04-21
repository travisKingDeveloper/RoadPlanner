<?php
//*********
//*@Description echo limited text
//*@Param string $text, int $limit
//*@return string
//*********
function limit_text( $text, $limit )

{

if( strlen($text)>$limit )

{   $return='';
	for($i=0;$i<$limit;$i++)
	  { 
	 
	  $return =$return.$text[$i];
	 
	  
	   }

$text = $return."...";
}


return $text;

}


function show_date($datetime){
	
}

?>