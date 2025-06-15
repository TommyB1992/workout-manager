<?php

function getIconBtn(string $url, string $iconType, string $btnType): string {
    return '
    <a href="' . $url . '" class="icon-button icon-button-' . $btnType . '">
      <svg fill="currentColor">
        <use href="#' . $iconType . '-icon" />
      </svg>
    </a>';
}

function showEditBtn(string $url): string {
    return getIconBtn($url, 'edit', 'info');
}

function showDeleteBtn(string $url) {
    return getIconBtn($url, 'delete', 'danger');
}

?>

<?php require_once __DIR__ . '/../icons.php' ?>

  <div class="row">
    <div class="eight columns">
      <div class="card">
        <div class="card-header">Muscoli</div>
        <div class="card-content">
          <table class="u-full-width bordered">
            <colgroup>
                <col>
                <col>
                <col style="width: 100px">
            </colgroup>
            <thead>
              <tr>
                <th>Nome</th>
                <th colspan="2">Abilitato</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($muscles as $id => $muscle): ?>
                <tr>
                  <td><?= $muscle['name'] ?></td>
                  <td><?= $muscle['enabled'] ? '✓' : '✕' ?></td>
                  <td>
                    <?= showEditBtn("/muscle/show/{$id}") ?>
                    <?= showDeleteBtn("/muscle/delete/{$id}") ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="eight columns">
      <div class="card">
        <div class="card-header">Crea muscolo</div>
        <div class="card-content">
          <form action="/muscle/create" method="post">
            <div class="four columns">
              <input class="u-full-width" type="text" name="name" placeholder="Nome...">
            </div>
            <div class="five columns">
              <select class="u-full-width" name="group_id">
                <option value="" selected>--- Gruppo ---</option>
                <?php foreach ($groups as $id => $name): ?>
                  <option value="<?= $id ?>"><?= $name ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="three columns">
              <input class="button-primary" type="submit" value="Inserisci">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
