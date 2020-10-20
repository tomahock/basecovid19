<?php

namespace Lib;

require_once '/var/www/html/vendor/autoload.php';

use MongoDB\Client;
use Lib\TwitterTools;

class EntidadeStore
{
    static $connection;

    static $db = 'covid19';

    static private function connect()
    {
        if (!self::$connection) {
            self::$connection = new Client('mongodb://root:MongoDB2019!@mongo:27017');
            self::$connection = self::$connection->{self::$db};
        }

        return self::$connection;
    }


    static public function save($data)
    {
        $collection = self::connect()->entidades;
        $data->created = new \MongoDB\BSON\UTCDateTime();
        $data->updated = new \MongoDB\BSON\UTCDateTime();

        $return = $collection->insertOne($data);

        return $return;
    }

    static public function updateOrSaveById($id, $data)
    {
        $collection = self::connect()->entidades;

        $query = array(
            'id' => $id
        );

        $exists = $collection->findOne($query);

        if ($exists) {
            echo 'updating: ' . json_encode($data) . PHP_EOL;
            $data->updated = new \MongoDB\BSON\UTCDateTime();
            self::updateById($id, $data);
        } else {
            echo 'creating new: ' . json_encode($data) . PHP_EOL;
            self::save($data);
            self::sendTweet($data);
        }
    }

    static public function sendTweet($data)
    {
        $text = "ℹ Novo Contrato ℹ\r\n\r\n 🏛️ Adjudicante: {$data->contracting[0]->description}\r\n ✒️Adjudicatário: {$data->contracted[0]->description}\r\n \r\n 💸 Valor: {$data->initialContractualPrice}\r\n \r\n 📅 Data: {$data->signingDate}\r\n\r\n 📜 Descrição: {$data->objectBriefDescription} \r\n\r\n 🏷️ Tipo: {$data->contractingProcedureType}\r\n\r\n 🔗 http://www.base.gov.pt/Base/pt/Pesquisa/Contrato?a={$data->id}";

        //TwitterTools::tweet($text);
    }

    static public function saveLastId($id)
    {
        $data = array(
            'id' => $id,
            'created' => new \MongoDB\BSON\UTCDateTime()
        );

        /** @var $collection \MongoCollection */
        $collection = self::connect()->lastEntidadeId;

        $return = $collection->insertOne($data);

        return $return;
    }

    static public function updateById($id, $data)
    {
        $collection = self::connect()->entidades;

        $query = array(
            'id' => $id
        );

        $data = array(
            '$set' => $data
        );

        $collection->updateOne($query, $data);

        return $collection->findOne($query);
    }

    static public function getItemById($id)
    {
        $collection = self::connect()->entidades;

        $query = array(
            'id' => $id
        );

        return $collection->findOne($query);
    }

    static public function getItemByNIF($nif)
    {
        $collection = self::connect()->entidades;

        $query = array(
            'nif' => $nif
        );

        return $collection->findOne($query);
    }

    static public function getLastId()
    {
        $collection = self::connect()->lastEntidadeId;

        $options = array(
            'sort' => array(
                'id' => -1
            ),
            'limit' => 1
        );
        $result = $collection->find([], $options);
        foreach ($result as $r) {
            return $r['id'];
        }
    }

    static public function getLast10()
    {
        $collection = self::connect()->entidades;

        $options = array(
            'sort' => array(
                'id' => -1
            ),
            'limit' => 9
        );

        return $collection->find([], $options);
    }

    static public function getContractingContractsCount($nif)
    {
        $collection = self::connect()->entidades;

        $query = array(
            'contracting.nif' => (string)$nif
        );

        return $collection->count($query);
    }

    static public function getContractingContractsTotalPrice($nif)
    {
        $collection = self::connect()->entidades;

        $pipeline = array(
            array(
                '$match' => array(
                    'contracting.nif' => (string)$nif
                ),
            ),
            array(
                '$group' => array(
                    '_id' => '$contracting.nif',
                    'total' => array(
                        '$sum' => '$price'
                    )
                )
            )
        );

        $result = $collection->aggregate($pipeline)->toArray()[0];
        return $result['total'];
    }
}
