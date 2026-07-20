<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ajouter commission — Vola+</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-vola">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="/operateur/situation">Vola<span class="plus">+</span></a>
    <a href="/commission" class="btn btn-sm" style="color:#fff;border:1px solid rgba(255,255,255,0.3);border-radius:10px;"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
</nav>

<div class="container py-5 fade-in">
  <div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-lg-4">

      <div class="card-vola">
        <div class="card-body p-4">
          <div class="text-center mb-4">
            <div class="stat-icon green mx-auto mb-2" style="width:56px;height:56px;font-size:1.5rem;">
              <i class="bi bi-percent"></i>
            </div>
            <h5 class="fw-bold">Ajouter une commission</h5>
          </div>

          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-vola alert-vola-danger"><i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>

          <form action="/commission/store" method="post">
            <label for="id_operateur_source" class="form-label fw-semibold">Opérateur source</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-arrow-right-circle"></i></span>
              <select class="form-control" name="id_operateur_source" id="id_operateur_source" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($operateurs as $op): ?>
                  <option value="<?= $op['id_operateur'] ?>"><?= esc($op['nom_operateur']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <label for="id_operateur_dest" class="form-label fw-semibold">Opérateur destination</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-arrow-down-circle"></i></span>
              <select class="form-control" name="id_operateur_dest" id="id_operateur_dest" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($operateurs as $op): ?>
                  <option value="<?= $op['id_operateur'] ?>"><?= esc($op['nom_operateur']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <label for="taux" class="form-label fw-semibold">Taux de commission (%)</label>
            <div class="input-group mb-4">
              <span class="input-group-text"><i class="bi bi-percent"></i></span>
              <input type="number" class="form-control" name="taux" id="taux" step="0.1" min="0.1" max="100" placeholder="Ex: 2.5" required>
            </div>

            <button type="submit" class="btn btn-vola btn-vola-green w-100 btn-lg mb-2">
              <i class="bi bi-check-circle me-1"></i>Ajouter
            </button>
            <a href="/commission" class="btn btn-outline-secondary w-100">Annuler</a>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>
