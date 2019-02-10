CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE `categories` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50)  NOT NULL UNIQUE
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT NOT NULL,
  name VARCHAR(50) NOT NULL UNIQUE,
  description CHAR(255),
  img VARCHAR(100) NOT NULL,
  start_price INT NOT NULL,
  date_end TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  step VARCHAR(100),
  owner_id INT,
  winner_id INT,
  categories_id INT
-- Создай обычные индексы для этих трёх полей, так как по ним будет идти выборка в будущем
-- Что то я не на гуглил что за обычные индексы! VARCHAR???
);




CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  data_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  amount INT,
  owner_id INT,
  lots_id INT
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email CHAR(50) NOT NULL UNIQUE,
  name CHAR(50) NOT NULL,
  password CHAR(15) NOT NULL,
  avatar CHAR(70),
  contacts CHAR(100)
);