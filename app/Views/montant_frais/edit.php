<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Modifier un barème — Vola+</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/dashboard">Vola<span class="text-warning">+</span></a>
    <a href="/montant-frais" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
</nav>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-semibold"><i class="bi bi-pencil me-1"></i>Modifier le barème</div>
        <div class="card-body">
          <form action="/montant-frais/<?= $montantFrais['id_montant_frais'] ?>/update" method="post">
            <?= csrf_field() ?>
            <label class="form-label fw-semibold">Montant minimum (Ar)</label>
            <input type="number" name="montant1" class="form-control mb-3" value="<?= $montantFrais['montant1'] ?>" required min="0">

            <label class="form-label fw-semibold">Montant maximum (Ar)</label>
            <input type="number" name="montant2" class="form-control mb-3" value="<?= $montantFrais['montant2'] ?>" required min="0">

            <label class="form-label fw-semibold">Frais (Ar)</label>
            <input type="number" name="frais" class="form-control mb-4" value="<?= $montantFrais['frais'] ?>" required min="0">

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-success flex-fill"><i class="bi bi-check-circle me-1"></i>Mettre à jour</button>
              <a href="/montant-frais" class="btn btn-secondary">Annuler</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
