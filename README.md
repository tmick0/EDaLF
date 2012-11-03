EDaLF
=====

Easy DAtabase-Linked Forms (for PHP)
------------------------------------
Travis Mick  
lq@le1.ca  
November 2012

Version 0.01a - Prototype release

[View demonstration ->](http://le1.ca/home/edalf/)

- - -

###Quick Setup Guide:
1. Create a MySQL table for a form to use  
    See `edalf-example.sql` for sample structure

2. Import the EDaLF classes  
    `require_once 'edalf/edalf.php';`

3. Create a new form  
    `$EForm1 = EDaLF::newForm();`

4. Link the form to the database table  
    `$EForm1->link('example1');`

5. Configure the field mappings, either manually or automagically
    Manual  
    ```
    $EForm1->map(array(  
        'RowIndex'    => array('ID',            'Index',    '',                            ''      ) ,  
        'FirstName'   => array('First Name',    'Text',     'John',                        'r,l32' ) ,  
        'LastName'    => array('Last Name',     'Text',     'Doe',                         'r,l32' ) ,    
        'Phone'       => array('Phone Number',  'Text',     'xxx-xxx-xxxx',                'l13'   ) ,    
        'Email'       => array('Email Address', 'Text',     'xyzzy@example.com',           'r,l128') ,    
        'Comments'    => array('Comments',      'TextArea', 'Please leave your feedback.', 'r,l300,w6,c45')  
    ));
    ```
    
    Automatic - attempts to autodetect these parameters from the database structure  
    `$EForm1->autoinit();`

6. Finalize the field mappings, to generate a unique identifier for the form  
    `$EForm1->finalize();`

7. Do something with the form
    * Make a form to input data  
    `$EForm1->generateForm();`
    * Handle submitted data  
    `$EForm1->checkPost();`
    * Display the content of the table  
    `$EForm1->generateTable();`

See `edalf-example.php` for more details
