<?php
    if (!defined('ISLOADPAGE')) {
        define('ISLOADPAGE', true);
    }
    require_once __DIR__ . '/../extra/lib.php';

    use Wruczek\PhpFileCache\PhpFileCache;
    use Carbon\Carbon;

    $serverMethod = $_SERVER['REQUEST_METHOD'];

    $dataReturn = [
        "status" => false,
        "message" => "Something went wrong"
    ];

    if ($serverMethod == "POST") {
        $dataRaw = json_decode(file_get_contents('php://input'), 1);
        if ($dataRaw) {
            $getToken = (isset($dataRaw['token']))?$dataRaw['token']:false;
            $getUserId = (isset($dataRaw['user_id']))?(int) $dataRaw['user_id']:false;
            $getUsername = (isset($dataRaw['username']))?$dataRaw['username']:false;
            $getMessage = (isset($dataRaw['message']))?$dataRaw['message']:false;
            $getCreatedAt = (isset($dataRaw['created_at']))?$dataRaw['created_at']:false;
        }
    
        if ($getToken) {
            $verifyToken = tokenDecode($getToken);
            if ($verifyToken) {

                $cache = new PhpFileCache();
                $dataFilter = $cache->refreshIfExpired("chat-filter", function () use ($conn) {
                    $sql = "SELECT * FROM chat_filter";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $hasil = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $filters = [];
                    foreach($stmt->fetchAll() as $k => $v) {
                        $filters[] = $v;
                    }
                    return $filters;
                }, 3600 * 12);

                if (count($dataFilter) > 0) {
                    foreach ($dataFilter as $key => $value) {
                        if (contains($getMessage, $value['kata']) !== FALSE) {
                            $getMessage = str_ireplace($value['kata'], "!@#$%^&*", $getMessage);
                            $stmt = $conn->prepare("INSERT INTO chat_filtered (`filter_id`, `user_id`, `created_at`) VALUES (:filter_id, :user_id, :created_at)");
                            $dateNow = Carbon::now();
                            $stmt->bindParam(':filter_id', $value['id'], PDO::PARAM_INT);
                            $stmt->bindParam(':user_id', $getUserId, PDO::PARAM_INT);
                            $stmt->bindParam(':created_at', $dateNow);
                            $stmt->execute();

                            $stmt = $conn->prepare("UPDATE chat_filter SET last_attemp_at = :attemp WHERE id = :id");
                            $stmt->bindParam(':id', $value['id'], PDO::PARAM_INT);
                            $stmt->bindParam(':attemp', $dateNow);
                            $stmt->execute();
                        }
                    }
                }

                $stmt = $conn->prepare("INSERT INTO chat VALUES (null, :userId, :username, :msg, :created)"); 
                $stmt->bindParam(':userId', $getUserId, PDO::PARAM_INT);
                $stmt->bindParam(':username', $getUsername, PDO::PARAM_STR);
                $stmt->bindParam(':msg', $getMessage, PDO::PARAM_STR);
                $stmt->bindParam(':created', $getCreatedAt, PDO::PARAM_STR);
                $stmt->execute();

                $dataReturn = [
                    "status" => true,
                    "message" => "Success",
                    "data" => [
                        "message" => $getMessage
                    ]
                ];

                returnJSON($dataReturn, 200);
            }

            $dataReturn = [
                "status" => false,
                "message" => "Token not valid",
                "dbg" => $verifyToken
            ];

            returnJSON($dataReturn, 403);
        } else {
            $dataReturn = [
                "status" => false,
                "message" => "Token Missing"
            ];

            returnJSON($dataReturn, 403);
        }
    } else {
        returnJSON($dataReturn, 405);
    }
