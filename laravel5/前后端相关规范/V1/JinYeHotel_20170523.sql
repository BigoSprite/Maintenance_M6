CREATE DATABASE JinYeHotel;

USE JinYeHotel;

CREATE TABLE distributionroom (
  serialId						char(20) 				NOT NULL,
  roomName						char(50) 				NOT NULL,
  description					char(100) 				DEFAULT NULL,
  address						char(50) 				NOT NULL,
  productionPro					char(50) 				DEFAULT NULL,
  telephoneNumber				char(50) 				NOT NULL,
  installationDate				timestamp 				NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (serialId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE gmdevice_type (
  name 							char(50) 				NOT NULL,
  typeDesc						text,
  PRIMARY KEY (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE asset_info (
  id							 int(11)  				NOT NULL AUTO_INCREMENT,
  serialId						 char(50) 				NOT NULL,
  name						     char(50) 				NOT NULL,
  type							 char(50) 				NOT NULL,
  unit							 char(10) 				NOT NULL,
  amount						 int(11)  				NOT NULL,
  addDate						 timestamp 				NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


