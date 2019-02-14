CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  end_time TIMESTAMP NULL,
  name VARCHAR(100) NOT NULL,
  description VARCHAR(255),
  img VARCHAR(255) NOT NULL,
  start_price INT NOT NULL,
  step INT NOT NULL,
  owner_id INT NOT NULL,
  winner_id INT,
  сategory_id INT NOT NULL
);

CREATE INDEX owner_id_idx ON lots(owner_id);
CREATE INDEX winner_id_idx ON lots(winner_id);
CREATE INDEX сategory_id_idx ON lots(сategory_id);

CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  amount INT,
  owner_id INT,
  lot_id INT
);

CREATE INDEX owner_id_idx ON bets(owner_id);
CREATE INDEX lot_id_idx ON bets(lot_id);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(320) NOT NULL UNIQUE,
  name VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  avatar VARCHAR(255),
  contacts VARCHAR(255) NOT NULL
);

