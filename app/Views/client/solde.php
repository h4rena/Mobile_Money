<?php $client = session()->get('client'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Voir Solde — Vola+</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<?= view('client/navbar', ['active' => 'solde']) ?>

<div class="container py-5 fade-in">
  <div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-lg-4">

      <div class="solde-card">
        <div class="mb-3">
          <i class="bi bi-wallet2" style="font-size:2.5rem; opacity:0.8;"></i>
        </div>
        <div class="solde-label">Votre solde disponible</div>
        <div class="solde-value"><?= number_format($solde, 0, ',', ' ') ?></div>
        <div class="solde-unit">Ariary</div>
        <hr style="border-color: rgba(255,255,255,0.2); margin: 1.5rem 0;">
        <a href="/dashboard" class="btn btn-lg" style="background:rgba(255,255,255,0.2); color:#fff; border-radius:12px; font-weight:600; width:100%;">
          <i class="bi bi-house me-1"></i>Retour au tableau de bord
        </a>
      </div>

    </div>
  </div>
</div>

</body>
</html>
