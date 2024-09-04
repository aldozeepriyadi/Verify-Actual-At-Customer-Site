<?php
require_once __DIR__ . '/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use React\EventLoop\StreamSelectLoop;
use React\Socket\SocketServer;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Evenement\EventEmitter;

class LocationUpdate implements MessageComponentInterface {
    protected $clients;
    protected $locations;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->locations = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        if (isset($data['driver_id']) && isset($data['latitude']) && isset($data['longitude'])) {
            include "../config.php";
            $sql = "UPDATE kyb_trsverifikasikedatangan SET kyb_lat = ?, kyb_longi = ? WHERE kyb_id_user = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssi", $data['latitude'], $data['longitude'], $data['driver_id']);
                $stmt->execute();
                $stmt->close();
            }

            // Simpan lokasi driver di memori untuk dibagikan ke klien yang terhubung
            $this->locations[$data['driver_id']] = [
                'kyb_lat' => $data['latitude'],
                'kyb_longi' => $data['longitude']
            ];

            // Broadcast lokasi terbaru ke semua klien
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    $client->send($msg);
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

$loop = new StreamSelectLoop();
$webSock = new SocketServer('0.0.0.0:80', $loop);
$webServer = new IoServer(new HttpServer(new WsServer(new LocationUpdate())), $webSock);

echo "WebSocket server started on ws://localhost:8080\n";

$loop->run();
