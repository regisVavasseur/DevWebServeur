import mysqlKnex from "../../../config/knex.js";
import MessagePublisher from './MessagePublisher.js';

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
async function createOrder(orderDataJson) {
    const newOrder = {
        id: orderDataJson.commande.id,
        delai: orderDataJson.commande.delai,
        date_commande: orderDataJson.commande.date,
        type_livraison: orderDataJson.commande.type_livraison,
        etape: 1,
        montant_total: orderDataJson.commande.montant,
        mail_client: orderDataJson.commande.mail_client
    };

    await mysqlKnex('commande').insert(newOrder);

    for (const item of orderDataJson.commande.items) {
        const newItem = {
            numero: item.numero,
            libelle: item.libelle,
            taille: item.taille,
            libelle_taille: item.libelle_taille,
            tarif: item.tarif,
            quantite: item.quantite,
            commande_id: newOrder.id
        };

        await mysqlKnex('item').insert(newItem);
    }

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

    // Créez une instance de MessagePublisher
    const messagePublisher = new MessagePublisher();
    messagePublisher.publish(
        id,
        (etat === 1 ? "REÇUE" : (etat === 2 ? "EN PRÉPARATION" : "PRÊTE") )
    );

    return commande;
}

export { getCommandeById, getAllCommandes, modificationEtatCommande, createOrder };