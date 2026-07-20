<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Situation des gains — Vola+</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/dashboard">Vola<span class="text-warning">+</span></a>
    <span class="navbar-text text-white"><i class="bi bi-graph-up me-1"></i>Côté Opérateur</span>
  </div>
</nav>

<div class="container py-4">

  <h4 class="fw-bold mb-1"><i class="bi bi-cash-stack text-success me-2"></i>Situation des gains</h4>
  <p class="text-muted mb-4">Gains via les frais sur retraits et transferts</p>

  <!-- Carte total -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm bg-success text-white">
        <div class="card-body">
          <small class="opacity-75">Total des gains (frais)</small>
          <h3 class="fw-bold mb-0"><?= number_format($totalGains, 0, ',', ' ') ?> Ar</h3>
        </div>
      </div>
    </div>
  </div>

  <!-- Tableau gains par opérateur -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-semibold">
      <i class="bi bi-table me-1"></i>Détail par opérateur et type d'opération
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Opérateur</th>
              <th>Type d'opération</th>
              <th class="text-end">Nb opérations</th>
              <th class="text-end">Total montant</th>
              <th class="text-end">Total frais (gains)</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($gains)): ?>
              <tr>
                <td colspan="5" class="text-center text-muted py-4">Aucune opération de retrait ou transfert</td>
              </tr>
            <?php else: ?>
              <?php foreach ($gains as $g): ?>
                <tr>
                  <td class="fw-semibold"><?= esc($g['nom_operateur']) ?></td>
                  <td>
                    <span class="badge bg-<?= $g['type_operation'] === 'Retrait' ? 'warning text-dark' : 'info' ?>">
                      <?= esc($g['type_operation']) ?>
                    </span>
                  </td>
                  <td class="text-end"><?= $g['nombre_operations'] ?></td>
                  <td class="text-end"><?= number_format($g['total_montant'], 0, ',', ' ') ?> Ar</td>
                  <td class="text-end fw-bold text-success"><?= number_format($g['total_frais'], 0, ',', ' ') ?> Ar</td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
          <?php if (!empty($gains)): ?>
            <tfoot class="table-light">
              <tr class="fw-bold">
                <td colspan="4" class="text-end">Total gains :</td>
                <td class="text-end text-success"><?= number_format($totalGains, 0, ',', ' ') ?> Ar</td>
              </tr>
            </tfoot>
          <?php endif; ?>
        </table>
      </div>
    </div>
  </div>

  <!-- Barème des frais dynamique avec boutons CRUD -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
      <span class="fw-semibold"><i class="bi bi-info-circle me-1"></i>Barème des frais</span>
      <a href="/montant-frais/create" class="btn btn-success btn-sm">
        <i class="bi bi-plus-circle me-1"></i>Ajouter
      </a>
    </div>
    <div class="card-body p-0">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Fourchette de montant</th>
            <th class="text-end">Frais</th>
            <th class="text-end" style="width:120px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($baremes)): ?>
            <tr>
              <td colspan="3" class="text-center text-muted py-3">Aucun barème configuré</td>
            </tr>
          <?php else: ?>
            <?php foreach ($baremes as $b): ?>
              <tr>
                <td><?= number_format($b['montant1'], 0, ',', ' ') ?> — <?= number_format($b['montant2'], 0, ',', ' ') ?> Ar</td>
                <td class="text-end fw-semibold"><?= number_format($b['frais'], 0, ',', ' ') ?> Ar</td>
                <td class="text-end">
                  <a href="/montant-frais/<?= $b['id_montant_frais'] ?>/edit" class="btn btn-outline-primary btn-sm me-1">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <form action="/montant-frais/<?= $b['id_montant_frais'] ?>/delete" method="post" class="d-inline" onsubmit="return confirm('Supprimer ce barème ?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
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

</body>
</html>
