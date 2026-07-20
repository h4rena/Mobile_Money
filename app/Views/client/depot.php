<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépôt — Vola+</title>
</head>
<body>
    <h2>Effectuer un dépôt</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <p>Client : <?= esc($client['nom_client']) ?> — <?= esc($client['numero']) ?></p>
    <p>Solde actuel : <?= number_format($client['solde'], 0, ',', ' ') ?> Ar</p>

    <form action="/operations/store" method="post">
        <input type="hidden" name="id_client" value="<?= $client['id_client'] ?>">
        <input type="hidden" name="id_type_operation" value="1">
        <input type="hidden" name="id_operateur" value="1">

        <label for="montant">Montant du dépôt (Ar) :</label><br>
        <input type="number" name="montant" id="montant" min="0" placeholder="Entrez le montant" required><br><br>

        <button type="submit">Effectuer le dépôt</button>
        <a href="/dashboard">Annuler</a>
    </form>
</body>
</html>