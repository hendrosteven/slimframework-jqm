<?php

//header("Access-Control-Allow-Origin: *");
require_once './libs/Slim/Slim.php';
require_once './libs/db.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->response->headers->set('Access-Control-Allow-Origin', '*');
$app->response->headers->set('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
$app->response->headers->set('Access-Control-Allow-Headers', 'X-CSRF-Token,X-Requested-With,Accept,Accept-Version,Content-Length,Content-MD5, Content-Type, Date,X-Api-Version');
$app->response->headers->set('Content-Type', 'application/json');

$app->get("/hotels/get/:id", function($id) {    
    $sql = "SELECT id,nama,alamat,telp,email,img FROM tbl_hotel WHERE id=:id";
    try {
        $db = getConn();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $hotel = $stmt->fetchObject();
        $db = null;
        echo '{"item":' . json_encode($hotel) . '}';
    } catch (Exception $ex) {
        echo '"error":{"text":"' . $ex->getMessage() . '"}}';
    }
});

$app->get("/hotels/delete", function() {
    
});

$app->post("/hotels/update", function() {
    
});

$app->get('/hotels', function() {
    $sql = "SELECT id,nama,alamat,telp,email,img FROM tbl_hotel";
    try {
        $db = getConn();
        $stmt = $db->query($sql);
        $hotels = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"items":' . json_encode($hotels) . '}';
    } catch (Exception $ex) {
        echo '"error":{"text":"' . $ex->getMessage() . '"}}';
    }
});

$app->post('/hotels/insert', function() {
    $sql = "INSERT INTO tbl_hotel(nama,alamat,telp,email) "
            . "VALUES(:nama,:alamat,:telp,:email)";
    $app = \Slim\Slim::getInstance();
    $data = array(
        'nama' => $app->request->post('nama'),
        'alamat' => $app->request->post('alamat'),
        'telp' => $app->request->post('telp'),
        'email' => $app->request->post('email')
    );
    try {
        $db = getConn();
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        $affected_rows = $stmt->rowCount();
        echo '{"inserted":' . $affected_rows . '}';
    } catch (Exception $ex) {
        echo '"error":{"text":"' . $ex->getMessage() . '"}}';
    }
});

$app->run();



