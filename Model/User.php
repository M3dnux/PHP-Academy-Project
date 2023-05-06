<?php
	class User
	{
		private $login;
		private $password;
		private $name;
		private $id_card;
		private $birth_date;
		private $email;

		function __construct($login, $password, $name, $id_card, $birth_date, $email)
		{
			$this->login = $login;
			$this->password = $password;
			$this->name = $name;
			$this->id_card = $id_card;
			$this->birth_date = $birth_date;
			$this->email = $email;
		}

		private $data = array();

		public function __get($attr)
		{
			if (!isset($this->$attr)) return "erreur";
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

		public static function connect($login, $password)
		{
			require("bdConnexion.php");
			$sql = $conn->query("SELECT * FROM tuser WHERE login = '$login' and password='$password'");
			$sql->setFetchMode(PDO::FETCH_OBJ);
			$resultat = $sql->fetch();
			return $resultat;
		}

		public static function addUser($u)
		{
			require("bdConnexion.php");
			$result = User::connect($u->login, $u->password);
			if($result){
				return 0;
			}
            else{
				$query = $conn->prepare("INSERT INTO tuser VALUES (:login, :password, :name, :id_card, :birth_date, :email, 1)");
				$query->bindParam(":login", $u->login);
				$query->bindParam(":password", $u->password);
				$query->bindParam(":name", $u->name);
				$query->bindParam(":id_card", $u->id_card);
				$query->bindParam(":birth_date", $u->birth_date);
				$query->bindParam(":email", $u->email);
				$nb = $query->execute();
				return $nb;
			}
		}

		public static function getUser($username)
        {
            require("bdConnexion.php");
            $stmt = $conn->prepare("SELECT * FROM tuser WHERE login = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $resultat = $stmt->fetch(PDO::FETCH_OBJ);
            return $resultat;
        }
	}
?>