//importation de l'application depuis le fichier de configuration des routes
import express from "express"
import routeConfig from "../src/config/routes.js";

//creation d'une instance express
const app = express();

routeConfig(app);

// Définition du port sur lequel le serveur écoutera
const port = process.env.port || 3000;

//lancement du serveur et écoute sur le port défini

app.listen(port, () => {
    console.log('Le serveur est en écoute sur le port ' + port);
})
