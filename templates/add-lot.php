<main>
    <nav class="nav">
        <ul class="nav__list container">
          <?php foreach ($categories as $category):?>
              <li class="nav__item">
                  <a href="pages/all-lots.html"><?= get_value($category, 'name');?></a>
              </li>
          <?php endforeach; ?>
        </ul>
    </nav>
<form class="form form--add-lot container <?= ($errors) ? 'form--invalid' : '' ?>" action="add.php" method="post" enctype="multipart/form-data">
  <h2>Добавление лота</h2>
  <div class="form__container-two">
    <div class="form__item <?= get_value($errors,'name') ? 'form__item--invalid' : '' ?>">
      <label for="lot-name">Наименование</label>
      <input id="lot-name" type="text" name="name" placeholder="Введите наименование лота" value="<?= data_xss(get_value($lot_data,'name'));?>">
      <span class="form__error"><?= get_value($errors,'name') ?></span>
    </div>
    <div class="form__item <?= get_value($errors,'category_id') ? 'form__item--invalid' : '' ?>">
      <label for="category">Категория</label>
      <select id="category" name="category_id">
        <option>Выберите категорию</option>
        <?php foreach ($categories as $category):?>
        <option value="<?= get_value($category, 'id') ?>" <?php if (get_value($lot_data, 'category_id') == get_value($category, 'id')): ?>selected<?php endif ?> >
          <?= get_value($category, 'name');?></option>
        <?php endforeach; ?>
      </select>
      <span class="form__error"><?= get_value($errors, 'category_id')?></span>
    </div>
  </div>
  <div class="form__item form__item--wide <?= get_value($errors,'description') ? 'form__item--invalid' : '' ?>">
    <label for="message">Описание</label>
    <textarea id="message" name="description" placeholder="Напишите описание лота"><?= data_xss(get_value($lot_data,'description'));?></textarea>
    <span class="form__error"><?= get_value($errors,'description')?></span>
  </div>
  <div class="form__item form__item--file <?= get_value($errors, 'img') ? 'form__item--invalid' : '' ?>">
    <label>Изображение</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" id="photo2" name="img" value="">
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
    </div>
    <span class="form__error"><?= get_value($errors, 'img')?></span>
  </div>
  <div class="form__container-three ">
    <div class="form__item form__item--small <?= get_value($errors,'start_price') ? 'form__item--invalid' : '' ?>">
      <label for="lot-rate">Начальная цена</label>
      <input id="lot-rate" type="number" name="start_price" placeholder="0" value="<?= get_value($lot_data,'start_price');?>">
      <span class="form__error"><?= get_value($errors, 'start_price') ?></span>
    </div>
    <div class="form__item form__item--small <?= get_value($errors,'step') ? 'form__item--invalid' : '' ?>">
      <label for="lot-step">Шаг ставки</label>
      <input id="lot-step" type="number" name="step" placeholder="0" value="<?= get_value($lot_data,'step');?>">
      <span class="form__error"><?= get_value($errors,'step') ?></span>
    </div>
    <div class="form__item <?= get_value($errors,'end_time') ? 'form__item--invalid' : '' ?>">
      <label for="lot-date">Дата окончания торгов</label>
      <input class="form__input-date" id="lot-date" type="date" name="end_time" value="<?= get_value($lot_data, 'end_time');?>">
      <span class="form__error"><?= get_value($errors,'end_time') ?></span>
    </div>
  </div>
  <span class="form__error form__error--bottom"><?= ($errors) ? 'Пожалуйста, исправьте ошибки в форме.' : '' ?></span>
  <button type="submit" class="button">Добавить лот</button>
</form>
</main>
