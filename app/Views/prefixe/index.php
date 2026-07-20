<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mon préfixe — Vola+</title>
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
    <div class="col-sm-8 col-md-6 col-lg-4">

      <div class="card-vola">
        <div class="card-body p-4">
          <div class="text-center mb-4">
            <div class="stat-icon green mx-auto mb-2" style="width:56px;height:56px;font-size:1.5rem;">
              <i class="bi bi-hash"></i>
            </div>
            <h5 class="fw-bold">Mon préfixe</h5>
            <p class="text-muted small mb-0"><?= esc($operateur['nom_operateur']) ?></p>
          </div>

          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-vola alert-vola-success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
          <?php endif; ?>
          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-vola alert-vola-danger"><i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>

          <div class="text-center mb-4 p-3" style="background:rgba(34,197,94,0.08);border-radius:12px;">
            <div class="text-muted small mb-1">Préfixe actuel</div>
            <div class="fw-bold" style="font-size:2rem;color:var(--vola-green);"><?= esc($currentPrefixe['prefixe'] ?? '—') ?></div>
          </div>

          <form action="/prefixes/update" method="post">
            <?= csrf_field() ?>

            <label for="id_prefixe" class="form-label fw-semibold">Changer de préfixe</label>
            <div class="input-group mb-4">
              <span class="input-group-text"><i class="bi bi-hash"></i></span>
              <select class="form-select" name="id_prefixe" id="id_prefixe" required>
                <option value="" disabled>Choisir un préfixe...</option>
                <?php foreach ($allPrefixes as $p): ?>
                  <option value="<?= $p['id_prefixe'] ?>" <?= ($p['id_prefixe'] == $operateur['id_prefixe']) ? 'selected' : '' ?>>
                    <?= esc($p['prefixe']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <button type="submit" class="btn btn-vola btn-vola-green w-100 btn-lg mb-2">
              <i class="bi bi-check-circle me-1"></i>Mettre à jour
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
