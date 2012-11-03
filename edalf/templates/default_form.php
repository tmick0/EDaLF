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

//EDaLF default form
EDaLF::setDefaultHandler('Form',function($id,$title,$fields){
	$cols = count($fields);
	echo "<form class='edalf' method='post' action='{$_SERVER['PHP_SELF']}'>";
	echo "<input type='hidden' name='edalf' value='true'/>";
	echo "<input type='hidden' name='edalf-id' value='$id'/>";
	echo "<table border='0'>";
	echo "<tr><th colspan='$cols'>$title</th></tr>";
	foreach($fields as $field){
		if($field['Settings']['Hidden'] == true) continue;
		if($field['Type'] == "Index") continue;
		$maxl = "";
		if($field['Settings']['MaxLength'] > -1){
			$maxl = "maxlength='{$field['Settings']['MaxLength']}'";
		}
		$req = "";
		if($field['Settings']['Required'] == true){
			$req = "<sup>*</sup>";	
		}
		echo "<tr>";
		echo "<th>{$field['Label']} $req</td>";
		echo "<td>";
		switch($field['Type']){
			case 'Text':
				echo "<input $maxl type='text' name='{$field['Column']}' value='{$field['Default']}' size='{$field['Settings']['Columns']}'/>";
				break;
			case 'TextArea':
				echo "<textarea $maxl name='{$field['Column']}' rows='{$field['Settings']['Rows']}' cols='{$field['Settings']['Columns']}'>{$field['Default']}</textarea>";
				break;
		}
		echo "</td>";
		echo "</tr>";
	}
	echo "<tr><td colspan='$cols'><input type='submit' value='Submit &rarr;'/></td></tr>";
	echo "</table>";
	echo "</form>";
});

?>
