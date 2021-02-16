<?php
    defined('ISLOADPAGE') OR exit('No direct script access allowed');

    require_once __DIR__ . '/../../../extra/lib.php';

    use Josantonius\Session\Session;

    $getPage = (int) $parameterPagging;
    if ($getPage < 1) {
        $getPage = 0;
    } else {
        $getPage = round($getPage, 0);
        $getPage--;
    }
    $setOffset = ($getPage * 10);

    $list = [];

    if (!$parameterSearch) {
        $resultJumlah = $conn->prepare("SELECT count(*) FROM users"); 
    } else {
        $resultJumlah = $conn->prepare("SELECT count(*) FROM users WHERE `username` LIKE CONCAT('%', :username, '%')"); 
        $resultJumlah->bindParam(':username', $parameterSearch, PDO::PARAM_STR);
    }
    $resultJumlah->execute(); 
    $getJumlah = $resultJumlah->fetchColumn(); 

    if ($getJumlah > 0) {
        if (!$parameterSearch) {
            $stmt = $conn->prepare("SELECT `id`, `username`, `email`, `role` FROM users ORDER BY id DESC LIMIT 10 OFFSET :skip");
        } else {
            $stmt = $conn->prepare("SELECT `id`, `username`, `email`, `role` FROM users WHERE `username` LIKE CONCAT('%', :username, '%') ORDER BY id DESC LIMIT 10 OFFSET :skip");
            $stmt->bindParam(':username', $parameterSearch, PDO::PARAM_STR);
        }
        $stmt->bindParam(':skip', $setOffset, PDO::PARAM_INT);
        $stmt->execute();
        $hasil = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach($stmt->fetchAll() as $k => $v) {
            $list[] = $v;
        }
    }
?>
<md-content>
    <div class="dashboard-container dashboard-main-content">
        <div class="main-module">
            <md-card>
                <md-card-content>
                    <div class="layout-row">
                        <span>User</span>
                        <span class="flex"></span>
                        <a href="/pbb/index.php?page=users&action=add">Tambah</a>
                    </div>
                    <form class="layout-row layout-align-start-center" method="GET" action="/pbb/index.php">
                        <input type="hidden" name="page" value="users"/>
                        <div class="group">
                            <input type="text" name="q" />
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Search</label>
                        </div>
                        <div class="btn-box">
                            <button class="btn btn-submit" type="submit">Search</button>
                        </div>
                    </form>
                    <div class="full-width">
                        <md-table-container>
                            <table class="md-table">
                                <thead class="md-head">
                                    <tr class="md-row">
                                        <th class="md-column" style="width: 10%;text-align: left;"><span class="table-thead-text">No</span></th>
                                        <th class="md-column" style="width: 50%;text-align: left;"><span class="table-thead-text">Username</span></th>
                                        <th class="md-column" style="width: 40%;text-align: left;"><span class="table-thead-text">Email</span></th>
                                    </tr>
                                </thead>
                                <tbody class="md-body">
                                    <?php
                                    if (count($list) > 0) {
                                        $currentNumber = $setOffset;
                                        foreach ($list as $key => $value) {
                                            $currentNumber++;
                                            echo '<tr class="md-row tr-action">';
                                                echo '<td class="md-cell"><span class="table-thead-text">' . $currentNumber .'</span></td>';
                                                echo '<td class="md-cell">
                                                    <div class="layout-column">
                                                        <span class="table-thead-text">' . $value['username'] .'</span>
                                                        <span class="tr-data-actions layout-row">
                                                            <a class="selecable-content" href="/pbb/index.php?page=users&action=edit&id=' . $value['id'] .'">Edit</a>
                                                            <span>&nbsp;&#8226;&nbsp;</span>
                                                            <a class="selecable-content" href="/pbb/index.php?page=users&action=delete&id=' . $value['id'] .'">Delete</a>
                                                        </span>
                                                    </div>
                                                </td>';
                                                echo '<td class="md-cell"><span class="table-thead-text">' . $value['email'] .'</span></td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr class="md-row"><td colspan="3">Data tidak di temukan</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            if ($getJumlah > 0) {
                                // Membuat halaman
                                echo '<div class="pagination">';
                                $getHalaman = ceil($getJumlah / 10);
                                if ($getHalaman > 1) {
                                    for ($i=0; $i < $getHalaman; $i++) { 
                                        if ($getPage != $i) {
                                            $halamanFix = $i + 1;
                                            if (!$parameterSearch) {
                                                echo '<a href="/pbb/index.php?page=users&pi=' . $halamanFix .'">' . $halamanFix .'</a>';
                                            } else {
                                                echo '<a href="/pbb/index.php?page=users&q=' . $parameterSearch .'&pi=' . $halamanFix .'">' . $halamanFix .'</a>';
                                            }
                                        } else {
                                            $halamanFix = $i + 1;
                                            echo '<a class="active">' . $halamanFix .'</a>';
                                        }
                                    }
                                }
                                echo '</div>';
                            }
                            ?>
                        </md-table-container>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    </div>
</md-content>
