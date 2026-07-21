<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modifier préfixe — Vola+</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-vola">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="/operateur/situation">Vola<span class="plus">+</span></a>
    <a href="/prefixes" class="btn btn-sm" style="color:#fff;border:1px solid rgba(255,255,255,0.3);border-radius:10px;"><i class="bi bi-arrow-left me-1"></i>Retour</a>
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
            <h5 class="fw-bold">Modifier le préfixe</h5>
          </div>

          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-vola alert-vola-danger"><i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>

          <form action="/prefixes/<?= $monPrefixe['id_mon_prefixe'] ?>/update" method="post">
            <?= csrf_field() ?>

            <label for="prefixe" class="form-label fw-semibold">Préfixe</label>
            <div class="input-group mb-4">
              <span class="input-group-text"><i class="bi bi-hash"></i></span>
              <input type="text" class="form-control" name="prefixe" id="prefixe"
                     value="<?= esc($monPrefixe['prefixe']) ?>"
                     placeholder="ex: 031" maxlength="3" required>
            </div>

            <button type="submit" class="btn btn-vola btn-vola-blue w-100 btn-lg mb-2">
              <i class="bi bi-check-circle me-1"></i>Mettre à jour
            </button>
            <a href="/prefixes" class="btn btn-outline-secondary w-100">Annuler</a>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
