<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Situation des clients — Vola+</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<?= view('operateur/partials/navbar') ?>

<div class="container-fluid px-3 px-md-4 py-4 fade-in">

  <h4 class="fw-bold mb-1"><i class="bi bi-people-fill text-success me-2"></i>Situation des comptes clients</h4>
  <p class="text-muted mb-4">Liste de tous les clients et leurs soldes</p>

  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="stat-card green">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="stat-label">Nombre de clients</div>
            <div class="stat-value text-success"><?= count($clients) ?></div>
          </div>
          <div class="stat-icon green"><i class="bi bi-people"></i></div>
        </div>
      </div>
    </div>
  </div>

  <div class="card-vola">
    <div class="card-header-vola">
      <span><i class="bi bi-table me-1"></i>Liste des clients</span>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table-vola mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Nom complet</th>
              <th>Numéro</th>
              <th class="text-end">Solde</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($clients)): ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-4">Aucun client enregistré</td>
              </tr>
            <?php else: ?>
              <?php foreach ($clients as $i => $c): ?>
                <tr>
                  <td class="text-muted"><?= $i + 1 ?></td>
                  <td class="fw-semibold"><?= esc($c['nom_client']) ?></td>
                  <td><span class="badge" style="background:rgba(85,85,85,0.1);color:#555;border-radius:6px;"><?= esc($c['numero']) ?></span></td>
                  <td class="text-end fw-bold text-success"><?= number_format($c['solde'], 0, ',', ' ') ?> Ar</td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
