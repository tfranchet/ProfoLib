# ProfoLib

##Requiert
- php 7.2
- symfony

##Demarrage local
- git clone
- composer install
- Créer une table vide mysql
- Modifier la ligne ```DATABASE_URL="mysql://username:password@adresse:port/dbname"``` avec vos infos de db dans le .env
- php bin/console doctrine:migrations:migrate
- symfony server:start