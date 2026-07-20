<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert — Vola+</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/dashboard">Vola<span class="text-warning">+</span></a>
    <a href="/dashboard" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
</nav>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-lg-4">
      <div class="card border-0 shadow">
        <div class="card-body p-4">
          <h4 class="fw-bold text-primary mb-3"><i class="bi bi-send me-1"></i>Envoyer de l'argent</h4>

          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger py-2"><i class="bi bi-exclamation-triangle me-1"></i><?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success py-2"><i class="bi bi-check-circle me-1"></i><?= session()->getFlashdata('success') ?></div>
          <?php endif; ?>

          <div class="bg-primary bg-opacity-10 rounded p-3 mb-3 text-center">
            <small class="text-muted">Client</small>
            <div class="fw-semibold"><?= esc($client['nom_client']) ?> — <?= esc($client['numero']) ?></div>
            <small class="text-muted">Solde actuel</small>
            <div class="fs-5 fw-bold text-success"><?= number_format($client['solde'], 0, ',', ' ') ?> Ar</div>
          </div>

          <form action="/operations/store" method="post">
            <input type="hidden" name="id_client" value="<?= $client['id_client'] ?>">
            <input type="hidden" name="id_type_operation" value="3">

            <label for="numero_destinataire" class="form-label fw-semibold">Numéro du destinataire</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" name="numero_destinataire" id="numero_destinataire" placeholder="03X XXX XXXX" required>
            </div>

            <label for="montant" class="form-label fw-semibold">Montant du transfert (Ar)</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-cash"></i></span>
              <input type="number" class="form-control" name="montant" id="montant" min="0" placeholder="Entrez le montant" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-lg mb-2">
              <i class="bi bi-send me-1"></i>Effectuer le transfert
            </button>
            <a href="/dashboard" class="btn btn-outline-secondary w-100">Annuler</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
