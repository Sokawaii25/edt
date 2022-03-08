# Rendu
dumpBD.sql
edt

# Schema relationnel UML
Avis(note, commentaire, emailEtuduiant) 0..* <-> 1 Prof(nom, prenom, email) 1..* <-> 0..* Matiere(titre, reference) 1 <-> 0..* Cours(dateHeureDebut, dateHeureFin, type) 0..* <-> 1 Salle(numero)
Prof 1 <-> 0..* Cours

# Prérequis
Activer le module intl dans PHP (php.ini)
Déployer la base de données Postgres à partir du fichier fourni et adapter les paramètres de connexion dans le .env (tout en bas, l'url de connexion)

# Fonctionnalités

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

Avis :
- note : assert valeur entre 0 et 5
- emailEtudiant : email valide
- couple emailEtudiant/professeur unique

Cours :
- dateHeureDebut : assert DateTime non vide, supérieure à 8h00 et à l'heure actuelle, inférieure à la dateHeureFin
- dateHeureFin : assert DateTime non vide, supérieure à la dateHeureDebut, comprise dans la même journée et inférrieure à 19h00

Salle :
- numero : supérieur à 0 et unique

- Pas de cours en même temps dans la même salle
- Pas de cours en même temps avec le même prof

# Fonctionnalités qui n'ont pas abouti
- Interface avec toutes les heures de la journée et les cours placés en fonction de leur horaire