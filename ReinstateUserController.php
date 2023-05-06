<?php
include_once("user.php"); // include user entity to call function
include_once("userProfile.php");

class ReinstateUserController
{
    //Will only fetch profiles that are not suspended
    function fetchProfileData()
    {
        $profileArr = array();
        $userProfile = new userProfile();
        $profileArr = $userProfile->fetchProfileData('Active');
        return $profileArr;
    }

    //Will fetch users that are suspended
    function fetchUserData($userProfile)
    {
        $userArr = array();
        $user = new user();
        $userArr = $user->fetchUserData($userProfile, 'Suspended');
        return $userArr;
    }

    //Validates user has been successfully reinstated
    function validateUser($userID)
    {
        $user = new User();

        $validateAction = $user->modifyUserStatus($userID, "Active");
        if ($validateAction == true)
        {
            $userName = $user -> getUserName($userID);
            return success_alert("User : $userName has been reinstated");
        }
        else 
            return failure_alert("Unexpected error has occurred while reinstating user");
    }
}
