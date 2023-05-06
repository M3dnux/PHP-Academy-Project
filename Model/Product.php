<?php
	class Product
	{
		private $id;
		private $des;
		private $desc;
		private $brand;
		private $color;
		private $quantity;
		private $price;

		function __construct($id, $des, $desc, $brand, $color, $quantity, $price)
		{
			$this->id = $id;
			$this->des = $des;
			$this->desc = $desc;
			$this->brand = $brand;
			$this->color = $color;
			$this->quantity = $quantity;
			$this->price = $price;
		}

		private $data = array();

		public function __get($attr)
		{
			if (!isset($this->$attr)) return "error";
			else return ($this->$attr);
		}

		public function __set($attr, $value)
		{
			$this->$attr = $value;
		}
		public function __isset($attr)
		{
			return isset($this->$attr);
		}

		public static function getAllProducts()
        {
            require("bdConnexion.php");
            $sql = $conn->query("SELECT * FROM tproduct WHERE quantity > 0");
            $sql->setFetchMode(PDO::FETCH_OBJ);
            $resultat = $sql->fetchAll();
            return $resultat;
        }

		public static function getProductsByPriceRange($minP, $maxP) {
			require("bdConnexion.php");
			$sql = $conn->prepare("SELECT * FROM tproduct WHERE price BETWEEN :min AND :max");
			$sql->bindParam(':min', $minP);
			$sql->bindParam(':max', $maxP);
			$sql->execute();
			$resultat = $sql->fetchAll(PDO::FETCH_OBJ);
			return $resultat;
		}

		public static function getProductsByName($name) {
			require("bdConnexion.php");
			$sql = $conn->prepare("SELECT * FROM tproduct WHERE designation LIKE :name");
			$sql->bindValue(':name', "%$name%", PDO::PARAM_STR);
			$sql->execute();
			$resultat = $sql->fetchAll(PDO::FETCH_OBJ);
			return $resultat;
		}

        public static function getProduct($id)
        {
            require("bdConnexion.php");
            $stmt = $conn->prepare("SELECT * FROM tproduct WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $resultat = $stmt->fetch(PDO::FETCH_OBJ);
            return $resultat;
        }

		public static function updateProduct($p)
		{
			require("bdConnexion.php");
			$query = "UPDATE tproduct SET designation=?, description=?, brand=?, color=?, quantity=?, price=? WHERE id=?";
			$stmt = $conn->prepare($query);
			$stmt->execute([$p->des, $p->desc, $p->brand, $p->color, $p->quantity, $p->price, $p->id]);
			$nb = $stmt->rowCount();
			return $nb;
		}

		public static function updateQuantity($qt, $id, $qtToBuy)
		{
			require("bdConnexion.php");
			$query = $conn->prepare("UPDATE tproduct SET quantity=:qt WHERE id=:id");
			$q = ($qt-$qtToBuy);
			$query->bindParam(":qt", $q);
			$query->bindParam(":id", $id);

			$nb = $query->execute();
            return $nb;
		}

		public static function deleteProduct($id)
		{
			require("bdConnexion.php");
            $query = $conn->prepare("DELETE FROM tproduct WHERE id=:id");
            $query->bindParam(":id", $id);
            $nb = $query->execute();
            return $nb;
		}

		public static function addProduct($p)
		{
			require("bdConnexion.php");
			$result = Product::getProduct($p->id);
			if ($result) {
				return 0;
			} else {
				$query = $conn->prepare("INSERT INTO tproduct VALUES (:id, :designation, :description, :brand, :color, :quantity, :price)");
				$query->bindParam(":id", $p->id);
				$query->bindParam(":designation", $p->des);
				$query->bindParam(":description", $p->desc);
				$query->bindParam(":brand", $p->brand);
				$query->bindParam(":color", $p->color);
				$query->bindParam(":quantity", $p->quantity);
				$query->bindParam(":price", $p->price);
				$nb = $query->execute();
				return $nb;
    		}
		}
	}
?>