<?php
include_once("userProfile.php"); // include user entity to call function

class ReinstateUserProfileController
{
    function fetchProfileData()
    {
        $profileArr = array();
        $userProfile = new userprofile();
        $profileArr = $userProfile->fetchProfileData('Suspended');
        return $profileArr;
    }
    function validateUserProfile($profileID)
    {
        $userProfile = new UserProfile();

        $validateAction = $userProfile->modifyProfileStatus($profileID, "Active");
        if ($validateAction == true) {
            $profileName = $userProfile->getProfile($profileID);
            return success_alert("User Profile: $profileName has been reinstated.");
        } else
            return failure_alert("Unexpected error has occurred while reinstating user profile");
    }
}
