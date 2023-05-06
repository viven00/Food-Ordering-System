<?php
include_once("UserProfile.php");// include user profile entity to call function
class ModifyUserProfileController
{
    function getAllUserProfile()
    {
        $profileArr = array();

        $userProfile = new UserProfile();
        $profileArr = $userProfile -> getAllUserProfiles();

        return $profileArr;
    }

    function modifyUserProfile($oldUserProfileID, $newUserProfile)
    {
        $userProfile = new UserProfile();
        $validation = $userProfile->modifyUserProfile($oldUserProfileID, $newUserProfile);
        if ($validation == true) 
        {
            return success_alert("User profile successfully modified!");
        } 
        else 
        {
            return failure_alert("Unable to modify user profile.");
        }
    }
}
