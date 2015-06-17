<?php
/**
 * ˵�����־��ļ�����_v1.sqlΪ��β(20120522021241_all_v1.sql)
 * ���ܣ�ʵ��mysql���ݿ�־���,ѡ�����б���,ʵ�ֵ���sql�ļ����־�sql����
 * ʹ�÷�����
 *
 * -------------------------------- ���ݿⱸ�ݣ�������--------------------------------
 * �ֱ����������û��������룬���ݿ��������ݿ����
 * $db = new DBManage ( 'localhost', 'root', 'root', 'test', 'utf8' );
 * �����������ĸ���(��ѡ),����Ŀ¼(��ѡ��Ĭ��Ϊbackup),�־��С(��ѡ,Ĭ��2000����2M)
 * $db->backup ();
 *
 * -------------------------------- ���ݿ�ָ������룩--------------------------------
 * �ֱ����������û��������룬���ݿ��������ݿ����
 * $db = new DBManage ( 'localhost', 'root', 'root', 'test', 'utf8' );
 * ������sql�ļ�
 * $db->restore ( './backup/20120516211738_all_v1.sql');
 */
class DbManage {
    var $db; // ���ݿ�����
    var $database; // �������ݿ�
    var $sqldir; // ���ݿⱸ���ļ���
    // ���з�
    private $ds = "\n";
    // �洢SQL�ı���
    public $sqlContent = "";
    // ÿ��sql���Ľ�β��
    public $sqlEnd = ";";

    /**
     * ��ʼ��
     *
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @param string $charset
     */
    function __construct($host = 'localhost', $username = 'root', $password = '', $database = 'test', $charset = 'utf8') {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->charset = $charset;
        set_time_limit(0);//��ʱ������
        @ob_end_flush();
        // �������ݿ�
        $this->db = @mysql_connect ( $this->host, $this->username, $this->password ) or die( '<p class="dbDebug"><span class="err">Mysql Connect Error : </span>'.mysql_error().'</p>');
        // ѡ��ʹ���ĸ����ݿ�
        mysql_select_db ( $this->database, $this->db ) or die('<p class="dbDebug"><span class="err">Mysql Connect Error:</span>'.mysql_error().'</p>');
        // ���ݿ���뷽ʽ
        mysql_query ( 'SET NAMES ' . $this->charset, $this->db );

    }

    /*
     * ������ѯ���ݿ��
     */
    function getTables() {
        $res = mysql_query ( "SHOW TABLES" );
        $tables = array ();
        while ( $row = mysql_fetch_array ( $res ) ) {
            $tables [] = $row [0];
        }
        return $tables;
    }

    /*
     *
     * ------------------------------------------���ݿⱸ��start----------------------------------------------------------
     */

    /**
     * ���ݿⱸ��
     * �����������ĸ���(��ѡ),����Ŀ¼(��ѡ��Ĭ��Ϊbackup),�־��С(��ѡ,Ĭ��2000����2M)
     *
     * @param $string $dir
     * @param int $size
     * @param $string $tablename
     */
    function backup($tablename = '', $dir, $size) {
        $dir = $dir ? $dir : './backup/';
        // ����Ŀ¼
        if (! is_dir ( $dir )) {
            mkdir ( $dir, 0777, true ) or die ( '�����ļ���ʧ��' );
        }
        $size = $size ? $size : 2048;
        $sql = '';
        // ֻ����ĳ����
        if (! empty ( $tablename )) {
            if(@mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$tablename."'")) == 1) {
             } else {
                $this->_showMsg('��-<b>' . $tablename .'</b>-�����ڣ����飡',true);
                die();
            }
            $this->_showMsg('���ڱ��ݱ� <span class="imp">' . $tablename.'</span>');
            // ����dump��Ϣ
            $sql = $this->_retrieve ();
            // �����ṹ��Ϣ
            $sql .= $this->_insert_table_structure ( $tablename );
            // ��������
            $data = mysql_query ( "select * from " . $tablename );
            // �ļ���ǰ�沿��
            $filename = date ( 'YmdHis' ) . "_" . $tablename;
            // �ֶ�����
            $num_fields = mysql_num_fields ( $data );
            // �ڼ��־�
            $p = 1;
            // ѭ��ÿ����¼
            while ( $record = mysql_fetch_array ( $data ) ) {
                // ������¼
                $sql .= $this->_insert_record ( $tablename, $num_fields, $record );
                // ������ڷ־��С����д���ļ�
                if (strlen ( $sql ) >= $size * 1024) {
                    $file = $filename . "_v" . $p . ".sql";
                    if ($this->_write_file ( $sql, $file, $dir )) {
                        $this->_showMsg("��-<b>" . $tablename . "</b>-��-<b>" . $p . "</b>-���ݱ������,�����ļ� [ <span class='imp'>" .$dir . $file ."</span> ]");
                    } else {
                        $this->_showMsg("���ݱ� -<b>" . $tablename . "</b>- ʧ��",true);
                        return false;
                    }
                    // ��һ���־�
                    $p ++;
                    // ����$sql����Ϊ�գ����¼���ñ�����С
                    $sql = "";
                }
            }
            // ��ʱ�������
            unset($data,$record);
            // sql��С�����־��С
            if ($sql != "") {
                $filename .= "_v" . $p . ".sql";
                if ($this->_write_file ( $sql, $filename, $dir )) {
                    $this->_showMsg( "��-<b>" . $tablename . "</b>-��-<b>" . $p . "</b>-���ݱ������,�����ļ� [ <span class='imp'>" .$dir . $filename ."</span> ]");
                } else {
                    $this->_showMsg("���ݾ�-<b>" . $p . "</b>-ʧ��<br />");
                    return false;
                }
            }
            $this->_showMsg("��ϲ��! <span class='imp'>���ݳɹ�</span>");
        } else {
            $this->_showMsg('���ڱ���');
            // ����ȫ����
            if ($tables = mysql_query ( "show table status from " . $this->database )) {
                $this->_showMsg("��ȡ���ݿ�ṹ�ɹ���");
            } else {
                $this->_showMsg("��ȡ���ݿ�ṹʧ�ܣ�");
                exit ( 0 );
            }
            // ����dump��Ϣ
            $sql .= $this->_retrieve ();
            // �ļ���ǰ�沿��
            $filename = date ( 'YmdHis' ) . "_all";
            // ������б�
            $tables = mysql_query ( 'SHOW TABLES' );
            // �ڼ��־�
            $p = 1;
            // ѭ�����б�
            while ( $table = mysql_fetch_array ( $tables ) ) {
                // ��ȡ����
                $tablename = $table [0];
                // ��ȡ��ṹ
                $sql .= $this->_insert_table_structure ( $tablename );
                $data = mysql_query ( "select * from " . $tablename );
                $num_fields = mysql_num_fields ( $data );

                // ѭ��ÿ����¼
                while ( $record = mysql_fetch_array ( $data ) ) {
                    // ������¼
                    $sql .= $this->_insert_record ( $tablename, $num_fields, $record );
                    // ������ڷ־��С����д���ļ�
                    if (strlen ( $sql ) >= $size * 1000) {

                        $file = $filename . "_v" . $p . ".sql";
                        // д���ļ�
                        if ($this->_write_file ( $sql, $file, $dir )) {
                            $this->_showMsg("-��-<b>" . $p . "</b>-���ݱ������,�����ļ� [ <span class='imp'>".$dir.$file."</span> ]");
                        } else {
                            $this->_showMsg("��-<b>" . $p . "</b>-����ʧ��!",true);
                            return false;
                        }
                        // ��һ���־�
                        $p ++;
                        // ����$sql����Ϊ�գ����¼���ñ�����С
                        $sql = "";
                    }
                }
            }
            // sql��С�����־��С
            if ($sql != "") {
                $filename .= "_v" . $p . ".sql";
                if ($this->_write_file ( $sql, $filename, $dir )) {
                    $this->_showMsg("-��-<b>" . $p . "</b>-���ݱ������,�����ļ� [ <span class='imp'>".$dir.$filename."</span> ]");
                } else {
                    $this->_showMsg("��-<b>" . $p . "</b>-����ʧ��",true);
                    return false;
                }
            }
            $this->_showMsg("��ϲ��! <span class='imp'>���ݳɹ�</span>");
        }
    }

    //  ��ʱ�����Ϣ
    private function _showMsg($msg,$err=false){
        $err = $err ? "<span class='err'>ERROR:</span>" : '' ;
        echo "<p class='dbDebug'>".$err . $msg."</p>";
        flush();

    }

    /**
     * �������ݿⱸ�ݻ�����Ϣ
     *
     * @return string
     */
    private function _retrieve() {
        $value = '';
        $value .= '--' . $this->ds;
        $value .= '-- MySQL database dump' . $this->ds;
        $value .= '-- Created by DbManage class, Power By yanue. ' . $this->ds;
        $value .= '-- http://yanue.net ' . $this->ds;
        $value .= '--' . $this->ds;
        $value .= '-- ����: ' . $this->host . $this->ds;
        $value .= '-- ��������: ' . date ( 'Y' ) . ' ��  ' . date ( 'm' ) . ' �� ' . date ( 'd' ) . ' �� ' . date ( 'H:i' ) . $this->ds;
        $value .= '-- MySQL�汾: ' . mysql_get_server_info () . $this->ds;
        $value .= '-- PHP �汾: ' . phpversion () . $this->ds;
        $value .= $this->ds;
        $value .= '--' . $this->ds;
        $value .= '-- ���ݿ�: `' . $this->database . '`' . $this->ds;
        $value .= '--' . $this->ds . $this->ds;
        $value .= '-- -------------------------------------------------------';
        $value .= $this->ds . $this->ds;
        return $value;
    }

    /**
     * �����ṹ
     *
     * @param unknown_type $table
     * @return string
     */
    private function _insert_table_structure($table) {
        $sql = '';
        $sql .= "--" . $this->ds;
        $sql .= "-- ��Ľṹ" . $table . $this->ds;
        $sql .= "--" . $this->ds . $this->ds;

        // ���������ɾ����
        $sql .= "DROP TABLE IF EXISTS `" . $table . '`' . $this->sqlEnd . $this->ds;
        // ��ȡ��ϸ����Ϣ
        $res = mysql_query ( 'SHOW CREATE TABLE `' . $table . '`' );
        $row = mysql_fetch_array ( $res );
        $sql .= $row [1];
        $sql .= $this->sqlEnd . $this->ds;
        // ����
        $sql .= $this->ds;
        $sql .= "--" . $this->ds;
        $sql .= "-- ת����е����� " . $table . $this->ds;
        $sql .= "--" . $this->ds;
        $sql .= $this->ds;
        return $sql;
    }

    /**
     * ���뵥����¼
     *
     * @param string $table
     * @param int $num_fields
     * @param array $record
     * @return string
     */
    private function _insert_record($table, $num_fields, $record) {
        // sql�ֶζ��ŷָ�
        $insert = '';
        $comma = "";
        $insert .= "INSERT INTO `" . $table . "` VALUES(";
        // ѭ��ÿ���Ӷ����������
        for($i = 0; $i < $num_fields; $i ++) {
            $insert .= ($comma . "'" . mysql_escape_string ( $record [$i] ) . "'");
            $comma = ",";
        }
        $insert .= ");" . $this->ds;
        return $insert;
    }

    /**
     * д���ļ�
     *
     * @param string $sql
     * @param string $filename
     * @param string $dir
     * @return boolean
     */
    private function _write_file($sql, $filename, $dir) {
        $dir = $dir ? $dir : './backup/';
        // ����Ŀ¼
        if (! is_dir ( $dir )) {
            mkdir ( $dir, 0777, true );
        }
        $re = true;
        if (! @$fp = fopen ( $dir . $filename, "w+" )) {
            $re = false;
            $this->_showMsg("��sql�ļ�ʧ�ܣ�",true);
        }
        if (! @fwrite ( $fp, $sql )) {
            $re = false;
            $this->_showMsg("д��sql�ļ�ʧ�ܣ����ļ��Ƿ��д",true);
        }
        if (! @fclose ( $fp )) {
            $re = false;
            $this->_showMsg("�ر�sql�ļ�ʧ�ܣ�",true);
        }
        return $re;
    }

    /*
     *
     * -------------------------------�ϣ����ݿ⵼��-----------�ָ���----------�£����ݿ⵼��--------------------------------
     */

    /**
     * ���뱸������
     * ˵�����־��ļ���ʽ20120516211738_all_v1.sql
     * �������ļ�·��(����)
     *
     * @param string $sqlfile
     */
    function restore($sqlfile) {
        // ����ļ��Ƿ����
        if (! file_exists ( $sqlfile )) {
            $this->_showMsg("sql�ļ������ڣ�����",true);
            exit ();
        }
        $this->lock ( $this->database );
        // ��ȡ���ݿ�洢λ��
        $sqlpath = pathinfo ( $sqlfile );
        $this->sqldir = $sqlpath ['dirname'];
        // ����Ƿ�����־�������20120516211738_all_v1.sql��_v�ֿ�,����˵���з־�
        $volume = explode ( "_v", $sqlfile );
        $volume_path = $volume [0];
        $this->_showMsg("����ˢ�¼��ر�������Է�ֹ������ֹ�����в��������������ݿ�ṹ����");
        $this->_showMsg("���ڵ��뱸�����ݣ����Եȣ�");
        if (empty ( $volume [1] )) {
            $this->_showMsg ( "���ڵ���sql��<span class='imp'>" . $sqlfile . '</span>');
            // û�з־�
            if ($this->_import ( $sqlfile )) {
                $this->_showMsg( "���ݿ⵼��ɹ���");
            } else {
                 $this->_showMsg('���ݿ⵼��ʧ�ܣ�',true);
                exit ();
            }
        } else {
            // ���ڷ־����ȡ��ǰ�ǵڼ��־�ѭ��ִ�����·־�
            $volume_id = explode ( ".sq", $volume [1] );
            // ��ǰ�־�Ϊ$volume_id
            $volume_id = intval ( $volume_id [0] );
            while ( $volume_id ) {
                $tmpfile = $volume_path . "_v" . $volume_id . ".sql";
                // ���������־�����ִ��
                if (file_exists ( $tmpfile )) {
                    // ִ�е��뷽��
                    $this->msg .= "���ڵ���־� $volume_id ��<span style='color:#f00;'>" . $tmpfile . '</span><br />';
                    if ($this->_import ( $tmpfile )) {

                    } else {
                        $volume_id = $volume_id ? $volume_id :1;
                        exit ( "����־�<span style='color:#f00;'>" . $tmpfile . '</span>ʧ�ܣ����������ݿ�ṹ���𻵣��볢�Դӷ־�1��ʼ����' );
                    }
                } else {
                    $this->msg .= "�˷־���ȫ������ɹ���<br />";
                    return;
                }
                $volume_id ++;
            }
        }if (empty ( $volume [1] )) {
            $this->_showMsg ( "���ڵ���sql��<span class='imp'>" . $sqlfile . '</span>');
            // û�з־�
            if ($this->_import ( $sqlfile )) {
                $this->_showMsg( "���ݿ⵼��ɹ���");
            } else {
                 $this->_showMsg('���ݿ⵼��ʧ�ܣ�',true);
                exit ();
            }
        } else {
            // ���ڷ־����ȡ��ǰ�ǵڼ��־�ѭ��ִ�����·־�
            $volume_id = explode ( ".sq", $volume [1] );
            // ��ǰ�־�Ϊ$volume_id
            $volume_id = intval ( $volume_id [0] );
            while ( $volume_id ) {
                $tmpfile = $volume_path . "_v" . $volume_id . ".sql";
                // ���������־�����ִ��
                if (file_exists ( $tmpfile )) {
                    // ִ�е��뷽��
                    $this->msg .= "���ڵ���־� $volume_id ��<span style='color:#f00;'>" . $tmpfile . '</span><br />';
                    if ($this->_import ( $tmpfile )) {

                    } else {
                        $volume_id = $volume_id ? $volume_id :1;
                        exit ( "����־�<span style='color:#f00;'>" . $tmpfile . '</span>ʧ�ܣ����������ݿ�ṹ���𻵣��볢�Դӷ־�1��ʼ����' );
                    }
                } else {
                    $this->msg .= "�˷־���ȫ������ɹ���<br />";
                    return;
                }
                $volume_id ++;
            }
        }
    }

    /**
     * ��sql���뵽���ݿ⣨��ͨ���룩
     *
     * @param string $sqlfile
     * @return boolean
     */
    private function _import($sqlfile) {
        // sql�ļ�������sql�������
        $sqls = array ();
        $f = fopen ( $sqlfile, "rb" );
        // �����������
        $create_table = '';
        while ( ! feof ( $f ) ) {
            // ��ȡÿһ��sql
            $line = fgets ( $f );
            // ��һ��Ϊ�˽�������ϳ�������sql���
            // �����βû�а���';'(��Ϊһ��������sql��䣬�����ǲ������)�����Ҳ�����'ENGINE='(������������һ��)
            if (! preg_match ( '/;/', $line ) || preg_match ( '/ENGINE=/', $line )) {
                // ������sql����봴����sql���Ӵ�����
                $create_table .= $line;
                // ��������˴���������һ��
                if (preg_match ( '/ENGINE=/', $create_table)) {
                    //ִ��sql��䴴����
                    $this->_insert_into($create_table);
                    // ��յ�ǰ��׼����һ����Ĵ���
                    $create_table = '';
                }
                // ��������
                continue;
            }
            //ִ��sql���
            $this->_insert_into($line);
        }
        fclose ( $f );
        return true;
    }

    //���뵥��sql���
    private function _insert_into($sql){
        if (! mysql_query ( trim ( $sql ) )) {
            $this->msg .= mysql_error ();
            return false;
        }
    }

    /*
     * -------------------------------���ݿ⵼��end---------------------------------
     */

    // �ر����ݿ�����
    private function close() {
        mysql_close ( $this->db );
    }

    // �������ݿ⣬���ⱸ�ݻ���ʱ����
    private function lock($tablename, $op = "WRITE") {
        if (mysql_query ( "lock tables " . $tablename . " " . $op ))
            return true;
        else
            return false;
    }

    // ����
    private function unlock() {
        if (mysql_query ( "unlock tables" ))
            return true;
        else
            return false;
    }

    // ����
    function __destruct() {
        if($this->db){
            mysql_query ( "unlock tables", $this->db );
            mysql_close ( $this->db );
        }
    }

}