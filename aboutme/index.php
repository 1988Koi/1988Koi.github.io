<?php
require __DIR__ . "/../data.php";
require __DIR__ . "/../functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About | <?= e($name) ?></title>
  <link rel="stylesheet" href="/style.css">
</head>
<body>
  <main>
    <header class="glass hero about-hero">
      <div class="avatar" aria-hidden="true"><?= e($about["Initials"]) ?></div>
      <h1>About me</h1>
      <p><?= e($about["intro"]) ?></p>
      <p><a href="/">Back to home</a></p>
    </header>

    <section class="about-grid">
      <article class="glass card">
        <h2>Skills</h2>
        <ul class="levels">
          <?php foreach ($skillLevels as $skill => $level): ?>
            <li>
              <span><?= e($skill) ?></span>
              <span class="orbs" role="img" aria-label="Level <?= (int) $level ?> of 5">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <i class="orb <?= $i <= $level ? "on" : "" ?>"></i>
                <?php endfor; ?>
              </span>
            </li>
          <?php endforeach; ?>
        </ul>
      </article>

      <article class="glass card">
        <h2>Currently learning</h2>
        <ul class="plain">
          <?php foreach ($about["learning"] as $item): ?>
            <li><?= e($item) ?></li>
          <?php endforeach; ?>
        </ul>
      </article>

      <article class="glass card">
        <h2>Fun facts</h2>
        <ul class="plain">
          <?php foreach ($about["facts"] as $fact): ?>
            <li><?= e($fact) ?></li>
          <?php endforeach; ?>
        </ul>
      </article>

      <article class="glass card">
        <h2>My path</h2>
        <ol class="timeline">
          <?php foreach ($about["Timeline"] as $step): ?>
            <li><strong><?= e($step["when"]) ?></strong> <?= e($step["what"]) ?></li>
          <?php endforeach; ?>
        </ol>
      </article>
    </section>
</main>
</body>
</html>