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
    <form class="form container <?= ($errors) ? 'form--invalid' : '' ?>" action="login.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
      <div class="form__item <?= $errors['email'] ? 'form__item--invalid' : '' ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $form['email'];?>">
        <span class="form__error"><?= $errors['email'] ?></span>
      </div>
      <div class="form__item form__item--last <?= $errors['password'] ? 'form__item--invalid' : '' ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?= $form['password'];?>">
        <span class="form__error"><?= $errors['password'] ?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>

</div>
