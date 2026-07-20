<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Situation des gains — Vola+</title>
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
        <li class="nav-item"><a class="nav-link active" href="/operateur/situation"><i class="bi bi-graph-up me-1"></i>Situation</a></li>
        <li class="nav-item"><a class="nav-link" href="/commission"><i class="bi bi-percent me-1"></i>Commissions</a></li>
        <li class="nav-item"><a class="nav-link" href="/prefixes"><i class="bi bi-hash me-1"></i>Préfixes</a></li>
        <li class="nav-item"><a class="nav-link" href="/montant-frais"><i class="bi bi-info-circle me-1"></i>Barèmes</a></li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <div class="avatar"><?= isset($operateur['email']) ? strtoupper(substr($operateur['email'], 0, 1)) : 'O' ?></div>
        <span class="text-white fw-semibold d-none d-md-inline"><?= esc($operateur['email'] ?? 'Operateur') ?></span>
        <a href="/auth/logout" class="text-white text-decoration-none ms-2" title="Deconnexion"><i class="bi bi-box-arrow-left"></i></a>
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid px-3 px-md-4 py-4 fade-in">

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-vola alert-vola-success mb-3"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-vola alert-vola-danger mb-3"><i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <h4 class="fw-bold mb-1"><i class="bi bi-cash-stack text-success me-2"></i>Situation des gains</h4>
  <p class="text-muted mb-4">Gains via les frais sur retraits et transferts</p>

  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="stat-card green">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="stat-label">Total des gains (frais)</div>
            <div class="stat-value text-success"><?= number_format($totalGains, 0, ',', ' ') ?> <span class="stat-label">Ar</span></div>
          </div>
          <div class="stat-icon green"><i class="bi bi-cash-coin"></i></div>
        </div>
      </div>
    </div>
  </div>

  <?php if (empty($gainsParOperateur)): ?>
    <div class="card-vola mb-4">
      <div class="card-body text-center text-muted py-5">
        <i class="bi bi-inbox" style="font-size:2.5rem;"></i>
        <p class="mt-3 mb-0">Aucune opération de retrait ou transfert</p>
      </div>
    </div>
  <?php else: ?>
    <?php foreach ($gainsParOperateur as $nomOp => $lignes): ?>
      <div class="card-vola mb-4">
        <div class="card-header-vola d-flex justify-content-between align-items-center">
          <span class="fw-bold">
            <i class="bi bi-building me-1"></i><?= esc($nomOp) ?>
          </span>
          <span class="badge" style="background:rgba(11,110,79,0.1);color:var(--vola-green);font-size:0.85rem;font-weight:600;">
            <i class="bi bi-cash-stack me-1"></i><?= number_format($totalParOperateur[$nomOp], 0, ',', ' ') ?> Ar
          </span>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table-vola mb-0">
              <thead>
                <tr>
                  <th>Type d'opération</th>
                  <th class="text-end">Nb opérations</th>
                  <th class="text-end">Total montant</th>
                  <th class="text-end">Gains (frais)</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($lignes as $g): ?>
                  <tr>
                    <td>
                      <?php if ($g['type_operation'] === 'Retrait'): ?>
                        <span class="badge" style="background:rgba(244,162,97,0.15);color:var(--vola-gold);"><i class="bi bi-arrow-up-right me-1"></i><?= esc($g['type_operation']) ?></span>
                      <?php else: ?>
                        <span class="badge" style="background:rgba(37,99,235,0.1);color:var(--vola-blue);"><i class="bi bi-send me-1"></i><?= esc($g['type_operation']) ?></span>
                      <?php endif; ?>
                    </td>
                    <td class="text-end"><?= $g['nombre_operations'] ?></td>
                    <td class="text-end"><?= number_format($g['total_montant'], 0, ',', ' ') ?> Ar</td>
                    <td class="text-end fw-bold text-success"><?= number_format($g['total_frais'], 0, ',', ' ') ?> Ar</td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <div class="card-vola mb-4">
    <div class="card-header-vola d-flex justify-content-between align-items-center">
      <span><i class="bi bi-info-circle me-1"></i>Barème des frais</span>
      <a href="/montant-frais/create" class="btn btn-vola btn-vola-green btn-sm">
        <i class="bi bi-plus-circle me-1"></i>Ajouter
      </a>
    </div>
    <div class="card-body p-0">
      <table class="table-vola">
        <thead>
          <tr>
            <th>Fourchette de montant</th>
            <th class="text-end">Frais</th>
            <th class="text-end" style="width:120px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($baremes)): ?>
            <tr>
              <td colspan="3" class="text-center text-muted py-3"><i class="bi bi-inbox me-1"></i>Aucun barème configuré</td>
            </tr>
          <?php else: ?>
            <?php foreach ($baremes as $b): ?>
              <tr>
                <td><?= number_format($b['montant1'], 0, ',', ' ') ?> — <?= number_format($b['montant2'], 0, ',', ' ') ?> Ar</td>
                <td class="text-end fw-semibold"><?= number_format($b['frais'], 0, ',', ' ') ?> Ar</td>
                <td class="text-end">
                  <a href="/montant-frais/<?= $b['id_montant_frais'] ?>/edit" class="btn btn-sm" style="color:var(--vola-blue);border:1px solid var(--vola-border);border-radius:8px;">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="/montant-frais/<?= $b['id_montant_frais'] ?>/delete" method="post" class="d-inline" onsubmit="return confirm('Supprimer ce barème ?')">
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

  <div class="card-vola">
    <div class="card-header-vola d-flex justify-content-between align-items-center">
      <span><i class="bi bi-percent me-1"></i>Commissions inter-opérateurs</span>
      <a href="/commission" class="btn btn-vola btn-vola-blue btn-sm">
        <i class="bi bi-gear me-1"></i>Gérer
      </a>
    </div>
    <div class="card-body text-center text-muted py-4">
      <i class="bi bi-arrow-left-right" style="font-size:2rem;"></i>
      <p class="mt-2 mb-0">Gérez les taux de commission pour les transferts inter-opérateurs</p>
    </div>
  </div>

</div>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
