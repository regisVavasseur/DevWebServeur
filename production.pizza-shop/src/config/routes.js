import helmet from "helmet";
import express from "express";
import GetAllCommandesAction from "../app/actions/getAllCommandesAction.js";
import PatchCommandesEtatAction from "../app/actions/PatchCommandesEtatAction.js";
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
                next(404)
            }
        });

    app.route(('/commandes'))
        .get(async (req, res, next) => {
            try {
                const commandeAction = new GetAllCommandesAction();
                res.type('application/json')
                    .status(200)
                    .send(await commandeAction.execute());
            } catch (err) {
                next(404)
            }
        })

    app.route('/commandes/:id/:etat')
        .patch(async (req, res, next) => {
            try {
                const commandeAction = new PatchCommandesEtatAction();
                const commande = await commandeAction.exec(req.params.id, req.params.etat);
                res.send(commande);
            } catch (err) {
                next(404)
            }
        })

    //catch 404 error
    app.use((req, res) => { res.sendStatus(404); }) ;

    //catch all other errors
    app.use((err, req, res, next) => {
        res.status(err).json({ error: err });
    });
}