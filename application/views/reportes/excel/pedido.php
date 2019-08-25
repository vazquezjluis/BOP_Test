<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
header('Content-Disposition: attachment; filename=rep_menu_pedido_'. date('Y-m-d H:i:s').'.xls');

?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Legajo</th>
            <th>Persona</th>
            <th>Plato</th>
            <th>Estado</th>
            <th>Nota</th>
            <th>Fecha Pedido</th>
            <th>valor</th>
        </tr>
    </thead>
    <tbody>
        
        <?php 
            foreach ($_SESSION['excel_pedido'] as $r) {
            echo '<tr>';
            echo '<td> '.$r->legajo.'</td>';
            echo '<td> '.$r->persona.'</td>';
            echo '<td> '.$r->plato.'</td>';
            echo '<td> '.$r->estado.'</td>';
            echo '<td> '.$r->nota.'</td>';
            echo '<td> '.date('d/m/Y',strtotime($r->f_pedido)).'</td>';
            echo '<td> '.$r->valor.'</td>';
            
            echo '</tr>';
        }?>
        <tr>
            
        </tr>
    </tbody>
</table>
