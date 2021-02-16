<?php
    defined('ISLOADPAGE') OR exit('No direct script access allowed');

    require_once __DIR__ . '/../../../extra/lib.php';

    use Josantonius\Session\Session;

    $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE id = :id LIMIT 1"); 
    $stmt->bindParam(':id', $parameterId);
    $stmt->execute();
    $row = $stmt->fetch();

    if (!$row) {
        echo 'Data not found';
        header( "refresh:2;url=/pbb/index.php?page=users" );
        exit();
    }
?>
<md-content>
    <div class="dashboard-container dashboard-main-content">
        <div class="main-module">
            <md-card>
                <md-card-content>
                    <div class="layout-row">
                        <span>Edit Users</span>
                        <span class="flex"></span>
                        <a href="/pbb/index.php?page=users">Batal</a>
                    </div>
                    <div class="layout-column full-width">
                        <form method="POST" action="/pbb/index.php?page=users&action=save">
                            <input type="hidden" name="id" value="<?php echo $row['id'];?>" >
                            <div class="group">
                                <input type="text" name="username" value="<?php echo $row['username'];?>" required="required"/>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Username</label>
                            </div>
                            <div class="group">
                                <input type="text" name="email" value="<?php echo $row['email'];?>" required="required"/>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Email</label>
                            </div>
                            <div class="group">
                                <input type="password" name="password"/>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Password (Fill to changed password)</label>
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