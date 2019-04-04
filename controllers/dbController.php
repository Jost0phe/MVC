<?php

class dbController extends configController{
    private $bddserver = '127.0.0.1';
    private $bddname = '';
    private $bdduser = 'root';
    private $bddpassword = '';
    private $bdddriver = '';
    private $bddlink;
    
    function __construct(){
        parent::__construct();
        $config = parent::getConfigParameter('dbConfig');
        
        foreach($config as $key=>$value){
            $method = 'set'.ucfirst($key);
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
        
        $dsn = $this->bdddriver.':dbname='.$this->bddname.';host='.$this->bddserver;
        try {
            $this->bddlink = new PDO($dsn , $this->bdduser, $this->bddpassword);
            $this->bddlink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Failed:' . $e->getMessage();
        }
    }
    
    function getBddserver() {
        return $this->bddserver;
    }

    function getBddname() {
        return $this->bddname;
    }

    function getBdduser() {
        return $this->bdduser;
    }

    function getBddpassword() {
        return $this->bddpassword;
    }
    function getBdddriver() {
        return $this->bdddriver;
    }

    function setBdddriver($bdddriver) {
        $this->bdddriver = $bdddriver;
    }

        function setBddserver($bddserver) {
        $this->bddserver = $bddserver;
    }

    function setBddname($bddname) {
        $this->bddname = $bddname;
    }

    function setBdduser($bdduser) {
        $this->bdduser = $bdduser;
    }

    function setBddpassword($bddpassword) {
        $this->bddpassword = $bddpassword;
    }
    function getBddlink() {
        return $this->bddlink;
    }

    function setBddlink($bddlink) {
        $this->bddlink = $bddlink;
    }

    function findOneBy(object $objet, array $options=array()){
        try{
            $table = get_class($objet);
            $champs = '*';
            if(isset($options['champs']) && !empty($options['champs'])){
                $champs = implode (',', $options['champs']);
            }
            
            if(!isset($options['criteria'])){
                throw new Exception(__METHOD__.' '.__LINE__.':criteria doit être définit');
            }
            
            $query = 'SELECT '.$champs.' FROM '.$table.' WHERE ';
            $nbCriteria = count(array_keys($options['criteria']));
            $keys = array_keys($options['criteria']);
            
            for($i=0; $i< $nbCriteria; $i++){
                if($i > 0){
                    $query .= ' AND ';
                }
            $query .= $keys[$i].' = :'.$keys[$i];
            }
            $query .= ' LIMIT 1';
            
            $req = $this->bddlink->prepare($query);
            $req->execute($options['criteria']);
            $result = $req->fetch(PDO::FETCH_ASSOC);
            return $result;                    
        }catch(Exception $ex){
            echo $ex->getMessage();
            return array();
        }
    }
    
    function findOneById(object $objet, $id){
        return $this->findOneBy($objet,
                array(
            'criteria' => array('id'=>$id)
            ));
    }
    
    function newRecord(object $object, array $datas = array()){
        try{
            if(empty($datas)){
                throw new Exception(__METHOD__.''.__LINE__.': erreur');
            }
            $table = get_class($object);
            
            $rowColumns = '`'.implode('`,`', array_keys($datas)).'`';
            $rowValues = ':'.implode(',:', array_keys($datas));
            
            $reqNewRecord = 'INSERT INTO '.$table.' ('.$rowColumns.') VALUES ';
            $reqNewRecord .= '('.$rowValues.')';
            
            echo $reqNewRecord; die();
            
            $Enregistrement = $this->bddlink->prepare($reqNewRecord);
            $Enregistrement->execute($datas);
                    
            return array(true);
        } catch (Exception $ex) {
            echo $ex->getMessage(); 
            return array();
        }
     
    }
}
