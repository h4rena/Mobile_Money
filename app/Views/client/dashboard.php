<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tableau de bord — Vola+</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-vola">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="/dashboard">Vola<span class="plus">+</span></a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <i class="bi bi-list text-white" style="font-size:1.4rem;"></i>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link active" href="/dashboard"><i class="bi bi-grid-1x2-fill me-1"></i>Tableau de bord</a></li>
        <li class="nav-item"><a class="nav-link" href="/client/solde"><i class="bi bi-eye me-1"></i>Voir solde</a></li>
        <li class="nav-item"><a class="nav-link" href="/transfert"><i class="bi bi-send me-1"></i>Envoyer</a></li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <div class="avatar"><?= strtoupper(substr($client['nom_client'], 0, 1)) ?></div>
        <span class="text-white fw-semibold d-none d-md-inline"><?= esc($client['nom_client']) ?></span>
        <a href="/auth/logout" class="text-white text-decoration-none ms-2" title="Deconnexion"><i class="bi bi-box-arrow-left"></i></a>
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid px-3 px-md-4 py-4 fade-in">

  <!-- Solde + Messages flash -->
  <div class="row g-3 mb-4">
    <div class="col-12">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-vola alert-vola-success mb-3">
          <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-vola alert-vola-danger mb-3">
          <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <div class="stat-card green">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <div class="stat-label">Solde disponible</div>
            <div class="stat-value text-success"><?= number_format($client['solde'], 0, ',', ' ') ?> <span class="stat-label">Ar</span></div>
          </div>
          <div class="stat-icon green"><i class="bi bi-wallet2"></i></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <!-- Actions rapides -->
    <div class="col-lg-4">
      <div class="card-vola h-100">
        <div class="card-header-vola"><i class="bi bi-lightning-fill text-warning me-1"></i>Actions rapides</div>
        <div class="card-body">
          <div class="d-flex flex-column gap-2">
            <a href="/transfert" class="qa-btn green">
              <i class="bi bi-send"></i>
              <span>Envoyer de l'argent</span>
            </a>
            <a href="/depot" class="qa-btn blue">
              <i class="bi bi-plus-circle"></i>
              <span>Recharger</span>
            </a>
            <a href="/retrait" class="qa-btn red">
              <i class="bi bi-arrow-down-left-circle"></i>
              <span>Retirer</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Transactions recentes -->
    <div class="col-lg-8">
      <div class="card-vola h-100">
        <div class="card-header-vola d-flex justify-content-between align-items-center">
          <span><i class="bi bi-clock-history me-1"></i>Transactions recentes</span>
          <a href="#" class="text-success text-decoration-none small fw-semibold">Tout voir</a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table-vola">
              <thead>
                <tr><th></th><th>Operation</th><th>Date</th><th class="text-end">Montant</th></tr>
              </thead>
              <tbody>
                <?php if (empty($operations)): ?>
                  <tr><td colspan="4" class="text-center text-muted py-4"><i class="bi bi-inbox me-1"></i>Aucune transaction</td></tr>
                <?php else: ?>
                  <?php foreach ($operations as $op): ?>
                    <?php
                      $isDepot = ($op['id_type_operation'] == 1);
                      $isRetrait = ($op['id_type_operation'] == 2);
                      $isTransfert = ($op['id_type_operation'] == 3);
                    ?>
                    <tr>
                      <td>
                        <?php if ($isDepot): ?>
                          <i class="bi bi-arrow-down-left tx-depot"></i>
                        <?php elseif ($isRetrait): ?>
                          <i class="bi bi-arrow-up-right tx-retrait"></i>
                        <?php else: ?>
                          <i class="bi bi-arrow-left-right tx-transfert"></i>
                        <?php endif; ?>
                      </td>
                      <td class="fw-semibold"><?= esc($op['type_libelle']) ?></td>
                      <td class="text-muted small"><?= date('d M Y H:i', strtotime($op['date_operation'])) ?></td>
                      <td class="text-end fw-bold <?= $isDepot ? 'tx-depot' : 'tx-retrait' ?>">
                        <?= $isDepot ? '+' : '- ' ?><?= number_format($op['montant'], 0, ',', ' ') ?> Ar
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
