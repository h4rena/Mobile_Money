CREATE TABLE mon_prefixe(
    id_mon_prefixe INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL
);

CREATE TABLE prefixes(
    id_prefixe INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL
);

CREATE TABLE users(
    id_user INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL,
    mot_de_passe TEXT NOT NULL,
    id_operateur INTEGER,
    FOREIGN KEY (id_operateur) REFERENCES operateurs(id_operateur) ON DELETE SET NULL
);

CREATE TABLE mon_operateur(
    id_mon_operateur INTEGER PRIMARY KEY AUTOINCREMENT,
    id_mon_prefixe INTEGER,
    FOREIGN KEY (id_mon_prefixe) REFERENCES mon_prefixe(id_mon_prefixe) ON DELETE CASCADE
);

CREATE TABLE operateurs(
    id_operateur INTEGER PRIMARY KEY AUTOINCREMENT,
    id_prefixe INTEGER,
    nom_operateur TEXT NOT NULL,
    FOREIGN KEY (id_prefixe) REFERENCES prefixes(id_prefixe) ON DELETE CASCADE
);

CREATE TABLE type_operation(
    id_type_operation INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

CREATE TABLE clients(
    id_client INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_client TEXT NOT NULL,
    numero TEXT NOT NULL,
    solde REAL NOT NULL
);

CREATE TABLE montant_frais(
    id_montant_frais INTEGER PRIMARY KEY AUTOINCREMENT,
    montant1 REAL NOT NULL,
    montant2 REAL NOT NULL,
    frais REAL NOT NULL
);

CREATE TABLE promotion(
    id_promotion INTEGER PRIMARY KEY AUTOINCREMENT,
    pourcentage INTEGER
);


CREATE TABLE operations(
    id_operation INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operateur INTEGER,
    id_operateur_dest INTEGER DEFAULT NULL,
    id_type_operation INTEGER,
    id_client INTEGER,
    montant REAL NOT NULL,
    frais REAL DEFAULT 0,
    id_promotion INTEGER,
    date_operation DATETIME NOT NULL,
    FOREIGN KEY (id_operateur) REFERENCES operateurs(id_operateur) ON DELETE CASCADE,
    FOREIGN KEY (id_operateur_dest) REFERENCES operateurs(id_operateur) ON DELETE SET NULL,
    FOREIGN KEY (id_type_operation) REFERENCES type_operation(id_type_operation) ON DELETE CASCADE,
    FOREIGN KEY (id_client) REFERENCES clients(id_client) ON DELETE CASCADE
);

CREATE TABLE historique_operations(
    id_historique INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operation INTEGER,
    date_historique DATETIME NOT NULL,
    FOREIGN KEY (id_operation) REFERENCES operations(id_operation) ON DELETE CASCADE
);



CREATE TABLE commission (
    id_commission INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operateur_source INTEGER,
    id_operateur_dest INTEGER,
    taux REAL NOT NULL,
    FOREIGN KEY (id_operateur_source) REFERENCES operateurs(id_operateur),
    FOREIGN KEY (id_operateur_dest) REFERENCES operateurs(id_operateur)
);

INSERT INTO prefixes (prefixe) VALUES
('032'),
('033'),
('034'),
('038');

INSERT INTO mon_prefixe (prefixe) VALUES
('031');

-- OPERATEURS
INSERT INTO operateurs (id_prefixe, nom_operateur) VALUES
(1, 'Orange Money'),
(2, 'Airtel Money'),
(3, 'Telma Money'),
(4, 'MVola');

INSERT INTO mon_operateur (id_mon_prefixe) VALUES
(1);

INSERT INTO users (email, mot_de_passe, id_operateur) VALUES
('vola@vola.mg', '$2y$12$iCnSzfReumcvQDzNmxXJEugLQUbJoK0HGX9dUuu5fGm0EjOt3vKTa', 4);

-- TYPES D'OPERATION
INSERT INTO type_operation (libelle) VALUES
('Depot'),
('Retrait'),
('Transfert'),
('Paiement'),
('Achat de credit');

-- CLIENTS
INSERT INTO clients (nom_client, numero, solde) VALUES
('Jean Rakoto', '0321234567', 250000),
('Marie Rasoanaivo', '0339876543', 180000),
('Paul Andry', '0341122334', 95000),
('Sarah Randria', '0385566778', 320000),
('Lucas Rakotomalala', '0329988776', 120000),
('Nina Razafindra', '0334455667', 75000);

-- MONTANTS / FRAIS
INSERT INTO montant_frais (montant1, montant2, frais) VALUES
(0, 1000, 50),
(1001, 5000, 100),
(5001, 10000, 250),
(10001, 50000, 500),
(50001, 100000, 1000),
(100001, 500000, 2000);

INSERT INTO promotion(pourcentage) VALUES(10);

-- OPERATIONS
INSERT INTO operations (
    id_operateur,
    id_operateur_dest,
    id_type_operation,
    id_client,
    montant,
    date_operation
) VALUES
(1, NULL, 1, 1, 50000, '2026-07-01 09:15:00'),
(4, 1, 3, 1, 20000, '2026-07-02 14:30:00'),
(2, NULL, 2, 2, 10000, '2026-07-03 11:00:00'),
(3, NULL, 4, 3, 5000, '2026-07-04 16:45:00'),
(4, NULL, 5, 4, 2000, '2026-07-05 08:20:00'),
(1, 3, 3, 5, 75000, '2026-07-06 13:10:00'),
(2, NULL, 1, 6, 30000, '2026-07-07 17:40:00'),
(3, NULL, 2, 2, 25000, '2026-07-08 10:25:00'),
(4, NULL, 4, 3, 15000, '2026-07-09 12:00:00'),
(1, NULL, 5, 4, 1000, '2026-07-10 18:15:00');

-- COMMISSIONS (inter-operateurs)
INSERT INTO commission (id_operateur_source, id_operateur_dest, taux) VALUES
(1, 2, 2.0),
(1, 3, 2.5),
(1, 4, 3.0),
(2, 1, 2.0),
(2, 3, 2.0),
(2, 4, 2.5),
(3, 1, 2.5),
(3, 2, 2.0),
(3, 4, 2.0),
(4, 1, 3.0),
(4, 2, 2.5),
(4, 3, 2.0);

-- VIEW : gains calcules dynamiquement depuis le bareme
CREATE VIEW v_gains AS
SELECT
    o.id_operation,
    o.id_operateur,
    op.nom_operateur,
    o.id_type_operation,
    tp.libelle AS type_operation,
    o.montant,
    COALESCE(mf.frais, 0) AS frais_calcule,
    o.date_operation
FROM operations o
JOIN operateurs op ON op.id_operateur = o.id_operateur
JOIN type_operation tp ON tp.id_type_operation = o.id_type_operation
LEFT JOIN montant_frais mf ON o.montant >= mf.montant1 AND o.montant <= mf.montant2
WHERE o.id_type_operation IN (2, 3);

-- VIEW : operations enrichies (client + operateur + type)
CREATE VIEW v_operations_detail AS
SELECT
    o.id_operation,
    o.id_client,
    o.id_operateur,
    o.id_operateur_dest,
    o.id_type_operation,
    o.montant,
    o.frais,
    o.date_operation,
    tp.libelle AS type_libelle,
    c.nom_client,
    c.numero,
    c.solde,
    op.nom_operateur,
    opd.nom_operateur AS nom_operateur_dest
FROM operations o
JOIN type_operation tp ON tp.id_type_operation = o.id_type_operation
JOIN clients c ON c.id_client = o.id_client
JOIN operateurs op ON op.id_operateur = o.id_operateur
LEFT JOIN operateurs opd ON opd.id_operateur = o.id_operateur_dest;

-- VIEW : stats completes par operateur (tous types)
CREATE VIEW v_stats_operateur AS
SELECT
    op.nom_operateur,
    tp.libelle AS type_operation,
    COUNT(*) AS nombre_operations,
    SUM(o.montant) AS total_montant,
    SUM(o.frais) AS total_frais
FROM operations o
JOIN operateurs op ON op.id_operateur = o.id_operateur
JOIN type_operation tp ON tp.id_type_operation = o.id_type_operation
GROUP BY op.nom_operateur, tp.libelle;

-- VIEW : commission avec noms des operateurs
CREATE VIEW v_commission_noms AS
SELECT
    c.id_commission,
    cs.nom_operateur AS source,
    cd.nom_operateur AS destination,
    c.taux,
    c.id_operateur_source,
    c.id_operateur_dest
FROM commission c
JOIN operateurs cs ON cs.id_operateur = c.id_operateur_source
JOIN operateurs cd ON cd.id_operateur = c.id_operateur_dest;

-- VIEW : settlement (montants a envoyer entre operateurs)
CREATE VIEW v_settlement AS
SELECT
    opsrc.nom_operateur AS operateur_source,
    opdst.nom_operateur AS operateur_destination,
    COALESCE(SUM(o.montant), 0) AS total_transferts,
    COALESCE(c.taux, 0) AS taux,
    COALESCE(SUM(o.montant * c.taux / 100), 0) AS commission_totale
FROM operations o
JOIN operateurs opsrc ON opsrc.id_operateur = o.id_operateur
JOIN operateurs opdst ON opdst.id_operateur = o.id_operateur_dest
LEFT JOIN commission c ON c.id_operateur_source = o.id_operateur AND c.id_operateur_dest = o.id_operateur_dest
WHERE o.id_type_operation = 3 AND o.id_operateur_dest IS NOT NULL
GROUP BY opsrc.nom_operateur, opdst.nom_operateur;