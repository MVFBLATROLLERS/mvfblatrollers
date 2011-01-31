/* this will delete the database!!! */
DROP DATABASE hsjobs;
CREATE DATABASE hsjobs;
USE hsjobs;

CREATE TABLE users(
    userid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash CHAR(128) NOT NULL,
    data MEDIUMBLOB,
    INDEX (email)
);

CREATE TABLE files(
    fileid INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(256),
    ext VARCHAR(16),
    type VARCHAR(256),
    size INT,
    created_date INT,
    ip CHAR(16),
    permissions MEDIUMBLOB,
    hide_until INT
);

CREATE TABLE dl_time_exceptions(
    userid INT NOT NULL,
    fileid INT NOT NULL,
    start_time INT,
    end_time INT
);

INSERT INTO users (username, email, password_hash, data) 
    VALUES ('root', 'root@localhost',  	'be379e65f38ef84006140a18e34ae49b0a8673d1932f2d49ac1af14692a15784278de12add3a89c55cc444f2570e1e2a69ca72f33fc20efc130c0cc140c05b56', 
         'a:3:{s:8:"usertype";s:4:"root";s:11:"permissions";N;s:4:"data";N;}');
		 
CREATE USER 'hsjobs'@'localhost';
SET PASSWORD FOR 'hsjobs'@'localhost' = PASSWORD('hsjobs');
GRANT ALL ON hsjobs.* to 'hsjobs'@'localhost' IDENTIFIED BY 'hsjobs';

FLUSH PRIVILEGES;




