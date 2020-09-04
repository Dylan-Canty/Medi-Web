<?php

class Handler{

    private $database = "mediscreen";
    private $user = "root";
    private $password = "";
    private $server = "localhost";
    private $charset = "utf8";
    private $debug = "true";
    
    private function connect(){
        try{
            $dsn = "mysql:host=".$this->server.";dbname=".$this->database.";charset".$this->charset;
            
            $connection = new PDO($dsn, $this->user, $this->password);
            
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $connection;
        }catch(Exception $e){
            echo "Connection failed: ".$e->getMessage();
            die;
        }
    }
    
    private function query($query, $array){

        $query = str_replace('db.',$this->database.'.', $query);
        $run = $this->connect()->prepare($query);
        try{
            $run->execute($array);
            return $run;
        }catch(Exception $e){
            if($this->debug == "true"){
                echo "Connection failed: ".$e->getMessage();
                die;   
            }
            
        }
    }

    public function router(){
        
        if(isset($_POST['getPatients'])){
            $this->getPatients();
        }else if(isset($_POST['getRiskLevels'])){
            $this->getRiskLevels();
        }else if(isset($_POST['addPatient'])){
            $this->addPatient();
        }else if(isset($_POST['register'])){
            $this->register();
        }else if(isset($_POST['login'])){
            $this->login(false);
        }else if(isset($_POST['adminLogin'])){
            $this->login(true);
        }else if(isset($_POST['getUser'])){
            $this->getUser();
        }else if(isset($_POST['exportData'])){
            $this->exportData();
        }else if(isset($_POST['getCategoryRiskLevel'])){
            $this->getCategoryRiskLevel();
        }else if(isset($_POST['getChartData'])){
            $this->getChartData();
        }else if(isset($_POST['editInfo'])){
            $this->editInfo();
        }
    }

    function getUser(){
        @session_start();
        @$name = $_SESSION['name'];
        $message["name"] = $name;
        $message["okay"] = true;

        $this->respond($message);
    }
    
    function getPatients(){
        @session_start();

        if(isset($_SESSION['admin'])){
            $result = $this->query("select fname, lname, email, phone from db.patient p inner join db.patient_professional pp on pp.patient_id = p.id ",[]);
        }else{
            $p_id = $_SESSION['id'];
            $result = $this->query("select fname, lname, email, phone from db.patient p inner join db.patient_professional pp on pp.patient_id = p.id where pp.professional_id = ? ",[$p_id]);
        }

        $message = $result->fetchAll();
        
        $this->respond($message);
    }

    function getRiskLevels(){
        @session_start();
        if(isset($_SESSION['admin'])){
            $result = $this->query("select fname, lname, concat('', heart, '%') as heart, concat('', cancer, '%') as cancer, concat('', diabetes, '%') as diabetes from db.patient p inner join db.patient_professional pp on pp.patient_id = p.id",[]);
        }else{
            $p_id = $_SESSION['id'];
            $result = $this->query("select fname, lname, concat('', heart, '%') as heart, concat('', cancer, '%') as cancer, concat('', diabetes, '%') as diabetes from db.patient p inner join db.patient_professional pp on pp.patient_id = p.id where pp.professional_id = ? ",[$p_id]);
        }
        

        $message = $result->fetchAll();
        
        $this->respond($message);
    }

    function getCategoryRiskLevel(){
        
        $result = $this->query("select concat('', AVG(heart), '%') as heart, concat('', AVG(cancer), '%') as cancer, concat('', AVG(diabetes), '%') as diabetes from db.patient",[]);

        $row = $result->fetch();

        $message['heart'] = $row['heart'];
        $message['cancer'] = $row['cancer'];
        $message['diabetes'] = $row['diabetes'];
        
        @session_start();

        if($_SESSION['type'] == "insurance"){
            $message['okay'] = true;
        }else{
            $message['okay'] = false;
        }

        $this->respond($message);
    }

    function getChartData(){
        
        $result = $this->query("select AVG(heart) as heart, AVG(cancer) as cancer, AVG(diabetes) as diabetes from db.patient",[]);

        $row = $result->fetch();

        $message['heart'] = $row['heart'];
        $message['cancer'] = $row['cancer'];
        $message['diabetes'] = $row['diabetes'];
        
        @session_start();

        if($_SESSION['type'] == "insurance"){
            $message['okay'] = true;
        }else{
            $message['okay'] = false;
        }

        $this->respond($message);
    }

    function addPatient(){
        @session_start();
        
        $p_id = $_SESSION['id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $heart = $_POST['heart'];
        $cancer = $_POST['cancer'];
        $diabetes = $_POST['diabetes'];
        $index = md5(microtime());
        
        $this->query("insert into db.patient (id, fname, lname, email, phone, heart, cancer, diabetes) values (?,?,?,?,?,?,?,?)",
            [$index, $fname, $lname, $email, $phone, $heart, $cancer, $diabetes]);

        $this->query("insert into db.patient_professional (patient_id, professional_id) values (?,?)",[$index, $p_id]);

        header("Location: ../index.php");
    }

    function register(){
        @session_start();
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $type = $_POST['type'];
        $pass = $_POST['pass'];
        
        $this->query("insert into db.professional (fname, lname, email, phone, type, pass) values (?,?,?,?,?,?)",
            [$fname, $lname, $email, $phone, $type, password_hash($pass, PASSWORD_DEFAULT)]);
        
        header("Location: ../Login.php");
    }

    function login($admin){
        $email = $_POST['email'];
        $pass = $_POST['password'];
        
        $res = $this->query("select * from db.professional where email = ?",[$email]);

        if($res->rowCount() > 0){
            $row = $res->fetch();
            $id = $row['id'];
            $pass2 = $row['pass'];
            $name = $row['fname']." ".$row['lname'];
            $type = $row['type'];
            if(password_verify($pass, $pass2)){
                @session_start();
                $_SESSION['id'] = $id;
                $_SESSION['name'] = $name;
                $_SESSION['type'] = $type;
                if($admin){
                    $_SESSION['admin'] = "true";
                    header("Location: ../AdminDash.php");
                    die;
                }else{
                    header("Location: ../index.php");
                    die;
                }
            }else{
                header("Location: ../Login.php?err=Wrong Password"); 
            }
        }else{
            header("Location: ../Login.php?err=Email does not exist");
        }
    }
    
    function respond($message){
        echo json_encode($message);
    }

    function exportData(){
        
        $res = $this->query("select fname, lname, email, phone, heart, cancer, diabetes from db.patient",[]);
        
        $fileName = "data.csv";

        $file = fopen($fileName, "w");

        $str = "fname,lname,email,phone,heart,cancer,diabetes\n";
        fwrite($file, $str);
        while($row = $res->fetch()){
            
            $fname = $row['fname'];
            $lname = $row['lname'];
            $email = $row['email'];
            $phone = $row['phone'];
            $heart = $row['heart'];
            $cancer = $row['cancer'];
            $diabetes = $row['diabetes'];
            
            $str = "$fname,$lname,$email,$phone,$heart,$cancer,$diabetes\n";

            fwrite($file, $str);

        }
        
        fclose($file);

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.basename($fileName));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileName));
        header("Content-Type: text/plain");
        readfile($fileName);
    }

    function editInfo(){
        $id = $_POST['id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $this->query("update db.patient set fname = ?, lname = ?, email = ?, phone = ? where id = ?",[$fname, $lname, $email, $phone, $id]);

        header("Location: ../index.php");
    }
}

$handler = new Handler();

$handler->router();

?>