<?php
namespace Aac;

use Aac\Model\Board;
use Aac\Model\BoardRepositoryMemory;
use Aac\Model\BoardRepositorySession;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

use Slim\Slim;


class Sockets implements MessageComponentInterface
{
    protected $clients;

    protected $app;


    function __construct($config)
    {

        $this->clients = new \SplObjectStorage;

        $app = new Slim($config); //Ioc

        $this->configureApp($app);

        $this->app = $app;
    }

    public function onOpen(ConnectionInterface $conn)
    {

//we accept everyone. We should make sure there is one player1 and one player2 at least
        $this->clients->attach($conn);
        $this->sendMessage($conn, 'init', 'hello');


        echo "New connection! ({$conn->resourceId})\n";
        echo "New connection! ({$conn->remoteAddress})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "message received " . $msg . "\n";

        $msgData = json_decode($msg, true);
        $action = $msgData['action'];


        switch ($action) {
            case 'get_board':

                /** @var Board $board */
                $board = $this->app->Board;

                $this->sendMessage($from, $action, $board->getBoardData());

                break;

            case 'move':
                $id = $msgData['player']; //get from credentials instead
                $column = $msgData['column'];

                /** @var $board Board */
                $board = $this->app->Board;

                $disc_added = $board->putDisc($id, $column);

                if (!isset($disc_added['error'])) {
                    $result = array(
                        'player' => $disc_added['player'],
                        'column' => $disc_added['column'],
                        'row' => $disc_added['row'],
                        'success' => 'yes'
                    );

                    foreach ($this->clients as $client) {
                        // The sender is not the receiver, send to each client connected
                        $this->sendMessage($client, $action, $result);
//                            $client->send($msg);
                    }

                } else {
                    $this->sendError($from, $action, $disc_added['error']);
                }


                break;


        }


    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    protected function sendError(ConnectionInterface $conn, $action, $message)
    {
        $conn->send(json_encode(array('error' => $message, 'action' => $action, 'status' => 400)));
    }

    protected function sendMessage(ConnectionInterface $conn, $action, $message, $status = 200)
    {
        $conn->send(json_encode(array('data' => $message, 'action' => $action, 'status' => $status)));

    }


    protected function configureApp(Slim $app)
    {

        $app->container->singleton('BoardRepository', function ($c) {

            return new BoardRepositoryMemory();
        });

        $app->container->singleton('Board', function ($c) {

            $repository = $c['BoardRepository'];

            $board = new Board($repository);

            return $board;
        });

    }


}