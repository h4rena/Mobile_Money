<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Connexion Operateur — Vola+</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body class="login-bg">

<div class="login-card fade-in">
  <div class="text-center mb-4">
    <div class="login-logo">Vola<span class="plus">+</span></div>
    <p class="login-subtitle"><i class="bi bi-person-gear me-1"></i>Espace Operateur</p>
  </div>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-vola alert-vola-danger">
      <i class="bi bi-exclamation-triangle"></i>
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <form action="/auth/log_operateur" method="post">
    <label for="operateur" class="form-label fw-semibold">Nom operateur</label>
    <div class="input-group mb-3">
      <span class="input-group-text"><i class="bi bi-person"></i></span>
      <input type="text" class="form-control" id="operateur" name="operateur" placeholder="Nom de l'operateur" required autofocus>
    </div>

    <label for="mdp" class="form-label fw-semibold">Mot de passe</label>
    <div class="input-group mb-4">
      <span class="input-group-text"><i class="bi bi-lock"></i></span>
      <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
    </div>

    <button type="submit" class="btn btn-vola btn-vola-green w-100 btn-lg">
      <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
    </button>
    <p>email:vola@vola.mg</p>
    <p>password:mdp1</p>
  </form>

  <hr class="my-3">
  <div class="text-center">
    <a href="/" class="text-decoration-none small"><i class="bi bi-arrow-left me-1"></i>Retour - Client</a>
  </div>
</div>

</body>
</html>
