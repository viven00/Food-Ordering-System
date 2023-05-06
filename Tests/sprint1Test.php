<?php
// ./vendor/bin/phpunit
// composer dump-autoload -o

class adminTest extends \PHPUnit\Framework\TestCase
{

    public function setUp(): void
    {
        include("config.php");
        $this->conn = $conn;

        //insert test data into db 
        $sql = "INSERT INTO `user` (`userID`, `username`, `password`, `name`, `email`, `phoneNumber`, `userProfile`, `status`) 
                VALUES ('9999', 'test1', 'test1', 'test1', 'test1@email.com', '12345678', '1', 'Active')";
        @$this->conn->query($sql);


        $sql = "INSERT INTO `userprofile` (`profileID`, `profileName`, `status`) VALUES ('999', 'test1', 'Active')";
        @$this->conn->query($sql);
    }

    public function teardown(): void
    {
        //clean up DB
        $sql = "DELETE FROM user WHERE userID = 9999";
        @$this->conn->query($sql);

        $sql = "DELETE FROM user WHERE name = 'test0' OR name = 'testProfile'";
        @$this->conn->query($sql);

        $sql = "DELETE FROM `userprofile` WHERE `profileID` = 999";
        @$this->conn->query($sql);
    }

    //test to see check functionality 
    //There will always be an admin whose Profile ID = 1;
    public function testGetProfile()
    {
        $testGetProfile = new UserProfile();
        $this->assertEquals($testGetProfile->getProfile('1'), 'Administrator');
    }

    public function testGetUserAccount()
    {
        $testGetUserAccount = new User();
        //retrieve data of dummy user that is placed into db user
        $this->assertTrue($testGetUserAccount->getUserAccount('test1', 'test1'));

        //test when data is enter where user does not exist in db
        $this->assertFalse($testGetUserAccount->getUserAccount('', ''));
    }

    public function testAddUserProfile()
    {
        $testAddUP = new UserProfile();
        $this->assertTrue($testAddUP->addUserProfile('testProfile'));

        $sql = "SELECT * FROM userprofile WHERE profileName = 'testProfile'";
        $qRes = @$this->conn->query($sql);
        $row = mysqli_fetch_assoc($qRes);
        $profileName = $row['profileName'];

        $this->assertEquals($profileName, 'testProfile');


        // clear up DB 
        $sql = "DELETE FROM userprofile WHERE profileName = 'testProfile'";
        @$this->conn->query($sql);
    }

    public function testAddUser()
    {
        $testAddUser = new User();
        $this->assertTrue($testAddUser->addUserAccount('test0', 'test0', 'testProfile', 'testProfile@testProfile.com', '12345678', '1'));
       
        $sql = "SELECT * FROM user WHERE username = 'test0'";
        $qRes = @$this->conn->query($sql);
        $row = mysqli_fetch_assoc($qRes);

        $name = $row['name'];
        $this->assertEquals($name, 'testProfile');
    }

    public function testModifyUserAcct()
    {
        $testModifyUserAcct = new User();
        $testModifyUserAcct->modifyUserAcct('9999', 'test2', 'test2', 'test2', 'test2@email.com', '11111111', '2');

        $sql = "SELECT * FROM `user` WHERE `userID` = '9999'";
        $qRes = @$this->conn->query($sql);
        $row = mysqli_fetch_assoc($qRes);

        $username = $row['username'];
        $password = $row['password'];
        $email = $row['email'];
        $name = $row['name'];
        $phoneNumber = $row['phoneNumber'];
        $userProfile = $row['userProfile'];

        $this->assertEquals($username, 'test2');
        $this->assertEquals($password, 'test2');
        $this->assertEquals($name, 'test2');
        $this->assertEquals($email, 'test2@email.com');
        $this->assertEquals($phoneNumber, '11111111');
        $this->assertEquals($userProfile, '2');
    }


    public function testModifyUserProfile()
    {
        $testModifyUserProfile = new UserProfile();

        $testModifyUserProfile->modifyUserProfile(999, 'test2');

        $sql = "SELECT profileName FROM `userprofile` WHERE `profileID` = '999'";
        $row = @$this->conn->query($sql)->fetch_assoc();
        $profileName = $row['profileName'];
        $this -> assertEquals($profileName, 'test2');
    }

    public function testSuspendUserProfile()
    {

        $testSuspendUserProfile = new UserProfile();

        $testSuspendUserProfile->modifyProfileStatus(999, 'Suspended');

        $sql = "SELECT status FROM `userprofile` WHERE `profileID` = '999'";
        $row = @$this->conn->query($sql)->fetch_assoc();

        $userProfileStatus = $row['status'];

        $this->assertEquals($userProfileStatus, "Suspended");
    }

    public function testSuspendUserAcct()
    {
        $testSuspendUserAcct = new user();

        $testSuspendUserAcct->modifyUserStatus(9999, 'Suspended');

        $sql = "SELECT status FROM `user` WHERE `userID` = '9999'";
        $row = @$this->conn->query($sql)->fetch_assoc();

        $userStatus = $row['status'];

        $this->assertEquals($userStatus, "Suspended");
    }
}
