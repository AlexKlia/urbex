<?php
/**
 * Created by PhpStorm.
 * User: Big Boss
 * Date: 14/12/2016
 * Time: 10:12
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


        $nb =(int)$nb;

        $sql ='SELECT pictures.id, pictures.title, pictures.descr, users.username, pictures.url, pictures.local, pictures.date, pictures.id_user, users.id '.
            'FROM `pictures` INNER JOIN users WHERE users.id = pictures.id_user' .
            ' ORDER BY pictures.date DESC LIMIT :limit OFFSET :offset ';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':offset', $offset, PDO::PARAM_INT);
        $sth->bindParam(':limit', $nb, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function CountPictures(){
        $sql= 'SELECT COUNT(id) AS nb FROM pictures';
        $result = $this->dbh->query($sql);
        $row = $result->fetch();
        return $row['nb'];


    }
}