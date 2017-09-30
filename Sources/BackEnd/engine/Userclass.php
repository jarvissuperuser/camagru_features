<?php
/**
 *untested
 */
class User
{
	/**
	 *@param DB_Control $conn Description
	 */
	public function __construct($conn)
	{
    $this->dbCon = $conn;
		try{
			
      if ($this->dbCon == NULL){
        throw new Exception ("No Connection");
      }
      return $this;
    }catch(Exception $ex){
      echo $ex->getTraceAsString() . ":" . $ex->getMessage();
    }
	}

	public $hashed;
	/**
	 * @var void
	 */
	public $username;
  
  /**
	 * @var void
	 */
	public $vryfctnStatus;


	/**
	 * @var void
	 */
	public $userid;

	/**
	 * @var void
	 */
	public $email;
	/**
	 * @var void
	 */
	public $password;
	/**
	 * @var DB_Control
	 */
	public $dbCon;


  /**
	 * statuses
   * i = inactive;
   * a = active;
   * b = blocked;
   * r = password reset requested
   *
	 */
	public function addUser()
	{
		$db = $this->dbCon;
    $usr = $this;
    $usr->hash();
    $table = "Camagru.users";
    $Col = ['userName','email','password','verificationStatus'];
    $values = [$usr->username,$usr->email,$usr->password,'i'];
    $query = $db->insert($table,$Col, $values);
    $query .= "ON DUPLICATE UPDATE verificationStatus='$usr->vryfctnStatus',"
            . "password = '{$usr->password}';";
    $statement = $this->dbCon->dbCon->prepare($query);
    $simple = "userName:{$this->username}";
    $complex = base64_encode($simple);
    $ar = array_flip(explode('/', ServerRoot));//get excution folder
    $sv = $ar[0];
    if ($statement->execute()){
      mail($usr->email,
              "Confirm Registration",
              "Please Click follow http://localhost/$sv/?uri=$complex");
      return $this;
    }
    return NULL;
	}

	
	/**
	 * sha-256 encryptionn
	 */
	private function hash()
	{
		if ($this->hashed != 1)
		{
			$this->password = hash("sha256",$this->password);
      $this->hashed = 1;
		}
	}

	/**
	 */
	public function getUser($id)
	{
    $db = $this->dbCon;
    $limiter = "userID = :id limit 1";
    $query = $db->select(['userName','email','verificationStatus'],
            "Camagru.users", $limiter);
    $statement = $db->dbCon->prepare($query);
    $statement->bindParam("id", $id);
    $statement->execute();
    $user = $statement->fetchObject();
    if ($statement->rowCount() > 0){
      $this->email = $user->email;
      $this->userid = $id;
      $this->username = $user->userName;
      $this->password = null;
      return $this;
    }
    return NULL;
	}

	/**
   * if email is correct ret = 0;
   * if email password is correct return userid;
   * if failed ret = -1;
	 * 
	 */
	public function verify()
	{

    $this->hash();
    $limiter = "email = '{$this->email}'"  
    ." GROUP BY userID LIMIT 1;";
    $query = $this->dbCon->select(["count(*) as c","userID as d","password"], "Camagru.users", $limiter);
    $statement = $this->dbCon->prep($query, $this->dbCon->dbCon);
    $statement->execute();
    $res = $statement->fetchObject();
    if($statement->rowCount() > 0){
      if ($res->password === $this->password){
        return $res->d;
      }
			else
				return $res->c - 1;
    }    
    return $statement->rowCount();
	}
}
