<?php
class UsersDb
{
    const USERS_TABLE = 'users';
    const EDUCATION_TABLE = 'education';
    const CITIES_TABLE = 'cities';
    const USERS_EDUCATION = 'users_education';
    const USERS_CITIES = 'users_cities';

    protected $db;
    
    public function __construct()
    {
        $this -> db = Zend_Registry::get('db');
    }

    public function getUsers() {

        $sql = 'SELECT u.`id` AS user_id, u.`name`, e.`title` AS `education`
                    FROM users AS u, education AS e, cities AS c, users_education AS ue, users_cities AS uc
                    WHERE u.id=ue.`user_id` AND ue.`education_id`=e.id
                    GROUP BY user_id';
        $items = $this -> db -> fetchAll($sql);

        foreach($items AS $key=>$val){
            $cities = $this->getCitiesByUserId($val['user_id']);
            $items[$key]['city'] = $cities;
        }

        return $items;
    }

    public function getUsersByFilter($ids) {

        $cities_filter = ' ';
        $citiesIds = array();
        $education_filter = ' ';
        $educationIds = array();

        if($ids!=''){
            $idsData = explode(",",$ids);

            foreach($idsData as $val){
                if(strstr($val,'cities')){
                    $tmp = explode("cities_check",$val);
                    $citiesIds[] = $tmp[1];
                } else {
                    $tmp = explode("edu_check",$val);
                    $educationIds[] = $tmp[1];
                }
            }
            $citiesIdsStr = implode(",", $citiesIds);
            $educationIdsStr = implode(',',$educationIds);
            if($citiesIdsStr!=''){
                $cities_filter = ' AND u.id IN(SELECT user_id FROM users_cities WHERE city_id IN('.$citiesIdsStr.')) ';
            }
            if($educationIdsStr!=''){
                $education_filter = ' AND u.id IN(SELECT user_id FROM users_education WHERE education_id IN('.$educationIdsStr.')) ';
            }
        }

        $sql = 'SELECT u.`id` AS user_id, u.`name`, e.`title` AS `education`
                    FROM users AS u, education AS e, cities AS c, users_education AS ue, users_cities AS uc
                    WHERE u.id=ue.`user_id` AND ue.`education_id`=e.id '.$cities_filter.$education_filter.'
                    GROUP BY user_id';

        $items = $this -> db -> fetchAll($sql);

        foreach($items AS $key=>$val){
            $cities = $this->getCitiesByUserId($val['user_id']);
            $items[$key]['city'] = $cities;
        }


        return $items;
    }


    public function getUsers2() {

        $sql = 'SELECT u.`id` AS user_id, u.`name`, e.`title` AS `education`
                    FROM users AS u, education AS e, cities AS c, users_education AS ue, users_cities AS uc
                    WHERE u.id=ue.`user_id` AND ue.`education_id`=e.id
                    GROUP BY user_id DESC LIMIT 0,4';
        $items = $this -> db -> fetchAll($sql);

        foreach($items AS $key=>$val){
            $cities = $this->getCitiesByUserId($val['user_id']);
            $items[$key]['city'] = $cities;
        }

        return $items;
    }

    public function getEducation(){
        return $this -> db -> fetchAll('SELECT id, title FROM '.self::EDUCATION_TABLE);
    }

    public function getCitiesByUserId($userId){
        $items =  $this -> db -> fetchAll('SELECT title FROM '.self::CITIES_TABLE.' WHERE id IN(SELECT city_id FROM '.self::USERS_CITIES.' WHERE user_id=?) ORDER BY title',$userId);
        $arrValues = array();
        foreach($items as $val){
            $arrValues[] = $val['title'];
        }
        return implode(', ',$arrValues);
    }

    public function getCities(){
        return $this -> db -> fetchAll('SELECT id, title FROM '.self::CITIES_TABLE.' ORDER BY title');
    }


    public function updateEducation($userID, $educationID) {
        $data = array(
        	'education_id'    =>  $educationID
        );
        $where[] = "user_id = ".$userID;
        $this -> db -> update(self::USERS_EDUCATION, $data, $where);
        return true;
    }

}