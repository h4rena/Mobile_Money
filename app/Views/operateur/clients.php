<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Situation des clients — Vola+</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/dashboard">Vola<span class="text-warning">+</span></a>
    <span class="navbar-text text-white"><i class="bi bi-people me-1"></i>Côté Opérateur</span>
    <div class="d-flex gap-2">
      <a href="/operateur/situation" class="btn btn-outline-light btn-sm">Gains</a>
      <a href="/operateur/clients" class="btn btn-outline-light btn-sm">Clients</a>
      <a href="/auth/logout" class="btn btn-outline-warning btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Déconnexion</a>
    </div>
  </div>
</nav>

<div class="container py-4">

  <h4 class="fw-bold mb-1"><i class="bi bi-people-fill text-success me-2"></i>Situation des comptes clients</h4>
  <p class="text-muted mb-4">Liste de tous les clients et leurs soldes</p>

  <!-- Carte total -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm bg-success text-white">
        <div class="card-body">
          <small class="opacity-75">Nombre de clients</small>
          <h3 class="fw-bold mb-0"><?= count($clients) ?></h3>
        </div>
      </div>
    </div>
  </div>

  <!-- Tableau clients -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">
      <i class="bi bi-table me-1"></i>Liste des clients
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
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
                  <td><span class="badge bg-secondary"><?= esc($c['numero']) ?></span></td>
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

</body>
</html>
