<div class="eight columns">
  <div class="row">
    <form action="<?= $base_url ?>measure/update" method="post">
      <input type="hidden" name="measure_id" value="<?= $measure["id"] ?>">

      <div class="card">
        <div class="card-header">Modifica misurazione</div>
        <div class="card-content">
          <div class="six columns">
            <input class="u-full-width" type="text" name="name" value="<?= $measure["name"] ?>">
          </div>
          <div class="six columns">
            <select class="u-full-width" name="group_id">
              <option value="" <?= ($measure["group"] == "" ? " selected" : "") ?>>--- Gruppo ---</option>
              <?php foreach ($groups as $id => $group): ?>
                <option value="<?= $id ?>"<?= ($measure["group"] == $id ? " selected" : "") ?>><?= $group ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="card-footer">
          <input class="button-primary" type="submit" value="Aggiorna">
        </div>
      </div>
    </form>
  </div>

  <div class="row">
    <p><a href="<?= $base_url ?>measure">↩ Torna indietro</a></p>
  </div>
</div>