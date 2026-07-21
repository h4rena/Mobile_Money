<?php $client = session()->get('client'); ?>
<nav class="navbar navbar-expand-lg navbar-vola">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="/dashboard">Vola<span class="plus">+</span></a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <i class="bi bi-list text-white" style="font-size:1.4rem;"></i>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link <?= $active === 'dashboard' ? 'active' : '' ?>" href="/dashboard"><i class="bi bi-grid-1x2-fill me-1"></i>Tableau de bord</a></li>
        <li class="nav-item"><a class="nav-link <?= $active === 'depot' ? 'active' : '' ?>" href="/depot"><i class="bi bi-plus-circle me-1"></i>Dépôt</a></li>
        <li class="nav-item"><a class="nav-link <?= $active === 'retrait' ? 'active' : '' ?>" href="/retrait"><i class="bi bi-arrow-down-left-circle me-1"></i>Retrait</a></li>
        <li class="nav-item"><a class="nav-link <?= $active === 'transfert' ? 'active' : '' ?>" href="/transfert"><i class="bi bi-send me-1"></i>Envoyer</a></li>
        <li class="nav-item"><a class="nav-link <?= $active === 'solde' ? 'active' : '' ?>" href="/client/solde"><i class="bi bi-eye me-1"></i>Solde</a></li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <div class="avatar"><?= strtoupper(substr($client['nom_client'], 0, 1)) ?></div>
        <span class="text-white fw-semibold d-none d-md-inline"><?= esc($client['nom_client']) ?></span>
        <a href="/auth/logout" class="text-white text-decoration-none ms-2" title="Deconnexion"><i class="bi bi-box-arrow-left"></i></a>
      </div>
    </div>
  </div>
</nav>
