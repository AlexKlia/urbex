<?php

namespace Model;

use \W\Model\Model;

class VotesModel extends Model
{
    public function insert($userId, $pictureId )
    {
        $sql= ' INSERT INTO votes(id_picture, id_user) VALUES (:picture, :user)';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':picture', $pictureId);
        $sth->bindParam(':user', $userId);
        $sth->execute();
    }
}