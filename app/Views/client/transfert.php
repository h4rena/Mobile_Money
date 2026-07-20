<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfert — Vola+</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-vola">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="/dashboard">Vola<span class="plus">+</span></a>
    <a href="/dashboard" class="btn btn-sm" style="color:#fff; border:1px solid rgba(255,255,255,0.3); border-radius:10px;"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
</nav>

<div class="container py-5 fade-in">
  <div class="row justify-content-center">
    <div class="col-sm-10 col-md-7 col-lg-5">

      <div class="card-vola">
        <div class="card-body p-4">
          <div class="text-center mb-4">
            <div class="stat-icon blue mx-auto mb-2" style="width:56px;height:56px;font-size:1.5rem;">
              <i class="bi bi-send"></i>
            </div>
            <h5 class="fw-bold">Envoyer de l'argent</h5>
            <small class="text-muted">Même opérateur uniquement</small>
          </div>

          <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-vola alert-vola-danger"><i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?></div>
          <?php endif; ?>

          <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-vola alert-vola-success"><i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
          <?php endif; ?>

          <div class="client-info blue mb-3">
            <small class="text-muted">Client</small>
            <div class="fw-semibold"><?= esc($client['nom_client']) ?> — <?= esc($client['numero']) ?></div>
            <small class="text-muted">Solde actuel</small>
            <div class="fs-5 fw-bold text-success"><?= number_format($client['solde'], 0, ',', ' ') ?> Ar</div>
          </div>

          <form action="/operations/store" method="post" id="formTransfert">
            <input type="hidden" name="id_client" value="<?= $client['id_client'] ?>">
            <input type="hidden" name="id_type_operation" value="3">

            <label class="form-label fw-semibold">Destinataires</label>
            <div id="destinataires-list">
              <div class="destinataire-row input-group mb-2">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control dest-input" name="numero_destinataire[]" placeholder="03X XXX XXXX" required>
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove" style="display:none;" title="Retirer"><i class="bi bi-x-lg"></i></button>
              </div>
            </div>

            <button type="button" id="btn-add" class="btn btn-sm w-100 mb-3" style="color:var(--vola-blue);border:1px dashed var(--vola-blue);border-radius:8px;background:rgba(37,99,235,0.03);">
              <i class="bi bi-plus-circle me-1"></i>Ajouter un destinataire
            </button>

            <div id="alert-inter" class="small mb-3 p-2 text-center" style="display:none;background:rgba(244,162,97,0.1);border:1px solid rgba(244,162,97,0.3);border-radius:8px;color:#b45309;font-weight:600;">
              <i class="bi bi-exclamation-triangle me-1"></i>Tous les numéros doivent être du même opérateur
            </div>

            <div id="split-preview" class="small text-center mb-3 p-2" style="display:none;background:rgba(11,110,79,0.05);border:1px solid rgba(11,110,79,0.15);border-radius:8px;color:var(--vola-green);font-weight:600;">
              <i class="bi bi bi-arrow-left-right me-1"></i>Chaque destinataire recevra <span id="split-amount">0</span> Ar
            </div>

            <label for="montant" class="form-label fw-semibold">Montant total (Ar)</label>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
              <input type="number" class="form-control" name="montant" id="montant" min="1" placeholder="Entrez le montant total" required>
            </div>

            <div id="frais-box" class="mb-4 p-3" style="background:rgba(37,99,235,0.05);border:1px solid rgba(37,99,235,0.15);border-radius:10px;">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="inclus_frais" id="inclus_frais" value="1" checked>
                <label class="form-check-label fw-semibold" for="inclus_frais">
                  <i class="bi bi-shield-check text-primary me-1"></i>Inclure les frais de retrait
                </label>
                <div class="small text-muted mt-1">L'expéditeur paie les frais. Les destinataires reçoivent le montant complet.</div>
              </div>
            </div>

            <button type="submit" id="btn-submit" class="btn btn-vola btn-vola-blue w-100 btn-lg mb-2">
              <i class="bi bi-send me-1"></i>Effectuer le transfert
            </button>
            <a href="/dashboard" class="btn btn-outline-secondary w-100">Annuler</a>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const clientNumero = '<?= esc($client['numero']) ?>';
    const prefixeClient = clientNumero.substring(0, 3);

    const list = document.getElementById('destinataires-list');
    const btnAdd = document.getElementById('btn-add');
    const btnSubmit = document.getElementById('btn-submit');
    const alertInter = document.getElementById('alert-inter');
    const splitPreview = document.getElementById('split-preview');
    const splitAmount = document.getElementById('split-amount');
    const inputMontant = document.getElementById('montant');
    const checkbox = document.getElementById('inclus_frais');
    const fraisBox = document.getElementById('frais-box');

    function creerLigne() {
        const row = document.createElement('div');
        row.className = 'destinataire-row input-group mb-2';
        row.innerHTML = '<span class="input-group-text"><i class="bi bi-person"></i></span>' +
            '<input type="text" class="form-control dest-input" name="numero_destinataire[]" placeholder="03X XXX XXXX" required>' +
            '<button type="button" class="btn btn-sm btn-outline-danger btn-remove" title="Retirer"><i class="bi bi-x-lg"></i></button>';

        row.querySelector('.btn-remove').addEventListener('click', function() {
            row.remove();
            verifierTout();
            mettreAJourPreview();
        });

        row.querySelector('.dest-input').addEventListener('input', function() {
            verifierTout();
        });

        list.appendChild(row);
        row.querySelector('.dest-input').focus();
    }

    function verifierTout() {
        const inputs = list.querySelectorAll('.dest-input');
        let tousValides = true;
        let tousVides = true;

        inputs.forEach(function(input) {
            const val = input.value.replace(/\s/g, '');
            if (val.length >= 3) {
                tousVides = false;
                const prefixe = val.substring(0, 3);
                if (prefixe !== prefixeClient) {
                    tousValides = false;
                    input.style.borderColor = 'var(--vola-red)';
                } else {
                    input.style.borderColor = '';
                }
            }
        });

        const nbInputs = inputs.length;
        const btnsRemove = list.querySelectorAll('.btn-remove');
        btnsRemove.forEach(function(btn) {
            btn.style.display = nbInputs > 1 ? '' : 'none';
        });

        if (!tousValides) {
            alertInter.style.display = '';
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-50');
        } else {
            alertInter.style.display = 'none';
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('opacity-50');
        }

        const tousRemplis = inputs.length > 0 && Array.from(inputs).every(function(i) {
            return i.value.replace(/\s/g, '').length >= 3 && i.value.replace(/\s/g, '').substring(0, 3) === prefixeClient;
        });

        if (tousRemplis && tousValides) {
            checkbox.disabled = false;
            checkbox.checked = true;
            fraisBox.style.borderColor = 'rgba(37,99,235,0.15)';
        }
    }

    function mettreAJourPreview() {
        const inputs = list.querySelectorAll('.dest-input');
        const nb = inputs.length;
        const montant = parseFloat(inputMontant.value) || 0;

        if (nb > 0 && montant > 0) {
            const parDest = Math.floor(montant / nb);
            splitAmount.textContent = parDest.toLocaleString('fr-FR');
            splitPreview.style.display = '';
        } else {
            splitPreview.style.display = 'none';
        }
    }

    btnAdd.addEventListener('click', function() {
        creerLigne();
        mettreAJourPreview();
    });

    inputMontant.addEventListener('input', mettreAJourPreview);

    list.addEventListener('input', function() {
        verifierTout();
        mettreAJourPreview();
    });

    document.getElementById('formTransfert').addEventListener('submit', function(e) {
        verifierTout();
        if (btnSubmit.disabled) {
            e.preventDefault();
        }
    });

    verifierTout();
    mettreAJourPreview();
});
</script>

</body>
</html>
