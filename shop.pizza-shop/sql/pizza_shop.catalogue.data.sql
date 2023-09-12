-- Adminer 4.8.1 PostgreSQL 13.1 (Debian 13.1-1.pgdg100+1) dump

INSERT INTO "categorie" ("id", "libelle") VALUES
(5,	'Pizzas'),
(6,	'Boissons'),
(7,	'Salades'),
(8,	'Desserts');

INSERT INTO "produit" ("id", "numero", "libelle", "description", "image", "categorie_id") VALUES
(2,	1,	'Margherita',	'Tomate, mozzarella, basilic',	'https://www.dominos.fr/ManagedAssets/FR/product/PZSO.png',	5),
(3,	2,	'Reine',	'Tomate, mozzarella, jambon, champignons',	'https://www.dominos.fr/ManagedAssets/FR/product/PZRE.png',	5),
(4,	3,	'Savoyarde',	'Tomate, mozzarella, jambon, reblochon, pommes de terre, oignons',	'https://www.dominos.fr/ManagedAssets/FR/product/PZSA.png',	5),
(5,	4,	'Pepperoni',	'Tomate, mozzarella, pepperoni',	'https://www.dominos.fr/ManagedAssets/FR/product/PZPE.png',	5),
(6,	5,	'cola',	'Cola-Calo',	'https://www.dominos.fr/ManagedAssets/FR/product/BOCO.png',	6),
(7,	6,	'eau',	'eau',	'https://www.dominos.fr/ManagedAssets/FR/product/BOEA.png',	6),
(8,	7,	'salade verte',	'salade verte',	'https://www.dominos.fr/ManagedAssets/FR/product/SASA.png',	7),
(9,	8,	'salade tomate',	'salade tomate',	'https://www.dominos.fr/ManagedAssets/FR/product/SATO.png',	7),
(10,	9,	'tiramisu',	'tiramisu',	'https://www.dominos.fr/ManagedAssets/FR/product/DETI.png',	8),
(11,	10,	'panna cotta',	'panna cotta',	'https://www.dominos.fr/ManagedAssets/FR/product/DEPA.png',	8);

INSERT INTO "taille" ("id", "libelle") VALUES
(3,	'normale'),
(4,	'grande');

INSERT INTO "tarif" ("produit_id", "taille_id", "tarif") VALUES
(2,	3,	8.99),
(2,	4,	11.99),
(3,	3,	9.99),
(3,	4,	12.99),
(4,	3,	10.99),
(4,	4,	13.99),
(5,	3,	9.99),
(5,	4,	12.99),
(6,	3,	2.99),
(6,	4,	3.99),
(7,	3,	1.99),
(7,	4,	2.99),
(8,	3,	3.99),
(8,	4,	4.99),
(9,	3,	4.99),
(9,	4,	5.99),
(10,	3,	3.99),
(10,	4,	4.99),
(11,	3,	4.99),
(11,	4,	5.99);

-- 2023-09-01 09:53:07.591384+00
