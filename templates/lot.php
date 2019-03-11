<main>
<nav class="nav">
    <ul class="nav__list container">
      <?php foreach ($categories as $category):?>
          <li class="nav__item">
              <a href="pages/all-lots.html"><?=get_value($category,'name');?></a>
          </li>
      <?php endforeach; ?>
    </ul>
</nav>
<section class="lot-item container">
    <h2><?= data_xss(get_value($lot, 'name')); ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= get_value($lot, 'img'); ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?= get_value($lot, 'category_name'); ?></span></p>
            <p class="lot-item__description"><?= data_xss(get_value($lot, 'description')); ?></p>
        </div>
        <div class="lot-item__right">

            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                  <?= time_to_end(get_value($lot, 'end_time'));?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= format_price(get_value($lot,'current_price')); ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= get_value($lot, 'minimum_rate'); ?> р</span>
                    </div>
                </div>
                <?php if(!$restrictions): ?>
                <form class="lot-item__form" action="/lot.php?lot_id=<?= (int)$lot_id; ?>" method="post">
                    <p class="lot-item__form-item form__item <?= ($errors ? 'form__item--invalid' : '') ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="bet" placeholder="<?= get_value($lot, 'minimum_rate'); ?>" value="<?= $bet_field ?>">
                        <span class="form__error"><?= get_value($errors, 'bet') ?></span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
              <?php else: ?>
                  <div class="lot-item__state">
                      <span><?php print $restrictions; ?></span>
                  </div>
              <?php endif; ?>
            </div>
            <div class="history">
                <h3>История ставок (<span><?= count($bets) ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($bets as $bet): ?>
                    <tr class="history__item">
                        <td class="history__name"><?= data_xss(get_value($bet, 'user_name'))?></td>
                        <td class="history__price"><?= get_value($bet, 'amount')?></td>
                        <td class="history__time"><?= format_data(get_value($bet, 'create_time'))?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
</main>





