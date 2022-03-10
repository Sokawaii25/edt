# Rendu
dumpBD.sql
edt

# Schema relationnel UML
Avis(note, commentaire, emailEtuduiant) 0..* <-> 1 Prof(nom, prenom, email) 1..* <-> 0..* Matiere(titre, reference) 1 <-> 0..* Cours(dateHeureDebut, dateHeureFin, type) 0..* <-> 1 Salle(numero)
Prof 1 <-> 0..* Cours
Avis 0..* <-> 1 Cours

# Prérequis
Posséder une version de PHP >= 8.1.3 et un serveur Postgres
Activer les modules intl, postgres et pdo-postgres dans PHP (php.ini)
Déployer la base de données Postgres à partir du fichier fourni et adapter les paramètres de connexion dans le fichier .env (ligne 27)


# Fonctionnalités

## Application
- http://127.0.0.1:8000/ ou http://127.0.0.1:8000/edt.html
- http://127.0.0.1:8000/notetonprofhtml
- http://127.0.0.1:8000/admin (après s'être connecté)
- http://127.0.0.1:8000/api + les endpoints ci-dessus

## Front-end

- Changement du jour séléctioné par clics sur les boutons 'Jour précédent' et 'Jour suivant'
- Affichage des cours de la journée séléctionée dans l'ordre chronologique.
- Les cours en train de se déroulés sont entourés de rouge.
- Un clic sur un cours permet d'acceder à l'interface d'avis de Cours et de Professeur
- Il est possible de voir, créer et supprimer des avis via la modale.

## Authentification
- Authentification via email et mot de passe avec la méthode Form Login de Symfony

## Admin
- CRUD Professeur
- CRUD Matiere
- CRUD Avis
- CRUD Cours
- CRUD Salle
- CRUD User

## API
### Endpoints
| Méthode  | Endpoint                  | Description                        | Paramètres 
|----------|---------------------------|------------------------------------|------------
**Professeurs**
| `GET`    | /api/professeurs          | Retourne la liste des professeurs  |
| `GET`    | /api/professeurs/:id      | Retourne un professeur en          |
|          |                           | fonction de son id                 |
| `GET`    | /api/professeurs/:id/avis | Récupère les avis d'un professeur  | 
| `POST`   | /api/professeurs/:id/avis | Ajoute un avis au professeur       | note: string, commentaire: text, emailEtudiant: email
 
**Matieres** 

**Avis** 
| `GET`    | /api/avis                 | Retourne la liste des avis         |
| `PATCH`  | /api/avis/:id             | Modifie un avis                    | note: string, commentaire: text, emailEtudiant: email
| `DELETE` | /api/avis/:id             | Supprime un avis                   |

**Cours**
| `GET`    | /api/cours                | Retourne la liste des cours        |
| `GET`    | /api/cours/:id            | Retourne un cours en fonction de   |
                                       | son id                             |
| `GET`    | /api/cours/date/:date     | Retourne les cours d'un jour donné | date: yyyy-mm-jj
| `GET`    | /api/cours/:id/avis       | Retourne les avis d'un cours donné |

**Salles**
| `GET`    | /api/salles               | Retourne la liste des salles       |

## Validation
Professeur :
- email : email valide et unique

- note : assert valeur entre 0 et 5
- emailEtudiant : email valide
- couple emailEtudiant/professeur unique
Cours :
- dateHeureDebut : assert DateTime non vide, supérieure à 8h00 et à l'heure actuelle, inférieure à la dateHeureFin
- dateHeureFin : assert DateTime non vide, supérieure à la dateHeureDebut, comprise dans la même journée et inférrieure à 19h00
- Assert sur l'entitée: Salle disponible dans l'intervalle de temps  ]dateHeureDebut; dateHeureFin[
- Assert sur l'entitée: Professeur n'as pas un autre cours dans l'intervalle de temps  ]dateHeureDebut; dateHeureFin[

Salle :
- numero : supérieur à 0 et unique


# Fonctionnalités qui n'ont pas abouti
- Interface avec toutes les heures de la journée et les cours placés en fonction de leur horaire


étapes d'in,stallation :
- avoir docker
- faire docker compose up -d dans edt pour lancer la base de données
- y restorer le dump (et check l'accs à la base au passage)
- lancer le serveur