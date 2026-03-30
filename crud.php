<?php

require_once 'database.php';



class Crud{

public $pdo;
//public final string  $name;
public function __construct(){
    $this->pdo =new Database();
}
public function insert($table,$data){
     
if($this->pdo->checkTheTable($table)){

$query="SELECT COLUMN_NAME FROM 
INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA=DATABASE()
AND TABLE_NAME=:table_name ";

$stmt=$this->pdo->connect->prepare($query);

$stmt->execute([':table_name'=>$table]);

$cols=$stmt->fetchAll(PDO::FETCH_COLUMN);

$filteredData=[];

foreach ($data as $column=>$value){
if(in_array($column,$cols)){
    $filteredData[$column]=$value;
}
}
if(empty($filteredData)){
    return ['success'=>false,'message'=>'لا توجد أعمدة صالحة للادخال'];
}
$columns=array_keys($filteredData);

$placeHolders=array_map(
fn($col)=> ":$col"
,$columns);

$placeHoldersStrings=implode(',',$placeHolders);

$query="INSERT INTO $table ( ". implode(',',$columns) .')'.'values (' 
.$placeHoldersStrings .')';

$stmt=$this->pdo->connect->prepare($query);

$stmt->execute($filteredData);


return ['success'=>true,'message'=> ' تم الادخال بنجاح ✅ '];

}
    return ['success'=>false,'message'=>'الجدول غير صحيح ❌'];

}

public function update($table,$data,$id){

if($this->pdo->checkTheTable($table)){


$query="SELECT COLUMN_NAME FROM 
INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA=DATABASE()
AND TABLE_NAME=:table_name ";

$stmt=$this->pdo->connect->prepare($query);

$stmt->execute([':table_name'=>$table]);

$cols=$stmt->fetchAll(PDO::FETCH_COLUMN);

$filteredData=[];

foreach ($data as $column=>$value){
if(in_array($column,$cols)){
    $filteredData[$column]=$value;
}
}
if(empty($filteredData)){

    return ['success'=>false,'message'=> '  لا توجد أعمدة صالحة للتعديل'];
}
$columns=array_keys($filteredData);


$setParts=[];

foreach($columns as $col){

$setParts[]=" `$col`=:$col";


}

$elements=implode(',',$setParts);

$query="UPDATE  `$table` SET $elements  WHERE id=:id  ";

$stmt=$this->pdo->connect->prepare($query);

$filteredData['id']=$id;


$stmt->execute($filteredData);

$rowCount = $stmt->rowCount();

if ($rowCount > 0) {
    return ['success'=>true, 'message'=> "تم التحديث بنجاح ✅ ($rowCount سجل)"];
} else {
    return ['success'=>false, 'message'=> 'لم يتم تحديث أي سجل (البيانات مطابقة أو السجل غير موجود)'];
}


}
    return ['success'=>false,'message'=>'الجدول غير صحيح ❌'];


}


public function showTable($table){

if(!$this->pdo->checkTheTable($table)){
        return ['success'=>false,'message'=>'الجدول غير صحيح ❌'];
}

$query ="SELECT * FROM `$table`";

$stmt=$this->pdo->connect->prepare($query);

$stmt->execute();

$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
   
return ['success'=>true,'data'=>$result]; 

}

public function delete($table,$id){

if(!$this->pdo->checkTheTable($table)){
       
return ['success'=>false,'message'=>'الجدول غير صحيح ❌'];
}
try{
$query="delete from `$table` where id=?";

$stmt=$this->pdo->connect->prepare($query);

$rowCount=$stmt->execute([$id]);

 if ($rowCount > 0) {
            return [
                'success' => true,
                'message' => "تم الحذف بنجاح ✅ ($rowCount سجل)",
                'affected_rows' => $rowCount
            ];
        } else {
            return [
                'success' => false,
                'message' => 'لم يتم العثور على السجل أو تم حذفه مسبقاً'
            ];
        }
        
}

catch(Exception $e){

return ['success'=>false]; 

}


}
   public function getBook(int $id){


   $query="SELECT * FROM books WHERE id=?";

   $stmt=$this->pdo->connect->prepare($query);

   $stmt->execute([$id]);

   return $stmt->fetchAll();
   }

    public function numberOfBooks(int $category_id){
 
   $query= "SELECT COUNT(*) FROM books WHERE category_id=?";

   $stmt=$this->pdo->connect->prepare($query);

   $stmt->execute([$category_id]);

   $rowCount=$stmt->fetchColumn();

    return $rowCount;
   }

   public function getAllBookAndCategory() {

   
    $sql = "SELECT books.*, categories.name as category_name 
            FROM books 
            LEFT JOIN categories ON books.category_id = categories.id";

     $stmt=$this->pdo->connect->prepare($sql);


  $stmt->execute();

  $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
   
   return ['success'=>true,'data'=>$result]; 

}

public function getById($table,int $id){

if(!$this->pdo->checkTheTable($table)){
        return ['success'=>false,'message'=>'الجدول غير صحيح ❌'];
}

$query="SELECT * FROM  $table where id=?";

 $stmt=$this->pdo->connect->prepare($query);


  $stmt->execute([$id]);

  $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
   
   return ['success'=>true,'data'=>$result]; 


}

   
}
