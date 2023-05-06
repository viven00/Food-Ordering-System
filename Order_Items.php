<?php
class Order_Items
{
    private $orderID;
    private $itemID;
    private $quantity;

    function __construct()
    {
        include("config.php");

        $this->conn = $conn;
    }

    public function addOrderItems($orderID)
    {
        $data = array();
        foreach ($_SESSION["cart_item"] as $item) {
            $itemID = ($item["itemID"]);
            $quantity = ($item["quantity"]);
            $data[] = "('$orderID', $itemID, $quantity)";
        }
        $values = implode(' , ', $data);
        $sql = "INSERT INTO order_items(orderID, itemID, quantity) VALUES $values;";

        $result = @$this->conn->query($sql);
        if ($result == TRUE) {
                return $result = true;
        } else {
            return $result = false;
        }
    }

    public function updateOrderItems($orderID)
    {
        $newData = array(); // to store items that does not exist in the table
        // $oldData = array(); // to store items that exist in the table
        foreach ($_SESSION["cart_item"] as $item) {
            $itemID = ($item["itemID"]);
            $quantity = ($item["quantity"]);
            $sql = "SELECT * FROM order_items WHERE orderID='$orderID' AND itemID = '$itemID'";
            $result = @$this->conn->query($sql);

            if (mysqli_num_rows($result) == 0) {
                $newData[] = "('$orderID', $itemID, $quantity)";
            } else {
                $Row = mysqli_fetch_assoc($result);
                $quantity = $Row['quantity'] + $quantity;
                $sql3 = "UPDATE order_items SET quantity='$quantity' WHERE orderID='$orderID' AND itemID='$itemID'";
                $result3 = @$this->conn->query($sql3);
            }
        }

        if (!empty($newData)) {
            $values = implode(' , ', $newData);
            $sql2 = "INSERT INTO order_items(orderID, itemID, quantity) VALUES $values;";
            $result2 = @$this->conn->query($sql2);
        }

        if (($result3 == TRUE) || ($result2 == TRUE)) 
        {
            return $result = true;
        } 
        else 
        {
            return $result = false;
        }
    }

    public function getOrderItemsByID($orderID)
    {
        $sql = "SELECT menuitem.itemName, order_items.quantity 
        FROM order_items INNER JOIN menuitem 
        ON order_items.itemID = menuitem.itemID 
        WHERE orderID = '$orderID'";
        $result = @$this->conn->query($sql);

        return $result;
    }

    function deleteItem($no)
    {
        $sql = "DELETE FROM order_items WHERE no = '$no'";

        $queryResult = @$this->conn->query($sql);

        if ($queryResult === TRUE)
            return true;
        else
            return false;
    }


    function deleteOrder($orderID)
    {
        $sql = "DELETE FROM order_items WHERE orderID = '$orderID'";

        $queryResult = @$this->conn->query($sql);

        if ($queryResult === TRUE)
            return true;
        else
            return false;
    }

    function viewOrderItems($orderID)
    {
        $sql = "SELECT * FROM order_items WHERE orderID = '$orderID'";

        $qRes = @$this->conn->query($sql);

        $resultsArray = array();

        while ($row = $qRes->fetch_assoc()) {
            $resultsArray[] = $row;
        }
        
        return $resultsArray;
    }

    function updateOrderQuantity($no, $quantity)
    {
        $sql = "UPDATE order_items SET quantity = $quantity WHERE no = $no";

        $queryResult = @$this->conn->query($sql);

        if ($queryResult === TRUE)
            return true;
        else
            return false;
    }
}
