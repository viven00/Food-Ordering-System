<?php
include_once("User.php");// include user entity to call function
include_once("UserProfile.php");

class SuspendUserController
{
    //Will only fetch profiles that are not suspended
    function fetchProfileData ()
    {
        $profileArr = array();  
        $userProfile = new userProfile();
        $profileArr = $userProfile -> fetchProfileData('Active');
        return $profileArr;
    }

    //Will fetch users that are suspended
    function fetchUserData($userProfile)
    {
        $userArr = array();  
        $user = new user();
        $userArr = $user -> fetchUserData($userProfile, 'Active');
        return $userArr;
    }

    //Validates user has been successfully reinstated
    function validateUser($userID)
    {
        $user = new User();

        $validateAction = $user->modifyUserStatus($userID, "Suspended");
        if ($validateAction == true)
        {
            $userName = $user -> getUserName($userID);
            return success_alert("User : $userName has been suspended.");
        }
        else 
            return failure_alert("Unexpected error has occurred while suspending user");
    }
}

?>

