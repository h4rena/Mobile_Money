<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Connexion — Vola+</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body class="login-bg">

<div class="login-card fade-in">
  <div class="text-center mb-4">
    <div class="login-logo">Vola<span class="plus">+</span></div>
    <p class="login-subtitle">Connectez-vous pour continuer</p>
  </div>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-vola alert-vola-danger">
      <i class="bi bi-exclamation-triangle"></i>
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <form action="/auth/log" method="post">
    <label for="numero" class="form-label fw-semibold">Numero de telephone</label>
    <div class="input-group mb-4">
      <span class="input-group-text"><i class="bi bi-phone"></i></span>
      <input type="tel" class="form-control" id="numero" name="numero" placeholder="034 00 000 00" required autofocus>
    </div>
    <button type="submit" class="btn btn-vola btn-vola-green w-100 btn-lg">
      <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
    </button>
  </form>
  <a href="/operateur/login">Operateur</a>
</div>

</body>
</html>
