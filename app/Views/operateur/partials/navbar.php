<?php $operateur = session()->get('operateur') ?? []; ?>
<?php $activePage = $activePage ?? ''; ?>

<nav class="navbar navbar-expand-lg navbar-vola">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="/operateur/situation">Vola<span class="plus">+</span></a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navOp">
      <i class="bi bi-list text-white" style="font-size:1.4rem;"></i>
    </button>
    <div class="collapse navbar-collapse" id="navOp">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?= $activePage === 'situation' ? 'active' : '' ?>" href="/operateur/situation">
            <i class="bi bi-graph-up me-1"></i>Situation
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $activePage === 'commission' ? 'active' : '' ?>" href="/commission">
            <i class="bi bi-percent me-1"></i>Commissions
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $activePage === 'prefixe' ? 'active' : '' ?>" href="/prefixes">
            <i class="bi bi-hash me-1"></i>Préfixes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $activePage === 'bareme' ? 'active' : '' ?>" href="/montant-frais">
            <i class="bi bi-info-circle me-1"></i>Barèmes
          </a>
        </li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <div class="avatar"><?= isset($operateur['email']) ? strtoupper(substr($operateur['email'], 0, 1)) : 'O' ?></div>
        <span class="text-white fw-semibold d-none d-md-inline"><?= esc($operateur['email'] ?? 'Operateur') ?></span>
        <a href="/auth/logout" class="text-white text-decoration-none ms-2" title="Deconnexion">
          <i class="bi bi-box-arrow-left"></i>
        </a>
      </div>
    </div>
  </div>
</nav>
