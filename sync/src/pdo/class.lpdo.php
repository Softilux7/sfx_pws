<?php
/**
 *
 * @Author : Poplax [Email:linjiang9999@gmail.com];
 * @Date : Fri Jun 03 10:17:17 2011;
 * @Filename class.lpdo.php;
 */

/**
 * class lpdo PDO
 * one table support only
 */
class lpdo extends PDO
{
    public $sql = '';
    public $tail = '';
    private $charset = 'UTF8';
    private $options;

    /**
     *
     * @Function : __construct;
     * @Param  $ : $options Array DB config ;
     * @Return Void ;
     */
    public function __construct($options)
    {
        $this->options = $options;
        $dsn = $this->createdsn($options);
        $attrs = empty($options['charset']) ? array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $this->charset) : array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $options['charset']);
        try {
            parent::__construct($dsn, $options['username'], $options['password'], $attrs);
        } catch (PDOException $e) {
            //echo 'Connection failed: ' . $e->getMessage();
            $this->gravarLogPDO('Connection failed: ' . $e->getMessage() . "\n");
        }
    }

    /**
     *
     * @Function : createdsn;
     * @Param  $ : $options Array;
     * @Return String ;
     */
    private function createdsn($options)
    {
        return $options['dbtype'] . ':host=' . $options['host'] . ';dbname=' . $options['dbname'] . ';port=' . $options['port'];
    }

    /**
     * Grava Log em txt
     * @param $msg
     */
    public function gravarLogPDO($msg)
    {

        $data = date("d-m-y");
        $hora = date("H:i:s");
        $ip = $_SERVER['REMOTE_ADDR'];

        //Nome do arquivo:
// rodrigo motta
        $arquivo = getcwd() . "/log/" . $data . "_LoggerPDO.txt";

        //Texto a ser impresso no log:
        $texto = "[$hora][$ip]> $msg \n";

        $manipular = fopen("$arquivo", "a+ b");
        fwrite($manipular, $texto);
        fclose($manipular);

    }

    /**
     *
     * @Function : get_all;
     * @Param  $ : $table String, $condition Array, $getRes Boolean;
     * @Return Array |Object;
     */
    public function get_all($table, $getRes = false, $condition = array())
    {
        return $this->get_rows($table, $condition, $getRes);
    }

    /**
     *
     * @Function : get_rows;
     * @Param  $ : $table String, $getRes Boolean, $condition Array, $column Array;
     * @Return Array |Object;
     */
    public function get_rows($table, $condition, $getRes = false, $column = array(), $orderBy = false)
    {
        $fields = $this->get_fields($column); 
        $cdts = $this->get_condition($condition);
        $where = empty($condition) ? '' : ' where ' . $cdts;

        $orderBy = $orderBy != false ? $orderBy : '';
        $this->sql = 'select ' . $fields . ' from ' . $table . $where . ' ' . $orderBy;
        
        try {
            $this->sql .= $this->tail;
            $rs = parent::query($this->sql);
            //$this->gravarLogPDO('get_rows: ' . $this->sql."\n");
        } catch (PDOException $e) {
            trigger_error("get_rows: ", E_USER_ERROR);
            //echo $e->getMessage() . "<br/>\n";
            $this->gravarLogPDO('get_rows: ' . $e->getMessage() . "\n");
        }

        $rs = $getRes ? $rs : $rs->fetchAll(parent::FETCH_ASSOC);
        return $rs;
    }

    /**
     *
     * @Function : get_fields;
     * @Param  $ : $data Array;
     * @Return String ;
     */
    private function get_fields($data)
    {
        $fields = array();
        if (is_int(key($data))) {
            $fields = implode(',', $data);
        } else if (!empty($data)) {
            $fields = implode(',', array_keys($data));
        } else {
            $fields = '*';
        }
        return $fields;
    }

    /**
     *
     * @Function : get_condition;
     * @Param  $ : $condition Array, $oper String, $logc String;
     * @Return String ;
     */
    private function get_condition($condition, $oper = '=', $logc = 'AND')
    {
        $cdts = '';
        if (empty($condition)) {
            return $cdts = '';
        } else if (is_array($condition)) {
            $_cdta = array();
            foreach ($condition as $k => $v) {
                if (!is_array($v)) {
                    if (strtolower($oper) == 'like') {
                        $v = '\'%' . $v . '%\'';
                    } else if (is_string($v)) {
                        $v = '\'' . $v . '\'';
                    }
                    $_cdta[] = ' ' . $k . ' ' . $oper . ' ' . $v . ' ';
                } else if (is_array($v)) {
                    $_cdta[] = $this->split_condition($k, $v);
                }
            }
            $cdts .= implode($logc, $_cdta);
        } else {
            $cdts = $condition;
        }
        return $cdts;
    }

    /**
     *
     * @Function : split_condition;
     * @Param  $ : $field String, $cdt Array;
     * @Return String ;
     */
    private function split_condition($field, $cdt)
    {
        $cdts = array();
        $oper = empty($cdt[1]) ? '=' : $cdt[1];
        $logc = empty($cdt[2]) ? 'AND' : $cdt[2];
        if (!is_array($cdt[0])) {
            $cdt[0] = is_string($cdt[0]) ? "'$cdt[0]'" : $cdt[0];
        } else if (is_array($cdt[0]) || strtoupper(trim($cdt[1])) == 'IN') {
            $cdt[0] = '(' . implode(',', $cdt[0]) . ')';
        }

        $cdta[] = " $field $oper {$cdt[0]} ";
        if (!empty($cdt[3])) {
            $cdta[] = $this->get_condition($cdt[3]);
        }
        $cdts = ' ( ' . implode($logc, $cdta) . ' ) ';
        return $cdts;
    }

    public function load($query)
    {
        try {

            $result = parent::prepare($query);

            $result->execute();

            if ($result != false) {
                return $result->fetch(PDO::FETCH_OBJ);
            } else {
                throw $e;
            }

        } catch (PDOException $e) {
            //Erro na conex?o do banco
            throw $e;
        }
    }

    public function loadall($query)
    {
        try {

            $result = parent::prepare($query);

            $result->execute();

            if ($result != false) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw $e;
            }

        } catch (PDOException $e) {
            //Erro na conex?o do banco
            throw $e;
        }
    }

    /**
     *
     * @Function : delete;
     * @Param  $ : $table String, $condition Array;
     * @Return Int ;
     */
    public function delete($table, $condition)
    {
        $cdt = $this->get_condition($condition);
        $this->sql = 'delete from ' . $table . ' where ' . $cdt;
        return $this->exec($this->sql, __METHOD__);
    }

    /**
     *
     * @Function : exec;
     * @Param  $ : $sql, $method;
     * @Return Int ;
     */
    public function exec($sql, $method = '')
    {
        try {
            $this->sql = $sql . $this->tail;
            $efnum = parent::exec($this->sql);

            $error = $this->errorInfo();

            if ($error[2] != NULL) {
                $json = json_encode(array('MSG' => $error[2]));
    //            $this->gravarLogPDO("SQL: ".$this->sql . "\n" . "ERRO: ".$json . "\n");
            }
      //      $this->gravarLogPDO($this->sql ."\n".json_encode($error)."\n");
        } catch (PDOException $e) {
            //echo 'PDO ' . $method . ' Error: ' . $e->getMessage();
            $this->gravarLogPDO('PDO ' . $method . ' Error: ' . $e->getMessage() . "\n");
        }
        return intval($efnum);
    }

    /**
     *
     * @Function : setLimit;
     * @Param  $ : $start, $length;
     * @Return ;
     */
    public function set_limit($start = 0, $length = 20)
    {
        $this->tail = ' limit ' . $start . ', ' . $length;
    }

//    /**
//     * Grava Log no BD
//     * @param $msg
//     */
//    public function gravarLogBD($empresa_id, $base_id, $nmfantasia, $tabela, $evt, $log)
//    {
//        $dados = array();
//        $dados['empresa_id'] = $empresa_id;
//        $dados['base_id'] = $base_id;
//        $dados['nmfantasia'] = $nmfantasia;
//        $dados['tabela'] = $tabela;
//        $dados['evt'] = $evt;
//        $dados['log'] = $log;
//
//        $conditions = array();
//
//        $this->save('logs', $dados, $conditions);
//
//
//    }

    /**
     *
     * @Function : save;
     * @Param  $ : $table String, $data Array, $condition Array;
     * @Return Int ;
     */
    public function save($table, $data, $condition)
    {
        $cdt = $this->get_condition($condition);
        list($strf, $strd) = $this->get_fields_datas($data);
        $has1 = $this->get_one($table, $condition);
        if (!$has1) {
            $enum = $this->insert($table, $data);
        } else {
            $enum = $this->update($table, $data, $condition);
        }
        return $enum;
    }

    /**
     *
     * @Function : get_fields_datas;
     * @Param  $ : $data Array;
     * @Return Array ;
     */
    private function get_fields_datas($data)
    {
        $arrf = $arrd = array();
        foreach ($data as $f => $d) {
            $arrf[] = '`' . $f . '`';
            //$arrd[] = is_string($d) ? '\'' . $d . '\'' : $d;
            
            if($d == ''){
                $arrd[] = 'null';
            }else if(is_string($d)){
                 $arrd[] = '\'' . $d . '\'';
            }else{
                $arrd[] = $d;
            }
            
        }
        $res = array(implode(',', $arrf), implode(',', $arrd));
        return $res;
    }

    /**
     *
     * @Function : get_one;
     * @Param  $ : $table String, $condition Array, $getRes Boolean, $column Array;
     * @Return Array ;
     */
    public function get_one($table, $condition, $column = array(), $orderBy = false)
    {
        $rs = $this->get_rows($table, $condition, true, $column, $orderBy);
        $rs = $rs ? $rs->fetch(parent::FETCH_ASSOC) : $rs;
        return $rs;
    }

    /**
     *
     * @Function : insert;
     * @Param  $ : $table String, $data Array;
     * @Return Int ;
     */
    public function insert($table, $data)
    {
        list($strf, $strd) = $this->get_fields_datas($data);
        $this->sql = 'insert into `' . $table . '` (' . $strf . ') values (' . $strd . '); ';
        
        return $this->exec($this->sql, __METHOD__);
    }

    /**
     *
     * @Function : update;
     * @Param  $ : $table String, $data Array, $condition Array;
     * @Return Int ;
     */
    public function update($table, $data, $condition)
    {
        $cdt = $this->get_condition($condition);
        $arrd = array();
        foreach ($data as $f => $d) {
            if($d == ''){
                $arrd[] = "`$f` = null";
            }else{
                $arrd[] = "`$f` = '$d'";
            }
        }
        $strd = implode(',', $arrd);
        $this->sql = 'update ' . $table . ' set ' . $strd . ' where ' . $cdt;
        
//	$this->gravarLogPDO("$this->sql \n");
        return $this->exec($this->sql, __METHOD__);
    }

}

?>
