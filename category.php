<?php

require_once 'crud.php';
class category{

 private $id, $name, $description;

 private $connect;

 public function __construct()
{
    $this->connect=new Crud();
}
  public function getAll(){

   $result=$this->connect->showTable('categories');

   if(!$result['success'])

     return ['result'=>$result['message']];

   else return $result['data'];

   }

   public function getName(){
    return $this->name;
   }
 public function create($data){

  $result=$this->connect->insert('categories',$data);

     
    return ['result'=>$result['message']];
 }

   public function update($data,int $id){//$data is a associated array

     $result=$this->connect->update('categories',$data,$id);

     return ['result'=>$result['message']];
 
      
   }

    public function delete(int $id){

     $result=$this->connect->delete('categories',$id);

     return ['result'=>$result['message']];
 
      
   }





}