DROP DATABASE JACAL_COURSE;
CREATE DATABASE JACAL_COURSE;
USE JACAL_COURSE;

CREATE TABLE SYS_PERMISSION_ACCESS
(
	PERMISION_ACCESS_ID		INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    PER_PERMISSION_LEVEL	INT,
    PER_DESCRIPTION			TEXT
);



CREATE TABLE SYS_USER
(
	USER_ID					INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    USE_NAME				VARCHAR(50),
    USE_USER_NAME			VARCHAR(50),
    USE_PASSWORD			VARCHAR(50),
    USE_IMAGE_PROFILE		TEXT,
    USE_LAST_SESSION		DATETIME,
	USE_STATUS				INT
);


CREATE TABLE SYS_USER_ACCESS
(
	USER_ACCESS_ID			INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    USER_ID					INT,
    PERMISSION_ACCESS_ID	INT,
    FOREIGN KEY (USER_ID) REFERENCES SYS_USER(USER_ID),
    FOREIGN KEY (PERMISSION_ACCESS_ID) REFERENCES SYS_PERMISSION_ACCESS (PERMISSION_ACCESS_ID)
);

CREATE TABLE SYS_COURSE
(	
    COURSE_ID				INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    COU_NAME				VARCHAR(200),
    USER_ID					INT,
    COU_STATUS				INT,
    FOREIGN KEY (USER_ID) REFERENCES SYS_USER (USER_ID)
);


CREATE TABLE SYS_LANGUAGE
(
	LANGUAGE_ID				INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    LAN_LANGUAGE			VARCHAR(50)
);

CREATE TABLE SYS_COURSE_LANGUAGE
(
	COURSE_LANGUAGES_ID		INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    COURSE_ID				INT,
    LANGUAGE_ID				INT,
    FOREIGN KEY (COURSE_ID) REFERENCES SYS_COURSE (COURSE_ID),
    FOREIGN KEY (LANGUAGE_ID)	REFERENCES SYS_LANGUAGE (LANGUAGE_ID)
);


CREATE TABLE SYS_COURSE_TOPIC
(
	COURSE_TOPIC_ID			INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    COURSE_ID				INT,
    CTO_TOPIC				VARCHAR(200),
    CTO_PHASES				INT,
    CTO_STATUS				INT,
    FOREIGN KEY (COURSE_ID) REFERENCES SYS_COURSE (COURSE_ID)
);

CREATE TABLE SYS_COURSE_SUBTOPIC
(
	COURSE_SUBTOPIC_ID		INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    COURSE_ID				INT,
    COURSE_TOPIC_ID			INT,
    CSU_SUBTOPIC			VARCHAR(200),
    CSU_PHASES				INT,
    CSU_STATUS				INT,
    FOREIGN KEY	(COURSE_ID) REFERENCES SYS_COURSE (COURSE_ID),
    FOREIGN KEY (COURSE_TOPIC_ID) REFERENCES SYS_COURSE_TOPIC (COURSE_TOPIC_ID) 
);

CREATE TABLE SYS_TASK
(
	TASK_ID					INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    COURSE_ID				INT,
    COURSE_TOPIC_ID			INT,
    COURSE_SUBTOPIC_ID		INT,
    TAS_TASK				VARCHAR(100),
    TAS_DESCRIPTION			TEXT,
    TAS_REGISTER_DATE		DATETIME,
    TAS_LIMIT_DATE			DATETIME,
    TAS_DUE_DATE			DATETIME,
    TAS_STATUS				INT,
    FOREIGN KEY (COURSE_ID) REFERENCES SYS_COURSE (COURSE_ID),
    FOREIGN KEY (COURSE_TOPIC_ID) REFERENCES SYS_COURSE_TOPIC (COURSE_TOPIC_ID),
    FOREIGN KEY (COURSE_SUBTOPIC_ID) REFERENCES SYS_COURSE_SUBTOPIC (COURSE_SUBTOPIC_ID)
);

CREATE TABLE SYS_EVIDENCE
(
	EVIDENCE_ID				INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    TASK_ID					INT,
    EVI_URL					TEXT,
    EVI_STATUS				INT,
    FOREIGN KEY (TASK_ID) REFERENCES SYS_TASK (TASK_ID)
);

CREATE TABLE SYS_COURSE_USER
(
	CURSE_USER_ID					INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    COURSE_ID						INT,
    USER_ID							INT,
    FOREIGN KEY (COURSE_ID) REFERENCES SYS_COURSE(COURSE_ID),
    FOREIGN KEY (USER_ID) REFERENCES SYS_USER(USER_ID)
);

CREATE TABLE SYS_COURSE_TOPIC_USER
(
	COURSE_TOPIC_USER_ID			INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    COURSE_TOPIC_ID					INT,
    USER_ID							INT,
    FOREIGN KEY (COURSE_TOPIC_ID) REFERENCES SYS_COURSE_TOPIC(COURSE_TOPIC_ID),
    FOREIGN KEY (USER_ID) REFERENCES SYS_USER(USER_ID)
);

CREATE TABLE SYS_COURSE_SUBTOPIC_USER
(
	COURSE_SUBTOPIC_USER_ID			INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    COURSE_SUBTOPIC_ID				INT,
    USER_ID							INT,
    FOREIGN KEY (COURSE_SUBTOPIC_ID) REFERENCES SYS_COURSE_SUBTOPIC(COURSE_SUBTOPIC_ID),
    FOREIGN KEY (USER_ID) REFERENCES SYS_USER(USER_ID)
); 

select * from SYS_USER;
truncate table SYS_USER;
SELECT USER_ID FROM SYS_USER ORDER BY USER_ID DESC LIMIT 1;

DROP PROCEDURE strUserCreateUpdate;
DELIMITER $$
CREATE PROCEDURE strUserCreateUpdate
(
	IN _USER_ID INT, 
    IN _USE_NAME VARCHAR(50),
    IN _USE_PASSWORD VARCHAR(50), 
    IN _USE_IMAGE_PROFILE TEXT
)	
BEGIN
DECLARE last_id INT;
SET last_id = (SELECT USER_ID FROM SYS_USER ORDER BY USER_ID DESC LIMIT 1);
	INSERT INTO SYS_USER (USER_ID, USE_NAME, USE_USER_NAME, USE_PASSWORD, USE_IMAGE_PROFILE, USE_STATUS)
    VALUES (NULL, _USE_NAME, CONCAT(_USE_NAME, last_id + 1), _USE_PASSWORD, _USE_IMAGE_PROFILE, 1)
    ON DUPLICATE KEY UPDATE
    USE_NAME = _USE_NAME, USE_PASSWORD = _USE_PASSWORD;
    SELECT LAST_INSERT_ID();
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE strUserLogin
(
	IN _USE_USER_NAME VARCHAR(50)
)
BEGIN
	SELECT * FROM SYS_USER WHERE USE_USER_NAME = _USE_USER_NAME;
END $$
DELIMITER ;