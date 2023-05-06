<?php
class Order_Status
{
    private $orderID;
    private $created_at;
    private $tableNumber;
    private $customerPhone;
    private $gst;
    private $serviceCharge;
    private $total;
    private $status;

    function __construct()
    {
        include("config.php");

        $this->conn = $conn;
    }

    public function generateOrderID($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $orderID = '';
        for ($i = 0; $i < $length; $i++) {
            $orderID .= $characters[rand(0, $charactersLength - 1)];
        }
        $_SESSION['orderID'] = $orderID;
        return $_SESSION['orderID'];
    }

    function addOrder($orderID, $tableNumber, $customerPhone, $gst, $serviceCharge, $total)
    {
        date_default_timezone_set('Asia/Singapore');
        $todayDate = date("Y-m-d H:i:s");

        $sql = "INSERT INTO order_status(orderID, created_at, tableNumber, customerPhone, gst, serviceCharge, total, status) VALUES ('$orderID', '$todayDate','$tableNumber', '$customerPhone', '$gst','$serviceCharge','$total', 'Processing')";
        $qRes = @$this->conn->query($sql);
        if ($qRes === TRUE) {
            return $addOrder = true;
        } else {
            return $addOrder = false;
        }
    }

    public function updateOrder($orderID, $gst, $serviceCharge, $total)
    {
        $sql = "SELECT * FROM order_status WHERE orderID = '$orderID'";
        $qRes = @$this->conn->query($sql);
        $row = $qRes->fetch_assoc();
        $newGst = $row['gst'] + $gst;
        $newSC = $row['serviceCharge'] + $serviceCharge;
        $newTotal = $row['total'] + $total;

        $sql2 = "UPDATE order_status SET gst='$newGst', serviceCharge='$newSC', total='$newTotal' WHERE orderID ='$orderID'";
        $result = @$this->conn->query($sql2);
        if ($result === TRUE) {
            return $result = true;
        } else {
            return $result = false;
        }
    }

    public function getOrderStatusByID($orderID)
    {
        $sql = "SELECT * FROM order_status WHERE orderID = '$orderID'";
        $result = @$this->conn->query($sql);
        return $result;
    }
    function searchOrders($orderID, $created_at, $tableNumber, $customerPhone, $total, $status)
    {
        $sql = "SELECT * FROM order_status WHERE orderID IS NOT NULL ";

        if ($orderID != null) {
            $sql .= "AND orderID = '$orderID' ";
        }
        if ($created_at != null) {
            $sql .= "AND created_at between '$created_at' and '$created_at 23:59:59' ";
        }
        if ($tableNumber != null) {
            $sql .= "AND tableNumber = '$tableNumber' ";
        }
        if ($customerPhone != null) {
            $sql .= "AND customerPhone LIKE '%$customerPhone%' ";
        }
        if ($total != null) {
            $sql .= "AND total LIKE '%$total%' ";
        }
        if ($status != null) {
            $sql .= "AND status LIKE '%$status%' ";
        }

        $result = @$this->conn->query($sql);
        return $result;
    }

    public function updatePaymentStatus($orderID, $paymentMethod)
    {
        if ($paymentMethod == 'card') {
            $sql = "UPDATE order_status SET status='Paid' WHERE orderID ='$orderID'";
            $result = @$this->conn->query($sql);
            if ($result === TRUE) {
                return $result = 1;
            } else {
                return $result = false;
            }
        } elseif ($paymentMethod == 'counter') {
            $sql = "UPDATE order_status SET status='Payment Pending' WHERE orderID ='$orderID'";
            $result = @$this->conn->query($sql);
            if ($result === TRUE) {
                return $result = 2;
            } else {
                return $result = false;
            }
        } else {
            $result = false;
            return $result;
        }
    }

    public function updateOrderWithDiscountID($orderID, $total, $gst, $serviceCharge, $discountID)
    {
        $sql = "UPDATE order_status SET gst='$gst', serviceCharge='$serviceCharge', total='$total', discountID = '$discountID' WHERE orderID ='$orderID'";
        $result = @$this->conn->query($sql);
        if ($result === TRUE) {
            return $result = true;
        } else {
            return $result = false;
        }
    }

    public function monthlySalesReport($month)
    {
        $sql = "SELECT orderID, gst, serviceCharge, total, date(created_at) date
        FROM order_status
        WHERE status = 'Paid' AND created_at LIKE '%$month%' 
        ORDER BY date ASC";

        $result = @$this->conn->query($sql);
        return $result;
    }

    public function weeklySalesReport($week, $year)
    {
        $sql = "SELECT orderID, gst, serviceCharge, total, date(created_at) date
        FROM order_status
        WHERE status = 'Paid' AND WEEK(created_at) = '$week' AND YEAR(created_at) = '$year' 
        ORDER BY date ASC";

        $result = @$this->conn->query($sql);
        return $result;
    }

    public function dailySalesReport($date)
    {
        $sql = "SELECT orderID, gst, serviceCharge, total, date(created_at) date
        FROM order_status
        WHERE status = 'Paid' AND created_at LIKE '%$date%' ORDER BY date ASC";
    
        $result = @$this->conn->query($sql);
        return $result;
    }

    public function monthlyCustomerReport($month)
    {
        $sql = "SELECT YEAR(created_at) year, MONTHNAME(created_at) month, customerPhone, count(*) visits
        FROM order_status
        WHERE created_at LIKE '%$month%'
        GROUP BY year, MONTH(created_at), customerPhone
        ORDER BY visits DESC";

        $result = @$this->conn->query($sql);
        return $result;
    }

    public function weeklyCustomerReport($week, $year)
    {
        $sql = "SELECT YEAR(created_at) year, WEEK(created_at) week, customerPhone, count(*) visits
        FROM order_status
        WHERE WEEK(created_at) = '$week' AND YEAR(created_at) = '$year'
        GROUP BY year, week, customerPhone
        ORDER BY visits DESC";

        $result = @$this->conn->query($sql);
        return $result;
    }

    public function dailyCustomerReport($date)
    {
        $sql = "SELECT date(created_at) date, customerPhone, count(*) visits
        FROM order_status
        WHERE created_at LIKE '%$date%'
        GROUP BY date, customerPhone
        ORDER BY visits DESC";

        $result = @$this->conn->query($sql);
        return $result;
    }

    public function monthlyItemReport($month)
    {
        $sql = "SELECT year(order_status.created_at) year, MONTHNAME(created_at) month, menuitem.itemName itemName, order_items.itemID itemID, SUM(order_items.quantity) quantity
        FROM order_status JOIN order_items ON order_status.orderID = order_items.orderID JOIN menuitem ON order_items.itemID = menuitem.itemID 
        WHERE order_items.itemID > 0 AND created_at LIKE '%$month%'
        GROUP BY order_items.itemID, year, MONTH(created_at)
        ORDER BY quantity DESC";

        $result = @$this->conn->query($sql);
        return $result;
    }

    public function weeklyItemReport($week, $year)
    {
        $sql = "SELECT year(order_status.created_at) year, WEEK(created_at) week, menuitem.itemName itemName, order_items.itemID itemID, SUM(order_items.quantity) quantity
        FROM order_status JOIN order_items ON order_status.orderID = order_items.orderID JOIN menuitem ON order_items.itemID = menuitem.itemID 
        WHERE order_items.itemID > 0 AND WEEK(created_at) = '$week' AND YEAR(created_at) = '$year'
        GROUP BY order_items.itemID, year, week
        ORDER BY quantity DESC";

        $result = @$this->conn->query($sql);
        return $result;
    }

    public function dailyItemReport($date)
    {
        $sql = "SELECT date(order_status.created_at) date, menuitem.itemName itemName, order_items.itemID itemID, SUM(order_items.quantity) quantity
        FROM order_status JOIN order_items ON order_status.orderID = order_items.orderID JOIN menuitem ON order_items.itemID = menuitem.itemID 
        WHERE order_items.itemID > 0 AND created_at LIKE '%$date%'
        GROUP BY order_items.itemID, date
        ORDER BY quantity DESC";

        $result = @$this->conn->query($sql);
        return $result;
    }

    public function deleteOrder($orderID)
    {
        $sql = "DELETE FROM Order_Status WHERE orderID = '$orderID'";

        $queryResult = @$this->conn->query($sql);

        if ($queryResult === TRUE)
            return true;
        else
            return false;
    }

    public function updateStatus($orderID)
    {
        $sql = "UPDATE Order_Status SET `status`='Paid' WHERE orderID = '$orderID'";

        $queryResult = @$this->conn->query($sql);

        if ($queryResult === TRUE)
            return true;
        else
            return false;
    }
}
