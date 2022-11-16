<?php

  require '../config/database.php';

  class Student
  {
    
    public $name;
    public $email;
    public $mobile;
    
    private $conn;
    private $table_name;

    public function __construct($db)
    {

      $this->conn = $db;
      $this->table_name = "students";

    }

    public function create_data()
    {
      $conn = Database::connect();
      $query = "INSERT INTO ".$this->table_name." SET name = ?, email = ?, mobile = ?";
      $stmt = $conn->prepare($query);

      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->mobile = htmlspecialchars(strip_tags($this->mobile));

      $stmt->execute(array($this->name,$this->email,$this->mobile));

      if($stmt->rowCount() >= 1){
        return true;
      } else {
        return false;
      }
    }

    public function get_all_data()
    {
      $conn = Database::connect();
      $query = "SELECT * FROM ".$this->table_name;

      $stmt = $conn->prepare($query);
      $stmt->execute([$this->id]);

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_single_student($id)
    {
      $conn = Database::connect();
      $query = "SELECT * FROM ".$this->table_name." WHERE id = ?";

      $stmt = $conn->prepare($query);
      $stmt->execute([$id]);

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update_student($id)
    {
      $conn = Database::connect();
      $query = "UPDATE ".$this->table_name." SET name = ?, email = ?, mobile = ? WHERE id = ?";

      $stmt = $conn->prepare($query);
      $stmt->execute([$this->name,$this->email,$this->mobile,$id]);

      if($stmt->rowCount() >= 1){
        return true;
      } else {
        return false;
      }

    }

  }

?>