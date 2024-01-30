const express = require('express');
const { WebSocketServer } = require('ws');
const amqp = require('amqplib');

const PORT = 3000;
const AMQP_URL = 'amqp://admin:admin@rabbitmq';
const QUEUE_NAME = 'suivi_commandes';

const server = express()
    .use(
        (req, res) =>
        res.send('Express server with WebSocket and RabbitMQ')
    )
    .listen(PORT, () => console.log(`Server listening on http://localhost:${PORT}`));

const wss = new WebSocketServer({ server });
const clients = {};

wss.on('connection', (ws) => {
    console.log('Client connected');

    ws.on('message', (data) => {
        const message = data.toString();
        const [action, orderId] = message.split(':');
        if (action === 'subscribe' && orderId) {
            if (!clients[orderId]) {
                clients[orderId] = [];
            }
            clients[orderId].push(ws);
            ws.send(`Subscribed to updates for order ${orderId}`);
        }
    });
});

async function connectToRabbitMQ() {
    try {
        const conn = await amqp.connect(AMQP_URL);
        console.log('Connected to RabbitMQ');

        const channel = await conn.createChannel();
        await channel.assertQueue(QUEUE_NAME, { durable: false });
        console.log(`Waiting for messages in ${QUEUE_NAME}. To exit press CTRL+C`);

        channel.consume(QUEUE_NAME, (msg) => {
            if (msg !== null) {
                console.log(`Received message: ${msg.content.toString()}`);
                const { orderId, status } = JSON.parse(msg.content.toString());

                if (clients[orderId]) {
                    clients[orderId].forEach(client => {
                        client.send(`Order ${orderId} status: ${status}`);
                    });
                }

                channel.ack(msg);
            }
        });
    } catch(error) {
        console.error('Error connecting to RabbitMQ:', error);
    }
}

connectToRabbitMQ();