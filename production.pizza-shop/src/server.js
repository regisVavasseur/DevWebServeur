//importation de l'application depuis le fichier de configuration des routes
import app from "./config/routes.js";
import mysql from 'mysql';

const connection = mysql.createConnection({
    host: 'pizza-shop.production.db',
    user: 'production',
    password: 'production',
    database: 'production',
    port : 3306
});

connection.connect((err) => {
    if (err) {
        console.error('Erreur de connexion à la base de données:', err);
    } else {
        console.log('Connecté à la base de données MySQL!');
        // Tu peux effectuer des opérations sur la base de données ici
    }
});

// Définition du port sur lequel le serveur écoutera
const port = process.env.port || 3000;

//lancement du serveur et écoute sur le port défini
app.listen(port, () => {
    console.log('Le serveur est en écoute sur le port ' + port);
})
connection.end();