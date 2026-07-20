<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Connexion — Vola+</title>
<meta name="theme-color" content="#0B6E4F">
<link rel="manifest" href="manifest.json">

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div id="netBanner"><span class="dot"></span><span id="netBannerText">Mode hors ligne — connexion possible avec les identifiants déjà enregistrés sur cet appareil</span></div>

<div class="login-wrap">

  <!-- Panneau de marque -->
  <!-- <div class="login-aside">
    <div class="brand-mark">Vola<span class="plus">+</span></div>
    <div>
      <h1>La mobile money qui fonctionne, même sans réseau.</h1>
      <p class="lead-sub">Envoyez, recevez et payez vos factures partout à Madagascar. Vos opérations hors ligne se synchronisent dès que la connexion revient.</p>
    </div>
    <div class="login-stats">
      <div><strong>2,4 M</strong><span>Utilisateurs actifs</span></div>
      <div><strong>99,8 %</strong><span>Disponibilité</span></div>
      <div><strong>24/7</strong><span>Support client</span></div>
    </div>
  </div> -->

  <div class="login-form-col">
    <div class="login-form-box">
      <div class="brand-mark d-lg-none mb-4" style="color:var(--vola-ink);">Vola<span class="plus">+</span></div>
      <h2>Connexion</h2>
      <p class="sub">Accédez à votre espace Vola+.</p>

      <form id="loginForm" action="/auth/log" method="post">
        <label class="form-label-vola" >Numéro de téléphone</label>
        <input type="tel" class="input-vola mb-3" id="numero" name="numero" placeholder="034 00 000 00" required>
        <button type="submit" class="btn-vola-primary mt-2">Se connecter</button>
      </form>
    </div>
  </div>

</div>
</body>
</html>