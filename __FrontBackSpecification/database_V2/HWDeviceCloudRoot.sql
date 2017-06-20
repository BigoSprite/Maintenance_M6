CREATE DATABASE HWDeviceCloudRoot;
USE HWDeviceCloudRoot;

CREATE TABLE userInfo (
  userName 						char(30) 					NOT NULL,
  loginPassword 				char(50) 					NOT NULL,
  PRIMARY KEY (userName)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE nodeInfo
(
  nodeName                      char(50)                    NOT NULL,
  nodeIp    					char(50) 					NOT NULL,
  nodePort						int(11) 					NOT NULL,
  nodeUserName					char(50) 					NOT NULL,
  nodePassword					char(50) 					NOT NULL,
  address                       char(200) 					NOT NULL,
  remark                        text                        DEFAULT NULL,
  PRIMARY KEY (nodeName)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE realEstateInfo (
  dbName						char(50) 					NOT NULL,
  realEstateName				char(50) 					NOT NULL,
  address						char(200) 					NOT NULL,
  description					text 				    	NOT NULL,
  manageCompany                 char(200)                   NOT NULL,
  serviceEndDateTime            datetime                    NOT NULL,
  contactPersonName             char(20)                    NOT NULL,
  contactTel                    char(40)                    NOT NULL,
  longitude						float(13,10) 				NOT NULL,
  latitude						float(13,10) 				NOT NULL,
  nodeInfo_nodeName             char(50)                   NOT NULL,
  dbIp							char(50) 					NOT NULL,
  dbPort						int(11) 					NOT NULL,
  dbUserName					char(50) 					NOT NULL,
  dbPassword					char(50) 					NOT NULL,
  isDiscarded					bit(1) 						DEFAULT b'0',         
  PRIMARY KEY (dbName)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;