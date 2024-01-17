<?php
require '../../connect.php';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(!isset($_POST['category']) || !isset($_POST['type'])) exit("No direct script access allowed!");
    if(!in_array($_POST['type'], ['socmed','ppob','games'])) exit("No direct script access allowed!");
    if($_POST['type'] == 'ppob' && !isset($_POST['brand'])) exit("No direct script access allowed!");
    
    if($_POST['type'] == 'socmed') {
        $search = $call->query("SELECT * FROM srv_socmed WHERE cid = '".filter($_POST['category'])."' ORDER BY price ASC");
        if($search->num_rows > 0) {
            while($row = $search->fetch_assoc()) {
                $get_status = ($row['status'] == 'available') ? "<font color='green'><i class='far fa-check-circle mr-1'></i>Available</font>" : "<font color='red'><i class='far fa-times-circle mr-1'></i>Empty</font>";
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= currency($row['min']) ?></td>
                    <td><?= currency($row['max']) ?></td>
                    <td>Rp <?= currency($row['price']+$row['basic']) ?></td>
                    <td>Rp <?= currency($row['price']+$row['premium']) ?></td>
                    <td align="center"><?= $get_status ?></td>
                </tr>
                <?
            }
        } else {
            print '
                <tr>
                    <td colspan="6" class="text-center">No data available.</td>
                    <td class="text-center text-danger"><i class="far fa-times-circle"></td>
                </tr>
            ';
        }
    }
    
    if($_POST['type'] == 'ppob') {
        $search = $call->query("SELECT * FROM srv_ppob WHERE type = '".filter($_POST['category'])."' AND brand = '".filter($_POST['brand'])."' ORDER BY price ASC");
        if($search->num_rows > 0) {
            while($row = $search->fetch_assoc()) {
                $get_status = ($row['status'] == 'available') ? "<font color='green'><i class='far fa-check-circle mr-1'></i>Available</font>" : "<font color='red'><i class='far fa-times-circle mr-1'></i>Empty</font>";
                ?>
                <tr>
                    <td><?= $row['code'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['note'] ?></td>
                    <td>Rp <?= currency($row['price']+$row['basic']) ?></td>
                    <td>Rp <?= currency($row['price']+$row['premium']) ?></td>
                    <td align="center"><?= $get_status ?></td>
                </tr>
                <?
            }
        } else {
            print '
                <tr>
                    <td colspan="5" class="text-center">No data available.</td>
                    <td class="text-center text-danger"><i class="far fa-times-circle"></td>
                </tr>
            ';
        }
    }
    
    if($_POST['type'] == 'games') {
        $search = $call->query("SELECT * FROM srv_game WHERE game = '".filter($_POST['category'])."' ORDER BY price ASC");
        if($search->num_rows > 0) {
            while($row = $search->fetch_assoc()) {
                $get_status = ($row['status'] == 'available') ? "<font color='green'><i class='far fa-check-circle mr-1'></i>Available</font>" : "<font color='red'><i class='far fa-times-circle mr-1'></i>Empty</font>";
                ?>
                <tr>
                    <td><?= $row['code'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td>Rp <?= currency($row['price']+$row['basic']) ?></td>
                    <td>Rp <?= currency($row['price']+$row['premium']) ?></td>
                    <td align="center"><?= $get_status ?></td>
                </tr>
                <?
            }
        } else {
            print '
                <tr>
                    <td colspan="4" class="text-center">No data available.</td>
                    <td class="text-center text-danger"><i class="far fa-times-circle"></td>
                </tr>
            ';
        }
    }
} else {
    exit("No direct script access allowed!");
}