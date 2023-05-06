<?php

class User
{
    private $userID;
    private $username;
    private $password;
    private $name;
    private $email;
    private $phoneNumber;
    private $status;
    private $userProfile;
    private $conn = NULL;

    function __construct()
    {
        include("config.php");

        $this->conn = $conn;
    }
    

    public function getUserAccount($username, $password)
    {
        $sql = "SELECT * FROM user WHERE username ='$username' AND password ='$password'";
        $qRes = @$this->conn->query($sql);
        if (mysqli_num_rows($qRes) == 0) {
            return $validation = false;
        } else {
            return $validation = true;
        }
    }
    public function checkStatus($username, $status)
    {
        // $sql = "SELECT userprofile.status FROM user INNER JOIN userprofile 
        // ON user.userProfile = userprofile.profileID
        // WHERE user.username = '$username'"; //to get user profile status
        $sql = "SELECT * FROM user WHERE username ='$username'";
        $qRes = @$this->conn->query($sql);
        $Row = mysqli_fetch_assoc($qRes);

        // $sql2 = "SELECT * FROM user WHERE username ='$username'";// to get user status
        // $qRes2 = @$this->conn->query($sql2);
        // $Row2 = mysqli_fetch_assoc($qRes2);
        
        // $profileStatus = $Row['status'];
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

    public function getUserProfile($username)
    {
        $sql = "SELECT * FROM user WHERE username ='$username'";
        $qRes = @$this->conn->query($sql);
        $Row = mysqli_fetch_assoc($qRes);

        $userProfile = $Row['userProfile'];
        return $userProfile;
        // $sql = "SELECT user.userID, user.username, userprofile.profileName 
        // FROM user INNER JOIN userprofile 
        // ON user.userProfile = userprofile.profileID 
        // WHERE user.username = '$username'";

        // $qRes = @$this->conn->query($sql);
        // $Row = mysqli_fetch_assoc($qRes);
        // $userID = $Row['userID'];
        // $username = $Row['username'];
        // $userProfile = $Row['profileName'];

        // $_SESSION['userID'] = $userID;
        // if ($userProfile == 'Administrator')
        // {
        //     header("location:Admin.php?content=Home");
        // }

        // else if ($userProfile == 'Manager')
        // {
        //     header("location:Manager.php?content=Home");
        // }

        // else if ($userProfile == 'Staff')
        // {
        //     header("location:Staff.php?content=Home");
        // }

        // else if ($userProfile == 'Owner')
        // {
        //     header("location:Owner.php?content=Home");
        // }

        // else
        // {
        //     header("Location: index.php");
        // }
    }

    public function getUserID($username)
    {
        $sql = "SELECT * FROM user WHERE username ='$username'";
        $qRes = @$this->conn->query($sql);
        $Row = mysqli_fetch_assoc($qRes);

        $userID = $Row['userID'];
        return $userID;
    }

    public function checkDuplicateUsername($username)
    {
        $sql = "SELECT * FROM user WHERE username='$username'";
        $qRes = @$this->conn->query($sql);
        if (mysqli_num_rows($qRes) == 0) {
            return $checkUsername = true;
        } else {
            return $checkUsername = false;
        }
    }

    public function addUserAccount($username, $password, $name, $email, $phoneNumber,$userProfile)
    {
        $un = stripslashes($username);
        $n = stripslashes($name);

        $sql = "INSERT INTO user(username, password, name, email, phoneNumber,userProfile,status) VALUES( '$un', '$password', '$n', '$email', '$phoneNumber','$userProfile','Active')";
        $qRes = @$this->conn->query($sql);

        if ($qRes === TRUE) {
            return $validation = true;
        } else {
            return $validation = false;
        }
        

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

    public function modifyUserAcct($userID, $username, $password, $name, $email, $phoneNumber, $userProfile)
    {
        $sql = "UPDATE user SET ";

        if (!empty($username))
        {
            $sql .= "username = '$username',";
        }

        if (!empty($password))
        {
            $sql .= "password = '$password',";
        }

        if (!empty($name))
        {
            $sql .= "name = '$name',";
        }

        if (!empty($email))
        {
            $sql .= "email = '$email',";
        }

        if (!empty($phoneNumber))
        {
            $sql .= "phoneNumber = '$phoneNumber',";
        }

        if (!empty($userProfile))
        {
            $sql .= "userProfile = '$userProfile',";
        }

        // take away comma which is last char in string
        $sql = substr($sql, 0, -1);

        $sql .= "WHERE userID = $userID";

        $queryResult = @$this->conn->query($sql);
        if ($queryResult === TRUE)
        {
            return $validation = true;
        }
    }
    //----------------------------------------------------------------------------------------------//
    public function fetchUserData($userProfile, $status)
    {
        $profileArr = array();
        $sql = "SELECT userID, username FROM user WHERE userProfile = '$userProfile' AND status = '$status'";
        $qRes = @$this->conn->query($sql);

        while ($row = $qRes->fetch_assoc()) {
            $profileArr[$row['userID']] = $row["username"];
        }

        return $profileArr;
    }

    public function getUserName($userID)
    {
        $sql = "SELECT username FROM user WHERE userID = $userID";
        $qRes = @$this->conn->query($sql);

        if ($qRes == TRUE) 
        {
            $row = $qRes -> fetch_assoc();
            return $row ['username'];
        } 
        else 
        {
            return failure_alert("user profile does not exist");
        }
    }
    
    public function modifyUserStatus($userID, $status)
    {
        $sql = "UPDATE user SET status ='$status' WHERE userID = $userID";
        $qRes = @$this->conn->query($sql);

        if ($qRes === TRUE) {
            return $validateAction= true;
        } else {
            return $validateAction = false;
        }
    }


//----------------------------------------------------------------------------------------------//

    public function searchUser($userId, $userName, $name, $email, $phoneNumber, $userProfile, $status)
    {
        $sql = "SELECT * FROM user WHERE userId IS NOT NULL ";

        if ($userId != null)
        {
            $sql .= "AND userId = '$userId' ";
        }
        if ($userName != null)
        {
            $sql .= "AND username LIKE '%$userName%' ";
        }
        if ($name != null)
        {
            $sql .= "AND name LIKE '%$name%' ";
        }
        if ($email != null)
        {
            $sql .= "AND email LIKE '%$email%' ";
        }
        if ($phoneNumber != null)
        {
            $sql .= "AND phoneNumber LIKE '%$phoneNumber%' ";
        }
        if ($userProfile != null)
        {
            $sql .= "AND userProfile LIKE '%$userProfile%' ";
        }
        if ($status != null)
        {
            $sql .= "AND status LIKE '%$status%' ";
        }

        
        $result = @$this->conn->query($sql);
        return $result;
    }
}
