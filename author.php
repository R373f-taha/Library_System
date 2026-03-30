<?php
require_once 'crud.php';
class author{

   private  $id, $first_name, $last_name, $age, $join_date;
    
   private $connect;
   public function __construct()
   {
    $this->connect=new Crud();

   }

   public function getAll(){

   $result=$this->connect->showTable('authors');

   if(!$result['success'])
     return ['result'=>$result['message']];

   else return $result['data'];

   }

   public function create($data){//$data is a associated array

     $result=$this->connect->insert('authors',$data);

       
     return ['result'=>$result['message']];
 
      
   }

     public function update($data,int $id){//$data is a associated array

     $result=$this->connect->update('authors',$data,$id);

     return ['result'=>$result['message']];
 
      
   }

    public function delete(int $id){

     $result=$this->connect->delete('authors',$id);

     return ['result'=>$result['message']];
 
      
   }

   public function getFullName(){

   return $this->first_name.' '.$this->last_name;

   }

}