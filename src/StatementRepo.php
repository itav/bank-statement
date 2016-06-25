<?php

namespace App\Finance\Bank;

use Silex\Application;
use Itav\Component\Serializer\Serializer;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;
use MongoDB\Driver\Manager;

class StatementRepo
{
    //todo report:[idUser]
    const IMPORT_CACHE_NAME = 'report';
    const COL = 'bank_statement';
    const DB = 'db';
    const DB_COL = 'db.bank_statement';
    /**
     *
     * @var \MongoDB\Driver\Manager 
     */
    private $mongo;
    /**
     *
     * @var \Redis
     */
    private $redis;
    /**
     *
     * @var Serializer
     */
    private $serializer;
    
    
    public function __construct(Application $app)
    {
        $this->mongo = $app['mongo'];
        $this->redis = $app['redis'];
        $this->serializer = $app['serializer'];
    }

    /**
     * @param int $id
     * @return Statement 
     */    
    public function find($id)
    {
        $st = new Statement();
        $filter = ['_id' => new \MongoDB\BSON\ObjectId($id)];
        $query = new \MongoDB\Driver\Query($filter, []);
        $counter = $this->mongo->executeQuery(self::DB_COL, $query);
        $docs = $counter->toArray();
        if(empty($docs)){
            return $st;
        }
        $doc = $docs[0];
        $oid = $doc->_id;
        $data = json_decode(json_encode($doc), true);
        $data['id'] = $oid->__toString();
        unset($data['_id']);
        $this->serializer->unserialize($data, Statement::class, $st);
        return $st;
    }
    
    /**
     * @param int $id
     * @return Statement[]
     */    
    public function findAll()
    {
        $sts = [];
        $query = new \MongoDB\Driver\Query([], []);
        $counter = $this->mongo->executeQuery(self::DB_COL, $query);        
        foreach ($counter as $doc){
            
            $oid = $doc->_id;
            $data = json_decode(json_encode($doc), true);
            $data['id'] = $oid->__toString();
            unset($data['_id']);
            
            $st = new Statement();
            $this->serializer->unserialize($data, Statement::class, $st);
            $sts[] = $st;
        }
        return $sts;
    }
    
    /**
     * @param StatementCriteria $criteria
     * @return Statement[]
     */        
    public function findByCriteria($criteria)
    {
        $stms = [];
        
        return $stms;
    } 
    
    /**
     * @param Statement $statement
     * @return bool 
     */
    public function save($statement)
    {
        $data = $this->serializer->normalize($statement);
        $update = false;
        if(isset($data['id']) && $data['id']){
            $update = true;
            $id = $data['id'];
            unset($data['id']);
            $data['_id']  = new \MongoDB\BSON\ObjectId($id);
        }
        $bulk = new BulkWrite(['ordered' => true]);
        $update ? $bulk->update(['_id' => new \MongoDB\BSON\ObjectId($id)], $data, ['multi' => 0, 'upsert' => 1]) : $bulk->insert($data);
        $result = $this->mongo->executeBulkWrite(self::DB_COL, $bulk);        

        return $result;
    }
    
    public function delete($id)
    {
        $bulk = new BulkWrite();
        $bulk->delete(['_id' => new \MongoDB\BSON\ObjectId($id)], ['limit' => 1]);
        $result = $this->mongo->executeBulkWrite(self::DB_COL, $bulk);        
        return $result;        
        
    }


    public function saveInCache($statement)
    {
        $ret = $this->redis->set(self::IMPORT_CACHE_NAME, json_encode($this->serializer->normalize($statement)));
        return (bool)$ret;
    }
    
    public function loadFromCache()
    {
        $statement = new Statement();
        $data = json_decode($this->redis->get(self::IMPORT_CACHE_NAME), true);
        if(JSON_ERROR_NONE !== json_last_error()){
            return $statement;
        }
        $this->redis->del(self::IMPORT_CACHE_NAME);
        $this->serializer->unserialize($data, Statement::class, $statement);
        return $statement;
    }
}