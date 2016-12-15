<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 14/12/2016
 * Time: 10:03
 */

namespace Model;

use W\Model\Model;

class PicturesModel extends Model
{
    public function disctinct()
    {
        $sql = 'SELECT DISTINCT local FROM pictures';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();
    }

}