import amqp from 'amqplib';

class MessagePublisher {
    publish(orderId, newState) {
        amqp.connect('amqp://admin:admin@rabbitmq').then((connection) => {
            return connection.createChannel();
        }).then((channel) => {
            const exchange = 'pizzashop';
            const routingKey = 'suivi';
            const queue = 'suivi_commandes';

            channel.assertQueue(queue, {
                durable: false
            });

            const msg = JSON.stringify({
                orderId: orderId,
                status: newState
            });

            channel.assertExchange(exchange, 'direct', {
                durable: false
            });
            channel.publish(exchange, routingKey, Buffer.from(msg));
            console.log(" [x] Sent %s", msg);
        }).catch((error) => {
            console.error(" [x] An error occurred: ", error);
        });
    }
}

export default MessagePublisher;