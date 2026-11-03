<?php
require __DIR__ . "/data.php";
require __DIR__ . "/functions.php";

function links(string $url, string $label): string{
    return '<a href="' . e($url) . '" target="_blank" rel="noopener noreferrer">' . e($label) . '</a>';
}

function greetingtime(): string{
    $hour = (int) date("G");
    if ($hour < 12) return "Good morning";
    if ($hour < 18) return "Good afternoon";
    return "Good evening";
}

function oneLine(string $text): string {
    return str_replace(["\r", "\n", "|"], " ", $text);
}

$feedback = "";
$error = false;
if (($_SERVER["REQUEST_METHOD"] ?? "GET") === "POST") {
    $from = trim($_POST["from"] ?? "");
    $contact = trim($_POST["contact"] ?? "");
    $msg  = trim($_POST["message"] ?? "");

    $isEmail = filter_var($contact, FILTER_VALIDATE_EMAIL) !== false;
    $isPhone = preg_match('/^[+()\d\s-]{8,20}$/', $contact) === 1;

    if ($from === "" || $contact === "" || $msg === "") {
        $error = true;
        $feedback = "Please fill in both fields.";
    } else if (!$isEmail && !$isPhone) {
        $error = true;
        $feedback = "Enter a valid email or phone number.";
    } elseif (strlen($msg) > 500) {
        $error = true;
        $feedback = "Message is too long (500 characters max).";
    } else {
        $line = date("Y-m-d H:i") . " | " . oneLine($from) . " | " . oneLine($contact) . " | " . oneLine($msg) . "\n";
        file_put_contents(__DIR__ . "/messages.txt", $line, FILE_APPEND | LOCK_EX);
        $feedback = "Thanks, " . e($from) . "! Your message was received.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($name) ?> | Portfolio</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <span class="bubble b1" aria-hidden="true"></span>
  <span class="bubble b2" aria-hidden="true"></span>
  <span class="bubble b3" aria-hidden="true"></span>

  <main>
    <header class="glass hero">
      <h1><?= e($name) ?></h1>
      <p class ="card"><a href="/aboutme/">About me</a></p>
      <p><?= e($tagline) ?></p>
      <p><?= greetingtime() ?>, Welcome to my page.</p>
      <ul class="pills">
        <?php foreach ($skills as $skill): ?>
          <li><?= e($skill) ?></li>
        <?php endforeach; ?>
      </ul>
      <p class = "card"><a href="/game/">Play Bubble Pop!</a>
    </header>

    <section aria-labelledby="work">
      <h2 id="work">Projects</h2>
      <div class="grid">
        <?php foreach ($projects as $p): ?>
          <article class="glass card">
            <h3><?= e($p["title"]) ?></h3>
            <p><?= e($p["desc"]) ?></p>
            <p class="tags"><?= e(implode(", ", $p["tags"])) ?></p>
            <?php if (!empty($p["link"])): ?>
            <p><?= links($p["link"], "View project") ?></p>
          <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="glass contact" aria-labelledby="contact">
      <h2 id="contact">Say hello</h2>
      <?php if ($feedback !== ""): ?>
        <p class="note <?= $error ? "bad" : "good" ?>" role="status"><?= $feedback ?></p>
      <?php endif; ?>
      <form method="post" action="https://formspree.io/f/xdeewdrq">
        <label>Your name
          <input name="from" required value="<?= e($_POST["from"] ?? "") ?>">
        </label>
        <label>Email or phone
              <input name="contact" required value="<?= e($_POST["contact"] ?? "") ?>">
        </label>
        <label>Message
          <textarea name="message" rows="4" required maxlength="500"></textarea>
        </label>
        <button type="submit">Send message</button>
      </form>
    </section>

    <footer><p>&copy; <?= date("Y") ?> <?= e($name) ?></p></footer>
  </main>
</body>
</html>