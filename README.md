# Maison des ligues

![Maison des ligues](https://i.imgur.com/Toba9cv.png)

Projet Personnel Encadré de deuxième année de BTS SIO

## Installation
### Prérequis 
- Connection à la DB Oracle de la FFE
### Installation local (exemple: WAMPS):
1. Ajouter le sous-module api avec `git submodule init && git submodule update`
2. Configurer wamps afin de diriger le le virtual host suivant : 
```
<VirtualHost *:80>
    ServerName apil2l #Modifiable
    
    Alias /api   "d:/PHP/AP2-M2L/public/api/public" # A modifier
    Alias / "d:/PHP/AP2-M2L/public/" # A modifier

    <Directory "d:/PHP/AP2-M2L/public/"> # A modifier
        Options +Indexes +Includes +FollowSymLinks +MultiViews
        AllowOverride All
        Require local
    </Directory>

    <Directory "d:/PHP/AP2-M2L/public/api/public/"> # A modifier
        Options +Indexes +Includes +FollowSymLinks +MultiViews
        AllowOverride All
        Require local
    </Directory>
</VirtualHost>
```
3. Exécuter le fichier `/bin/seed/createDatabase.sql`.
4. Suivre "Installer les composants"
5. Exécuter `php bin/console doctrine:migrations:migrate` à la racine du projet
6. Exécuter le fichier `/bin/seed/seed.sql`.

### Installation sur serveur Linux
1. Exécuter le script `restore-MDL.sh` en tant que simple utilisateur avec des droits de sudo sur le serveur.
2. Configurer le host du serveur en ajoutant : `127.0.0.1   mdl.ap.prod`

### Installer les composants:
Executez la commande ``composer install --no-dev`` (no-dev ne sert que pour une prod) dans l'invite de commande à la racine du dossier

Changer les identifiants de base de données: Dans le fichier ``config/config.php`` changer les valeurs des variables de la classe

## Documentation

Documentation ouvrable dans le fichier `/docs/index.html`

Date de la dernière génération de documentation : 11/04/2024

Lancer la mise à jour/regénération de la documentation avec la commande suivante (à la racine du projet) : 
``php phpDocumentor.phar``

# Tester la prod
Note: Avoir accées au serveur 10.10.2.143
1. Configurer son fichier host et ajouter : `10.10.2.143 mdl.ap.prod`
2. se connecter à http://mdl.ap.prod

## Composants
* [Bundle Symfony 5.4](https://symfony.com) - Framework PHP

## Auteurs

* [Bruel Lucas](https://github.com/Lurius-Kitsune)
* [Matis Dembele](https://github.com/MatisDembele)