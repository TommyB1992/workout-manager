<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Workout Manager</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= $base_url ?>css/normalize.css">
  <link rel="stylesheet" href="<?= $base_url ?>css/skeleton.css">
  <link rel="stylesheet" href="<?= $base_url ?>css/style.css">
</head>
<body>
  <header>
    <div class="container">
      <div class="four columns">
        <div class="row">
          <div id="logo">
            <img src="<?= $base_url ?>img/logo.png">
            <span id="header-title">Workout Manager</span>
          </div>
        </div>
      </div>
      
      <div class="eight columns">
        <div class="row">
          <nav class="u-pull-right">
            <ul>
              <li><a href="<?= $base_url ?>workout">Workout</a></li>
              <li><a href="<?= $base_url ?>exercise">Esercizi</a></li>
              <li class="has-submenu"><a href="#">Misurazioni</a>
                <ul>
                  <li><a href="<?= $base_url ?>measure">Lista</a></li>
                  <li><a href="<?= $base_url ?>measure-value">Gestione</a></li>
                </ul>
              </li>
              <li class="has-submenu"><a href="#">Muscoli</a>
                <ul>
                  <li><a href="<?= $base_url ?>muscle">Lista</a></li>
                  <li><a href="<?= $base_url ?>muscle-worked">Associa</a></li>
                </ul>
              </li>
              <li><a href="<?= $base_url ?>training-method">Modelli d'Allenamento</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>

  <main>
    <div class="container">
      <div class="row">
        <?= $content ?>
      </div>
    </div>
  </main>

  <footer>
    <div class="container">
      <div class="row">
        <div class="twelve columns">
          <p>&copy; <?= date('Y') ?> Workout Manager</p>
        </div>
      </div>
    </div>
  </footer>

  <script src="<?= $base_url ?>js/style.js">
</body>
</html>
