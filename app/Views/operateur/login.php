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

  <form action="/auth/log_operateur" method="post">
    <label for="operateur" class="form-label fw-semibold">Email</label>
    <div class="input-group mb-3">
      <span class="input-group-text"><i class="bi bi-envelope"></i></span>
      <input type="email" class="form-control" id="operateur" name="operateur" placeholder="Email de l'opérateur" required autofocus>
    </div>

    <label for="mdp" class="form-label fw-semibold">Mot de passe</label>
    <div class="input-group mb-4">
      <span class="input-group-text"><i class="bi bi-lock"></i></span>
      <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger py-2"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <button type="submit" class="btn btn-vola btn-vola-green w-100 btn-lg">
      <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
    </button>
  </form>
</div>

</body>
</html>
