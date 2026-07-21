<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Barèmes des frais — Vola+</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<?= view('operateur/partials/navbar', ['activePage' => 'bareme']) ?>

<div class="container-fluid px-3 px-md-4 py-4 fade-in">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-bold mb-0"><i class="bi bi-list-ul text-success me-2"></i>Barèmes des frais</h4>
      <small class="text-muted">Fourchettes de montant et frais associés</small>
    </div>
    <a href="/montant-frais/create" class="btn btn-vola btn-vola-green">
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
              <th>Montant min</th>
              <th>Montant max</th>
              <th class="text-end">Frais</th>
              <th class="text-end" style="width:120px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($montantFrais)): ?>
              <tr>
                <td colspan="4" class="text-center text-muted py-4"><i class="bi bi-inbox me-1"></i>Aucun barème configuré</td>
              </tr>
            <?php else: ?>
              <?php foreach ($montantFrais as $mf): ?>
                <tr>
                  <td><?= number_format($mf['montant1'], 0, ',', ' ') ?> Ar</td>
                  <td><?= number_format($mf['montant2'], 0, ',', ' ') ?> Ar</td>
                  <td class="text-end fw-semibold"><?= number_format($mf['frais'], 0, ',', ' ') ?> Ar</td>
                  <td class="text-end">
                    <a href="/montant-frais/<?= $mf['id_montant_frais'] ?>/edit" class="btn btn-sm" style="color:var(--vola-blue);border:1px solid var(--vola-border);border-radius:8px;">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <form action="/montant-frais/<?= $mf['id_montant_frais'] ?>/delete" method="post" class="d-inline" onsubmit="return confirm('Supprimer ce barème ?')">
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
