<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Barèmes des frais — Vola+</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/dashboard">Vola<span class="text-warning">+</span></a>
    <a href="/operateur/situation" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
</nav>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-list-ul text-success me-2"></i>Barèmes des frais</h4>
    <a href="/montant-frais/create" class="btn btn-success btn-sm">
      <i class="bi bi-plus-circle me-1"></i>Ajouter
    </a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success py-2"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Montant min</th>
            <th>Montant max</th>
            <th class="text-end">Frais</th>
            <th class="text-end" style="width:120px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($montantFrais as $mf): ?>
            <tr>
              <td><?= number_format($mf['montant1'], 0, ',', ' ') ?> Ar</td>
              <td><?= number_format($mf['montant2'], 0, ',', ' ') ?> Ar</td>
              <td class="text-end fw-semibold"><?= number_format($mf['frais'], 0, ',', ' ') ?> Ar</td>
              <td class="text-end">
                <a href="/montant-frais/<?= $mf['id_montant_frais'] ?>/edit" class="btn btn-outline-primary btn-sm me-1">
                  <i class="bi bi-pencil"></i>
                </a>
                <form action="/montant-frais/<?= $mf['id_montant_frais'] ?>/delete" method="post" class="d-inline" onsubmit="return confirm('Supprimer ce barème ?')">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
