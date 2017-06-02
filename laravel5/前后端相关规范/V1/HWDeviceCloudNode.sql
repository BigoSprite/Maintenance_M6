CREATE DATABASE HWDeviceCloudNode;
USE HWDeviceCloudNode;

CREATE TABLE vdevice_node_info
(
  nodeName   char(50) NOT NULL,
  nodeRemark text     DEFAULT NULL,
  PRIMARY KEY (nodeName)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE vdevice_info (
  gprsID						char(20) 					NOT NULL,
  deviceName 					char(50) 					NOT NULL,
  deviceTypeName 				char(50) 					NOT NULL,
  deviceRemark                  text                        DEFAULT NULL,
  monitoredUnitName             char(50)                    NOT NULL, # 配电室名称（例如：配电室1）
  realestateinfo_dbName			char(50) 				    NOT NULL, # 也是数据库名称 外键（realestateinfo中的 dbName）
  protocolVersion				char(10) 					NOT NULL,
  protocolRemark				text    					DEFAULT NULL,
  contactPersonName             char(20)                    NOT NULL,                        
  contactTel					char(40) 					NOT NULL,
  deviceDetailInfo              text                        DEFAULT NULL,  # 适应未来接入一个真实设备
  parseJSON                     text                        DEFAULT NULL,
  isDiscarded					bit(1) 						DEFAULT b'0',
  addDate						timestamp 					NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (gprsID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE vdevice_status (
  gprsID						char(20) 					NOT NULL,
  isLogin						bit(1) 						DEFAULT b'0',
  lastLoginTime					datetime 					DEFAULT '0000-00-00 00:00:00',
  alarmFlag						bit(1) 						DEFAULT b'0',
  alarmUpdateTime				datetime 					DEFAULT NULL,
  isOperating					bit(1) 						DEFAULT b'0',
  operationDesc					char(200) 					DEFAULT NULL,
  operationUpdateTime			datetime 					DEFAULT NULL,
  PRIMARY KEY (gprsID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE realestateinfo (
  dbName						char(50) 					NOT NULL,
  realEstateName				char(50) 					NOT NULL,
  address						char(200) 					NOT NULL,
  description					text 				    	NOT NULL,
  PRIMARY KEY (dbName)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE vdevice_realtimedata (
  gprsID						char(20) 					NOT NULL,
  lastUpdateTime				timestamp 					NOT NULL DEFAULT '1970-01-01 08:00:01' ON UPDATE CURRENT_TIMESTAMP,
  var00 						bit(64) 				    DEFAULT NULL,
  var01 						bit(64) 				    DEFAULT NULL,
  var02 						bit(64) 				    DEFAULT NULL,
  var03 						bit(64) 				    DEFAULT NULL,
  var04 						bit(64) 				    DEFAULT NULL,
  var05 						bit(64) 				    DEFAULT NULL,
  var06 						bit(64) 				    DEFAULT NULL,
  var07 						bit(64) 				    DEFAULT NULL,
  var08 						bit(64) 				    DEFAULT NULL,
  var09 						bit(64) 				    DEFAULT NULL,
  var10 						bit(64) 				    DEFAULT NULL,
  var11 						bit(64) 				    DEFAULT NULL,
  var12 						bit(64) 				    DEFAULT NULL,
  var13 						bit(64) 				    DEFAULT NULL,
  var14 						bit(64) 				    DEFAULT NULL,
  var15 						bit(64) 				    DEFAULT NULL,
  var16 						bit(64) 				    DEFAULT NULL,
  var17 						bit(64) 				    DEFAULT NULL,
  var18 						bit(64) 				    DEFAULT NULL,
  var19 						bit(64) 				    DEFAULT NULL,
  var20 						bit(64) 				    DEFAULT NULL,
  var21 						bit(64) 				    DEFAULT NULL,
  var22 						bit(64) 				    DEFAULT NULL,
  var23 						bit(64) 				    DEFAULT NULL,
  var24 						bit(64) 				    DEFAULT NULL,
  var25 						bit(64) 				    DEFAULT NULL,
  var26 						bit(64) 				    DEFAULT NULL,
  var27 						bit(64) 				    DEFAULT NULL,
  var28 						bit(64) 				    DEFAULT NULL,
  var29 						bit(64) 				    DEFAULT NULL,
  var30 						bit(64) 				    DEFAULT NULL,
  var31 						bit(64) 				    DEFAULT NULL,
  var32 						bit(64) 				    DEFAULT NULL,
  var33 						bit(64) 				    DEFAULT NULL,
  var34 						bit(64) 				    DEFAULT NULL,
  var35 						bit(64) 				    DEFAULT NULL,
  var36 						bit(64) 				    DEFAULT NULL,
  var37 						bit(64) 				    DEFAULT NULL,
  var38 						bit(64) 				    DEFAULT NULL,
  var39 						bit(64) 				    DEFAULT NULL,
  var40 						bit(64) 				    DEFAULT NULL,
  var41 						bit(64) 				    DEFAULT NULL,
  var42 						bit(64) 				    DEFAULT NULL,
  var43 						bit(64) 				    DEFAULT NULL,
  var44 						bit(64) 				    DEFAULT NULL,
  var45 						bit(64) 				    DEFAULT NULL,
  var46 						bit(64) 				    DEFAULT NULL,
  var47 						bit(64) 				    DEFAULT NULL,
  var48 						bit(64) 				    DEFAULT NULL,
  var49 						bit(64) 				    DEFAULT NULL,
  PRIMARY KEY (gprsID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE vdevice_0000000001 (
  saveTime   					datetime 					NOT NULL,
  var00							bit(64) 					DEFAULT NULL,
  var01							bit(64) 					DEFAULT NULL,
  var02							bit(64) 					DEFAULT NULL,
  var03							bit(64) 					DEFAULT NULL,
  var04							bit(64) 					DEFAULT NULL,
  var05							bit(64) 					DEFAULT NULL,
  var06							bit(64) 					DEFAULT NULL,
  var07							bit(64) 					DEFAULT NULL,
  var08							bit(64) 					DEFAULT NULL,
  var09							bit(64) 					DEFAULT NULL,
  var10							bit(64) 					DEFAULT NULL,
  var11							bit(64) 					DEFAULT NULL,
  var12							bit(64) 					DEFAULT NULL,
  var13							bit(64) 					DEFAULT NULL,
  var14							bit(64) 					DEFAULT NULL,
  var15							bit(64) 					DEFAULT NULL,
  var16							bit(64) 					DEFAULT NULL,
  var17							bit(64) 					DEFAULT NULL,
  var18							bit(64) 					DEFAULT NULL,
  var19							bit(64) 					DEFAULT NULL,
  var20							bit(64) 					DEFAULT NULL,
  var21							bit(64) 					DEFAULT NULL,
  var22							bit(64) 					DEFAULT NULL,
  var23							bit(64) 					DEFAULT NULL,
  var24							bit(64) 					DEFAULT NULL,
  var25							bit(64) 					DEFAULT NULL,
  var26							bit(64) 					DEFAULT NULL,
  var27							bit(64) 					DEFAULT NULL,
  var28							bit(64) 					DEFAULT NULL,
  var29							bit(64) 					DEFAULT NULL,
  var30							bit(64) 					DEFAULT NULL,
  var31							bit(64) 					DEFAULT NULL,
  var32							bit(64) 					DEFAULT NULL,
  var33							bit(64) 					DEFAULT NULL,
  var34							bit(64) 					DEFAULT NULL,
  var35							bit(64) 					DEFAULT NULL,
  var36							bit(64) 					DEFAULT NULL,
  var37							bit(64) 					DEFAULT NULL,
  var38							bit(64) 					DEFAULT NULL,
  var39							bit(64) 					DEFAULT NULL,
  var40 						bit(64) 				    DEFAULT NULL,
  var41 						bit(64) 				    DEFAULT NULL,
  var42 						bit(64) 				    DEFAULT NULL,
  var43 						bit(64) 				    DEFAULT NULL,
  var44 						bit(64) 				    DEFAULT NULL,
  var45 						bit(64) 				    DEFAULT NULL,
  var46 						bit(64) 				    DEFAULT NULL,
  var47 						bit(64) 				    DEFAULT NULL,
  var48 						bit(64) 				    DEFAULT NULL,
  var49 						bit(64) 				    DEFAULT NULL,
  PRIMARY KEY (saveTime)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



