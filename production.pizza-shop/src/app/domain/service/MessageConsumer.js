import amqp from 'amqplib';
import { createOrder } from './commandes.js';

class MessageConsumer {
    consume() {
        console.log(" [x] Consumer started");
        amqp.connect('amqp://admin:admin@rabbitmq').then( (connection) => {
            console.log(" [x] Consumer connected");
            return connection.createChannel();
        }).then((channel) => {
            const queue = 'nouvelles_commandes';

            channel.assertQueue(queue, {
                durable: true
            });

            console.log(" [*] Waiting for messages in %s. To exit press CTRL+C", queue);

            channel.consume(queue, (msg) => {
                console.log(" [x] Received %s", msg.content.toString());
                const orderData = JSON.parse(msg.content.toString());
                createOrder(orderData).then(
                    () => {
                        console.log(" [x] Order created");
                    }
                );
            }, {
                noAck: true
            });
        }).catch((error) => {
            console.error(" [x] An error occurred: ", error);
        });
    }
}

export { MessageConsumer };