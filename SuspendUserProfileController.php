<?php
include_once("UserProfile.php");// include user entity to call function

class SuspendUserProfileController
{
    function fetchProfileData ()
    {
        $profileArr = array();  
        $userProfile = new UserProfile();
        $profileArr = $userProfile -> fetchProfileData('Active');
        return $profileArr;
    }

    function validateUserProfile($profileID)
    {
        $userProfile = new UserProfile();

        $validateAction = $userProfile->modifyProfileStatus($profileID, "Suspended");
        if ($validateAction == true)
        {
            $profileName = $userProfile -> getProfile($profileID);
            return success_alert("User Profile: $profileName has been suspended.");
        }
        else 
            return failure_alert("Unexpected error has occurred while suspending user profile");
    }
}
?>
