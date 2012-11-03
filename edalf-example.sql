/* Example EDaLF table */

CREATE TABLE IF NOT EXISTS `example1` (
  `RowIndex` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `FirstName` varchar(32) NOT NULL COMMENT 'First Name',
  `LastName` varchar(32) NOT NULL COMMENT 'Last Name',
  `Phone` varchar(13) DEFAULT NULL COMMENT 'Phone',
  `Email` varchar(128) NOT NULL COMMENT 'Email',
  `Comments` varchar(300) NOT NULL COMMENT 'Comments',
  PRIMARY KEY (`RowIndex`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Feedback Form' AUTO_INCREMENT=1 ;

