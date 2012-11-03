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

//EForm Class
class EForm extends EDaLF {
	static $defaults = array(
		'Required'  => false,
		'MaxLength' => -1,
		'Hidden'    => false,
		'Rows'      => 3,
		'Columns'   => 20
	);

	private $table;
	private $formid;
	private $title = "Untitled Form";
	private $fields = array();

	//links to db table
	public function link($table){
		$this->table = $table;
	}

	//sets displayed title
	public function title($title){
		$this->title = $title;
	}

	//interprets information regarding fields
	public function map($map){
		foreach($map as $column=>$field){
			$i = count($this->fields);
			$this->fields[$i] = array();
			$this->fields[$i]['Column']   = $column;
			$this->fields[$i]['Label']    = $field[0];
			$this->fields[$i]['Type']     = $field[1];
			$this->fields[$i]['Default']  = $field[2];
			$this->fields[$i]['Settings'] = EForm::$defaults;
			foreach(explode(",",$field[3]) as $setting){
				switch(substr($setting,0,1)){
					case 'r':
						$this->fields[$i]['Settings']['Required'] = true;
						break;
					case 'l':
						$this->fields[$i]['Settings']['MaxLength'] = intval(substr($setting,1));
						break;
					case 'h':
						$this->fields[$i]['Settings']['Hidden'] = true;
						break;
					case 'w':
						$this->fields[$i]['Settings']['Rows'] = intval(substr($setting,1));
						break;
					case 'c':
						$this->fields[$i]['Settings']['Columns'] = intval(substr($setting,1));
						break;
				}
			}
		}
	}

	//attempts to set up map based on sql structure
	public function autoinit(){
		$q = EDaLF::$sql_object->query("SHOW TABLE STATUS LIKE '{$this->table}'");
		$r = $q->fetch_assoc();
		$this->title($r['Comment']);
		$q = EDaLF::$sql_object->query("SHOW FULL COLUMNS FROM `{$this->table}`");
		$temp = array();
		while($r = $q->fetch_assoc()){
			$i = count($temp);
			$temp[$r['Field']] = array();
			$temp[$r['Field']][0] = $r['Comment'];
			$temp[$r['Field']][2] = $r['Default'];
			$temp[$r['Field']][3] = "";
			$matches = array();
			preg_match('/([a-z]+)\((.+?)\).*/',$r['Type'],$matches);
			if(isset($matches[2])){
				$matches[2] = explode(",",$matches[2]);
			}
			switch($matches[1]){
				case 'varchar':
					$temp[$r['Field']][3] .= "l{$matches[2][0]},";
					if($matches[2][0] > 128){
						$temp[$r['Field']][1] = "TextArea";
					}
					else{
						$temp[$r['Field']][1] = "Text";
					}
					break;
			}
			if($r['Key'] == "PRI"){
				$temp[$r['Field']][1] = "Index";
			}
			if($r['Null'] != "YES"){
				$temp[$r['Field']][3] .= "r,";
			}			
		}
		$this->map($temp);
	}

	//generate unique signature for this form configuration
	public function finalize(){
		$this->formid = substr(md5(var_export($this,1)),0,13);
	}

	//shows table
	public function generateTable(){
		$this->output('Table',$this->table);
	}

	//shows form
	public function generateForm(){
		$this->output('Form');
	}

	//checks to see if data has been submitted, and pushes to db if it has
	public function checkPost(){
		if(!isset($_POST['edalf']))
			return false;
			
		if($_POST['edalf-id'] != $this->formid)
			return false;

		$values = array();
		foreach($this->fields as $field){
			if($field['Settings']['Hidden'] == true) continue;
			if($field['Type'] == "Index") continue;
			$values[$field['Column']] = $_POST[$field['Column']];
		}

		$query = "INSERT INTO `{$this->table}` SET ";
		foreach($values as $i=>$v){
			$v = EDaLF::$sql_object->real_escape_string($v);
			$query.= "`$i` = '$v', ";
		}
		$query = substr($query,0,-2);

		EDaLF::$sql_object->query($query);
		return EDaLF::$sql_object->insert_id;
	}

	//sends output request to handler
	private function output($type,$table=""){
		$f = EDaLF::$handlers[$type];
		$f($this->formid,$this->title,$this->fields,$table);
	}
}

?>
