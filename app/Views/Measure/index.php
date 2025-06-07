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
        <div class="card-header">Misurazioni</div>
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
                <th colspan="2">Gruppo</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($measures as $id => $measure): ?>
                <tr>
                  <td><?= $measure['name'] ?></td>
                  <td><?= $groups[$measure['group']] ?? '<i>Non definito</i>' ?></td>
                  <td>
                    <?= showEditBtn("/measure/show/{$id}") ?>
                    <?= showDeleteBtn("/measure/delete/{$id}") ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="four columns">
      <div class="card">
        <div class="card-header">Gruppi</div>
        <div class="card-content">
          <table class="u-full-width bordered">
            <colgroup>
                <col>
                <col style="width: 100px">
            </colgroup>
            <thead>
              <tr>
                <th colspan="2">Nome</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($groups as $id => $group): ?>
                <tr>
                  <td><?= $group ?></td>
                  <td>
                    <?= showEditBtn("/measure-group/show/{$id}") ?>
                    <?= showDeleteBtn("/measure-group/delete/{$id}") ?>
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
        <div class="card-header">Crea misurazione</div>
        <div class="card-content">
          <form action="/measure/create" method="post">
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

    <div class="four columns">
      <div class="card">
        <div class="card-header">Crea gruppo</div>
        <div class="card-content">
          <form action="/measure-group/create" method="post">
            <div class="six columns">
              <input class="u-full-width" type="text" name="name" placeholder="Nome...">
            </div>
            <div class="six columns">
              <input class="button-primary" type="submit" value="Inserisci">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>







<?php /*

<div class="card">
    <div class="card-header">

    </div>

    <div class="card-content">
    
<table class="u-full-width bordered">
  <colgroup>
    <col>
    <col style="width: 200px;">
  </colgroup>

  <thead>
    <tr>
      <th colspan="2">Misurazione</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($groups as $groupId => $groupName): ?>
      <tr>
        <td style="text-align: center"><strong><?= $groupName ?></strong></td>
        <td>
          <?= showEditBtn("/group/show/{$groupId}") ?>
          <?= showDeleteBtn("/group/delete/{$groupId}") ?>
        </td>
      </tr>

      <?php foreach ($measures as $measureId => $measure): ?>
        <?php if ($measure["group"] == $groupId): ?>
          <tr>
            <td><?= $measure['name'] ?></td>
            <td>
              <?= showEditBtn("/measure/show/{$groupId}") ?>
              <?= showDeleteBtn("/measure/delete/{$measureId}") ?>
            </td>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>

      <tr>
        <td style="text-align: center" colspan="2"><strong> -- Senza Gruppo -- </strong></td>
      </tr>
      <?php foreach ($measures as $measureId => $measure): ?>
        <?php if (!isset($measure["group"])): ?>
          <tr>
            <td><?= $measure['name'] ?></td>
            <td>
              <?= showEditBtn("/measure/show/{$groupId}") ?>
              <?= showDeleteBtn("/measure/delete/{$measureId}") ?>
            </td>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </tbody>
</table>

    </div>
</div>




<table border="1">
    <tr>
        <td>#</td>
        <td>Misurazione</td>
        <td colspan="2">Tipo</td>
    </tr>

    <?php foreach ($measures as $id => $measure) { ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $measure["name"] ?></td>
            <td><?= $groups[$measure["group"]] ?></td>
            <td><a href="/measure/delete/<?= $id ?>">X</a> <a href="/measure/show/<?= $id ?>">E</a></td>
        </tr>
    <?php } ?>
</table>


<table border="1">
    <tr>
        <td>#</td>
        <td colspan="2">Gruppo</td>
    </tr>

    <?php foreach ($groups as $id => $group) { ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $group ?></td>
            <td><a href="/measure-group/delete/<?= $id ?>">X</a> <a href="/measure-group/show/<?= $id ?>">E</a></td>
        </tr>
    <?php } ?>
</table>

<br>
Crea misura:
<form action="/measure/create" method="post">
<input type="text" name="name" value="">
<select name="group_id">
        <option value=""></option>
        <?php foreach ($groups as $id => $name): ?>
            <option value="<?= $id ?>"><?= $name ?></option>
        <?php endforeach; ?>
</select>
<input type="submit">
</form>

<br>

Crea gruppo:
<form action="/measure-group/create" method="post">
<input type="text" name="name" value="">
<input type="submit">
</form>


<!--- todo: stampa tutte le misure sotto a un singolo gruyppo

    --> */ ?>