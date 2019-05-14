SET foreign_key_checks = 0;
DROP TABLE IF EXISTS `music_device`;
DROP TABLE IF EXISTS `music_store`;
DROP TABLE IF EXISTS `music_library`;
DROP TABLE IF EXISTS `music_arrange`;
DROP TABLE IF EXISTS `music_arrange_device`;
DROP TABLE IF EXISTS `music_arrange_item`;
-- ----------------------------
-- 音乐设备表
-- ----------------------------
CREATE TABLE `music_device`
(
  `id`             INT(11)     NOT NULL AUTO_INCREMENT,
  `deviceNo`       VARCHAR(10) NOT NULL UNIQUE,
  `deviceName`     VARCHAR(32) NOT NULL,
  `mac`            VARCHAR(32) NOT NULL UNIQUE,
  `storeNo`        VARCHAR(20) NOT NULL,
  `onlineStatus`   TINYINT(1)  NOT NULL,
  `registerStatus` TINYINT(1)  NOT NULL,
  `storageCard`    VARCHAR(10),
  `appVersion`     VARCHAR(30),
  `deviceSound`    VARCHAR(20),
  `lastMsgTime`    DATETIME,
  `createTime`     DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updateTime`     DATETIME,
  PRIMARY KEY (`id`)
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;

-- ----------------------------
-- 音乐门店表
-- ----------------------------
CREATE TABLE `music_store`
(
  `id`           INT(11)     NOT NULL AUTO_INCREMENT,
  `storeNo`      VARCHAR(20) NOT NULL UNIQUE,
  `storeName`    VARCHAR(32) NOT NULL,
  `customerName` VARCHAR(20) NOT NULL,
  `address`      VARCHAR(64),
  `createTime`   DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updateTime`   DATETIME,
  PRIMARY KEY (`id`)
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;

-- ----------------------------
-- 音乐库表
-- ----------------------------
CREATE TABLE `music_library`
(
  `id`         INT(11)     NOT NULL AUTO_INCREMENT,
  `musicNo`    VARCHAR(20) NOT NULL UNIQUE,
  `musicName`  VARCHAR(64) NOT NULL,
  `musicSize`  BIGINT(20)  NOT NULL,
  `musicUrl`   VARCHAR(60) NOT NULL,
  `playTime`   INT(20)     NOT NULL,
  `md5`        VARCHAR(32) NOT NULL,
  `createTime` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;

-- ----------------------------
-- 音乐播期表
-- ----------------------------
CREATE TABLE `music_arrange`
(
  `id`           INT(11)     NOT NULL AUTO_INCREMENT,
  `arrangeNo`    VARCHAR(20) NOT NULL UNIQUE,
  `arrangeName`  VARCHAR(64) NOT NULL,
  `customerName` VARCHAR(32) NOT NULL,
  `beginDate`    DATE,
  `endDate`      DATE,
  `beginTime`    VARCHAR(10) NOT NULL,
  `endTime`      VARCHAR(10) NOT NULL,
  `arrangeLevel` TINYINT(1)  NOT NULL,
  `createTime`   DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updateTime`   DATETIME,
  PRIMARY KEY (`id`)
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;

-- ----------------------------
-- 音乐播控表
-- ----------------------------
CREATE TABLE `music_arrange_device`
(
  `id`            INT(11)     NOT NULL AUTO_INCREMENT,
  `storeNo`       VARCHAR(10) NOT NULL,
  `deviceNo`      VARCHAR(20) NOT NULL,
  `progress`      INT(10),
  `pubStatus`     TINYINT(1)  NOT NULL DEFAULT 0,
  `arrangeStatus` TINYINT(1)  NOT NULL DEFAULT 0,
  `arrangeNo`     VARCHAR(20) NOT NULL,
  `arrangeName`   VARCHAR(64) NOT NULL,
  `beginDate`     DATE,
  `endDate`       DATE,
  `beginTime`     VARCHAR(10) NOT NULL,
  `endTime`       VARCHAR(10) NOT NULL,
  `arrangeLevel`  TINYINT(1)  NOT NULL,
  `createTime`    DATETIME             DEFAULT CURRENT_TIMESTAMP,
  `updateTime`    DATETIME,
  CONSTRAINT uk_music_arrange_device UNIQUE (deviceNo, arrangeNo),
  PRIMARY KEY (`id`)
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;

-- ----------------------------
-- 音乐播期子表
-- ----------------------------
CREATE TABLE `music_arrange_item`
(
  `id`        INT(11)     NOT NULL AUTO_INCREMENT,
  `arrangeNo` VARCHAR(20) NOT NULL ,
  `musicNo`   VARCHAR(20) NOT NULL,
  CONSTRAINT uk_music_arrange_item UNIQUE (musicNo, arrangeNo),
  PRIMARY KEY (`id`),
  FOREIGN KEY (musicNo) REFERENCES music_library (musicNo)  on update cascade on delete cascade,
  FOREIGN KEY (arrangeNo) REFERENCES music_arrange (arrangeNo)  on update cascade on delete cascade
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;

CREATE TABLE `socket_message`
(
  `id`           INT(11)     NOT NULL AUTO_INCREMENT,
  `devId`      VARCHAR(30) NOT NULL,
  `message`    VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = INNODB
  DEFAULT CHARSET = utf8;
