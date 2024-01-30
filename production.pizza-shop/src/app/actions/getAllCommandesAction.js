import {getAllCommandes} from "../domain/service/commandes.js";

class GetAllCommandesAction {
    async execute() {
        try {
            const commandes = await getAllCommandes();
            return commandes;
        } catch (error) {
            console.log(error.message);
            throw error;
        }
    }
}

export default GetAllCommandesAction;