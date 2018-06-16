<?php
	class Votes {
        
        private $voteid;
        private $question;
        private $deadline;
        private $owner;

        
         public function getVoteId()
        {
            return $this->voteid;
        }

 
        public function setVoteId($tasksid)
        {
            $this->voteid = $voteid;
        }
        
		
       public function getQuestion()
        {
            return $this->question;
        }

 
        public function setQuestion($question)
        {
            $this->question = $question;
        }
        
         public function getDescription()
        {
            return $this->description;
        }

 
        public function setDescription($description)
        {
            $this->description = $description;
        }
        
        
        public function getDeadline()
        {
            return $this->deadline;
        }

 
        public function setDeadline($deadline)
        {
            $this->deadline = $deadline;
        }
          
        public function getOwner()
        {
            return $this->owner;
        }

 
        public function setOwner($owner)
        {
            $this->owner = $owner;
        }
        
       



        
		public function addPoll(){
            

$conn = Db::getInstance();
	         $usersid = $_SESSION['usersID'];
  
        $statement = $conn->prepare("INSERT INTO voting (question, description, deadline, owner) VALUES (:question, :description, :deadline, :usersid);");
        $statement -> bindValue(":question", $this->getQuestion());
        $statement -> bindValue(":description", $this->getDescription());
        $statement -> bindValue(":deadline", $this->getDeadline());
        $statement -> bindValue(":usersid", $this->getOwner());
       

        $statement->execute();
            
		}
        
        
        public function updatePoll(){
            

$conn = Db::getInstance();
	    
  
        $statement = $conn->prepare("UPDATE voting SET question = :question, description = :description, deadline = :deadline, owner = :owner WHERE voteid = :voteid");
                  $statement -> bindValue(":voteid", $_GET['id']);
        $statement -> bindValue(":question", $this->getQuestion());
        $statement -> bindValue(":description", $this->getDescription());
        $statement -> bindValue(":deadline", $this->getDeadline());
        $statement -> bindValue(":owner", $this->getOwner());
       

        $statement->execute();
            
		}
        
        
        
        
         public function removeVote($votesid){
              
$conn = Db::getInstance();
        $statement = $conn->prepare("DELETE FROM voting WHERE voteid = :voteid");
        $statement->bindValue(':voteid', $votesid);
       $statement->execute();
    }

    public function getVotings()
    {
$conn = Db::getInstance();
  $usersid = $_SESSION['usersID'];
        $statement = $conn->prepare("SELECT * FROM voting WHERE deadline >= CURDATE() ORDER BY deadline asc");
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
    }
        
        public function getSinglePoll()
    {
$conn = Db::getInstance();
      
        
        $statement = $conn->prepare("SELECT * FROM voting WHERE voteid = :voteid");
               $statement->bindValue(":voteid", $_GET['id']);

        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
    }
        
        
        

       // LISTS FILTER 
    public function getListTasks()
    {
$conn = Db::getInstance();
  $usersid = $_SESSION['usersID'];
        $statement = $conn->prepare("SELECT * FROM tasks WHERE owner = :usersid and parentlist = :parentlist ORDER BY deadline asc");
        $statement -> bindValue(":usersid",  $usersid);
          $statement -> bindValue(":parentlist",  $_GET['name']);
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
    }
        
        // FOLLOW FILTER
         public function getForeignTasks()
    {
$conn = Db::getInstance();
        $statement = $conn->prepare("SELECT * FROM tasks WHERE parentlist = :parentlist ORDER BY deadline asc");
          $statement -> bindValue(":parentlist",  $_GET['name']);
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
    }
        
        
        // PERMISSION TASK MANIPULATION
             public function getOwnership()
    {
$conn = Db::getInstance();
             
        $usersid = $_SESSION['usersID'];
        $taskid = $_GET['id'];
        $statement = $conn->prepare("SELECT tasksID FROM tasks WHERE tasksID = :tasksID and owner = :owner");
        $statement->bindValue(':tasksID', $taskid);  
        $statement->bindValue(':owner', $usersid);  
        $statement->execute();

        $result = $statement->fetchAll();
    
     
        if (!empty($result[0]['tasksID'])) {
        return $result[0]['tasksID'];
            } else {
            return false;
        }
    }
        
              // COURSE FILTER 
    public function getCourseTasks()
    {
$conn = Db::getInstance();
  $usersid = $_SESSION['usersID'];
        $statement = $conn->prepare("SELECT * FROM tasks WHERE usersid = :usersid and course = :course ORDER BY deadline asc");
        $statement -> bindValue(":usersid",  $usersid);
          $statement -> bindValue(":course",  $_GET['name']);
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
    }
		
		
      public function deleteTask($tasksid)
    {
        $conn = Db::getInstance();;
        $statement = $conn->prepare("DELETE FROM tasks WHERE tasksID = :tasksID");
        $statement->bindValue(':tasksID', $tasksid);
       $statement->execute();
    }  
	     
    public function deleteTasks($parentlist)
    {
        $conn = Db::getInstance();;
        $statement = $conn->prepare("DELETE FROM tasks WHERE parentlist = :parentlist");
        $statement->bindValue(':parentlist', $parentlist);
       $statement->execute();
    }
        
          public function updateTask()
    {
  $conn = Db::getInstance();;
   
        $statement = $conn->prepare("UPDATE tasks SET taskname = :taskname, course = :course, deadline = :deadline, worktime = :worktime, owner = :owner, parentlist = :parentlist WHERE tasksID = :tasksid");
                   $statement -> bindValue(":tasksid", $_GET['id']);
     $statement -> bindValue(":taskname", $this->getTaskName());
        $statement -> bindValue(":course", $this->getCourse());
        $statement -> bindValue(":deadline", $this->getDeadline());
        $statement->bindValue(":worktime", $this->getWorkTime());
              $statement -> bindValue(":owner", $this->getOwner());
        $statement -> bindValue(":parentlist", $this->getParentList());

        $statement->execute();
    
    }
        
          // CHECKBOX - DEADLINE STATE
        
        public function setDone($taskid){
             $conn = Db::getInstance();;
            
            $state = "1";
               $statement = $conn->prepare("UPDATE tasks SET state = :state WHERE tasksID = :tasksid");
               $statement -> bindValue(":state", $state );
            $statement -> bindValue(":tasksid", $taskid);
              $statement->execute();
            
        }
        
          public function setUndone($taskid){
             $conn = Db::getInstance();;
            
            $state = "0";
               $statement = $conn->prepare("UPDATE tasks SET state = :state WHERE tasksID = :tasksid");
               $statement -> bindValue(":state", $state );
            $statement -> bindValue(":tasksid", $taskid);
              $statement->execute();
            
        }
        
          //  GET TOTAL WORKTIME
        public function getHours(){
    
   
      $conn = Db::getInstance();
      

        $statement = $conn->prepare("SELECT SUM(worktime) AS totalwork FROM tasks WHERE owner = :usersid;");
                 $statement -> bindValue(":usersid", $this->getUsersID);
        $statement->execute();

        $result = $statement->fetchAll();
        $sumhours = $result[0]['totalwork'];
        return $sumhours;
}
        
// CHECK IF DONE
           public function checkState($taskid){
    
   
      $conn = Db::getInstance();
      

        $statement = $conn->prepare("SELECT state FROM tasks WHERE tasksID = :taskid;");
        $statement -> bindValue(":taskid", $taskid);
        $statement->execute();

        $result = $statement->fetchAll();
            $currentstate = $result[0]['state'];
     return $currentstate;
}
        
      
        
        
  
        
        
    }






?>