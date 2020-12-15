<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

/*========================= LOGIN =========================*/
$app->post('/login', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    

$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));    
$email = $api->cleanInputs($request->getParam('email'));
$password = $api->cleanInputs($request->getParam('password'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($email)):$msg = "No email provided!";array_push($errors,$msg);else:endif;
if(empty($password)):$msg = "No password provided!";array_push($errors,$msg);else:endif;
if(!filter_var($email,FILTER_VALIDATE_EMAIL) && !empty($email)):$msg = "invalid email supplied!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$login = $api->LogIn($email,$password);
if($login == true):
$id = $api->getuserdetailsByEmail($email);    
return json_encode(['status'=>200,"response"=>"OK","data"=>$id]);
else:
$msg = "invalid login credentials";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= LOGIN ENDS =========================*/

/*========================= REGISTER =========================*/
$app->post('/register', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    

$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$fullname = $api->cleanInputs($request->getParam('fullname'));
$phone = $api->cleanInputs($request->getParam('phone'));
$email = $api->cleanInputs($request->getParam('email'));
$password = $api->cleanInputs($request->getParam('password'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($fullname)):$msg = "No Fullname provided!";array_push($errors,$msg);else:endif;
if(empty($email)):$msg = "No email provided!";array_push($errors,$msg);else:endif;
if(empty($password)):$msg = "No password provided!";array_push($errors,$msg);else:endif;
if(!filter_var($email,FILTER_VALIDATE_EMAIL) && !empty($email)):$msg = "invalid email supplied!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfEmailExists($email) == true):$msg ="email already exist!"; array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$signup = $api->signup($fullname,$email,$password,$phone);
if($signup == true):
$id = $api->getuserdetailsByEmail($email);    
return json_encode(['status'=>200,"response"=>"OK","data"=>$id]);
else:
$msg = "signup failed!";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= REGISTER ENDS =========================*/

/*========================= personal details =========================*/
$app->post('/user/personal-details', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    

$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$userid = $api->cleanInputs($request->getParam('userId'));
$name = $api->cleanInputs($request->getParam('name'));
$email = $api->cleanInputs($request->getParam('email'));
$phone = $api->cleanInputs($request->getParam('phone'));
$address = $api->cleanInputs($request->getParam('address'));
$dob = $api->cleanInputs($request->getParam('dateOfBirth'));
$website = $api->cleanInputs($request->getParam('website'));
$image = $api->cleanInputs($request->getParam('profilePicture'));
$tracker = rand().time();


if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($name)):$msg = "No name provided!";array_push($errors,$msg);else:endif;
if(empty($email)):$msg = "No email provided!";array_push($errors,$msg);else:endif;
if(empty($userid)):$msg = "No user id provided!";array_push($errors,$msg);else:endif;
if(!filter_var($email,FILTER_VALIDATE_EMAIL) && !empty($email)):$msg = "invalid email supplied!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfKeyExists($tracker) == true):$msg ="cv already exist!"; array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
if(empty($image)):
$file = '';    
else:
$folderPath = "images/";
$image_parts = explode(";base64,", $image);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$file = $folderPath . rand().time() . '.png';
file_put_contents($file, $image_base64);    
endif;    
$pdetails = $api->personalDetails($tracker,$userid,$name,$email,$address,$phone,$dob,$website,$file);
if($pdetails == true):
$pd = $api->getpdetailsByKey($tracker);
return json_encode(['status'=>200,"response"=>"OK","data"=>$pd]);
else:
$msg = "fail to fetch response!";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= personal details ends =========================*/


/*========================= education =========================*/
$app->post('/user/personal-details/education', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getParam('personalDetailsId'));
$course = $api->cleanInputs($request->getParam('course'));
$school = $api->cleanInputs($request->getParam('school'));
$grade = $api->cleanInputs($request->getParam('grade'));
$year = $api->cleanInputs($request->getParam('year'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($course)):$msg = "No course provided!";array_push($errors,$msg);else:endif;
if(empty($grade)):$msg = "No grade provided!";array_push($errors,$msg);else:endif;
if(empty($school)):$msg = "No school provided!";array_push($errors,$msg);else:endif;
if(empty($year)):$msg = "No year provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
if($api->checkIfEduExists($pid,$school,$year) == true):$msg = "data already exists!";array_push($errors,$msg);else:endif;


if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$edu = $api->education($pid,$course,$grade,$year,$school);
if($edu == true):
$edudetails = $api->geteduBypid($pid,$school,$year);    
return json_encode(['status'=>200,"response"=>"OK","data"=>$edudetails]);
else:
$msg = "fail to fetch response!";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= education ENDS =========================*/

/*========================= experience =========================*/
$app->post('/user/personal-details/experience', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getParam('personalDetailsId'));
$companyName = $api->cleanInputs($request->getParam('companyName'));
$jobTitle = $api->cleanInputs($request->getParam('jobTitle'));
$startDate = $api->cleanInputs($request->getParam('startDate'));
$endDate = $api->cleanInputs($request->getParam('endDate'));
$details = $api->cleanInputs($request->getParam('details'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($companyName)):$msg = "company name field empty!";array_push($errors,$msg);else:endif;
if(empty($jobTitle)):$msg = "No job title provided!";array_push($errors,$msg);else:endif;
if(empty($startDate)):$msg = "start date field empty!";array_push($errors,$msg);else:endif;
if(empty($endDate)):$msg = "end date field empty!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
if($api->checkIfExperienceExists($pid,$companyName,$jobTitle,$startDate) == true):$msg = "this data already exists!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$edu = $api->experience($pid,$companyName,$jobTitle,$startDate,$endDate,$details);
if($edu == true):
$expdetails = $api->getexperienceBypid($pid,$companyName,$jobTitle,$startDate);//  you can work in a company twice with same role but not same start date    
return json_encode(['status'=>200,"response"=>"OK","data"=>$expdetails]);
else:
$msg = "fail to fetch response!";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= education ENDS =========================*/

/*========================= skills =========================*/
$app->post('/user/personal-details/skills', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getParam('personalDetailsId'));
$skills = $api->cleanInputs($request->getParam('skills'));
$level = $api->cleanInputs($request->getParam('level'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($skills)):$msg = "skill field empty!";array_push($errors,$msg);else:endif;
if(empty($level)):$msg = "No skill level provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
if($api->checkIfSkillsExists($pid,$skills) == true):$msg = "skill already added!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$edu = $api->skills($pid,$skills,$level);
if($edu == true):
$expdetails = $api->getskills($pid,$skills);    
return json_encode(['status'=>200,"response"=>"OK","data"=>$expdetails]);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= skills ENDS =========================*/

/*========================= objective =========================*/
$app->post('/user/personal-details/objective', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getParam('personalDetailsId'));
$objective = $api->cleanInputs($request->getParam('objective'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($objective)):$msg = "objective field empty!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
if($api->checkIfObjectiveExists($pid,$objective) == true):$msg = "objective already exists!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$myobj = $api->objective($pid,$objective);
if($myobj == true):
$objdetails = $api->getobjective($pid,$objective);    
return json_encode(['status'=>200,"response"=>"OK","data"=>$objdetails]);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= objective ENDS =========================*/

/*========================= reference =========================*/
$app->post('/user/personal-details/reference', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getParam('personalDetailsId'));
$refname = $api->cleanInputs($request->getParam('refereeName'));
$jobTitle = $api->cleanInputs($request->getParam('jobTitle'));
$companyName = $api->cleanInputs($request->getParam('companyName'));
$email = $api->cleanInputs($request->getParam('email'));
$phone = $api->cleanInputs($request->getParam('phone'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($refname)):$msg = "reference name field empty!";array_push($errors,$msg);else:endif;
if(empty($jobTitle)):$msg = "job title field empty!";array_push($errors,$msg);else:endif;
if(empty($companyName)):$msg = "company name field empty!";array_push($errors,$msg);else:endif;
if(empty($email)):$msg = "email field empty!";array_push($errors,$msg);else:endif;
if(empty($phone)):$msg = "phone field empty!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
if($api->checkIfreferenceExists($pid,$refname) == true):$msg = "referee name already exists!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$ref = $api->reference($pid,$refname,$jobTitle,$companyName,$email,$phone);
if($ref == true):
$refdetails = $api->getreference($pid,$refname);    
return json_encode(['status'=>200,"response"=>"OK","data"=>$refdetails]);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= reference ENDS =========================*/

/*========================= projects =========================*/
$app->post('/user/personal-details/projects', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getParam('personalDetailsId'));
$title = $api->cleanInputs($request->getParam('title'));
$description = $api->cleanInputs($request->getParam('description'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($title)):$msg = "title field empty!";array_push($errors,$msg);else:endif;
if(empty($description)):$msg = "description field empty!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
if($api->checkIfprojectExists($pid,$title) == true):$msg = "title already exists!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$project = $api->project($pid,$title,$description);
if($project == true):
$projdetails = $api->getproject($pid,$title);    
return json_encode(['status'=>200,"response"=>"OK","data"=>$projdetails]);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= project ENDS =========================*/
    












