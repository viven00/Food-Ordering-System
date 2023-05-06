<?php
include_once("UserProfile.php"); // include user entity to call function
class addUserProfileController
{
    function addUserProfile($userProfile)
    {
        $user = new UserProfile();
        $checkProfileName = $user->checkDuplicateProfileName($userProfile);

        if ($checkProfileName == true) 
        {
            $validation = $user->addUserProfile($userProfile);
            if ($validation == true) 
            {
                return success_alert("User profile successfully added!");
            } 
            else 
            {
                return failure_alert("Unable to add user profile.");
            }
        }
        else
        {
            return failure_alert("This profile name is not available. Please use another profile name.");
        }
    }
}
