<?php



class Database{
public $connect;
public function __construct()
{
    
    $dsn="mysql:host=localhost;dbname=library;port=3307";
    $userName='root';
    $password='';
    $options=[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
   try{
    $this->connect=new PDO($dsn,$userName,$password,$options);
  
   }
   catch(PDOException $e){
  
   die('Failed connected <br>'. $e->getMessage().'<br>'. $e->getCode().'<br>') ;
   
   }
    


}

public function  checkTheTable($table){

  $query = "SELECT COUNT(*) 
            FROM information_schema.tables 
            WHERE table_schema = DATABASE() 
              AND table_name = :table_name";

  $stmt=$this->connect->prepare($query);
   
  $stmt->execute([':table_name'=>$table]);

  return $stmt->fetchColumn()>0;
}

public function checkColumn($table,$column){

$query="SELECT COUNT(*) 
       FROM information_schema.columns
       WHERE table_schema=DATABASE()
       AND table_name=:table_name
       AND column_name=:column_name";
$stmt=$this->connect->prepare($query);
$stmt->execute([':table_name'=>$table,
':column_name'=>$column
]);

return $stmt->fetchColumn()>0;

}
}