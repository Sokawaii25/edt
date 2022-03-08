# Rendu
dumpBD.sql
api
front

# Schema relationnel UML
Avis(note, commentaire, emailEtuduiant) 0..* <-> 1 Prof(nom, prenom, email) 1..* <-> 0..* Matiere(titre, reference) 1 <-> 0..* Cours(dateHeureDebut, dateHeureFin, type) 0..* <-> 1 Salle(numero)
Prof 1 <-> 0..* Cours

# Prérequis
Activer le module intl dans PHP (php.ini)
Déployer la base de données Postgres à partir du fichier fourni et adapter les paramètres de connexion dans le .env (tout en bas, l'url de connexion)

# Fonctionnalités

## Admin
- CRUD Professeur
- CRUD Matiere
- CRUD Avis
- CRUD Cours
- CRUD Salle

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

**Salles**
| `GET`    | /api/salles               | Retourne la liste des salles       |

## Validation
Professeur :
- Nom : string
- Prenom : string
- Email : email

- Pas de cours en même temps dans la même salle
- Pas de cours en même temps avec le même prof

# Fonctionnalités qui n'ont pas abouti