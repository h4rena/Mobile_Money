<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Connexion — Vola+</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-success bg-gradient min-vh-100 d-flex align-items-center justify-content-center">

<div class="card shadow-lg border-0" style="width:100%; max-width:400px;">
  <div class="card-body p-4 p-md-5">

    <div class="text-center mb-4">
      <h2 class="fw-bold text-success">Vola<span class="text-warning">+</span></h2>
      <p class="text-muted">Accédez à votre espace Vola+.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger py-2" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i><?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <form action="/auth/log" method="post">
      <label for="numero" class="form-label fw-semibold">Numéro de téléphone</label>
      <div class="input-group mb-3">
        <span class="input-group-text"><i class="bi bi-phone"></i></span>
        <input type="tel" class="form-control" id="numero" name="numero" placeholder="034 00 000 00" required autofocus>
      </div>
      <button type="submit" class="btn btn-success w-100 btn-lg">
        <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
      </button>
    </form>

  </div>
</div>

</body>
</html>
