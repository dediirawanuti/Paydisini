<?php
class SSP
{
    static function data_output($columns, $data, $isJoin = false) {
        $out = [];
        for($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = [];
            for($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $column = $columns[$j];
                if(isset($column['formatter'])) {
                    $row[$column['dt']] = ($isJoin) ? $column['formatter']($data[$i][$column['field']], $data[$i]) : $column['formatter']($data[$i][$column['db']], $data[$i]);
                } else {
                    $row[$column['dt']] = ($isJoin) ? $data[$i][$columns[$j]['field']] : $data[$i][$columns[$j]['db']];
                }
            }
            $out[] = $row;
        }
        return $out;
    }
    
    static function limit($request, $columns) {
        $limit = '';
        if(isset($request['start']) && $request['length'] != -1) $limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
        return $limit;
    }
    
    static function order($request, $columns, $isJoin = false) {
        $order = '';
        if(isset($request['order']) && count($request['order'])) {
            $orderBy = [];
            $dtColumns = SSP::pluck($columns, 'dt');
            for($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[ $columnIdx ];
                if($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ? 'ASC' : 'DESC';
                    $orderBy[] = ($isJoin) ? $column['db'].' '.$dir : '`'.$column['db'].'` '.$dir;
                }
            }
            $order = 'ORDER BY '.implode(', ', $orderBy);
        }
        return $order;
    }
    
    static function filter($request, $columns, &$bindings, $isJoin = false) {
        $globalSearch = [];
        $columnSearch = [];
        $dtColumns = SSP::pluck($columns, 'dt');
        if (isset($request['search']) && $request['search']['value'] != '') {
            $str = $request['search']['value'];
            for($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[ $columnIdx ];
                if($requestColumn['searchable'] == 'true') {
                    $binding = SSP::bind($bindings, '%'.$str.'%', PDO::PARAM_STR);
                    $globalSearch[] = ($isJoin) ? $column['db']." LIKE ".$binding : "`".$column['db']."` LIKE ".$binding;
                }
            }
        }
        
        for($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
            $requestColumn = $request['columns'][$i];
            $columnIdx = array_search($requestColumn['data'], $dtColumns);
            $column = $columns[$columnIdx];
            $str = $requestColumn['search']['value'];
            if($requestColumn['searchable'] == 'true' && $str != '') {
                $binding = SSP::bind($bindings, '%'.$str.'%', PDO::PARAM_STR);
                $columnSearch[] = ($isJoin) ? $column['db']." LIKE ".$binding : "`".$column['db']."` LIKE ".$binding;
            }
        }
        
        $where = '';
        if(count($globalSearch)) $where = '('.implode(' OR ', $globalSearch).')';
        if(count($columnSearch)) $where = $where === '' ? implode(' AND ', $columnSearch) : $where .' AND '. implode(' AND ', $columnSearch);
        if($where !== '') $where = 'WHERE '.$where;
        return $where;
    }
    
    static function simple($request, $sql_details, $table, $primaryKey, $columns, $joinQuery = NULL, $extraWhere = '', $groupBy = '', $having = '') {
        $bindings = [];
        $db = SSP::sql_connect($sql_details);
        $limit = SSP::limit($request, $columns);
        $order = SSP::order($request, $columns, $joinQuery);
        $where = SSP::filter($request, $columns, $bindings, $joinQuery);
        if($extraWhere) $extraWhere = ($where) ? ' AND '.$extraWhere : ' WHERE '.$extraWhere;
        $groupBy = ($groupBy) ? ' GROUP BY '.$groupBy .' ' : '';
        $having = ($having) ? ' HAVING '.$having .' ' : '';
        if($joinQuery) {
            $col = SSP::pluck($columns, 'db', $joinQuery);
            $query =  "SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $col)." $joinQuery $where $extraWhere $groupBy $having $order $limit";
        } else {
            $query =  "SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", SSP::pluck($columns, 'db'))."` FROM `$table` $where $extraWhere $groupBy $having $order $limit";
        }
        $data = SSP::sql_exec($db, $bindings,$query);
        $resFilterLength = SSP::sql_exec($db, "SELECT FOUND_ROWS()");
        $recordsFiltered = $resFilterLength[0][0];
        $resTotalLength = SSP::sql_exec($db, "SELECT COUNT(`{$primaryKey}`) FROM `$table`");
        $recordsTotal = $resTotalLength[0][0];
        return ['draw' => intval($request['draw']),'recordsTotal' => intval($recordsTotal),'recordsFiltered' => intval($recordsFiltered),'data' => SSP::data_output($columns, $data, $joinQuery)];
    }
    
    static function sql_connect($sql_details) {
        try {
            $db = @new PDO(
                "mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
                $sql_details['user'],
                $sql_details['pass'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            $db->query("SET NAMES 'utf8'");
        }
        catch (PDOException $e) {
            SSP::fatal(
                "An error occurred while connecting to the database. ".
                "The error reported by the server was: ".$e->getMessage()
            );
        }
        return $db;
    }
    
    static function sql_exec($db, $bindings, $sql = null) {
        if($sql === null) $sql = $bindings;
        $stmt = $db->prepare( $sql );
        if(is_array($bindings)) {
            for($i = 0, $ien = count($bindings); $i < $ien; $i++) {
                $stmt->bindValue($bindings[$i]['key'], $bindings[$i]['val'], $bindings[$i]['type']);
            }
        }

        try {
            $stmt->execute();
        }
        catch(PDOException $e) {
            SSP::fatal( "An SQL error occurred: ".$e->getMessage() );
        }

        return $stmt->fetchAll();
    }
    
    static function fatal($msg) {
        echo json_encode(['error' => $msg]);
        exit(0);
    }
    
    static function bind(&$a, $val, $type) {
        $key = ':binding_'.count( $a );
        $a[] = ['key' => $key,'val' => $val,'type' => $type];
        return $key;
    }
    
    static function pluck($a, $prop, $isJoin = false) {
        $out = [];
        for($i=0, $len=count($a); $i<$len; $i++) {
            $out[] = ($isJoin && isset($a[$i]['as'])) ? $a[$i][$prop]. ' AS '.$a[$i]['as'] : $a[$i][$prop];
        }
        return $out;
    }
}