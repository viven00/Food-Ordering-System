<?php

class UserProfile
{
    private $profileID;
    private $profileName;
    private $status;
    private $conn = NULL;
    
    function __construct()
    {
        include("config.php");
        $this->conn = $conn;
    }

    public function getProfile($profileID)
    {
        $sql = "SELECT profileName FROM userprofile WHERE profileID = $profileID";
        $qRes = @$this->conn->query($sql);

        if ($qRes == TRUE) 
        {
            $row = $qRes -> fetch_assoc();
            return $row ['profileName'];
        } 
        else 
        {
            return failure_alert("user profile does not exist");
        }
    }

    public function fetchProfileData ($status)
    {
        $profileArr = array();  
        $sql = "SELECT profileID, profileName FROM userprofile WHERE status = '$status'";
        $qRes = @$this->conn->query($sql);

        while ($row = $qRes -> fetch_assoc())
        {
            $profileArr[$row['profileID']] = $row["profileName"];
        }
        

        return $profileArr;
    }

    public function modifyProfileStatus($profileID, $status)
    {
        $sql = "UPDATE userprofile SET status ='$status' WHERE profileID = $profileID";
        $qRes = @$this->conn->query($sql);

        if ($qRes === TRUE) 
        {
            return $validateAction = true;
        } 
        else 
        {
            return $validateAction = false;
        }
    }

    public function getAllUserProfile()
    {
        $profileArr = array();  
        $sql = "SELECT * FROM userprofile";
        $qRes = @$this->conn->query($sql);

        while ($row = $qRes -> fetch_assoc())
        {
            $profileArr[$row['profileID']] = $row["profileName"];
        }

        return $profileArr;
    }

    public function getAllUserProfiles()
    {
        $profileArr = array();

        $sql = "SELECT * FROM userprofile";
        $qRes = @$this->conn->query($sql);
        
        while ($row = $qRes->fetch_assoc()) {
            $profileArr[] = $row;
        }

        /*
        while ($row = $qRes->fetch_assoc()) {
            $profileArr[$row['profileID']] = $row["profileName"];
        }
        */

        return $profileArr;
    }

    public function addUserProfile($userProfile)
    {
        $sql = "INSERT INTO userprofile (profileName, status) VALUES ('$userProfile', 'Active')";
       
        $queryResult = @$this->conn->query($sql);
        if ($queryResult === TRUE)
        {
            return $validation = true;
        } 
        else
        {
            return $validation = false;
        }
    }

    public function modifyUserProfile($oldUserProfileID, $newUserProfile)
    {
        $sql = "UPDATE userprofile SET profileName = '$newUserProfile' WHERE profileID = $oldUserProfileID";

        $queryResult = @$this->conn->query($sql);
        if ($queryResult === TRUE)
        {
            return $validation = true;
        } 
        else
        {
            return $validation = false;
        }
    }

    public function checkDuplicateProfileName($profileName)
    {
        $sql = "SELECT * FROM userprofile WHERE profileName='$profileName'";
        $qRes = @$this->conn->query($sql);
        if (mysqli_num_rows($qRes) == 0) 
        {
            return $checkProfileName = true;
        } 
        else 
        {
            return $checkProfileName = false;
        }
    }

    public function searchProfile($profileID, $profileName, $status)
    {
        $sql = "SELECT * FROM userprofile WHERE profileID IS NOT NULL ";

        if ($profileID != null)
        {
            $sql .= "AND profileID = '$profileID' ";
        }
        if ($profileName != null)
        {
            $sql .= "AND profileName LIKE '%$profileName%' ";
        }
        if ($status != null)
        {
            $sql .= "AND status LIKE '%$status%' ";
        }

        $result = @$this->conn->query($sql);
        return $result;
    }

    public function checkStatus($profileID, $status)
    {
        $sql = "SELECT * FROM userprofile WHERE profileID = $profileID";
        $qRes = @$this->conn->query($sql);
        $Row = mysqli_fetch_assoc($qRes);

        $getStatus = $Row['status'];
        if (($getStatus == $status))
        {
            return $checkStatus = true;
        }
        else
        {
            return $checkStatus = false;
        }

    }

    public function getProfileName($profileID)
    {
        $sql = "SELECT * FROM userprofile WHERE profileID = $profileID";
        $qRes = @$this->conn->query($sql);
        $Row = mysqli_fetch_assoc($qRes);

        $profileName = $Row['profileName'];
        return $profileName;
    }

}
