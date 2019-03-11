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
<form class="form container <?= ($errors) ? 'form--invalid' : '' ?>" action="login.php" method="post">
  <h2>Вход</h2>
  <div class="form__item <?= get_value($errors,'email') ? 'form__item--invalid' : '' ?>">
    <label for="email">E-mail*</label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= data_xss(get_value($user_data,'email'));?>">
    <span class="form__error"><?= get_value($errors, 'email') ?></span>
  </div>
  <div class="form__item form__item--last <?= get_value($errors,'password') ? 'form__item--invalid' : '' ?>">
    <label for="password">Пароль*</label>
    <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= data_xss(get_value($user_data, 'password'));?>">
    <span class="form__error"><?= get_value($errors,'password') ?></span>
  </div>
  <button type="submit" class="button">Войти</button>
</form>
</main>

