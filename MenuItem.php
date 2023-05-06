<?php

class MenuItem
{
    private $itemID;
    private $itemName;
    private $itemDescription;
    private $itemPrice;
    private $itemImage;

    function __construct()
    {
        include("config.php");

        $this->conn = $conn;
    }

    function addMenuItem($itemName, $itemPrice, $itemDescription, $itemImage)
    {
        $sql = "INSERT INTO menuitem(`itemName`, `itemPrice`, `itemDescription`, `itemImage`) VALUES('$itemName', '$itemPrice', '$itemDescription', '$itemImage')";
    
        $qRes = @$this->conn->query($sql);

        if ($qRes === TRUE) {
            return true;
        } else {
            return false;
        }
        
    }

    function verifyItemID ($itemID)
    {
        $sql = "SELECT * FROM menuitem WHERE itemID='$itemID'";
        $qRes = @$this->conn->query($sql);

        if (mysqli_num_rows($qRes) == 0) {
            return 1;   //Error code for familiar to find itemID in database
        } else {
            return 0;
        }
    }

    function getArrOfAllMenuItems()
    {
        $menuItemsArr = array();

        $sql = "SELECT * FROM menuitem";
        $qRes = @$this->conn->query($sql);
        
        while ($row = $qRes->fetch_assoc()) {
            $menuItemsArr[] = $row;
        }

        return $menuItemsArr;
    }

    function deleteMenuItem($itemID)
    {
        //get itemImage
        $sql1 = "SELECT * FROM menuitem WHERE itemID='$itemID'";
        $result = @$this->conn->query($sql1);
        $row = $result->fetch_assoc();
        $itemImage = $row['itemImage'];

        $sql2 = "DELETE FROM menuitem WHERE itemID = '$itemID'";

        $queryResult = @$this->conn->query($sql2);
        if ($queryResult === TRUE)
        {
            unlink("ItemImages/$itemImage");
            return $validation = true;
        } 
        else
        {
            return $validation = false;
        }
    }

    function modifyMenuItem($itemID, $itemName, $itemPrice, $itemDescription, $itemImage)
    {
        $sql = "UPDATE menuitem SET ";

        if (!empty($itemName))
        {
            $sql .= "itemName = '$itemName',";
        }

        if (!empty($itemPrice))
        {
            $sql .= "itemPrice = '$itemPrice',";
        }

        if (!empty($itemDescription))
        {
            $sql .= "itemDescription = '$itemDescription',";
        }

        if (!empty($itemImage))
        {
            $sql .= "itemImage = '$itemImage' ,";
        }

        // take away comma which is last char in string
        $sql = substr($sql, 0, -1);

        $sql .= "WHERE itemID = $itemID";

        $queryResult = @$this->conn->query($sql);
        if ($queryResult === TRUE)
        {
            return 0;
        }
        else
            return 2; //Error code for familiar to modify 
    }

    public function searchMenuItem($itemID, $itemName, $minPrice, $maxPrice, $itemDescription)
    {
        $sql = "SELECT * FROM menuItem WHERE itemID IS NOT NULL ";

        if ($itemID != null)
        {
            $sql .= "AND itemID = '$itemID' ";
        }
        if ($itemName != null)
        {
            $sql .= "AND itemName LIKE '%$itemName%' ";
        }
        if ($minPrice != null)
        {
            $sql .= "AND itemPrice >= '$minPrice' ";
        }
        if ($maxPrice != null)
        {
            $sql .= "AND itemPrice <= '$maxPrice' ";
        }
        if ($itemDescription != null)
        {
            $sql .= "AND itemDescription LIKE '%$itemDescription%' ";
        }

        $result = @$this->conn->query($sql);
        return $result;
    }
    function getItemName($itemID)
    {
        $sql = "SELECT * FROM menuitem WHERE itemID='$itemID'";
        $result = @$this->conn->query($sql);
        

        while ($row = $result->fetch_assoc()) {
        
            $itemName = $row['itemName'];
        }

        return $itemName;
    }
}
?>