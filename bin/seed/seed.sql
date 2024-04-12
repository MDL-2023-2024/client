SET FOREIGN_KEY_CHECKS=0;

TRUNCATE TABLE theme_atelier;
TRUNCATE TABLE vacation;
TRUNCATE TABLE proposer;
TRUNCATE TABLE nuite;
TRUNCATE TABLE inscription_restauration;
TRUNCATE TABLE restauration;
TRUNCATE TABLE inscription_atelier;
TRUNCATE TABLE inscription;
TRUNCATE TABLE hotel;
TRUNCATE TABLE compte;
TRUNCATE TABLE categorie_chambre;
TRUNCATE TABLE atelier;
TRUNCATE TABLE theme;

SET FOREIGN_KEY_CHECKS=1;

-- Insertion dans la table 'theme'
INSERT INTO theme (libelle) VALUES 
('Escrime Classique'), 
('Escrime Moderne'), 
('Techniques d\'Épée'), 
('Histoire de l\'Escrime');

-- Insertion dans la table 'atelier'
INSERT INTO atelier (libelle, nb_places_maxi) VALUES 
('Atelier Découverte', 20), 
('Atelier Avancé', 10), 
('Atelier Compétition', 15), 
('Atelier Histoire', 10);

INSERT INTO categorie_chambre (id, libelle_categorie) VALUES 
(1, 'Simple'), 
(2, 'Double');

-- Insertion dans la table 'hotel'
INSERT INTO hotel (pnom, adresse1, adresse2, cp, ville, tel, mail, website) VALUES 
('Ibis Styles Lille Centre Gare Beffroi', '172 rue Pierre Mauroy', null, '59000', 'Lille', '03 20 30 00 54', 'H1384@accor.com', 'https://all.accor.com/ssr/app/accor/rates/1384/index.fr.shtml?dateIn=2023-09-08&nights=2&compositions=1&stayplus=false&snu=false&accessibleRooms=false&destinati'),
('Ibis budget Lile Centre', '10 Rue de Courtrai', null, '59000', 'Lille', '08 92 68 30 78', 'H5208@accor.com', 'https://all.accor.com/ssr/app/ibis/rates/5208/index.fr.shtml?dateIn=2023-09-08&nights=2&compositions=1&stayplus=false&snu=false&accessibleRooms=false');

-- Insertion dans la table 'proposer'
INSERT INTO proposer (hotel_id, categorie_id, tarif_nuite) VALUES 
(2, 1, 70.0),
(2, 2, 80.0),
(1, 1, 95.0),
(1, 2, 105.0);

-- Insérer dans `atelier_theme`
INSERT INTO theme_atelier (atelier_id, theme_id) VALUES 
(1, 1), -- Lier 'Atelier Découverte' à 'Escrime Classique'
(1, 2), -- Lier 'Atelier Découverte' à 'Escrime Moderne'
(2, 1), -- Lier 'Atelier Avancé' à 'Escrime Classique'
(2, 2); -- Lier 'Atelier Avancé' à 'Escrime Moderne'

-- Insérer dans `restauration`
INSERT INTO restauration (date_restauration, type_repas) VALUES 
('2024-09-07 12:00:00', 'Déjeuner'),
('2024-09-07 19:00:00', 'Dîner'),
('2024-09-08 12:00:00', 'Déjeuner');

LOCK TABLES `compte` WRITE;
/*!40000 ALTER TABLE `compte` DISABLE KEYS */;
INSERT INTO `compte` VALUES (1,'lucasfox@outlook.fr','[\"ROLE_ADMIN\"]','$2y$13$E2DGrmfbFj4GDbu12pGlzuVxgbpgiIL5kjTPZOGQR.SR3uhH5nQiy','26098765188',1);
INSERT INTO `compte` VALUES (2,'dembelematis@gmail.com','[\"ROLE_ADMIN\"]','$2y$13$E2DGrmfbFj4GDbu12pGlzuVxgbpgiIL5kjTPZOGQR.SR3uhH5nQiy','22098765188',1);
/*!40000 ALTER TABLE `compte` ENABLE KEYS */;
-- mdp btssio2024
UNLOCK TABLES;