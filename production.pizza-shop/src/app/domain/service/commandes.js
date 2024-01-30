import mysqlKnex from "../../../config/knex.js";

async function getCommandeById(id) {
    const commande = await mysqlKnex("commande")
        .where({id : id})
        .first();
    return commande;
}

async function getAllCommandes() {
    const commandes = await mysqlKnex("commande")
        .select();
    return commandes;
}

async function modificationEtatCommande(id, etat){
    //recuperation de la commande
    let commande = await getCommandeById(id);
    const etatPrevious = commande.etape;
    etat = parseInt(etat);
    // verification avant de changer l'etat de la commande
    if (etat < 1 || etat > 3) {
        console.log("Il n'y a pas d'étape correspondante à l'état que vous demandez");
        throw new Error(400);
    }else if (etat === etatPrevious) {
        console.log("La commande est déjà à cet état");
        throw new Error(400);
    }
    else if (etat !== (etatPrevious +1) && (etat !== (etatPrevious - 1))) {
        console.log("Vous ne pouvez pas passer plus d'une étape à la fois, vous voulez passer de l'étape " + etatPrevious + " à l'étape " + etat);
        throw new Error(400);
    }

    //changement d'etat de la commande
    await mysqlKnex("commande")
            .where('id', id)
            .update({etape: etat});

    commande = await getCommandeById(id);
    return commande;
}

export { getCommandeById, getAllCommandes, modificationEtatCommande };