<div class="eight columns">
  <div class="row">
    <form action="<?= $base_url ?>muscle/update" method="post">
      <input type="hidden" name="muscle_id" value="<?= $id ?>">

      <div class="card">
        <div class="card-header">Modifica muscolo</div>
        <div class="card-content">
          <div class="six columns">
            <input class="u-full-width" type="text" name="name" value="<?= $name ?>">
          </div>
          <div class="six columns">
            <label>
                <input type="checkbox" name="enabled" value="1" <?= $enabled ? ' checked' : '' ?>>
                <span class="label-body">Abilitato</span>
            </label>
          </div>
        </div>
        <div class="card-footer">
          <input class="button-primary" type="submit" value="Aggiorna">
        </div>
      </div>
    </form>
  </div>

  <div class="row">
    <p><a href="<?= $base_url ?>muscle">↩ Torna indietro</a></p>
  </div>
</div>