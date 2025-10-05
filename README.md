# Plogg - Système de Gestion des Facturations

## À propos du projet
Projet réalisé dans le cadre d'un stage de fin d'études de 2ème année en Licence Génie Logiciel.
- **Période** : Juin - Juillet 2023 (2 mois)
- **Entreprise** : Plogg Tunisie
- **Type** : Stage technique
- **Niveau** : 2ème année Licence en Génie Logiciel

## Objectifs du stage
- Développement d'une application web de gestion des facturations
- Automatisation du processus de facturation
- Gestion des ressources humaines et des taux horaires
- Génération de rapports et KPIs

## Description
Application web de gestion des facturations et du personnel développée avec PHP et MySQL. Permet l'importation de fichiers Excel, la gestion des taux horaires et l'exportation des factures.

## Fonctionnalités
- Import/Export de fichiers Excel
- Gestion des personnels et leurs taux horaires
- Génération automatique des factures
- Gestion des projets à exclure
- Calcul des KPIs
- Interface administrative complète

## Prérequis
- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur
- XAMPP
- Extensions PHP requises :
  - mysqli
  - PhpSpreadsheet

## Installation
1. Cloner le projet dans le dossier `htdocs` de XAMPP :
```bash
cd c:\xampp\htdocs
git clone [url-du-projet] tache
```

2. Importer la base de données :
```sql
CREATE DATABASE excel1;
USE excel1;
-- Importer le fichier SQL fourni
```

3. Configurer la connexion à la base de données :
- Host: localhost
- Username: root
- Password: (laisser vide)
- Database: excel1

## Installation avec Docker
### Prérequis
- Docker
- Docker Compose

### Configuration Docker
Le projet inclut une configuration Docker pour un environnement de développement cohérent :
```yaml
services:
  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: rootpassword
      MYSQL_DATABASE: excel1
      MYSQL_USER: user
      MYSQL_PASSWORD: password
    ports:
      - "3306:3306"

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    ports:
      - "8081:80"
    environment:
      PMA_HOST: db
```

### Démarrage avec Docker
1. Lancer l'environnement :
```bash
docker-compose up -d
```

2. Accès aux services :
   - Application : http://localhost
   - PhpMyAdmin : http://localhost:8081
   - MySQL : localhost:3306

3. Arrêter l'environnement :
```bash
docker-compose down
```

### Volumes et Persistance
- Les données MySQL sont persistées via un volume Docker
- Les fichiers uploadés sont stockés dans le dossier `uploads/`

## Technologies utilisées
- Backend : PHP 8.0
- Base de données : MySQL
- Frontend : HTML5, CSS3, JavaScript
- Framework CSS : AdminLTE
- Librairies : PhpSpreadsheet pour la manipulation Excel
- Environnement : XAMPP

## Réalisations principales
1. Développement du système complet de gestion des facturations
2. Mise en place de l'import/export des fichiers Excel
3. Création d'une interface utilisateur intuitive
4. Implémentation de la gestion des taux variables
5. Système de génération automatique des rapports

## Contact
- Stagiaire : [Votre nom]
- Encadrant : [Nom de l'encadrant]
- Email : support@plogg.com

## Remerciements
Sincères remerciements à l'équipe de Plogg Tunisie pour leur encadrement et leur support tout au long de ce stage.
