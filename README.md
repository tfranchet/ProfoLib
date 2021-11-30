# ProfoLib
- V1.0.0

## Requiert
- php 7.2
- symfony

## Demarrage local
- git clone
- composer install
- Créer un schema vide mysql
- Modifier la ligne ```DATABASE_URL="mysql://username:password@adresse:port/dbname"``` avec vos infos de db dans le .env
- php bin/console doctrine:migrations:migrate
- symfony server:start
- php bin/console app:setup

#### login de base
- Login : admin@test
- Password : admin

#### si le démarrage local ne fonctionne pas
- possibilité de déploiement
- contactez tanguy.franchet@etudiant.univ-rennes1.fr
## UML
#### 4 classes
- Etudiant
- Professeur
- Rdv
- User

#### User
- email : string
- password : string
- roles (auto-généré par symfony, non utilisé) : string[]
- profile : Etudiant (nullable)
- profId : Professeur (nullable)

#### Etudiant
- email : string
- name : string
- rdvs : Rdv[]
- user : User

#### Professeur
- email : string
- name : string
- rdvs : Rdv[]
- user : User

#### RDV
- heureDebut : date
- heureFin : date
- etudiant : Etudiant
- professeur : Professeur

#### Choixs effectués :
- Doublons Etudiant-Professeur pour facilité de distinction sur le backend
- Doublons sur les email pour prendre des rdv avec des personnes n'ayant pas de comptes

## FRONT
- Utilisation de Twig pour la communication entre front et back
- les URL sont disponibles via la bannière en fonction des droits du user
