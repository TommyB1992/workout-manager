<div class="eight columns">
  <div class="row">
    <form action="<?= $base_url ?>measure-group/update" method="post">
      <input type="hidden" name="group_id" value="<?= $id ?>">

      <div class="card">
        <div class="card-header">Modifica gruppo</div>
        <div class="card-content">
          <input class="u-full-width" type="text" name="name" value="<?= $name ?>">
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