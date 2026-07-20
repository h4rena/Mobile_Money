<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Voir Solde — Vola+</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-dark bg-success shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/dashboard">Vola<span class="text-warning">+</span></a>
    <a href="/dashboard" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
</nav>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-lg-4">
      <div class="card border-0 shadow text-center">
        <div class="card-body p-5">
          <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
            <i class="bi bi-wallet2 text-success" style="font-size:2rem;"></i>
          </div>
          <h6 class="text-muted mb-1">Votre solde disponible</h6>
          <h1 class="display-4 fw-bold text-success mb-3">
            <?= number_format($solde, 0, ',', ' ') ?> <small class="fs-5">Ar</small>
          </h1>
          <hr>
          <a href="/dashboard" class="btn btn-success w-100 mt-2">
            <i class="bi bi-house me-1"></i>Retour au tableau de bord
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
