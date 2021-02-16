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
                        <span>Tambah Users</span>
                        <span class="flex"></span>
                        <a href="/pbb/index.php?page=users">Batal</a>
                    </div>
                    <div class="layout-column full-width">
                        <form method="POST" action="/pbb/index.php?page=users&action=save">
                            <div class="group">
                                <input type="text" name="username" required="required"/>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Username</label>
                            </div>
                            <div class="group">
                                <input type="text" name="email" required="required"/>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Email</label>
                            </div>
                            <div class="group">
                                <input type="password" name="password" required="required"/>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Password</label>
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