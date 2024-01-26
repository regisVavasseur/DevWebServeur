const express = require('express');
const { WebSocketServer } = require('ws');

const PORT = 3000;
const server = express()
    .use((req, res) => res.send('Express server with WebSocket'))
    .listen(PORT, () => console.log(`Server listening on http://localhost:${PORT}`));

const wss = new WebSocketServer({ server });

// Stocker les clients WebSocket en fonction de l'ID de commande
const clients = {};

wss.on('connection', (ws) => {
    console.log('Client connected');

    ws.on('message', (data) => {
        const message = data.toString();
        console.log(`Message received: ${message}`);

        // Supposons que le client envoie l'ID de commande pour s'abonner aux mises à jour
        // avec un message comme "subscribe:<orderID>"
        const [action, orderId] = message.split(':');

        if (action === 'subscribe' && orderId) {
            // Associer ce socket au orderId
            if (!clients[orderId]) {
                clients[orderId] = [];
            }
            clients[orderId].push(ws);

            ws.send(`Subscribed to updates for order ${orderId}`);
        } else {
            console.error('Unknown action');
        }
    });

    ws.on('close', () => {
        console.log('Client disconnected');
    });
});

// Fonction pour simuler la mise à jour d'une commande et notifier le client
function simulateOrderUpdate(orderId, status) {
    if (clients[orderId]) {
        clients[orderId].forEach(client => {
            client.send(`Order ${orderId} status: ${status}`);
        });
    }
}

// Simulation d'une mise à jour de commande
setTimeout(() => { simulateOrderUpdate('123', 'Preparing') }, 60*1000);
setTimeout(() => { simulateOrderUpdate('123', 'Ready for pickup') }, 120*1000);