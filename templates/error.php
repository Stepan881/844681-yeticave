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
    <h2><?= $error['title'] ?></h2>
    <p><?= $error['description'] ?></p>
</section>
</main>