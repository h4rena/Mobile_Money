<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mes préfixes — Vola+</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-vola">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="/operateur/situation">Vola<span class="plus">+</span></a>
    <a href="/operateur/situation" class="btn btn-sm" style="color:#fff;border:1px solid rgba(255,255,255,0.3);border-radius:10px;"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
</nav>

<div class="container py-5 fade-in">
  <div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-lg-5">

      <div class="card-vola">
        <div class="card-body p-4">
          <div class="text-center mb-4">
            <div class="stat-icon green mx-auto mb-2" style="width:56px;height:56px;font-size:1.5rem;">
              <i class="bi bi-hash"></i>
            </div>
            <h5 class="fw-bold">Mes préfixes</h5>
            <p class="text-muted small mb-0">Votre opérateur — max 2 préfixes</p>
          </div>

          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-vola alert-vola-success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
          <?php endif; ?>
          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-vola alert-vola-danger"><i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>

          <?php if (!empty($mesPrefixes)): ?>
            <?php foreach ($mesPrefixes as $mp): ?>
              <div class="d-flex align-items-center justify-content-between p-3 mb-2" style="background:rgba(34,197,94,0.08);border-radius:12px;">
                <div>
                  <div class="text-muted small">Préfixe</div>
                  <div class="fw-bold" style="font-size:1.5rem;color:var(--vola-green);"><?= esc($mp['prefixe']) ?></div>
                </div>
                <div class="d-flex gap-2">
                  <a href="/prefixes/<?= $mp['id_mon_prefixe'] ?>/edit" class="btn btn-sm" style="color:var(--vola-blue);border:1px solid var(--vola-border);border-radius:8px;">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="/prefixes/<?= $mp['id_mon_prefixe'] ?>/delete" method="post" class="d-inline" onsubmit="return confirm('Supprimer ce préfixe ?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm" style="color:var(--vola-red);border:1px solid var(--vola-border);border-radius:8px;">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="text-center text-muted py-3 mb-3">
              <i class="bi bi-inbox me-1"></i>Aucun préfixe configuré
            </div>
          <?php endif; ?>

          <?php if (count($mesPrefixes) < 2): ?>
            <hr class="my-3">
            <form action="/prefixes/store" method="post">
              <?= csrf_field() ?>
              <label for="prefixe" class="form-label fw-semibold">Ajouter un préfixe</label>
              <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-hash"></i></span>
                <input type="text" class="form-control" name="prefixe" id="prefixe"
                       placeholder="ex: 031" maxlength="3" required>
              </div>
              <button type="submit" class="btn btn-vola btn-vola-green w-100 btn-lg">
                <i class="bi bi-plus-circle me-1"></i>Ajouter
              </button>
            </form>
          <?php endif; ?>

        </div>
      </div>

    </div>
  </div>
</div>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
