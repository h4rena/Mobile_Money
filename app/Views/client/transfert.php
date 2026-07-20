<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert — Vola+</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-vola">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="/dashboard">Vola<span class="plus">+</span></a>
    <a href="/dashboard" class="btn btn-sm" style="color:#fff; border:1px solid rgba(255,255,255,0.3); border-radius:10px;"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
</nav>

<div class="container py-5 fade-in">
  <div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-lg-4">

      <div class="card-vola">
        <div class="card-body p-4">
          <div class="text-center mb-4">
            <div class="stat-icon blue mx-auto mb-2" style="width:56px;height:56px;font-size:1.5rem;">
              <i class="bi bi-send"></i>
            </div>
            <h5 class="fw-bold">Envoyer de l'argent</h5>
          </div>

          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-vola alert-vola-danger"><i class="bi bi-exclamation-triangle"></i><?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-vola alert-vola-success"><i class="bi bi-check-circle"></i><?= session()->getFlashdata('success') ?></div>
          <?php endif; ?>

          <div class="client-info blue">
            <small class="text-muted">Client</small>
            <div class="fw-semibold"><?= esc($client['nom_client']) ?> — <?= esc($client['numero']) ?></div>
            <small class="text-muted">Solde actuel</small>
            <div class="fs-5 fw-bold text-success"><?= number_format($client['solde'], 0, ',', ' ') ?> Ar</div>
          </div>

          <form action="/operations/store" method="post">
            <input type="hidden" name="id_client" value="<?= $client['id_client'] ?>">
            <input type="hidden" name="id_type_operation" value="3">

            <label for="numero_destinataire" class="form-label fw-semibold">Numero du destinataire</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" name="numero_destinataire" id="numero_destinataire" placeholder="03X XXX XXXX" required>
            </div>

            <label for="montant" class="form-label fw-semibold">Montant du transfert (Ar)</label>
            <div class="input-group mb-4">
              <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
              <input type="number" class="form-control" name="montant" id="montant" min="0" placeholder="Entrez le montant" required>
            </div>

            <button type="submit" class="btn btn-vola btn-vola-blue w-100 btn-lg mb-2">
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
