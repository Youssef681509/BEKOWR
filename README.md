<<<<<<< HEAD
### Support technique

 - Support version php-version 8.3.3 >=
 - Base de donnée MariaDB 10.11.7 >=
 - Symfony version 6.4 LTS

### Installation symfony

 - installe composer
[composer download ](https://getcomposer.org/Composer-Setup.exe)

`composer install`

 - Modifier le fichier .env en renseignant les informations de connexion à votre base de donnée
 ![image](https://drive.google.com/file/d/1wZg1P993v8sbgWmlZtfVyAcWNQHGCu27/view?usp=sharing)

 - Installation migration doctrine & création BD

`php bin/console doctrine:migrations:migrate`

 - Installation fixtures

`php bin/console doctrine:fixtures:load`

- Installation fichier asset

`php bin/console asset-map:compile`
=======
# BEKOWR
>>>>>>> 36607b829cfc78c409f944d0d83757bd072eb35c
