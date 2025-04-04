# G4CESIwebVM
Code Organisé pour faciliter le déploiement sur la VM


Voici la version la plus avancée et déployée sur notre VM azure !

Avec Apache comme hébergeur.

La version PHP est 8.3 .

Nous avons utilisés MySQL & phpMyAdmin pour ce qui est de la gestion de la BDD.


L'adresse de la VM est http://168.63.6.6/public/Accueil.php
ainsi que web4allg4.westeurope.cloudapp.azure.com/public/Accueil.php

Nous avons mis en place le modèle MVC ainsi que respecté la majeure partie des contraintes.

Nous avons utilisé Bootstrap pour certaines partie du frontend.

Nous avons par exemple notre footer et notre header qui sont partagés dans les fichiers qui le demandaient.

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

Par exemple si on va sur la page Accueil.php et qu'on se connecte sur un compte admin (celui de mahamadou),
une redirection aura lieu vers un admin_panel, permettant alors de différencier les admins des autres rôles.

Idem pour le rôles pilotes il sera redirigé vers un panel avec plusde restriction.


/public/Accueil.php permet la connection en tant qu'étudiant & user lambda non connecté.

/admin_panel.php permet la redirection d'un admin après la connection
