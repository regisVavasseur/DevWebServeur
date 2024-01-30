import knex from "knex";

const mysqlKnex = knex({
    client : "mysql",
    pool : {
        min: 2,
        max: 10
    },
    connection: {
        host : 'pizza-shop.production.db',
        user : 'production',
        password : 'production',
        database : 'production'
    }
});
export default mysqlKnex;