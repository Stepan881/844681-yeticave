  <main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($categories as $category):?>
        <li class="nav__item">
          <a href="pages/all-lots.html"><?=$category['name'];?></a>
        </li>
        <?php endforeach; ?>
      </ul>
    </nav>
      <form class="form container <?= $errors ? 'form--invalid' : '' ?>" action="sign-up.php" method="post" enctype="multipart/form-data"><!-- form--invalid -->
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?= $errors['email'] ? 'form__item--invalid' : '' ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $_POST['email'];?>">
        <span class="form__error"><?= $errors['email'] ?></span>
      </div>
      <div class="form__item <?= $errors['password'] ? 'form__item--invalid' : '' ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?= $_POST['password'];?>">
        <span class="form__error"><?= $errors['password'] ?></span>
      </div>
      <div class="form__item <?= $errors['name'] ? 'form__item--invalid' : '' ?>">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $_POST['name'];?>">
        <span class="form__error"><?= $errors['name'] ?></span>
      </div>
      <div class="form__item <?= $errors['contacts'] ? 'form__item--invalid' : '' ?>">
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться"><?= $_POST['contacts'];?></textarea>
        <span class="form__error"><?= $errors['contacts'] ?></span>
      </div>


      <div class="form__item form__item--file form__item--last <?= $user_avatar ? 'form__item--invalid' : '' ?>">
        <label>Аватар</label>
        <div class="preview">
          <button class="preview__remove" type="button">x</button>
          <div class="preview__img">
            <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
          </div>
        </div>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="photo2" name="img" value="">
          <label for="photo2">
            <span>+ Добавить</span>
          </label>
        </div><span class="form__error"><?= $user_avatar ?></span>
      </div>



      <span class="form__error form__error--bottom"><?= $errors ? 'Пожалуйста, исправьте ошибки в форме.' : '' ?></span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
  </main>