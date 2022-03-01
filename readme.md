1. lancer docker

2. lancer la base :
docker compose up -d

3. lancer le serveur symfony :
symfony serve

diag_classes :
Avis(note, commentaire, emailEtuduiant) 0..* <-> 1 Prof(nom, prenom, email) 1..* <-> 0..* Matiere(titre, reference)