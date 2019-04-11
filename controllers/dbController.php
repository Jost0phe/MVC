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
            //$query .= ' LIMIT 1';
//            var_dump($query); die();
            $req = $this->bddlink->prepare($query);
            $req->execute($options['criteria']);
            $result = $req->fetch(PDO::FETCH_ASSOC);
            return $result;                    
        }catch(Exception $ex){
            echo $ex->getMessage();
            return array();
        }
    }
    
    
    function findObjectbyAuteur(object $objet, array $options=array()){
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
            //$query .= ' LIMIT 1';
            $req = $this->bddlink->prepare($query);
            $req->execute($options['criteria']);
            $result = $req->fetchAll(PDO::FETCH_CLASS, $table);
            return $result;                    
        }catch(Exception $ex){
            echo $ex->getMessage();
            return array();
        }
    }
    
    function hydrateRecord(object $object, array $datas){
        foreach ($datas as $key=>$value){
            $method = 'set'.ucfirst($key);
            if(method_exists($object, $method)){
                $object->$method($value);
            }
        }
    }
    
    function findObjectById(object $object, $id){
        $datas = $this->findOneById($object, $id);
        $this->hydrateRecord($object, $datas);
    }
    
    function findAll(object $object){
        try{ 
        $table=get_class($object); //récupère la classe de mon objet 
        if(!isset($object)){ 
            throw new Exception(__METHOD__.' '.__LINE__.': criteria doit être défini'); 
        }
        $query = 'SELECT * FROM '.$table; 
        $req = $this->bddlink->prepare($query); 
        $req -> execute();
        $result = $req->fetchAll(PDO::FETCH_CLASS, $table);
        return $result; 
        }
        
        catch (Exception $ex){ 
            echo $ex->getMessage(); 
            return array();   
        } 
    }
    
    public function updateRecord(object $object, array $datas=array()) {
    try{
        if(empty($datas)){
            throw new Exception(__METHOD__.' '.__LINE__.' : datas ne peut être vide');
        }
        $table = get_class($object);

        //Affectation des valeurs du formulaire à ma requête
        $reqUpdateRecord = 'UPDATE '.$table.' SET ';

        $keys = array_keys($datas);
        $nbKeys = count($keys);

        for($i=0; $i < $nbKeys; $i++ ) {
            if($i > 0 ) {
                $reqUpdateRecord .= ', ';
            }
            $reqUpdateRecord .= $keys[$i].' = :'.$keys[$i];
        }

        $reqUpdateRecord .= ' WHERE id = :id';

        $datas['id'] = $object->getId();

        //Préparation de la requête
        $resUpdateRecord = $this->bddlink->prepare($reqUpdateRecord);

        $resUpdateRecord->execute($datas);

        return $resUpdateRecord->rowCount();
    } catch (Exception $ex) {
        echo $ex->getMessage();
        return 0;
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
            
            $Enregistrement = $this->bddlink->prepare($reqNewRecord);
            $Enregistrement->execute($datas);
                    
            return array(true);
        } catch (Exception $ex) {
            echo $ex->getMessage(); 
            return array();
        }
     
    }
    function deleteRecord(object $objet){
        try{
            if(!isset($objet)){
                throw new Exception(__METHOD__.' '.__LINE__.': user doit être défini');
            }
            $table = get_class($objet);
            $query = "DELETE FROM ".$table." WHERE ";
            $count = count(array_keys($options));
            $criteria = array_keys($options);
            for($i = 0; $i < $count; $i++){
                if($i>0){ 
                    $query .= ' AND '; 
                }
                $query .= $criteria[$i].' = :'.$criteria[$i]; 
                $options['id'] = $objet->getLogin();
                $req = $this->bddlink->prepare($query);
                $req->execute($options);
                
                return $req->rowCount();
            }
        }catch(Exception $ex){
            echo $ex->getMessage(); 
            return array();
        }
    }
}
