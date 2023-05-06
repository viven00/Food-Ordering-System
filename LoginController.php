<?php
include_once("User.php"); // include user entity to call function
include_once("UserProfile.php");
class LoginController
{
    function validateLogin($username, $password)
    {
        $user = new User();
        $validation = $user->getUserAccount($username, $password);

        if ($validation == true) {
            $status = 'Active';
            $checkUserStatus = $user->checkStatus($username, $status);
            if ($checkUserStatus == true) {
                $profileID = $user->getUserProfile($username);
                $userProfile = new UserProfile;
                $checkProfileStatus = $userProfile->checkStatus($profileID, $status);
                if ($checkProfileStatus == true) 
                {
                    $userID = $user->getUserID($username);
                    $profileName = $userProfile->getProfileName($profileID);
                    //set session
                    $_SESSION['userID'] = $userID;
                    $_SESSION['userProfile'] = $profileName;

                    if ($profileName == 'Administrator') 
                    {
                        header("location:Admin.php?content=Home");
                    } 
                    else if ($profileName == 'Manager') 
                    {
                        header("location:Manager.php?content=Home");
                    }
                    else if ($profileName == 'Staff')
                    {
                        header("location:Staff.php?content=Home");
                    }

                    else if ($profileName == 'Owner')
                    {
                        header("location:Owner.php?content=Home");
                    }

                    else
                    {
                        header("Location: index.php");
                    }
                }
                else
                {
                    return failure_alert("Your user profile is banned. Please contact the administrator for more info.");
                }
            } 
            else 
            {
                return failure_alert("Your account is banned. Please contact the administrator for more info.");
            }
        } 
        else 
        {
            return failure_alert("The e-mail address/password combination entered is not valid.");
        }
    }
}
