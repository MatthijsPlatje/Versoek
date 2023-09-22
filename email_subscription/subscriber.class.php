<?php 
/* 
 * Subscriber Class 
 * This class is used for database related (connect, fetch, insert, update, and delete) operations 
 * @author    CodexWorld.com 
 * @url        http://www.codexworld.com 
 * @license    http://www.codexworld.com/license 
 */ 
 
class Subscriber { 
    private $dbHost     = DB_HOST; 
    private $dbUsername = DB_USERNAME; 
    private $dbPassword = DB_PASSWORD; 
    private $dbName     = DB_NAME; 
    private $userTbl    = 'subscribers'; 
     
    function __construct()
    { 
        if(!isset($this->db))
        { 
            // Connect to the database
            $connectionInfo = array( "Database"=>$this->dbName, "UID"=>$this->dbUsername, "PWD"=>$this->dbPassword);
            $conn = sqlsrv_connect( $this->dbHost, $connectionInfo);

            if(!$conn)
            {   
                die("Database Login failed! Please make sure that the DB login credentials provided are correct");
            }
            else
            {
                $this->db = $conn;
            }
        } 
    } 

    function mssql_escape_string($data) {
        if(is_numeric($data))
            return $data;
        $unpacked = unpack('H*hex', $data);
        return '0x' . $unpacked['hex'];
    }
     
    /* 
     * Returns rows from the database based on the conditions 
     * @param string name of the table 
     * @param array select, where, order_by, limit and return_type conditions 
     */ 
    public function getRows($conditions = array()){ 
        $sql = 'SELECT '; 
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*'; 
        $sql .= ' FROM '.$this->userTbl; 
        if(array_key_exists("where",$conditions)){ 
            $sql .= ' WHERE '; 
            $i = 0; 
            foreach($conditions['where'] as $key => $value){ 
                $pre = ($i > 0)?' AND ':''; 
                $sql .= $pre.$key." = '".$value."'"; 
                $i++; 
            } 
        } 
         
        if(array_key_exists("order_by",$conditions)){ 
            $sql .= ' ORDER BY '.$conditions['order_by'];  
        }else{ 
            $sql .= ' ORDER BY id DESC ';  
        } 
         
        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){ 
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];  
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){ 
            $sql .= ' LIMIT '.$conditions['limit'];  
        } 
         
        //$result = $this->db->query($sql);
        $result = sqlsrv_query($this->db, $sql, array(), array('Scrollable' => 'buffered'));
         
        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){ 
            switch($conditions['return_type']){ 
                case 'count': 
                    //$data = $result->num_rows; 
                    $data = sqlsrv_num_rows($result);
                    break; 
                case 'single': 
                    //$data = $result->fetch_assoc(); 
                    $data = mssql_fetch_assoc($result); 
                    break; 
                default: 
                    $data = ''; 
            } 
        }else{ 
            if($result->num_rows > 0){ 
                //while($row = $result->fetch_assoc()){ 
                while($row = mssql_fetch_assoc($result))
                {
                    $data[] = $row; 
                } 
            } 
        }

        return !empty($data) ? $data : false; 
    } 
     
    /* 
     * Insert data into the database 
     * @param string name of the table 
     * @param array the data for inserting into the table 
     */ 
    public function insert($data)
    { 
        if(!empty($data) && is_array($data))
        { 
            $columns = ''; 
            $values  = ''; 
            $i = 0; 
            if(!array_key_exists('created',$data))
            { 
                $data['created'] = date("Y-m-d H:i:s"); 
            } 

            if(!array_key_exists('modified',$data))
            { 
                $data['modified'] = date("Y-m-d H:i:s"); 
            } 

            foreach($data as $key=>$val)
            { 
                $pre = ($i > 0)?', ':''; 
                $columns .= $pre.$key; 
                $values  .= $pre."'".$val."'"; 
                $i++; 
            } 

            $query = "INSERT INTO ".$this->userTbl." (".$columns.") VALUES (".$values.")"; 

            //$insert = $this->db->query($query);
            $insert = sqlsrv_query($this->db, $query);

            return $insert ? true : false; 
        }
        else
        { 
            return false; 
        } 
    } 
     
    /* 
     * Update data into the database 
     * @param string name of the table 
     * @param array the data for updating into the table 
     * @param array where condition on updating data 
     */ 
    public function update($data, $conditions){ 
        if(!empty($data) && is_array($data)){ 
            $colvalSet = ''; 
            $whereSql = ''; 
            $i = 0; 

            if(!array_key_exists('modified', $data))
            { 
                $data['modified'] = date("Y-m-d H:i:s"); 
            } 

            foreach($data as $key=>$val)
            { 
                $pre = ($i > 0)?', ':''; 
                $colvalSet .= $pre.$key."='".$val."'"; 
                $i++; 
            } 

            if(!empty($conditions)&& is_array($conditions))
            { 
                $whereSql .= ' WHERE '; 
                $i = 0; 
                foreach($conditions as $key => $value){ 
                    $pre = ($i > 0)?' AND ':''; 
                    $whereSql .= $pre.$key." = '".$value."'"; 
                    $i++; 
                } 
            } 

            $query = "UPDATE ".$this->userTbl." SET ".$colvalSet.$whereSql; 
            //$update = $this->db->query($query);
            $update = sqlsrv_query($this->db, $query); 

            return $update ? true : false; 
            //return $query;
        }
        else
        { 
            return false; 
        } 
    } 
     
    /* 
     * Delete data from the database 
     * @param string name of the table 
     * @param array where condition on deleting data 
     */ 
    public function delete($conditions){ 
        $whereSql = ''; 
        if(!empty($conditions)&& is_array($conditions)){ 
            $whereSql .= ' WHERE '; 
            $i = 0; 
            foreach($conditions as $key => $value){ 
                $pre = ($i > 0)?' AND ':''; 
                $whereSql .= $pre.$key." = '".$value."'"; 
                $i++; 
            } 
        } 
        $query = "DELETE FROM ".$this->userTbl.$whereSql; 
        //$delete = $this->db->query($query); 
        $delete = sqlsrv_query($this->db, $query); 

        return $delete ? true : false; 
    } 
}