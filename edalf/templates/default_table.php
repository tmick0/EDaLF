<?php

//********************************************************************************//
//                                                                                //
// EDaLF                                                                          //
// Easy DAtabase-Linked Forms (for PHP)                                           //
// Version 0.01a - Prototype release                                              //
//                                                                                //
// Travis Mick                                                                    //
// lq@le1.ca                                                                      //
// November 2012                                                                  //
//                                                                                //
//********************************************************************************//

//EDaLF default table
EDaLF::setDefaultHandler('Table',function($id,$title,$fields,$table){
	$cols = count($fields);
	echo "<div class='edalf edalf-res'>";
	echo "<table>";
	echo "<tr><th colspan='$cols'>$title</th></tr>";
	echo "<tr>";
	foreach($fields as $field){
		echo "<th>{$field['Label']}</th>";
	}
	echo "</tr>";
	$q = EDaLF::$sql_object->query("SELECT * FROM `$table`");
	if($q->num_rows > 0){
		while($r = $q->fetch_assoc()){
			echo "<tr>";
			foreach($fields as $field){
				echo "<td>{$r[$field['Column']]}</td>";
			}
			echo "</tr>";
		}
	}
	else{
		echo "<tr><td colspan='$cols'><i>(No results.)</i></td></tr>";
	}
	echo "</table>";
	echo "</div>";
});

?>
