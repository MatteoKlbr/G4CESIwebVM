# G4CESIwebVM

Code Organisé pour faciliter le déploiement sur la VM


Voici la version la plus avancée et déployée sur notre VM Azure !

Avec Apache comme hébergeur.

La version PHP est 8.3.

Nous avons utilisé MySQL & PHPMyAdmin pour ce qui est de la gestion de la BDD.


L'adresse de la VM est http://168.63.6.6/public/Accueil.php
ainsi que web4allg4.westeurope.cloudapp.azure.com/public/Accueil.php

(Nous avions utilisé une VM de secours avec une ancienne version et une ancienne configuration à l'adresse http://4.212.244.12/public/Accueil)

Nous avons mis en place le modèle MVC ainsi que respecté la majeure partie des contraintes.

Nous avons utilisé Bootstrap pour certaines parties du frontend.

Nous avons, par exemple, notre footer et notre header qui sont partagés dans les fichiers qui le demandaient.

Après plusieurs recherches pour https, il nous fallait un réel nom de domaine acheté ou implémenter un bot, choix que nous n'avons pas fait pour des questions de sécurité.

Voici les MDPs : pour les comptes existants :
mahamadou.bomou@gmail.com
Fatoumata1?
----------------------------------------------
matteo.kleber@gmail.com
matteo123
------------------------------------------------
hedi.rihani@gmail.com
hedi123
---------------------------------------------------
maximilien.junico@gmail.com
max123

Ils n'ont pas tous les mêmes rôles.

Par exemple, si on va sur la page Accueil.php et qu'on se connecte sur un compte admin (celui de Mahamadou),
Une redirection aura lieu vers un admin_panel, permettant alors de différencier les admins des autres rôles.

Le compte phpMyAdmin est hedi-rihani G4@CESIweb http://168.63.6.6/phpmyadmin/index.php?route=/

Idem pour le rôle pilote, il sera redirigé vers un panel avec plus de restrictions.

/public/Accueil.php permet la connexion en tant qu'étudiant & user lambda non connecté.

/admin_panel.php permet la redirection d'un admin après la connection

En vous souhaitant une bonne découverte du projet de notre côté !

Signé Groupe G4 CESI 2025 aka WEB4ALLG4 aka StageElevate .

MK

