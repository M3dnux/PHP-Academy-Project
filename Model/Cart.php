<?php

class Cart {
	private $user_id;
	private $product_id;
	private $quantity;

	function __construct($user_id, $product_id, $quantity) {
		$this->user_id = $user_id;
		$this->product_id = $product_id;
		$this->quantity = $quantity;
	}

	private $data = array();

	public function __get($attr) {
		if (!isset($this->$attr)) {
			return "error";
		} else {
			return ($this->$attr);
		}
	}

	public function __set($attr, $value) {
		$this->$attr = $value;
	}

	public function __isset($attr) {
		return isset($this->$attr);
	}

	public static function checkCart($user_id, $product_id) {
		require("bdConnexion.php");
		$query = $conn->prepare("SELECT * FROM tcart WHERE user_id = :user_id and product_id = :product_id");
		$query->bindParam(":user_id", $user_id);
		$query->bindParam(":product_id", $product_id);
		$query->execute();
		$resultat = $query->fetch(PDO::FETCH_OBJ);
		return $resultat;
	}

    public static function checkCartOfUser($user_id) {
		require("bdConnexion.php");
		$query = $conn->prepare("SELECT * FROM tcart WHERE user_id = :user_id");
		$query->bindParam(":user_id", $user_id);
		$query->execute();
		$resultat = $query->fetchAll(PDO::FETCH_OBJ);
		return $resultat;
	}

	public static function addToCart($user_id, $product_id, $quantity) {
		require("bdConnexion.php");
		if (Cart::checkCart($user_id, $product_id) == null) {
			$query = $conn->prepare("INSERT INTO tcart VALUES (:user_id, :product_id, :quantity)");
			$query->bindParam(":user_id", $user_id);
			$query->bindParam(":product_id", $product_id);
			$query->bindParam(":quantity", $quantity);
			$nb = $query->execute();
		} else {
			$nb = 0;
		}
		return $nb;
	}

    public static function updateQuantity($user_id, $product_id, $quantity) {
        require("bdConnexion.php");
        if (Cart::checkCart($user_id, $product_id) != null) {
            $query = $conn->prepare("UPDATE tcart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
            $query->bindParam(":user_id", $user_id);
            $query->bindParam(":product_id", $product_id);
            $query->bindParam(":quantity", $quantity);
            $nb = $query->execute();
        } else {
            $nb = 0;
        }
        return $nb;
    }

    public static function deleteCart($user_id)
		{
			require("bdConnexion.php");
            $query = $conn->prepare("DELETE FROM tcart WHERE user_id=:user_id");
            $query->bindParam(":user_id", $user_id);
            $nb = $query->execute();
            return $nb;
		}

    public static function deleteFromCart($user_id, $product_id)
		{
			require("bdConnexion.php");
            $query = $conn->prepare("DELETE FROM tcart WHERE user_id=:user_id and product_id=:product_id");
            $query->bindParam(":user_id", $user_id);
            $query->bindParam(":product_id", $product_id);
            $nb = $query->execute();
            return $nb;
		}
}
?>