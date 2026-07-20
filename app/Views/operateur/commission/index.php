<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Commissions — Vola+</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-vola">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="/operateur/situation">Vola<span class="plus">+</span></a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navOp">
      <i class="bi bi-list text-white" style="font-size:1.4rem;"></i>
    </button>
    <div class="collapse navbar-collapse" id="navOp">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/operateur/situation"><i class="bi bi-graph-up me-1"></i>Situation</a></li>
        <li class="nav-item"><a class="nav-link active" href="/commission"><i class="bi bi-percent me-1"></i>Commissions</a></li>
        <li class="nav-item"><a class="nav-link" href="/montant-frais"><i class="bi bi-info-circle me-1"></i>Barèmes</a></li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <a href="/auth/logout" class="text-white text-decoration-none" title="Deconnexion"><i class="bi bi-box-arrow-left"></i></a>
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid px-3 px-md-4 py-4 fade-in">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-0"><i class="bi bi-percent text-success me-2"></i>Commissions inter-opérateurs</h4>
      <small class="text-muted">Taux appliqués lors des transferts entre opérateurs</small>
    </div>
    <a href="/commission/create" class="btn btn-vola btn-vola-green">
      <i class="bi bi-plus-circle me-1"></i>Ajouter
    </a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-vola alert-vola-success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-vola alert-vola-danger"><i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <div class="card-vola">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table-vola">
          <thead>
            <tr>
              <th>Opérateur source</th>
              <th>Opérateur destination</th>
              <th class="text-end">Taux (%)</th>
              <th class="text-end" style="width:140px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($commissions)): ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-4">
                  <i class="bi bi-inbox me-1"></i>Aucune commission configurée
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($commissions as $c): ?>
                <tr>
                  <td>
                    <i class="bi bi-arrow-right-circle text-success me-1"></i>
                    <?= esc($operateursMap[$c['id_operateur_source']] ?? 'Inconnu') ?>
                  </td>
                  <td>
                    <i class="bi bi-arrow-down-circle text-primary me-1"></i>
                    <?= esc($operateursMap[$c['id_operateur_dest']] ?? 'Inconnu') ?>
                  </td>
                  <td class="text-end">
                    <span class="badge" style="background:rgba(11,110,79,0.1);color:var(--vola-green);font-size:0.95rem;font-weight:700;"><?= $c['taux'] ?>%</span>
                  </td>
                  <td class="text-end">
                    <a href="/commission/<?= $c['id_commission'] ?>/edit" class="btn btn-sm" style="color:var(--vola-blue);border:1px solid var(--vola-border);border-radius:8px;">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/commission/<?= $c['id_commission'] ?>/delete" method="post" class="d-inline" onsubmit="return confirm('Supprimer cette commission ?')">
                      <?= csrf_field() ?>
                      <button type="submit" class="btn btn-sm" style="color:var(--vola-red);border:1px solid var(--vola-border);border-radius:8px;">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <a href="/operateur/situation" class="btn btn-sm mt-3" style="color:var(--vola-blue);border:1px solid var(--vola-border);border-radius:8px;">
    <i class="bi bi-arrow-left me-1"></i>Retour
  </a>

</div>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
