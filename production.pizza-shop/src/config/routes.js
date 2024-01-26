import helmet from "helmet";
import express from "express";
import GetAllCommandesAction from "../app/actions/getAllCommandesAction.js";
export default  (app) => {
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

    app.route(('/commandes'))
        .get(async (req, res, next) => {
            try {
                const commandeAction = new GetAllCommandesAction();
                res.send(commandeAction.execute());
            } catch (err) {
                next(err)
            }
        })
}