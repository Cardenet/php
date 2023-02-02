CREATE USER 'provenusr'@'localhost' IDENTIFIED BY 'provenpass';

CREATE DATABASE userdb
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
  
USE userdb;

GRANT SELECT, INSERT, UPDATE, DELETE ON userdb.* TO 'provenusr'@'localhost';

CREATE TABLE users (
    id INTEGER PRIMARY KEY auto_increment,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(40) NOT NULL,
    role VARCHAR(10) NOT NULL DEFAULT 'registered'
) ENGINE InnoDb;

INSERT INTO users VALUES (0, "user01", "pass01", "admin");
INSERT INTO users VALUES (0, "user02", "pass02", "admin");
INSERT INTO users VALUES (0, "user03", "pass03", "admin");
INSERT INTO users VALUES (0, "user04", "pass04", "registered");
INSERT INTO users VALUES (0, "user05", "pass05", "registered");
INSERT INTO users VALUES (0, "user06", "pass06", "registered");