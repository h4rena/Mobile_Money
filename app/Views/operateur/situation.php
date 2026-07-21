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

<?= view('operateur/partials/navbar', ['activePage' => 'situation']) ?>

<div class="container-fluid px-3 px-md-4 py-4 fade-in">

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-vola alert-vola-success mb-3"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-vola alert-vola-danger mb-3"><i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <h4 class="fw-bold mb-1"><i class="bi bi-cash-stack text-success me-2"></i>Situation des gains</h4>
  <p class="text-muted mb-3">Gains via les frais sur retraits et transferts</p>

  <div class="d-flex align-items-center gap-3 mb-4">
    <div class="dropdown">
      <button class="btn btn-sm btn-vola btn-vola-green dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-funnel me-1"></i>
        <?= !$filtreType ? 'Tous' : ($filtreType === 'retrait' ? 'Retrait' : 'Transfert') ?>
      </button>
      <ul class="dropdown-menu dropdown-menu-vola">
        <li><a class="dropdown-item <?= !$filtreType ? 'active' : '' ?>" href="/operateur/situation"><i class="bi bi-grid me-2"></i>Tous</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item <?= $filtreType === 'retrait' ? 'active' : '' ?>" href="/operateur/situation?type=retrait"><i class="bi bi-arrow-up-right me-2"></i>Retrait</a></li>
        <li><a class="dropdown-item <?= $filtreType === 'transfert' ? 'active' : '' ?>" href="/operateur/situation?type=transfert"><i class="bi bi-send me-2"></i>Transfert</a></li>
      </ul>
    </div>
    <?php if ($filtreType): ?>
      <a href="/operateur/situation" class="btn btn-sm" style="border:1px solid var(--vola-border);color:var(--vola-red);border-radius:8px;">
        <i class="bi bi-x-circle me-1"></i>Effacer
      </a>
    <?php endif; ?>
  </div>

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
  
</div>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
