-- Категории
INSERT INTO сategory (name)
VALUES
('Доски и лыжи'),
('Крепления'),
('Ботинки'),
('Одежда'),
('Инструменты'),
('Разное');

-- Лоты (описание имя фото начальнаяЦена шаг пользователь победитель сатегория)
INSERT INTO lots
(description, end_time, name, img, start_price, step, owner_id, winner_id, сategory_id)
VALUES
('Доска Rossignol', '2019-05-05 00:00:01', '2014 Rossignol District Snowboard', 'img/lot-1.jpg', 10999, 1, 1, 1, 1),
('Доска Mens', '2019-05-05 00:00:01', 'DC Ply Mens 2016/2017 Snowboard', 'img/lot-2.jpg', 159999, 1, 1, 1, 1),
('Крепления Union', '2019-05-05 00:00:01', 'Крепления Union Contact Pro 2015 года размер L/XL', 'img/lot-3.jpg', 8000, 1, 1, 1, 2),
('Ботинки для сноуборда', '2019-05-05 00:00:01', 'Ботинки для сноуборда DC Mutiny Charocal', 'img/lot-4.jpg', 10999, 1, 1, 1, 3),
('Куртка для сноуборда', '2019-05-05 00:00:01', 'Куртка для сноуборда DC Mutiny Charocal', 'img/lot-5.jpg', 7500, 1, 1, 1, 4),
('Маска', '2019-05-05 00:00:01', 'Маска Oakley Canopy', 'img/lot-6.jpg', 10999, 1, 1, 1, 6);

-- Пользователи (емаил имя пароль аватар контактныеДанные	)
INSERT INTO users (email, name, password, avatar, contacts)
VALUES
('Admin@mail.ru', 'Admin', '123', NULL, 'Краснодар'),
('user@mail.ru', 'User', '321', NULL, 'Питер'),
('sepan@mail.ru', 'Stepan', '213', NULL, 'Москва');

-- Ставка (Сумма, пользователь, лот)
INSERT INTO bets (amount, owner_id, lot_id)
VALUES
(10000, 2, 5),
(11000, 3, 1);

-- получить все категории;
SELECT * FROM сategory;

-- получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, название категории;
SELECT lots.name, lots.start_price, lots.img, MAX(bets.amount), сategory.name AS category_name
FROM lots
JOIN сategory
ON lots.сategory_id = сategory.id
JOIN bets
ON bets.lot_id = lots.id
WHERE lots.winner_id = 1
GROUP BY bets.lot_id
ORDER BY lots.end_time DESC;

-- показать лот по его id. Получите также название категории, к которой принадлежит лот
SELECT lots.name AS lot_name, сategory.name AS category_name
FROM lots
JOIN сategory
ON lots.сategory_id = сategory.id
WHERE lots.id = 1;


-- обновить название лота по его идентификатору;
UPDATE lots
SET name = '2014 Rossignol District Snowboard'
WHERE id = 1;

-- получить список самых свежих ставок для лота по его идентификатору;
SELECT amount, create_time, lot_id
FROM bets
ORDER BY create_time DESC
LIMIT 10;



