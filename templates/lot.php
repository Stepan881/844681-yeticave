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
<section class="lot-item container">
    <h2><?= $lot['name']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $lot['img']; ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['category_name']; ?></span></p>
            <p class="lot-item__description"><?= $lot['description']; ?></p>
        </div>
        <div class="lot-item__right">
          <?php if($user): ?>
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                  <?= time_to_end($lot['end_time']);?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= $lot['start_price']; ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= $minimum_rate; ?> р</span>
                    </div>
                </div>
                <form class="lot-item__form" action="/lot.php?lot_id=<?= (int)$lot_id; ?>" method="post">
                    <p class="lot-item__form-item form__item <?= ($errors ? 'form__item--invalid' : '') ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="bet" placeholder="<?= $minimum_rate; ?>" value="<?= $bet_field ?>">
                        <span class="form__error"><?= get_value($errors, 'bet') ?></span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <?php else: ?>
            <div class="lot-item__state">
                <span>Войдите в свой аккаунт!</span>
            </div>
            <?php endif; ?>
            <div class="history">
                <h3>История ставок (<span>10</span>)</h3>
                <table class="history__list">
                    <?php foreach ($rates as $rate): ?>
                    <tr class="history__item">
                        <td class="history__name"><?= $rate['owner_id']?></td>
                        <td class="history__price"><?= $rate['amount']?></td>
                        <td class="history__time"><?= $rate['create_time']?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
</main>





