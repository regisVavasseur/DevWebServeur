import {modificationEtatCommande} from "../domain/service/commandes.js";

class PatchCommandesEtatAction {
    async exec (id, etat) {
        try {
            const commande = await modificationEtatCommande(id, etat);
            return commande;
        } catch (err) {
            console.log(err);
        }
    }
}

export default PatchCommandesEtatAction;