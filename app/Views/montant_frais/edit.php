<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modifier un barème — Vola+</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-vola">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="/operateur/situation">Vola<span class="plus">+</span></a>
    <a href="/montant-frais" class="btn btn-sm" style="color:#fff;border:1px solid rgba(255,255,255,0.3);border-radius:10px;"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
</nav>

<div class="container py-5 fade-in">
  <div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-lg-4">

      <div class="card-vola">
        <div class="card-body p-4">
          <div class="text-center mb-4">
            <div class="stat-icon blue mx-auto mb-2" style="width:56px;height:56px;font-size:1.5rem;">
              <i class="bi bi-pencil-square"></i>
            </div>
            <h5 class="fw-bold">Modifier le barème</h5>
          </div>

          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-vola alert-vola-danger"><i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>

          <form action="/montant-frais/<?= $montantFrais['id_montant_frais'] ?>/update" method="post">
            <?= csrf_field() ?>

            <label for="montant1" class="form-label fw-semibold">Montant minimum (Ar)</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-arrow-down-short"></i></span>
              <input type="number" class="form-control" name="montant1" id="montant1" value="<?= $montantFrais['montant1'] ?>" required min="0">
            </div>

            <label for="montant2" class="form-label fw-semibold">Montant maximum (Ar)</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-arrow-up-short"></i></span>
              <input type="number" class="form-control" name="montant2" id="montant2" value="<?= $montantFrais['montant2'] ?>" required min="0">
            </div>

            <label for="frais" class="form-label fw-semibold">Frais (Ar)</label>
            <div class="input-group mb-4">
              <span class="input-group-text"><i class="bi bi-cash"></i></span>
              <input type="number" class="form-control" name="frais" id="frais" value="<?= $montantFrais['frais'] ?>" required min="0">
            </div>

            <button type="submit" class="btn btn-vola btn-vola-blue w-100 btn-lg mb-2">
              <i class="bi bi-check-circle me-1"></i>Mettre à jour
            </button>
            <a href="/montant-frais" class="btn btn-outline-secondary w-100">Annuler</a>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>
