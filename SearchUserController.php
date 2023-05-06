<?php
include_once("User.php");// include user entity to call function
include_once("UserProfile.php");
class SearchUserController
{
    function searchUser($userId,$userName,$name,$email, $phoneNumber, $userProfile, $status)
    {
        $user = new User();
        $result = $user->searchUser($userId,$userName,$name,$email, $phoneNumber, $userProfile, $status);
        return $result;
    }
    function viewProfiles()
    {
        $userProfile = new UserProfile;
        $result = $userProfile->searchProfile(null, null, null);
        return $result;
    }
}
?>