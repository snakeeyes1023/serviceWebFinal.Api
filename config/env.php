<?php 

// Constante du mode de l'application
// dev : variables utilisées en local
// prod : pour le déploiement de l'api en production
define("MODE", "dev");

switch (MODE) {
    case "dev":
        // Configuration BD en local
        $_ENV['host'] = 'localhost';
        $_ENV['username'] = 'root';
        $_ENV['database'] = 'recipefinal';
        $_ENV['password'] = 'mysql';
        break;

    case "prod":
        // Configuration BD pour Heroku
        $_ENV['host'] = '70.32.23.53';
        $_ENV['username'] = 'jonath37_recipe';
        $_ENV['database'] = 'jonath37_recipe';
        $_ENV['password'] = '_LD~8kZ+h3{c';
        break;
};