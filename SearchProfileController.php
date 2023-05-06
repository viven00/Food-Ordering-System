<?php
include_once("UserProfile.php");// include user entity to call function
class SearchProfileController
{
    function searchProfile($profileID, $profileName, $status)
    {
        $profile = new UserProfile();
        $result = $profile->searchProfile($profileID, $profileName, $status);
        return $result;
    }
}
?>