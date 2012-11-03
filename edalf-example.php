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
// A demonstration of this example code can be found at http://le1.ca/home/edalf/ //
// Source can be found at https://github.com/le1ca/EDaLF                          //
//                                                                                //
//********************************************************************************//

// import the edalf classes
require_once 'edalf/edalf.php';

// establishes connection to mysql server
EDaLF::connect('localhost','edalf','password','edalf');

// change settings
EForm::$defaults['Rows'] = 6;
EForm::$defaults['Columns'] = 45;

// create new form and link to table `example1`
$EForm1 = EDaLF::newForm();
$EForm1->link('example1');

/*
// manual configuration
$EForm1->title('Feedback Form');
$EForm1->map(array(
	//column               label            type        default                        options
	'RowIndex'    => array('ID',            'Index',    '',                            ''      ) ,
	'FirstName'   => array('First Name',    'Text',     'John',                        'r,l32' ) ,
	'LastName'    => array('Last Name',     'Text',     'Doe',                         'r,l32' ) ,
	'Phone'       => array('Phone Number',  'Text',     'xxx-xxx-xxxx',                'l13'   ) ,
	'Email'       => array('Email Address', 'Text',     'xyzzy@example.com',           'r,l128') ,
	'Comments'    => array('Comments',      'TextArea', 'Please leave your feedback.', 'r,l300,w6,c45')
	
	// options explained:
	// r  = required field
	// l# = maximum length
	// w# = textarea rows
	// c# = textarea cols
));
*/

// automatically loads most options from mysql table
$EForm1->autoinit();

// sets internal id to allow data to be saved
$EForm1->finalize();

?>
<!DOCTYPE html>
<html>
<head>
	<title>EDaLF Demonstration</title>
	<style type="text/css">
		.edalf table{
			margin:1px;
			padding:1px;
			border:2px solid rgba(120,154,152,0.6);
			background-color:#8aa8a6;
			color:#ffffff;
			border-radius:4px;
			box-shadow:0px 0px 24px rgba(0,0,0,0.2);
		}
		.edalf th{
			text-shadow:1px 1px 2px rgba(0,0,0,0.3);
			font-weight:normal;
			font-size:16px;
		}
		.edalf input,.edalf textarea{
			font-family:monospace;
			font-size:12px;
			width:95%;
			display:block;
			margin:3px auto 3px auto;
		}
		.edalf table th{
			text-align:left;
		}
		.edalf table tr>*{
			border-top:1px solid #b9cecc;
		}
		.edalf table tr:first-child{
			height:32px;
		}
		.edalf table tr:first-child th{
			text-align:center;
			border-top:none;
			border:2px solid rgba(120,154,152,0.6);
			background-color:rgba(197,230,228,0.3);
			border-radius:8px;
			font-weight:bold;
			padding-left:4px;
			padding-right:4px;
		}
		.edalf table tr:nth-child(2)>*{
			border-top:none;
		}

		.edalf-res td+td, .edalf-res th+th{
			border-left:1px solid #b9cecc;
			padding-left:3px;
		}
		.edalf-res tr:nth-child(2)>*{
			font-weight:bold;
		}
	</style>
</head>
<body>
<?php
// sample application - show form, then show table on submit
if($i = $EForm1->checkPost() || isset($_GET['table'])){
	$EForm1->generateTable();
}
else{
	$EForm1->generateForm();
}
?>
</body>
</html>
