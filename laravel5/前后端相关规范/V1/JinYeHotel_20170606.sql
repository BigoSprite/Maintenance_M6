CREATE DATABASE JinYeHotel;

USE JinYeHotel;

CREATE TABLE distribution_room_info (
  serialId						int(20) 				NOT NULL AUTO_INCREMENT,
  roomName						char(50) 				NOT NULL UNIQUE,
  description					char(100) 			DEFAULT NULL,
  address						  char(50) 				NOT NULL,
  contactPerson				char(50) 				NOT NULL,
  contactTel  				char(50) 				NOT NULL,
  registerDate				timestamp 	    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (serialId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE vdevice_type_info (
  name 							char(50) 				NOT NULL,
  typeDesc						text,
  PRIMARY KEY (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE asset_info (
  id							                    int(11)  				NOT NULL AUTO_INCREMENT,
  distributionRoomInfo_serialId				char(50) 				NOT NULL,
  name						                    char(50) 				NOT NULL,
  type							                  char(50) 				NOT NULL,
  unit							                  char(10) 				NOT NULL,
  amount						                  int(11)  				NOT NULL,
  addDate						                  timestamp 			NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


