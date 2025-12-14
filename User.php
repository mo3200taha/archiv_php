<?php
require_once 'config.php';

class User {
    private $conn;
    private $table = 'users';
    
    public $id;
    public $username;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $bio;
    public $phone;
    public $address;
    public $city;
    public $country;
    public $profile_picture;
    public $date_of_birth;
    
    public function __construct() {
        $this->conn = getDbConnection();
    }
    
    // Create new user
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (username, email, password, first_name, last_name, bio, phone, address, city, country, profile_picture, date_of_birth) 
                  VALUES 
                  (:username, :email, :password, :first_name, :last_name, :bio, :phone, :address, :city, :country, :profile_picture, :date_of_birth)";
        
        $stmt = $this->conn->prepare($query);
        
        // Hash password
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        
        // Bind parameters
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':bio', $this->bio);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':profile_picture', $this->profile_picture);
        $stmt->bindParam(':date_of_birth', $this->date_of_birth);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Read user by ID
    public function read($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->bio = $row['bio'];
            $this->phone = $row['phone'];
            $this->address = $row['address'];
            $this->city = $row['city'];
            $this->country = $row['country'];
            $this->profile_picture = $row['profile_picture'];
            $this->date_of_birth = $row['date_of_birth'];
            return true;
        }
        return false;
    }
    
    // Update user profile
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET first_name = :first_name, 
                      last_name = :last_name, 
                      bio = :bio, 
                      phone = :phone, 
                      address = :address, 
                      city = :city, 
                      country = :country, 
                      profile_picture = :profile_picture, 
                      date_of_birth = :date_of_birth 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':bio', $this->bio);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':profile_picture', $this->profile_picture);
        $stmt->bindParam(':date_of_birth', $this->date_of_birth);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Delete user
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Get all users
    public function getAll() {
        $query = "SELECT id, username, email, first_name, last_name, city, country FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
