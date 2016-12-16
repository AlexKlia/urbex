<?php

namespace Model;

use \W\Model\Model;

class VotesModel extends Model
{
    public function insert($userId, $pictureId )
    {
        $sql= ' INSERT INTO votes VALUES (:picture, :userId)';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':picture', $pictureId);
        $sth->bindParam(':userId', $userId);
        $sth->execute();
    }
}