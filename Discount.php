<?php

class Discount
{
    private $discountID;
    private $discountName;
    private $discountAmount;
    private $discountStatus;
    
    function __construct()
    {
        include("config.php");

        $this->conn = $conn;
    }


    public function fetchDiscountData($status)
    {
        $discountArr = array();
        $sql = "SELECT discountID, discountName FROM discount WHERE discountStatus = '$status'";
        $qRes = @$this->conn->query($sql);

        while ($row = $qRes->fetch_assoc()) {
            $DiscountArr[$row['discountID']] = $row["discountName"];
        }

        return $DiscountArr;
    }
    public function checkDiscountName($discountName)
    {
        $sql = "SELECT * FROM discount WHERE discountName='$discountName'";
        $qRes = @$this->conn->query($sql);
        // if 0 rows found, there is no duplicate
        if (mysqli_num_rows($qRes) == 0) {
            return $result = false;
        } else {
            return $result = true;
        }
    }
    
    public function addDiscount($discountName, $discountAmount, $discountStatus)
    {
        $sql = "INSERT INTO discount (discountName, discountAmount, discountStatus) VALUES ('$discountName', '$discountAmount', '$discountStatus')";

        $qRes = @$this->conn->query($sql);

        if ($qRes === TRUE)
        {
            return $validation = true;
        } 
        else
        {
            return $validation = false;
        }
    }

    public function getArrAllDiscount()
    {
        $sql = "SELECT * FROM discount";
        
        $qRes = @$this->conn->query($sql);

        while ($row = $qRes->fetch_assoc()) {
            $discountArr[] = $row;
        }

        return $discountArr;
    }

    public function deleteDiscount($discountID)
    {
        $sql = "DELETE FROM discount WHERE discountID = '$discountID'";

        $qRes = @$this->conn->query($sql);
        if ($qRes === TRUE)
        {
            return $validation = true;
        } 
        else
        {
            return $validation = false;
        }
    }

    public function getArrInactiveDiscounts()
    {
        $sql = "SELECT * FROM discount WHERE discountStatus = 'Inactive'";

        $qRes = @$this->conn->query($sql);

        while ($row = $qRes->fetch_assoc()) {
            $discountArr[] = $row;
        }

        return $discountArr;
    }

    public function activateDiscount($discountID)
    {
        $sql = "UPDATE discount SET discountStatus = 'Active' WHERE discountID = '$discountID'";

        $qRes = @$this->conn->query($sql);
        if ($qRes === TRUE)
        {
            return $validation = true;
        } 
        else
        {
            return $validation = false;
        }
    }

    public function getArrActiveDiscounts()
    {
        $sql = "SELECT * FROM discount WHERE discountStatus = 'Active'";

        $qRes = @$this->conn->query($sql);

        while ($row = $qRes->fetch_assoc()) {
            $discountArr[] = $row;
        }

        return $discountArr;
    }

    public function deactivateDiscount($discountID)
    {
        $sql = "UPDATE discount SET discountStatus = 'Inactive' WHERE discountID = '$discountID'";

        $qRes = @$this->conn->query($sql);
        if ($qRes === TRUE)
        {
            return $validation = true;
        } 
        else
        {
            return $validation = false;
        }
    }

    
    public function modifyDiscount($discountID, $newDiscountName, $newDiscountAmount)
    {
        $sql = "UPDATE discount SET ";

        if (isset($newDiscountName))
        {
            $sql .= "discountName = '$newDiscountName',";
        }

        if (!empty($newDiscountAmount))
        {
            $sql .= "discountAmount = '$newDiscountAmount',";
        }


        // take away comma which is last char in string
        $sql = substr($sql, 0, -1);

        $sql .= " WHERE discountID = $discountID";

        $qRes = @$this->conn->query($sql);
        if ($qRes === TRUE)
        {
            return $validation = true;
        } 
        else
        {
            return $validation = false;
        }
    }

    public function getActiveDiscount($discountName)
    {
        $sql = "SELECT * FROM discount WHERE discountName='$discountName' AND discountStatus='Active'";
        $qRes = @$this->conn->query($sql);
        // if 0 rows found, there is no duplicate
        if (mysqli_num_rows($qRes) == 0) {
            return $result = false;
        } else {
            return $result = true;
        }
    }

    public function getDiscountAmount($discountName)
    {
        $sql = "SELECT * FROM discount WHERE discountName='$discountName'";
        $qRes = @$this->conn->query($sql);
        $row = $qRes->fetch_assoc();
        $discountAmt = $row['discountAmount'];

        return $discountAmt;
    }
    
    public function searchDiscount($discountID, $discountName, $discountAmount, $discountStatus)
    {
        $sql = "SELECT * FROM discount WHERE discountID IS NOT NULL ";

        if ($discountID != null)
        {
            $sql .= "AND discountID = '$discountID' ";
        }
        if ($discountName != null)
        {
            $sql .= "AND discountName LIKE '%$discountName%' ";
        }
        if ($discountAmount != null)
        {
            $sql .= "AND discountAmount = '$discountAmount' ";
        }
        if ($discountStatus != null)
        {
            $sql .= "AND discountStatus = '$discountStatus' ";
        }

        $result = @$this->conn->query($sql);
        return $result;
    }

    public function getDiscountID($discountName)
    {
        $sql = "SELECT * FROM discount WHERE discountName='$discountName'";
        $qRes = @$this->conn->query($sql);
        $row = $qRes->fetch_assoc();
        $discountID = $row['discountID'];

        return $discountID;
    }
    
}
