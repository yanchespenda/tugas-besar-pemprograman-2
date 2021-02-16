<?php
    defined('ISLOADPAGE') OR exit('No direct script access allowed');

    require_once __DIR__ . '/../../../extra/lib.php';

    use Josantonius\Session\Session;
?>
<md-content>
    <div class="dashboard-container dashboard-main-content">
        <div class="main-module">
            <md-card>
                <md-card-content>
                    <div class="layout-row">
                        <span>Tambah Filter Chat</span>
                        <span class="flex"></span>
                        <a href="/pbb/index.php?page=filter">Batal</a>
                    </div>
                    <div class="layout-column full-width">
                        <form method="POST" action="/pbb/index.php?page=filter&action=save">
                            <div class="group">
                                <input type="text" name="kata" required="required"/>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Kata</label>
                            </div>
                            <div class="btn-box">
                                <button class="btn btn-submit" name="submit" value="submit" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    </div>
</md-content>