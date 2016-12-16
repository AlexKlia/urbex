<?php
/**
 * Created by PhpStorm.
<<<<<<< HEAD
 * User: Big Boss
 * Date: 14/12/2016
 * Time: 10:12
=======
 * User: Etudiant
 * Date: 14/12/2016
 * Time: 10:03
>>>>>>> master
 */

namespace Model;


use \W\Model\Model;
use \W\Model\UsersModel;
use \W\Model\ConnectionModel;
use PDO;


class PicturesModel extends Model
{
    public function latestPictures($offset, $nb)
    {
        $nb = (int)$nb;

        $sql = 'SELECT pictures.id, pictures.title, pictures.descr, users.username, pictures.url_resize, pictures.local, pictures.date, COUNT(votes.id_user) AS nbVote FROM `pictures`' .
            'INNER JOIN users ON users.id = pictures.id_user left join votes ON votes.id_picture = pictures.id group by pictures.id' .
            ' ORDER BY pictures.date DESC LIMIT :limit OFFSET :offset';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sth->bindParam(':limit', $nb, PDO::PARAM_INT);

        $sth->execute();
        return $sth->fetchAll();
    }

    public function disctinct()
    {
        $sql = 'SELECT DISTINCT local FROM pictures';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function CountPictures()
    {
        $sql = 'SELECT COUNT(id) AS nb FROM pictures';
        $result = $this->dbh->query($sql);
        $row = $result->fetch();
        return $row['nb'];
    }

    public function getVotes()
    {
        $sql='SELECT pictures.id, pictures.title, pictures.descr, users.username, pictures.url_resize, pictures.local, pictures.date, votes.id_user, votes.id_picture FROM `pictures`'.
            'INNER JOIN users ON users.id = pictures.id_user left join votes ON votes.id_picture = pictures.id ';
        $result = $this->dbh->query($sql);
        $row = $result->fetchAll();
        return $row;

    }

    public function getNbVotes($id)
    {
        $sql = 'SELECT COUNT(*) FROM votes WHERE id_picture=:id';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }

}