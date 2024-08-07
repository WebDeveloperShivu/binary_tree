<?php
class BinaryTree {
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect to the database: " . $e->getMessage());
        }
    }

    public function insertNode($parentId, $level, $data) {
        $stmt = $this->pdo->prepare("INSERT INTO binary_tree (parent_id, level, data) VALUES (:parent_id, :level, :data)");
        $stmt->execute(['parent_id' => $parentId, 'level' => $level, 'data' => $data]);
        return $this->pdo->lastInsertId();
    }

    public function createTree($data) {
        $rootId = $this->insertNode(null, 1, $data);
        $this->addChildren($rootId, 2);
    }

    private function addChildren($parentId, $level) {
        if ($level > 20) {
            return;
        }

        $leftChildData = "Node at level $level (left)";
        $rightChildData = "Node at level $level (right)";

        $leftChildId = $this->insertNode($parentId, $level, $leftChildData);
        $rightChildId = $this->insertNode($parentId, $level, $rightChildData);

        $this->addChildren($leftChildId, $level + 1);
        $this->addChildren($rightChildId, $level + 1);
    }

    public function getTree($maxLevel = null) {
        if ($maxLevel) {
            $stmt = $this->pdo->prepare("SELECT * FROM binary_tree WHERE level <= :maxLevel ORDER BY level, id");
            $stmt->execute(['maxLevel' => $maxLevel]);
        } else {
            $stmt = $this->pdo->query("SELECT * FROM binary_tree ORDER BY level, id");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


// Usage
$host = 'localhost'; // replace with your host
$dbname = 'binary_tree_db'; // replace with your database name
$username = 'root'; // replace with your username
$password = ''; // replace with your password

$tree = new BinaryTree($host, $dbname, $username, $password);
// $tree->createTree('U');
$treeData = $tree->getTree(6); // Get data for level 5

?>
