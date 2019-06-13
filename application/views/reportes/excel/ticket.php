<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=rep_ticket_'. date('Y-m-d H:i:s').'.xls');

?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>F. Solicitud</th>
            <th>Solicita</th>
            <th>Descripcion</th>
            <th>Referencia</th>
            <th>Prioridad</th>
            <th>Asignado</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        
        <?php 
            $estado = array(
                1=>"Abierto",
                2=>"Resuelto",
                3=>"Cerrado",
                4=>"Cancelado"
            );
            $prioridad = array(
                0=>array("success","baja"),
                1=>array("important","alta"),
                2=>array("warning","media"),
                3=>array("",""),
                4=>array("",""),
                ''=>array("","")
            );
            foreach ($_SESSION['excel_ticket'] as $r) {
            echo '<tr>';
            echo '<td> '.$r->idTicket.'</td>';
            echo '<td> '.date('d/m/Y H:m:s',strtotime($r->f_solicitud)).'</td>';
            echo '<td> '.$r->solicita.'</td>';
            echo '<td> '.$r->descripcion.'</td>';
            echo '<td> '.$r->referencia.'</td>';
            echo '<td> '.$prioridad[$r->prioridad][1].'</td>';
            echo '<td> '.$r->asignado.'</td>';
            echo '<td> '.$estado[$r->estado].'</td>';
            
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
