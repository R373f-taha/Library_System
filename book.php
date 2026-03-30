<?php

require_once 'crud.php';
class Book{

private $id, $title, $author_id, $category_id, $publish_year, $image ;

private $connect;


public function __construct()
{
    $this->connect=new Crud();
}
public function getAll(){

   $result=$this->connect->getAllBookAndCategory() ;

   if(!$result['success'])
    
     return ['result'=>$result['message']];

   else return $result['data'];

   }
 public function create($data){

  $result=$this->connect->insert('books',$data);

     
    return ['result'=>$result['message']];
 }

   public function update($data,int $id){//$data is a associated array

     $result=$this->connect->update('books',$data,$id);

     return ['success'=>$result['message']];
 
      
   }

    public function delete(int $id){

     $result=$this->connect->delete('books',$id);

     return ['success'=>$result['success'],'message'=>$result['message']];
 
      
   }


   public function getBookById(int $id){

    $result=$this->connect->getById('books',$id);
    
    if($result['success'])

     return ['success'=>true,'data'=>$result['data']];

    else
       return ['success'=>false];
 
   }



}