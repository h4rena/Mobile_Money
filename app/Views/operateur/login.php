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
    <label for="operateur" class="form-label fw-semibold">Nom operateur</label>
    <div class="input-group mb-4">
      <span class="input-group-text"><i class="bi bi-phone"></i></span>
      <input type="text" class="form-control" id="operateur" name="operateur" placeholder="Nom de l'operateur" required autofocus>
      <input type="password" class="form-control" name="mdp" placeholder="Mot de passe" required>
    </div>
    <button type="submit" class="btn btn-vola btn-vola-green w-100 btn-lg">
      <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
    </button>
  </form>
</div>

</body>
</html>
