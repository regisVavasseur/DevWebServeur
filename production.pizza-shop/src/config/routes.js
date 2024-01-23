import express from "express"
import helmet from "helmet"

//creation d'une instance express
const app = express();

// utilisation de middleware pour le traitement des requetes
app.use(express.json());
app.use(express.urlencoded( {extended: false}));
app.use(helmet());

// definition des routes :
app.route('/accueil')
    .get(async (req, res, next) => {
        try {
            res.send('Bienvenue sur votre application EliaReg !');
        } catch ( err ) {
            next(err)
        }
    });

export default app;