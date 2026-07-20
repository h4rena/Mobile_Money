<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tableau de bord — Vola+</title>
<meta name="theme-color" content="#0B6E4F">
<link rel="manifest" href="manifest.json">

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div id="netBanner"><span class="dot"></span><span id="netBannerText">Mode hors ligne — les opérations seront synchronisées au retour du réseau</span></div>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="app-shell">

  <!-- Barre latérale -->
  <aside class="sidebar" id="sidebar">
    <div class="brand-mark">Vola<span class="plus">+</span></div>
    <ul class="nav-vola">
      <li><a href="#" class="active"><i class="bi bi-grid-1x2-fill"></i>Tableau de bord</a></li>
      <li><a href="#"><i class="bi bi-arrow-left-right"></i>Transactions</a></li>
      <li><a href="#"><i class="bi bi-send"></i>Envoyer de l'argent</a></li>
      <li><a href="#"><i class="bi bi-receipt"></i>Payer une facture</a></li>
      <li><a href="#"><i class="bi bi-qr-code-scan"></i>Scanner un code</a></li>
      <li><a href="#"><i class="bi bi-person"></i>Mon compte</a></li>
      <li><a href="#"><i class="bi bi-gear"></i>Paramètres</a></li>
    </ul>
    <div class="sidebar-foot">
      <a href="login.html" style="color:rgba(255,255,255,0.7);"><i class="bi bi-box-arrow-left me-2"></i>Déconnexion</a>
    </div>
  </aside>

  <div class="main-col">

    <div class="topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="burger-btn" onclick="openSidebar()"><i class="bi bi-list"></i></button>
        <h5>Tableau de bord</h5>
      </div>
      <div class="topbar-right">
        <span class="badge-offline-tag" id="offlineTag" style="display:none;">HORS LIGNE</span>
        <i class="bi bi-bell text-muted"></i>
        <div class="avatar-circle" id="avatarLetter">R</div>
      </div>
    </div>

    <div class="page-body">

      <!-- Cartes statistiques -->
      <div class="row g-3 mb-2">
        <div class="col-6 col-lg-3">
          <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
            <div class="stat-label">Solde disponible</div>
            <div class="stat-value"><span id="balanceValue">125 400</span> <span style="font-size:0.9rem;">Ar</span> <button class="btn btn-sm p-0 border-0" onclick="toggleBalance()"><i class="bi bi-eye" id="eyeIcon" style="font-size:0.85rem; color:var(--vola-muted);"></i></button></div>
            <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i>+12 000 aujourd'hui</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="stat-label">Reçu ce mois</div>
            <div class="stat-value">312 000 <span style="font-size:0.9rem;">Ar</span></div>
            <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i>+8 % vs mois dernier</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat-card">
            <div class="stat-icon" style="background:rgba(214,69,69,0.10); color:var(--vola-red);"><i class="bi bi-graph-down-arrow"></i></div>
            <div class="stat-label">Dépensé ce mois</div>
            <div class="stat-value">186 500 <span style="font-size:0.9rem;">Ar</span></div>
            <div class="stat-delta down"><i class="bi bi-arrow-down-short"></i>-3 % vs mois dernier</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat-card">
            <div class="stat-icon" style="background:#FFF4E0; color:#B87A1E;"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-label">En attente de sync.</div>
            <div class="stat-value" id="pendingCount">0</div>
            <div class="stat-delta" style="color:var(--vola-muted);">Opérations hors ligne</div>
          </div>
        </div>
      </div>

      <div class="row g-3 mt-1">
        <!-- Actions rapides -->
        <div class="col-lg-4">
          <div class="panel h-100">
            <div class="panel-head"><h6>Actions rapides</h6></div>
            <div class="qa-grid">
              <button class="qa-btn" onclick="openAction('Envoyer de l\'argent')"><i class="bi bi-send"></i>Envoyer</button>
              <button class="qa-btn" onclick="openAction('Recharger')"><i class="bi bi-plus-circle"></i>Recharger</button>
              <button class="qa-btn" onclick="openAction('Retirer')"><i class="bi bi-arrow-down-left-circle"></i>Retirer</button>
              <button class="qa-btn" onclick="openAction('Payer une facture')"><i class="bi bi-receipt"></i>Payer</button>
            </div>
          </div>
        </div>

        <!-- Transactions récentes -->
        <div class="col-lg-8">
          <div class="panel h-100">
            <div class="panel-head">
              <h6>Transactions récentes</h6>
              <a href="#">Tout voir</a>
            </div>
            <div style="overflow-x:auto;">
              <table class="table-vola">
                <thead>
                  <tr><th></th><th>Opération</th><th>Date</th><th style="text-align:right;">Montant</th></tr>
                </thead>
                <tbody id="txTableBody"><!-- injecté en JS --></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Modale action rapide -->
<div class="modal fade" id="actionModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-content-vola">
      <div class="modal-body p-4">
        <h6 class="fw-bold mb-3" id="actionModalTitle" style="font-family:var(--font-display);">Envoyer de l'argent</h6>
        <label class="form-label-vola">Numéro du destinataire</label>
        <input type="tel" class="input-vola mb-3" placeholder="034 00 000 00">
        <label class="form-label-vola">Montant (Ar)</label>
        <input type="number" class="input-vola mb-4" placeholder="0" id="actionAmount">
        <button class="btn-vola-primary" onclick="confirmAction()">Confirmer</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>