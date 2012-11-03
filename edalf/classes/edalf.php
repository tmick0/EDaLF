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

//Main EDaLF class
class EDaLF {
	static $sql_object;
	static $forms = array();
	static $handlers = array();

	//connects to mysql server
	static function connect($host,$user,$pass,$db){
		EDaLF::$sql_object = new mysqli($host,$user,$pass,$db);
		return true;
	}

	//creates new form object
	static function newForm(){
		$temp = new EForm();
		$forms[] = $temp;
		return $temp;
	}

	//sets handler
	static function setDefaultHandler($type,$function){
		EDaLF::$handlers[$type] = $function;
	}

	//shortcut for querying the database
	protected function query($s){
		EDaLF::$sql_object->query($s);
	}

	//commits and closes db connection at end of execution
	function __destruct(){
		EDaLF::$sql_object->commit();
		EDaLF::$sql_object->close();
	}
}

?>
