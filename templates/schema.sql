CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE `categories` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name char(50)  NOT NULL UNIQUE
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  data_add TIMESTAMP NOT NULL ,
  name CHAR(50) NOT NULL UNIQUE,
  description CHAR(255),
  img CHAR NOT NULL,
  start_price DECIMAL NOT NULL,
  date_end TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  step CHAR,
  autor_id INT,
  winner_id INT,
  categories_id INT
);

CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  data_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  sum_price DECIMAL,
  autor_id INT,
  lots_id INT
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  data_registr TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email CHAR(50) NOT NULL UNIQUE,
  name CHAR(50) NOT NULL UNIQUE,
  password CHAR(15) NOT NULL,
  avatar CHAR(70),
  contacts CHAR(100),
  create_lots_id INT,
  bets_id INT
);