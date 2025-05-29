<?php
namespace App\Table;
use App\Model\Post;
use App\Model\Category;
use App\Table\Exception\NotFoundException;
use App\Model\PaginatedQuery;
use App\Model\User;
use App\Table\Table;
use App\Table\CategoryTable;
use Exception;
use PDO;

class UserTable extends Table{

    protected $table="user";
    protected $class=User::class;

    public function findByUsername(string $username)
    {
        $query=$this->pdo->prepare("SELECT * FROM {$this->table} WHERE username = :nom");
        $query->execute(['username'=>$username]);
        $query->setFetchMode(PDO::FETCH_CLASS,$this->class);
        $result=$query->fetch();
        if($result===false){
            throw new Exception("Utilisateur introuvable.");
        }
        return $result;
    }

}