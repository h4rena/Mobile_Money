<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tableau de bord — Vola+</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/dashboard">Vola<span class="text-warning">+</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link active" href="/dashboard"><i class="bi bi-grid-1x2-fill me-1"></i>Tableau de bord</a></li>
        <li class="nav-item"><a class="nav-link" href="/client/solde"><i class="bi bi-eye me-1"></i>Voir solde</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-send me-1"></i>Envoyer</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-receipt me-1"></i>Payer</a></li>
      </ul>
      <div class="d-flex align-items-center text-white">
        <span class="me-2"><i class="bi bi-bell"></i></span>
        <div class="bg-light text-success fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;">
          <?= strtoupper(substr($client['nom_client'], 0, 1)) ?>
        </div>
        <span class="ms-2 d-none d-md-inline"><?= $client['nom_client'] ?></span>
        <a href="/" class="ms-3 text-white text-decoration-none"><i class="bi bi-box-arrow-left"></i></a>
      </div>
    </div>
  </div>
</nav>

<div class="container-fluid py-3">

  <!-- Solde -->
  <div class="row g-3 mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
              <i class="bi bi-wallet2 text-success"></i>
            </div>
          </div>
          <small class="text-muted">Solde disponible</small>
          <h4 class="fw-bold mb-0"><?= number_format($client['solde'], 0, ',', ' ') ?> <small class="fs-6">Ar</small></h4>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <!-- Actions rapides -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white fw-semibold"><i class="bi bi-lightning-fill text-warning me-1"></i>Actions rapides</div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <button class="btn btn-success" onclick="window.location.href='/transfert'">
              <i class="bi bi-send me-1"></i>Envoyer de l'argent
            </button>
            <a href="/depot" class="btn btn-primary">
              <i class="bi bi-plus-circle me-1"></i>Recharger
            </a>
            <button class="btn btn-outline-danger" onclick="window.location.href='/retrait'">
              <i class="bi bi-arrow-down-left-circle me-1"></i>Retirer
            </button>
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#actionModal" data-action="Payer une facture">
              <i class="bi bi-receipt me-1"></i>Payer une facture
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Transactions récentes -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
          <span class="fw-semibold"><i class="bi bi-clock-history me-1"></i>Transactions récentes</span>
          <a href="#" class="text-success text-decoration-none small">Tout voir</a>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr><th>Opération</th><th>Date</th><th class="text-end">Montant</th></tr>
              </thead>
              <tbody>
                <?php if (empty($operations)): ?>
                  <tr><td colspan="3" class="text-center text-muted py-4">Aucune transaction</td></tr>
                <?php else: ?>
                  <?php foreach ($operations as $op): ?>
                    <?php $isDepot = ($op['id_type_operation'] == 1); ?>
                    <tr>
                      <td>
                        <i class="bi bi-<?= $isDepot ? 'arrow-down-left text-success' : 'arrow-up-right text-danger' ?> me-2"></i>
                        <?= esc($op['type_libelle']) ?>
                      </td>
                      <td class="text-muted small"><?= date('d M Y', strtotime($op['date_operation'])) ?></td>
                      <td class="text-end fw-semibold <?= $isDepot ? 'text-success' : 'text-danger' ?>">
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

<!-- Modal action rapide -->
<div class="modal fade" id="actionModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="actionModalTitle">Envoyer de l'argent</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label class="form-label fw-semibold">Numéro du destinataire</label>
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="bi bi-phone"></i></span>
          <input type="tel" class="form-control" placeholder="034 00 000 00">
        </div>
        <label class="form-label fw-semibold">Montant (Ar)</label>
        <div class="input-group mb-3">
          <span class="input-group-text">Ar</span>
          <input type="number" class="form-control" placeholder="0" id="actionAmount">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-success" onclick="confirmAction()">
          <i class="bi bi-check-circle me-1"></i>Confirmer
        </button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('[data-bs-target="#actionModal"]').forEach(function(btn) {
  btn.addEventListener('click', function() {
    document.getElementById('actionModalTitle').textContent = this.dataset.action;
  });
});
function confirmAction() {
  var modal = bootstrap.Modal.getInstance(document.getElementById('actionModal'));
  modal.hide();
  alert('Opération confirmée !');
}
</script>
</body>
</html>
