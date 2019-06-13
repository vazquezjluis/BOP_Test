<?php
/*
    $serverName = "192.168.2.18";
    $connectionInfo = array( "Database"=>"controlLenox2", "UID"=>"intranet", "PWD"=>"intranetbingo");
    $conn = sqlsrv_connect( $serverName, $connectionInfo );
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    $sql = "SELECT imagen FROM cliente where id = 1";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }

    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          header("Content-Type: image/gif");
          echo $row['imagen'];
    }

    sqlsrv_free_stmt( $stmt); */
//header("Content-Type: image/gif");
//echo $imagen;
?>
