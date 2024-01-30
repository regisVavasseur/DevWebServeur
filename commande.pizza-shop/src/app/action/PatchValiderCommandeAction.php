<?php

namespace pizzashop\shop\app\action;

use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use pizzashop\shop\domain\service\commande\iCommander;
use pizzashop\shop\domain\service\commande\ServiceCommandeInvalidException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class PatchValiderCommandeAction
{
    private iCommander $commander;

    public function __construct(iCommander $commander)
    {
        $this->commander = $commander;
    }

    /**
     * @throws Exception
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {

        //récupération du mail de l'utilisateur connecté via le middleware CheckJWT
        // issu du token JWT présenté par le client dans le header Authorization de la requête.
        $email = $request->getAttribute('email');

        $id = $args['id_commande'] ?? 0;

        $dataJson = [];

        $logger = new Logger('app.logger');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/errors.log', Level::Error));

        try {
            $service = $this->commander;
            $service->validerCommande($id, $email);
        } catch (ServiceCommandeInvalidException $e) {
            if ($e->getCode() == 400) {
                throw new HttpBadRequestException($request, $e->getMessage());
            }
            if ($e->getCode() == 404) {
                throw new HttpNotFoundException($request, $e->getMessage());
            }
        }
        $dataJson['type'] = 'commande';
        $dataJson['status'] = 'success';
        $dataJson['commande'] = $service->accederCommande($id, $email);

        try {
            $connection = new AMQPStreamConnection('rabbitmq', 5672, 'admin', 'admin');
        } catch (Exception $e) {
            die($e->getMessage());
        }

        $channel = $connection->channel();

        $exchangeName = 'pizzashop';
        $queueName = 'nouvelles_commandes';
        $keyQueue = 'nouvelle';

        $channel->exchange_declare($exchangeName, 'direct', false, false, false);
        $channel->queue_declare($queueName, false, true, false, false, ['x-queue-type' => ['S', 'classic']]);
        $channel->queue_bind($queueName, $exchangeName, $keyQueue);

        $channel->basic_publish(new AMQPMessage(json_encode($dataJson)), 'pizzashop', $keyQueue);

//        $msg = $channel->basic_get($queueName);

//        if ($msg) {
//            $decodeMessage = json_decode($msg->body, true);
//            $channel->basic_ack($msg->getDeliveryTag());
//        } else {
//            echo "Aucun message dans la file\n";
//            exit(0);<
//        }

        $channel->close();
        $connection->close();

        $response->getBody()->write(json_encode($dataJson));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

    }
}