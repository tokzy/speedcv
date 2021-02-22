<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$url = "https://speedcv.net/public";

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

/*========================= RESET PASSWORDS =========================*/
$app->post('/user/password/reset', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    

$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));    
$email = $api->cleanInputs($request->getParam('email'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($email)):$msg = "No email provided!";array_push($errors,$msg);else:endif;
if($api->checkIfEmailExists($email) == false):$msg ="email does not exist!"; array_push($errors,$msg);else:endif;
if(!filter_var($email,FILTER_VALIDATE_EMAIL) && !empty($email)):$msg = "invalid email supplied!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$code = $api->Code(5);    
$save = $api->resetCode($email,$code);

endif;
});
/*========================= RESET PASSWORD ENDS =========================*/

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
$file =  rand().time() . '.png';
file_put_contents($folderPath .''.$file, $image_base64);    
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
/*========================= experience ENDS =========================*/

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


/*========================= Headings =========================*/
$app->get('/sections/{apiKey}/{secretKey}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getAttribute('apiKey');    
$secretkeys = $request->getAttribute('secretKey');  

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$fetch = $api->fetchHeadings();
if($fetch == true):    
return json_encode($fetch);
elseif(count($fetch) <= 0):
return json_encode($fetch);
else: 
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Headings ENDS =========================*/
/*========================= Create Headings =========================*/
$app->post('/sections/create', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getParam('apiKey');    
$secretkeys = $request->getParam('secretKey');  
$title = $api->cleanInputs($request->getParam('title'));
$pid = $api->cleanInputs($request->getParam('personalDetailsId'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($title)):$msg = "No title field provided!";array_push($errors,$msg);else:endif;
if($api->checkIfTitleExists($title,$pid) == true):$msg = "title already exists!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$create = $api->CreateHeading($title,$pid);
$get = $api->getsectionBytitle($title,$pid)['id'];    
if($create == true):    
return json_encode(['status'=>200,'response'=>"success",'id' =>$get]);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Create Headings ENDS =========================*/

/*========================= Edit Headings =========================*/
$app->put('/sections/edit/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$id = $api->cleanInputs($request->getAttribute('id'));
$title = $api->cleanInputs($request->getParam('title'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($title)):$msg = "No title field provided!";array_push($errors,$msg);else:endif;
if($api->checkIfTitleIdExists($id) == false):$msg = "id doesn't exist!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$edit = $api->editHeading($id,$title);    
if($edit == true):    
return json_encode(['status'=>200,'response'=>"success"]);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Edit Heading ENDS =========================*/

/*========================= Delete Headings =========================*/
$app->delete("/sections/delete/{id}", function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$id = $api->cleanInputs($request->getAttribute('id'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if($api->checkIfTitleIdExists($id) == false):$msg = "id doesn't exist!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$delete = $api->DeleteHeading($id);    
if($delete == true):    
return json_encode(['status'=>200,'response'=>"success"]);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Delete Heading ENDS =========================*/

/*========================= Miscellaneous =========================*/
$app->post("/user/personal-details/miscellaneous", function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getParam('apiKey');    
$secretkeys = $request->getParam('secretKey');  
$id = $api->cleanInputs($request->getParam('headerId'));
$pid = $api->cleanInputs($request->getParam('personalDetailsId'));
$value = $api->cleanInputs($request->getParam('value'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No id provided!";array_push($errors,$msg);else:endif;
if(empty($value)):$msg = "No value provided!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
if($api->checkIfTitleIdExists($id) == false):$msg = "id doesn't exist!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$create = $api->CreateMiscellaneous($id,$pid,$value);    
if($create == true):    
return json_encode(['status'=>200,'response'=>"success"]);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Miscellaneous ENDS =========================*/


/*========================= Templates Listing =========================*/
$app->get("/user/template-lists/{apiKey}/{secretKey}", function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getAttribute('apiKey');    
$secretkeys = $request->getAttribute('secretKey');  

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$fetch = $api->fetchTemplates();    

if($fetch == true):    
return json_encode($fetch);
elseif(count($fetch) <= 0):
return json_encode($fetch);
else: 
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Templates lists ENDS =========================*/

/*========================= Create and get pdf =========================*/
$app->post("/user/generatepdf", function (Request $request, Response $response,array $args) {
$baseurl = "https://speedcv.net/public";    
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getParam('apiKey');    
$secretkeys = $request->getParam('secretKey');  
$pid = $request->getParam('personalDetailsId');  
$tmpid = $request->getParam('templateId');  

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
if($api->checkIftempIdExists($tmpid) == false && !empty($pid)):$msg = "invalid template id!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$name = rand().'.pdf';
$command = "wkhtmltopdf ".$baseurl."/templates/cv".$tmpid.".php?pid=".$pid." ./genpdf/".$name." 2>&1";
$generate = shell_exec($command);
$udetails = $api->getpd($pid);
$path = $baseurl."/genpdf/".$name."";
$store = $api->StorePdf($udetails['user_id'],$path);
return json_encode(["status"=>200, "path" => $path]);
exit;
//else:
//$msg = "fail to fetch response or something went wrong!";
//array_push($errors,$msg);
//return json_encode(["status"=>400, "error" => $errors]);    
//endif;
endif;
});
/*========================= Create and get pdf ENDS =========================*/

/*========================= Get Personal Details =========================*/
$app->get('/user/personal-details/fetch/{personalDetailsId}/{apiKey}/{secretKey}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getAttribute('apiKey');    
$secretkeys = $request->getAttribute('secretKey'); 
$pid = $request->getAttribute('personalDetailsId'); 

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$fetch = $api->getpd($pid);
if($fetch == true):    
return json_encode(['status'=>200,'data'=>$fetch]);
elseif(count($fetch) <= 0):
return json_encode($fetch);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Get Personal Details ENDS =========================*/

/*========================= Edit Personal Details =========================*/
$app->put('/user/personal-details/edit/{personalDetailsId}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getParam('apiKey');    
$secretkeys = $request->getParam('secretKey'); 
$pid = $request->getAttribute('personalDetailsId'); 
$name = $api->cleanInputs($request->getParam('name'));
$email = $api->cleanInputs($request->getParam('email'));
$phone = $api->cleanInputs($request->getParam('phone'));
$address = $api->cleanInputs($request->getParam('address'));
$dob = $api->cleanInputs($request->getParam('dateOfBirth'));
$website = $api->cleanInputs($request->getParam('website'));
$image = $api->cleanInputs($request->getParam('profilePicture'));

$details = $api->getpd($pid);

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($name)):$msg = "No name provided!";array_push($errors,$msg);else:endif;
if(empty($email)):$msg = "No email provided!";array_push($errors,$msg);else:endif;
if(!filter_var($email,FILTER_VALIDATE_EMAIL) && !empty($email)):$msg = "invalid email supplied!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(empty($image)):    
$file = $details['profile'];    
else:
$folderPath = "images/";
$image_parts = explode(";base64,", $image);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$file = rand().time() . '.png';
$oldImage = "./images/".$details['profile'];
if(file_exists($oldImage)): unlink($oldImage);endif;
file_put_contents($folderPath.''.$file, $image_base64);    
endif;    

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$peditdetails = $api->UpdatepersonalDetails($pid,$name,$email,$address,$phone,$dob,$website,$file);
if($peditdetails == true):    
return json_encode(['status'=>200,'response'=>'OK']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Edit Personal Details ENDS =========================*/

/*========================= Get Education Details =========================*/
$app->get('/user/education/fetch/{personalDetailsId}/{apiKey}/{secretKey}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getAttribute('apiKey');    
$secretkeys = $request->getAttribute('secretKey'); 
$pid = $request->getAttribute('personalDetailsId'); 

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$fetch = $api->getAllEduBypid($pid);
if($fetch == true):    
return json_encode($fetch);
elseif(count($fetch) <= 0):
return json_encode($fetch);
else: 
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Get Education Details ENDS =========================*/

/*========================= Edit education =========================*/
$app->put('/user/education/edit/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey')); 
$id = $api->cleanInputs($request->getAttribute('id'));
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));
$course = $api->cleanInputs($request->getParam('course'));
$school = $api->cleanInputs($request->getParam('school'));
$grade = $api->cleanInputs($request->getParam('grade'));
$year = $api->cleanInputs($request->getParam('year'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No id provided!";array_push($errors,$msg);else:endif;
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
$upedu = $api->UpdateEducation($pid,$id,$course,$grade,$year,$school);
if($upedu == true):    
return json_encode(['status'=>200,"response"=>"success"]);
else:
$msg = "fail to fetch response!";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Edit education ENDS =========================*/

/*========================= Delete Education Details =========================*/
$app->delete('/user/education/delete/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getParam('apiKey');    
$secretkeys = $request->getParam('secretKey'); 
$pid = $request->getAttribute('personalDetailsId'); 
$id = $request->getAttribute('id'); 

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No education section id provided!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$fetch = $api->deleteEdu($pid,$id);
if($fetch == true):    
return json_encode(['status' => 200, 'response' => 'success']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Get Education Details ENDS =========================*/

/*========================= Get experience =========================*/
$app->get('/user/experience/fetch/{personalDetailsId}/{apiKey}/{secretKey}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getAttribute('apiKey'));    
$secretkeys = $api->cleanInputs($request->getAttribute('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$getedu = $api->getExperience($pid);
if($getedu == true):   
return json_encode($getedu);
elseif(count($getedu) <= 0):
return json_encode($getedu);
else: 
$msg = "fail to fetch response!";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================== Get Experience ENDS =========================*/

/*========================= Edit experience =========================*/
$app->put('/user/experience/edit/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));
$id = $api->cleanInputs($request->getAttribute('id'));
$companyName = $api->cleanInputs($request->getParam('companyName'));
$jobTitle = $api->cleanInputs($request->getParam('jobTitle'));
$startDate = $api->cleanInputs($request->getParam('startDate'));
$endDate = $api->cleanInputs($request->getParam('endDate'));
$details = $api->cleanInputs($request->getParam('details'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$getexp = $api->UpdateExperience($pid,$id,$companyName,$jobTitle,$startDate,$endDate,$details);
if($getexp == true):   
return json_encode(['status'=>200,"response"=>"success"]);
else:
$msg = "fail to fetch response!";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================== Get Experience ENDS =========================*/

/*========================= Delete Experience Details =========================*/
$app->delete('/user/experience/delete/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getParam('apiKey');    
$secretkeys = $request->getParam('secretKey'); 
$pid = $request->getAttribute('personalDetailsId'); 
$id = $request->getAttribute('id'); 

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No experience section id provided!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$fetch = $api->deleteExperience($pid,$id);
if($fetch == true):    
return json_encode(['status' => 200, 'response' => 'success']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Delete Experience ENDS =========================*/

/*========================= Get skills =========================*/
$app->get('/user/skills/fetch/{personalDetailsId}/{apiKey}/{secretKey}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getAttribute('apiKey'));    
$secretkeys = $api->cleanInputs($request->getAttribute('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$skills = $api->getAllSkills($pid);
if($skills == true):    
return json_encode($skills);
elseif(count($skills) <= 0):
return json_encode($skills);
else: 
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Get skills ENDS =========================*/

/*========================= Edit skills =========================*/
$app->put('/user/skills/edit/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));
$id = $api->cleanInputs($request->getAttribute('id'));
$skills = $api->cleanInputs($request->getParam('skills'));
$level = $api->cleanInputs($request->getParam('level'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No id provided!";array_push($errors,$msg);else:endif;
if(empty($skills)):$msg = "skill field empty!";array_push($errors,$msg);else:endif;
if(empty($level)):$msg = "No skill level provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$editskills = $api->UpdateSkills($pid,$id,$skills,$level);
if($editskills == true):
return json_encode(['status'=>200,"response"=>"OK"]);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= skills ENDS =========================*/

/*========================= Delete Skills =========================*/
$app->delete('/user/skills/delete/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getParam('apiKey');    
$secretkeys = $request->getParam('secretKey'); 
$pid = $request->getAttribute('personalDetailsId'); 
$id = $request->getAttribute('id'); 

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No skills section id provided!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$deleteskills = $api->deleteSkills($pid,$id);
if($deleteskills == true):    
return json_encode(['status' => 200, 'response' => 'success']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Delete Skills ENDS =========================*/

/*========================= Get objective =========================*/
$app->get('/user/objective/fetch/{personalDetailsId}/{apiKey}/{secretKey}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getAttribute('apiKey'));    
$secretkeys = $api->cleanInputs($request->getAttribute('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$getobj = $api->getAllobjective($pid);
if($getobj == true):
return json_encode($getobj);
elseif(count($getobj) <= 0):
return json_encode($getobj);
else: 
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Get objective ENDS =========================*/

/*========================= Edit objective =========================*/
$app->put('/user/objective/edit/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));
$id = $api->cleanInputs($request->getAttribute('id'));
$objective = $api->cleanInputs($request->getParam('objective'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No id provided!";array_push($errors,$msg);else:endif;
if(empty($objective)):$msg = "objective field empty!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$myobj = $api->Updateobjective($pid,$id,$objective);
if($myobj == true):    
return json_encode(['status'=>200,"response"=>"OK"]);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= objective ENDS =========================*/

/*========================= Delete objective =========================*/
$app->delete('/user/objective/delete/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getParam('apiKey');    
$secretkeys = $request->getParam('secretKey'); 
$pid = $request->getAttribute('personalDetailsId'); 
$id = $request->getAttribute('id'); 

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No objective section id provided!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$deleteskills = $api->deleteObjective($pid,$id);
if($deleteskills == true):    
return json_encode(['status' => 200, 'response' => 'success']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Delete objective ENDS =========================*/


/*========================= Get reference =========================*/
$app->get('/user/reference/fetch/{personalDetailsId}/{apiKey}/{secretKey}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getAttribute('apiKey'));    
$secretkeys = $api->cleanInputs($request->getAttribute('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$ref = $api->getAllreference($pid);
if($ref == true):    
return json_encode($ref);
elseif(count($ref) <= 0):
return json_encode($ref);
else: 
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Get reference ENDS =========================*/

/*========================= Edit reference =========================*/
$app->put('/user/reference/edit/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));
$id = $api->cleanInputs($request->getAttribute('id'));
$refname = $api->cleanInputs($request->getParam('refereeName'));
$jobTitle = $api->cleanInputs($request->getParam('jobTitle'));
$companyName = $api->cleanInputs($request->getParam('companyName'));
$email = $api->cleanInputs($request->getParam('email'));
$phone = $api->cleanInputs($request->getParam('phone'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No id provided!";array_push($errors,$msg);else:endif;
if(empty($refname)):$msg = "reference name field empty!";array_push($errors,$msg);else:endif;
if(empty($jobTitle)):$msg = "job title field empty!";array_push($errors,$msg);else:endif;
if(empty($companyName)):$msg = "company name field empty!";array_push($errors,$msg);else:endif;
if(empty($email)):$msg = "email field empty!";array_push($errors,$msg);else:endif;
if(empty($phone)):$msg = "phone field empty!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$ref = $api->Updatereference($pid,$id,$refname,$jobTitle,$companyName,$email,$phone);
if($ref == true):    
return json_encode(['status'=>200,'response'=>'success']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Edit reference ENDS =========================*/

/*========================= Delete reference =========================*/
$app->delete('/user/reference/delete/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));
$id = $api->cleanInputs($request->getAttribute('id'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$deleteref = $api->deleteReference($pid,$id);
if($deleteref == true):    
return json_encode(['status' => 200, 'response' => 'success']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Delete reference ENDS =========================*/

/*========================= Get projects =========================*/
$app->get('/user/projects/fetch/{personalDetailsId}/{apiKey}/{secretKey}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getAttribute('apiKey'));    
$secretkeys = $api->cleanInputs($request->getAttribute('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$project = $api->getAllproject($pid);
if($project == true):    
return json_encode($project);
elseif(count($project) <= 0):
return json_encode($project);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Get project ENDS =========================*/

/*========================= Edit Projects =========================*/
$app->put('/user/projects/edit/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));
$id = $api->cleanInputs($request->getAttribute('id'));
$title = $api->cleanInputs($request->getParam('title'));
$description = $api->cleanInputs($request->getParam('description'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No id provided!";array_push($errors,$msg);else:endif;
if(empty($title)):$msg = "title field empty!";array_push($errors,$msg);else:endif;
if(empty($description)):$msg = "description field empty!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$ref = $api->UpdateProject($pid,$id,$title,$description);
if($ref == true):    
return json_encode(['status'=>200,'response'=>'success']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Edit projects ENDS =========================*/

/*========================= Delete projects =========================*/
$app->delete('/user/projects/delete/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));
$id = $api->cleanInputs($request->getAttribute('id'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$deleteref = $api->deleteProject($pid,$id);
if($deleteref == true):    
return json_encode(['status' => 200, 'response' => 'success']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Delete Projects ENDS =========================*/

/*========================= Fetch Miscellaneous =========================*/
$app->get("/user/miscellaneous/fetch/{personalDetailsId}/{sectionId}/{apiKey}/{secretKey}", function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getAttribute('apiKey');    
$secretkeys = $request->getAttribute('secretKey');  
$sid = $api->cleanInputs($request->getAttribute('sectionId'));
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($sid)):$msg = "No section id provided!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
if($api->checkIfTitleIdExists($sid) == false):$msg = "section id doesn't exist!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$getmisc = $api->GetMiscellaneous($pid,$sid);    
if($getmisc == true):    
return json_encode($getmisc);
elseif(count($getmisc) <= 0):
return json_encode($getmisc);
else: 
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Fetch Miscellaneous ENDS =========================*/

/*========================= Edit Miscellaneous =========================*/
$app->put("/user/miscellaneous/edit/{personalDetailsId}/{id}", function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getParam('apiKey');    
$secretkeys = $request->getParam('secretKey');  
$id = $api->cleanInputs($request->getAttribute('id'));
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));
$value = $api->cleanInputs($request->getParam('value'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No section id provided!";array_push($errors,$msg);else:endif;
if(empty($value)):$msg = "No value provided!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$updatemisc = $api->UpdateMiscellaneous($id,$pid,$value);    
if($updatemisc == true):    
return json_encode(['status'=>200,'response'=>"success"]);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Edit Miscellaneous ENDS =========================*/

/*========================= Delete miscellaneous projects =========================*/
$app->delete('/user/miscellaneous/delete/{personalDetailsId}/{id}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getParam('apiKey'));    
$secretkeys = $api->cleanInputs($request->getParam('secretKey'));  
$pid = $api->cleanInputs($request->getAttribute('personalDetailsId'));
$id = $api->cleanInputs($request->getAttribute('id'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($pid)):$msg = "No personal details id provided!";array_push($errors,$msg);else:endif;
if(empty($id)):$msg = "No id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;
if($api->checkIfPidExists($pid) == false && !empty($pid)):$msg = "invalid personal details id!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$deleteref = $api->deleteMiscellaneous($pid,$id);
if($deleteref == true):    
return json_encode(['status' => 200, 'response' => 'success']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Delete Miscellaneous projects ENDS =========================*/

/*========================= Fetch User Cvs =========================*/
$app->get("/user/cv/fetch/{userId}/{apiKey}/{secretKey}", function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getAttribute('apiKey');    
$secretkeys = $request->getAttribute('secretKey');  
$uid = $api->cleanInputs($request->getAttribute('userId'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($uid)):$msg = "No user id provided!";array_push($errors,$msg);else:endif;
if($api->checkIfIdExists($uid) == false):$msg = "user id does not exists!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$getmisc = $api->GetUserCvs($uid);    
if($getmisc == true):    
return json_encode($getmisc);
elseif(count($getmisc) <= 0):
return json_encode($getmisc);
else:    
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Fetch User Cvs ENDS =========================*/

/*========================= Delete User Cvs =========================*/
$app->get("/user/cv/delete/{userId}", function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getParam('apiKey');    
$secretkeys = $request->getParam('secretKey');  
$uid = $api->cleanInputs($request->getAttribute('userId'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($uid)):$msg = "No user id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$getmisc = $api->deleteCvs($uid);    
if($getmisc == true):    
return json_encode(['status' => 200, 'response' => 'success']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Delete User Cvs ENDS =========================*/

/*========================= Get Pdf =========================*/
$app->get('/user/cv/fetchpdf/{userId}/{apiKey}/{secretKey}', function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $api->cleanInputs($request->getAttribute('apiKey'));    
$secretkeys = $api->cleanInputs($request->getAttribute('secretKey'));  
$uid = $api->cleanInputs($request->getAttribute('userId'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($uid)):$msg = "No user id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$getpdf = $api->getAllPdf($uid);
if($getpdf == true):   
return json_encode($getpdf);
elseif(count($getpdf) <= 0):
return json_encode($getpdf);
else: 
$msg = "fail to fetch response!";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================== Get Pdf ENDS =========================*/

/*========================= Delete User pdf =========================*/
$app->delete("/user/cv/pdf/delete/{id}", function (Request $request, Response $response,array $args) {
$api = new Apiclass();    
$errors = array();

$apikeys = $request->getParam('apiKey');    
$secretkeys = $request->getParam('secretKey');  
$uid = $api->cleanInputs($request->getAttribute('id'));

if(empty($apikeys)):$msg = "No api key provided!";array_push($errors,$msg);else:endif;
if(empty($secretkeys)):$msg = "No secret key provided!";array_push($errors,$msg);else:endif;
if(empty($uid)):$msg = "No user id provided!";array_push($errors,$msg);else:endif;
$checkkeys = $api->checkKeys($apikeys,$secretkeys);
if($checkkeys == false && !empty($apikeys) && !empty($secretkeys)):$msg = "Authentication failed, invalid api or secret keys!";array_push($errors,$msg);else:endif;

if(count($errors) > 0):
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
else:
$details = $api->getPdfByid($uid);
$path = $details['path'];       
$getmisc = $api->deletePdf($uid);    
//unlink($path);
if($getmisc == true):    
return json_encode(['status' => 200, 'response' => 'success']);
else:
$msg = "fail to fetch response";    
array_push($errors,$msg);
return json_encode(["status"=>400, "response"=>"error","errors"=>$errors]);
endif;
endif;
});
/*========================= Delete User Cvs ENDS =========================*/
