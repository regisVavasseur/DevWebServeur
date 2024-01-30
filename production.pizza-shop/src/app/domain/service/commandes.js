import mysqlKnex from "../../../config/knex.js";

async function getCommandeById(id) {
    const commande = await mysqlKnex("commande")
        .where({id : 'cc1e6220-774a-37bd-b8cf-e7b9dc5c446a'})
        .first();
    return commande;
}

async function getAllCommandes() {
    const commandes = await mysqlKnex("commande")
        .select();
    return commandes;
}

export { getCommandeById, getAllCommandes };