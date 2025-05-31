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

    public function findByUser(string $email)
    {
        $query=$this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $query->execute(['email'=>$email]);
        $query->setFetchMode(PDO::FETCH_CLASS,$this->class);
        $result=$query->fetch();
        if($result===false){
            throw new Exception("Utilisateur introuvable.");
        }
        return $result;
    }

    /**
     * @return array [id => nom complet]
     */
    public function list(): array
    {
        $users = $this->pdo
            ->query("SELECT id, nom, prenom FROM {$this->table} WHERE role_id = 1 ORDER BY nom ASC")
            ->fetchAll(PDO::FETCH_ASSOC);
        
        $results = [];
        foreach($users as $user) {
            $results[$user['id']] = $user['prenom'] . ' ' . $user['nom'];
        }
        return $results;
    }

}