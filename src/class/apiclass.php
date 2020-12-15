<?php
class Apiclass {

private $hostname = 'localhost';
private $user = 'root';
private $dbname = 'speedy';
private $password = 'jehovah205';
protected $connection;
private $charset = 'utf8';

private function connect(){
$dsn = "mysql:host=$this->hostname;dbname=$this->dbname;charset=$this->charset";
try{
$this->connection = new \PDO($dsn,$this->user,$this->password);  
return $this->connection;
} catch(\PDOException $e){
throw new \PDOException($e->getMessage(),(int)$e->getCode());
}
}

public function checkKeys(string $apikeys, string $secretekeys){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM apiTokens WHERE api_key = :apikey AND secret_key = :secretkey"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':apikey',$apikeys,\PDO::PARAM_STR);
$stmt->bindParam(':secretkey',$secretekeys,\PDO::PARAM_STR);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}

public function cleanInputs($data){
$data = trim($data);
$data2 = stripslashes($data);
$data3 = strip_tags($data2);
$data4 = htmlentities($data3);
return $data4;
}

public function LogIn(string $email,string $password){
$this->connect()->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );  

$sql = "SELECT email,password from users WHERE email = :email"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(\PDO::FETCH_ASSOC);

if($stmt->rowCount() > 0):
if(password_verify($password,$row['password'])):
return true;
else:
return false;
endif;
else:
return false;
endif;        
}

public function getuserdetailsByEmail(string $email){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT fullname,email,id,datemade from users WHERE email = :email LIMIT 1"; 
$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':email',$email,PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row;
}

public function getpdetailsByKey(string $key){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT id,email,trackcv from personalDetails WHERE trackcv = :trackid LIMIT 1"; 
$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':trackid',$key,PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row;
}

public function checkIfEmailExists(string $email){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM users WHERE email = :email"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}

public function checkIfKeyExists(string $key){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM personalDetails WHERE trackcv = :trackid"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':trackid',$key,\PDO::PARAM_STR);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}


public function checkIfEmailExistsPd(string $email){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM personalDetails WHERE email = :email"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}

public function checkIfPidExists(int $id){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM personalDetails WHERE id = :pid"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':pid',$id,\PDO::PARAM_INT);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}


public function signup(string $name,string $email,string $password,int $phone){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
$sql = "INSERT INTO users (fullname,email,phone,password,datemade)
VALUES(:fullname,:email,:phone,:password,:datemade)";

$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':fullname',$name,\PDO::PARAM_STR);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->bindParam(':phone',$phone,\PDO::PARAM_INT);
$stmt->bindParam(':password',$passwordHash,\PDO::PARAM_STR);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function personalDetails(string $tracker,int $userid, string $name,string $email,string $address,int $phone,string $dob,string $website,string $profile){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   
if(empty($profile)):
$sql = "INSERT INTO personalDetails (trackcv,user_id,name,address,email,phone,dob,website,profile,datemade)
VALUES(:trackcv,:uid,:name,:address,:email,:phone,:dob,:website,:profile,:datemade)";

$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':uid',$userid,\PDO::PARAM_INT);
$stmt->bindParam(':name',$name,\PDO::PARAM_STR);
$stmt->bindParam(':trackcv',$tracker,\PDO::PARAM_STR);
$stmt->bindParam(':address',$address,\PDO::PARAM_STR);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->bindParam(':phone',$phone,\PDO::PARAM_INT);
$stmt->bindParam(':dob',$dob,\PDO::PARAM_STR);
$stmt->bindParam(':website',$website,\PDO::PARAM_STR);
$stmt->bindParam(':profile',$profile,\PDO::PARAM_STR);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);
$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;     
else:    
$sql = "INSERT INTO personalDetails (trackcv,user_id,name,address,email,phone,dob,website,datemade)
VALUES(:trackcv,:uid,:name,:address,:email,:phone,:dob,:website,:datemade)";

$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':uid',$userid,\PDO::PARAM_INT);
$stmt->bindParam(':name',$name,\PDO::PARAM_STR);
$stmt->bindParam(':trackcv',$tracker,\PDO::PARAM_STR);
$stmt->bindParam(':address',$address,\PDO::PARAM_STR);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->bindParam(':phone',$phone,\PDO::PARAM_INT);
$stmt->bindParam(':dob',$dob,\PDO::PARAM_STR);
$stmt->bindParam(':website',$website,\PDO::PARAM_STR);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);
$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
endif;
}

public function education(int $pid,string $course,string $grade,string $year,string $school){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "INSERT INTO education (pid,course,school,grade,year,datemade)
VALUES(:pid,:course,:school,:grade,:year,:datemade)";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':course',$course,\PDO::PARAM_STR);
$stmt->bindParam(':school',$school,\PDO::PARAM_STR);
$stmt->bindParam(':year',$year,\PDO::PARAM_STR);
$stmt->bindParam(':grade',$grade,\PDO::PARAM_STR);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function skills(int $pid,string $skills,int $level){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "INSERT INTO skills (pid,skills,level,datemade)
VALUES(:pid,:skills,:level,:datemade)";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':skills',$skills,\PDO::PARAM_STR);
$stmt->bindParam(':level',$level,\PDO::PARAM_INT);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}


public function geteduBypid(int $pid,string $school,string $year){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

$sql = "SELECT * from education WHERE pid = :pid AND school = :school AND year = :year LIMIT 1"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
$stmt->bindParam(':school',$school,PDO::PARAM_STR);
$stmt->bindParam(':year',$year,PDO::PARAM_STR);

$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row;
}

public function checkIfEduExists(int $pid,string $school,string $year){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM education WHERE pid = :pid AND school = :school AND year = :year"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':school',$school,\PDO::PARAM_STR);
$stmt->bindParam(':year',$year,PDO::PARAM_STR);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}


public function getskills(int $pid,string $skills){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from skills WHERE pid = :pid AND skills = :skills LIMIT 1"; 
$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
$stmt->bindParam(':skills',$skills,PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row;
}

public function checkIfSkillsExists(int $id,string $skills){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM skills WHERE pid = :pid AND skills = :skills"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':pid',$id,\PDO::PARAM_INT);
$stmt->bindParam(':skills',$skills,\PDO::PARAM_STR);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}

public function checkIfExperienceExists(int $pid,string $companyName,string $jobTitle,string $startDate){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM experience WHERE pid = :pid AND companyName = :company AND jobTitle = :job AND startDate = :startd"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
$stmt->bindParam(':company',$companyName,PDO::PARAM_STR);
$stmt->bindParam(':job',$jobTitle,PDO::PARAM_STR);
$stmt->bindParam(':startd',$startDate,PDO::PARAM_STR);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}


public function experience(int $pid,string $companyName,string $jobTitle,string $startDate,string $endDate,string $details){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "INSERT INTO experience (pid,companyName,jobTitle,startDate,endDate,details,datemade)
VALUES(:pid,:company,:jobTitle,:startDate,:endDate,:details,:datemade)";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':company',$companyName,\PDO::PARAM_STR);
$stmt->bindParam(':jobTitle',$jobTitle,\PDO::PARAM_STR);
$stmt->bindParam(':startDate',$startDate,\PDO::PARAM_STR);
$stmt->bindParam(':endDate',$endDate,\PDO::PARAM_STR);
$stmt->bindParam(':details',$details,\PDO::PARAM_STR);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function getexperienceBypid(int $pid,string $companyName,string $jobTitle,string $startDate){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from experience WHERE pid = :pid AND companyName = :company AND jobTitle = :job AND startDate = :startd LIMIT 1"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
$stmt->bindParam(':company',$companyName,PDO::PARAM_STR);
$stmt->bindParam(':job',$jobTitle,PDO::PARAM_STR);
$stmt->bindParam(':startd',$startDate,PDO::PARAM_STR);

$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row;
}

public function objective(int $pid,string $objective){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "INSERT INTO objective (pid,obj,datemade)
VALUES(:pid,:obj,:datemade)";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':obj',$objective,\PDO::PARAM_STR);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function getobjective(int $pid,string $objective){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from objective WHERE pid = :pid AND obj = :obj LIMIT 1"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
$stmt->bindParam(':obj',$objective,PDO::PARAM_STR);

$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row;
}

public function getreference(int $pid,string $refname){
    $conn = $this->connect();
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT * from reference WHERE pid = :pid AND refereeName = :ref LIMIT 1"; 
    $stmt = $this->connect()->prepare($sql);
    
    $stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
    $stmt->bindParam(':ref',$refname,PDO::PARAM_STR);
    
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
    }

public function getproject(int $pid,string $title){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from projects WHERE pid = :pid AND title = :title LIMIT 1"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
$stmt->bindParam(':title',$title,PDO::PARAM_STR);

$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row;
}

public function checkIfprojectExists(int $pid,string $title){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM projects WHERE pid = :pid AND title = :title"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':title',$title,\PDO::PARAM_STR);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}

public function checkIfObjectiveExists(int $pid,string $objective){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM objective WHERE pid = :pid AND obj = :obj"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':obj',$objective,\PDO::PARAM_STR);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}

public function checkIfreferenceExists(int $pid,string $refname){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM reference WHERE pid = :pid AND refereeName = :ref"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
$stmt->bindParam(':ref',$refname,PDO::PARAM_STR);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}


public function reference(int $pid,string $refname,string $jobtitle,string $companyName,string $email, int $phone){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "INSERT INTO reference (pid,refereeName,jobTitle,companyName,email,phone,datemade)
VALUES(:pid,:refname,:jobtitle,:companyn,:email,:phone,:datemade)";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':refname',$refname,\PDO::PARAM_STR);
$stmt->bindParam(':jobtitle',$jobtitle,\PDO::PARAM_STR);
$stmt->bindParam(':companyn',$companyName,\PDO::PARAM_STR);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->bindParam(':phone',$phone,\PDO::PARAM_STR);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function project(int $pid,string $title,string $description){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "INSERT INTO projects (pid,title,description,datemade)
VALUES(:pid,:title,:description,:datemade)";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':title',$title,\PDO::PARAM_STR);
$stmt->bindParam(':description',$description,\PDO::PARAM_STR);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}


}
?>
