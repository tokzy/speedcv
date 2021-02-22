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


public function checkCode(string $email){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM `passResetCode` WHERE email = :email"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}

public function checkIfCodeMatchesEmail(int $code,string $email){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM `passResetCode` WHERE code = :code AND email = :email"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->bindParam(':code',$code,\PDO::PARAM_INT);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}

public function UpdateCode(string $email,int $code){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "UPDATE `passResetCode` SET code = :code,datemade = :datemade WHERE email = :email";

$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->bindParam(':code',$code,\PDO::PARAM_INT);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function UpdatePassword(string $email,string $password){
    $conn = $this->connect();
    $conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12));
    $sql = "UPDATE `users` SET password = :pass WHERE email = :email";
    
    $stmt = $this->connect()->prepare($sql);
    $stmt->bindParam(':email',$email,\PDO::PARAM_STR);
    $stmt->bindParam(':pass',$passwordHash,\PDO::PARAM_STR);
    
    $result = $stmt->execute();
    if($result):
    return true;
    else:
    return false;
    endif;        
    }

public function Code(int $len){
$result = "";
$chars = "0123456789";	
$chararray = str_split($chars);
for($i=0;$i<$len;$i++){
$randitem = array_rand($chararray);
$result .= "".$chararray[$randitem];	
}		
return $result;
}	   

public function resetCode(string $email,int $code){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "INSERT INTO `passResetCode` (email,code,datemade)
VALUES(:email,:code,:datemade)";

$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->bindParam(':code',$code,\PDO::PARAM_INT);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
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


public function getsectionBytitle(string $title,$pid){
    $conn = $this->connect();
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $sql = "SELECT id,title from `headings` WHERE title = :title AND pid = :pid LIMIT 1";
    $stmt = $this->connect()->prepare($sql);

    $stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
    $stmt->bindParam(':title',$title,PDO::PARAM_STR);

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
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

public function checkIfIdExists(int $id){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM users WHERE id = :id"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

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
if(!empty($profile)):
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

public function fetchHeadings(){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT title,id from headings ORDER BY id ASC"; 
$stmt = $this->connect()->prepare($sql);
$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}

public function checkIfTitleExists(string $title,int $pid){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM headings WHERE title = :title AND pid =:pid"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
$stmt->bindParam(':title',$title,PDO::PARAM_STR);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}


public function checkIfTitleIdExists(int $id){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM headings WHERE id = :id"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':id',$id,PDO::PARAM_INT);

$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}

public function checkIfmiscExists(int $id,int $pid){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM miscellaneous WHERE headingId = :id AND pid = :pid"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':id',$id,PDO::PARAM_INT);
$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}

public function CreateHeading(string $title,int $pid){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "INSERT INTO headings (pid,title,datemade)
VALUES(:pid,:title,:datemade)";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
$stmt->bindParam(':title',$title,\PDO::PARAM_STR);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}


public function editHeading(int $id, string $title){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "UPDATE headings SET title = :title WHERE id = :id";

$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);
$stmt->bindParam(':title',$title,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function DeleteHeading(int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "DELETE FROM headings WHERE id = :id";

$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function CreateMiscellaneous(int $id,int $pid,string $value){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   
$sql = "INSERT INTO `miscellaneous`(headingId,pid,value,datemade)
VALUES(:hid,:pid,:value,:datemade)";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':hid',$id,\PDO::PARAM_INT);
$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':value',$value,\PDO::PARAM_STR);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function fetchTemplates(){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT path,id from `templateLists` ORDER BY id ASC"; 
$stmt = $this->connect()->prepare($sql);
$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}

public function getpd(int $pid){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from `personalDetails` WHERE id = :pid"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row;
}

public function getAllpdById(int $pid){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from `personalDetails` WHERE id = :pid"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}

public function getheadersbytitle(string $title){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from `headings` WHERE mydefault = :title"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':title',$title,PDO::PARAM_STR);

$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row;
}

public function getheadersbyheaderId(int $id){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from `headings` WHERE id = :id"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':id',$id,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row;
}

public function getAllObjBypid(int $pid){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from `objective` WHERE pid = :pid"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}

public function getAllEduBypid(int $pid){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from `education` WHERE pid = :pid"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}

public function checkIftempIdExists(int $id){
$connect = $this->connect();

$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);  
$sql = "SELECT count(*) FROM `templateLists` WHERE id = :id"; 

$stmt = $connect->prepare($sql);
$stmt->bindParam(':id',$id,PDO::PARAM_INT);
$stmt->execute();
$rowcount = $stmt->fetchColumn();
if($rowcount > 0):return true;else:return false;endif;    
}

public function StorePdf(int $userid,string $path){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "INSERT INTO `pdf`(user_id,path,datemade)
VALUES(:userid,:path,:datemade)";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':userid',$userid,\PDO::PARAM_INT);
$stmt->bindParam(':path',$path,\PDO::PARAM_STR);
$stmt->bindParam(':datemade',$date,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}


public function UpdatepersonalDetails(int $pid, string $name,string $email,string $address,int $phone,string $dob,string $website,string $profile){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   
if(empty($profile)):
$sql = "UPDATE personalDetails SET name = :name,address = :address,email = :email,phone = :phone,dob = :dob,
website = :website WHERE id = :pid";

$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':name',$name,\PDO::PARAM_STR);
$stmt->bindParam(':address',$address,\PDO::PARAM_STR);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->bindParam(':phone',$phone,\PDO::PARAM_INT);
$stmt->bindParam(':dob',$dob,\PDO::PARAM_STR);
$stmt->bindParam(':website',$website,\PDO::PARAM_STR);
$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;     
else:    
$sql = "UPDATE personalDetails SET name = :name,address = :address,email = :email,phone = :phone,dob = :dob,
website = :website,profile = :profile WHERE id = :pid";

$stmt = $this->connect()->prepare($sql);
$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':name',$name,\PDO::PARAM_STR);
$stmt->bindParam(':address',$address,\PDO::PARAM_STR);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->bindParam(':phone',$phone,\PDO::PARAM_INT);
$stmt->bindParam(':dob',$dob,\PDO::PARAM_STR);
$stmt->bindParam(':profile',$profile,\PDO::PARAM_STR);
$stmt->bindParam(':website',$website,\PDO::PARAM_STR);
$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
endif;
}

public function UpdateEducation(int $pid,int $id,string $course,string $grade,string $year,string $school){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "UPDATE education SET course = :course,school = :school,grade = :grade,year = :year WHERE pid = :pid AND id = :id";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);
$stmt->bindParam(':course',$course,\PDO::PARAM_STR);
$stmt->bindParam(':school',$school,\PDO::PARAM_STR);
$stmt->bindParam(':year',$year,\PDO::PARAM_STR);
$stmt->bindParam(':grade',$grade,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function getExperience(int $pid){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from experience WHERE pid = :pid"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}

public function UpdateExperience(int $pid,int $id,string $companyName,string $jobTitle,string $startDate,string $endDate,string $details){
$conn = $this->connect();
$date = date("Y-m-d H:i:s");
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "UPDATE experience SET companyName = :company,jobTitle = :jobTitle ,startDate = :startDate
,endDate = :endDate ,details = :details WHERE id = :id AND pid = :pid";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);
$stmt->bindParam(':company',$companyName,\PDO::PARAM_STR);
$stmt->bindParam(':jobTitle',$jobTitle,\PDO::PARAM_STR);
$stmt->bindParam(':startDate',$startDate,\PDO::PARAM_STR);
$stmt->bindParam(':endDate',$endDate,\PDO::PARAM_STR);
$stmt->bindParam(':details',$details,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function getAllSkills(int $pid){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from skills WHERE pid = :pid"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}

public function UpdateSkills(int $pid,int $id,string $skills,string $level){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "UPDATE skills SET skills = :skills,level = :level WHERE id = :id AND pid = :pid";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);
$stmt->bindParam(':skills',$skills,\PDO::PARAM_STR);
$stmt->bindParam(':level',$level,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function getAllobjective(int $pid){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from `objective` WHERE pid = :pid"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}

public function Updateobjective(int $pid,int $id,string $objective){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "UPDATE objective SET obj = :obj WHERE id = :id AND pid = :pid";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);
$stmt->bindParam(':obj',$objective,\PDO::PARAM_STR);
$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function getAllreference(int $pid){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from `reference` WHERE pid = :pid"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}  

public function Updatereference(int $pid,int $id,string $refname,string $jobtitle,string $companyName,string $email, int $phone){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "UPDATE reference SET refereeName = :refname,jobTitle = :jobtitle,companyName = :company,
email = :email,phone = :phone WHERE id = :id AND pid = :pid";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);
$stmt->bindParam(':refname',$refname,\PDO::PARAM_STR);
$stmt->bindParam(':jobtitle',$jobtitle,\PDO::PARAM_STR);
$stmt->bindParam(':company',$companyName,\PDO::PARAM_STR);
$stmt->bindParam(':email',$email,\PDO::PARAM_STR);
$stmt->bindParam(':phone',$phone,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function deleteReference(int $pid,int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "DELETE FROM reference WHERE id = :id AND pid = :pid";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function getAllproject(int $pid){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from `projects` WHERE pid = :pid"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}  

public function UpdateProject(int $pid,int $id,string $title,string $description){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "UPDATE projects SET title = :title,description = :descrip WHERE id = :id AND pid = :pid";

$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);
$stmt->bindParam(':title',$title,\PDO::PARAM_STR);
$stmt->bindParam(':descrip',$description,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function GetMiscellaneous(int $pid,int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "SELECT * FROM `miscellaneous` WHERE headingId = :id AND pid = :pid";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;       
}

public function UpdateMiscellaneous(int $id,int $pid,string $value){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "UPDATE `miscellaneous` SET value = :val WHERE id = :id AND pid = :pid";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);
$stmt->bindParam(':val',$value,\PDO::PARAM_STR);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function deleteMiscellaneous(int $pid,int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "DELETE FROM `miscellaneous` WHERE id = :id AND pid = :pid";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}


public function deleteEdu(int $pid,int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "DELETE FROM `education` WHERE id = :id AND pid = :pid";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function deleteExperience(int $pid,int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "DELETE FROM `experience` WHERE id = :id AND pid = :pid";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function deleteSkills(int $pid,int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "DELETE FROM `skills` WHERE id = :id AND pid = :pid";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function deleteObjective(int $pid,int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "DELETE FROM `objective` WHERE id = :id AND pid = :pid";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,\PDO::PARAM_INT);
$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function GetUserCvs(int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "SELECT name,email,id FROM `personalDetails` WHERE user_id = :id";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;       
}

public function deleteCvs(int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "DELETE FROM `personalDetails` WHERE id = :id";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function getAllPdf(int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "SELECT * FROM `pdf` WHERE user_id = :id";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;       
}

public function getPdfByid(int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "SELECT * FROM `pdf` WHERE id = :id";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetch(\PDO::FETCH_ASSOC);
return $row;       
}

public function deletePdf(int $id){
$conn = $this->connect();
$conn->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );   

$sql = "DELETE FROM `pdf` WHERE id = :id";
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':id',$id,\PDO::PARAM_INT);

$result = $stmt->execute();
if($result):
return true;
else:
return false;
endif;        
}

public function getMisc(int $pid){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from `miscellaneous` WHERE pid = :pid GROUP BY headingId"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}  

public function getAllValues(int $headingId,int $pid){
$conn = $this->connect();
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
$sql = "SELECT * from `miscellaneous` WHERE pid = :pid AND headingId = :hid"; 
$stmt = $this->connect()->prepare($sql);

$stmt->bindParam(':pid',$pid,PDO::PARAM_INT);
$stmt->bindParam(':hid',$headingId,PDO::PARAM_INT);

$stmt->execute();
$row = $stmt->fetchAll();
return $row;
}  

}

