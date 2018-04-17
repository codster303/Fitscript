<?php
class Friend 
{
    private $FriendUserID;
    public $FriendFirstName;
    public $FriendLastName;
    public $Steps;
    //public $ListOfFriends;

    function __construct($FriendID, $FriendFirstName, $FriendLastName, $Steps)
    {
        $this->FriendUserID = $FriendID;
        $this->FriendFirstName = $FriendFirstName;
        $this->FriendLastName = $FriendLastName;
        $this->Steps = $Steps != null ? $Steps : "";
    }
    function Friends()
    {
        require_once 'login.php'; 
        $conn = new mysqli($hn, $un, $pw, $db);
        if ($conn->connect_error) 
            die($conn->connect_error);
        $userID = $_SESSION['userID'];

        $query  = "Select 
                f.UserID,
                f.FriendID, 
                u.FirstName, 
                u.LastName, 
                sum(s.Steps) as steps 
            from Friends f
                join Users u on u.UserID = f.FriendID
                left join Steps s on s.UserID = u.UserID 
            WHERE 
                f.UserID = $userID AND
                f.status = 'Accepted' and 
                s.DateUpdated BETWEEN date_sub(now(), INTERVAL 7 day) and now() OR
                s.DateUpdated is null";
        $results = $conn->query($query); 
        if (!$results) die ("Database access failed: " . $conn->error);
        
        while($result = $results->fetch_array(MYSQLI_ASSOC))
        {   
            $FriendList[] = new Friend($result['FriendID'], $result['FirstName'], $result['LastName'], $result['steps']);   
        }
        $results->close();
        $conn->close();
        return $FriendList;
    }

    function PendingFriends()
    {
        $conn = new mysqli($hn, $un, $pw, $db);
        if ($conn->connect_error) 
            die($conn->connect_error);

            $query  = "Select 
                            f.UserID,
                            f.FriendID, 
                            u.FirstName 
                            from Friends f
                        join 
                            Users u on u.UserID = f.FriendID
                        where 
                            f.status = 'Pending'";


        return;
    }
    
    function SendFriendRequest()
    {
        return;
    }

    function AcceptFriendRequest()
    {
        return;
    }

    function DeclineFriendRequest()
    {
        return;
    }
    
    function DeleteFriend()
    {
        return;
    }
}

?>