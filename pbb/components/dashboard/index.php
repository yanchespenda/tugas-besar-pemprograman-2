<?php
    defined('ISLOADPAGE') OR exit('No direct script access allowed');

    require_once __DIR__ . '/../../../extra/lib.php';

    use Josantonius\Session\Session;
    
    $getUsername = Session::get('username');

    $stmt = $conn->prepare("SELECT count(`id`) as jumlah FROM chat"); 
    $stmt->execute();
    $rowA = $stmt->fetch();

    $stmt = $conn->prepare("SELECT count(`id`) as jumlah FROM chat_filter"); 
    $stmt->execute();
    $rowB = $stmt->fetch();

    $stmt = $conn->prepare("SELECT count(`id`) as jumlah FROM chat_filtered"); 
    $stmt->execute();
    $rowC = $stmt->fetch();

    $stmt = $conn->prepare("SELECT count(`id`) as jumlah FROM users"); 
    $stmt->execute();
    $rowD = $stmt->fetch();

?>
<md-content>
    <div class="dashboard-cover">
		<div class="dashboard-featured-image"></div>
		<div class="dashboard-featured-bread"></div>
		<div class="dashboard-featured-content">
			<div class="dashboard-featured-core">
				<div class="featured-title"></div>
				<div class="featured-selector"></div>
			</div>
			<div class="featured-data">
				<div class="featured-data-right">
					<div class="featured-data-right-top">
						<span class="md-title featured-title"><?php echo "Holla, " . $getUsername; ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div>
        <div class="dashboard-container dashboard-main-content dashboard-page">
            <div class="dashboard-title">
				<h2 class="md-headline">
					<span>Statistik</span>
				</h2>
			</div>
            <div class="layout-column">
                <div class="layout-row layout-wrap dashboard-main-card-container">
                    <div class="dashboard-main-card-mini">
                        <md-card class="dashboard-card dashboard-main-card-mini-md">
                            <md-card-content class="dashboard-card-content layout-column">
                                <div class="dashboard-card-header">
									<h3 class="dashboard-card-title">Jumlah Chat</h3>
                                </div>
                                <div class="layout-align-center-center layout-row">
                                    <span class="md-headline"><?php echo numberShorten($rowA['jumlah']); ?></span>
                                </div>
                            </md-card-content>
                        </md-card>
                    </div>
                    <div class="dashboard-main-card-mini">
                        <md-card class="dashboard-card dashboard-main-card-mini-md">
                            <md-card-content class="dashboard-card-content layout-column">
                                <div class="dashboard-card-header">
									<h3 class="dashboard-card-title">Jumlah Filter</h3>
                                </div>
                                <div class="layout-align-center-center layout-row">
                                    <span class="md-headline"><?php echo numberShorten($rowB['jumlah']); ?></span>
                                </div>
                            </md-card-content>
                        </md-card>
                    </div>
                    <div class="dashboard-main-card-mini">
                        <md-card class="dashboard-card dashboard-main-card-mini-md">
                            <md-card-content class="dashboard-card-content layout-column">
                                <div class="dashboard-card-header">
									<h3 class="dashboard-card-title">Jumlah Filter Terdeteksi</h3>
                                </div>
                                <div class="layout-align-center-center layout-row">
                                    <span class="md-headline"><?php echo numberShorten($rowC['jumlah']); ?></span>
                                </div>
                            </md-card-content>
                        </md-card>
                    </div>
                    <div class="dashboard-main-card-mini">
                        <md-card class="dashboard-card dashboard-main-card-mini-md">
                            <md-card-content class="dashboard-card-content layout-column">
                                <div class="dashboard-card-header">
									<h3 class="dashboard-card-title">Jumlah Users</h3>
                                </div>
                                <div class="layout-align-center-center layout-row">
                                    <span class="md-headline"><?php echo numberShorten($rowD['jumlah']); ?></span>
                                </div>
                            </md-card-content>
                        </md-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</md-content>
