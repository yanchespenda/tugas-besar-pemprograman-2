<?php
defined('ISLOADPAGE') OR exit('No direct script access allowed');

require_once __DIR__ . '/is_koneksi.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/PhpFileCache.php';

use \Carbon\Carbon;
use Josantonius\Session\Session;
use \Kreait\Firebase\JWT\CustomTokenGenerator;
use \Kreait\Firebase\JWT\Error\IdTokenVerificationFailed;
use \Kreait\Firebase\JWT\IdTokenVerifier;

Session::start();

$PHP_JWT_KEY = "YP1k1QdDvLP62IjwbJXzXVPi5n3dogsQ";
$serviceAccountEmail = "firebase-adminsdk-gp830@projectreport-fd135.iam.gserviceaccount.com";
$projectId = 'projectreport-fd135';
$privateKey = <<<EOD
-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDIrNI+gC7eTvZU
B+yxQgOMkmewSkc6JZGbuNspcDBe0TuAXjewHgiG/e8WX/AaDJxbiwS0FPD8GvJ0
BcuajEM5j24TAw7SHeqPzSg6YvVCp6rDInOXJiSKBOFEpmAT8gRHRKm8Oh9JJNVL
c/fRjmLgXzvI1G9R3Dg/lj4/uCz+qg5AzrJsSzwjDRC8UGUZgQ+bhUjWvb3cQ++m
qikZzBr1I4yIPe58iovwLMgzvYVqXONf8+PhVuSuByrjhbScihD4qrvXmnZWz+0T
6aqCZ/NW+JgCgH4bVs0pGsFiDwJMwG2GkWu8075wfOYXhRcUhboNktwzNrCafwbz
NRuc+hTrAgMBAAECggEADqQZRMkaYkrViwT2/mnIE4H9Aa4xqyrhiECA8PGH/er7
Ed8N5hIS4jJ1tqayQFxKLh2i7raWbHZU2SUxGSoBn5n42HdBJhBbtDkuJbBhn4bX
HRyO3WjBgrZfbyBKYzolmMOINLzy2mXPEA26d3YRfbhFBt6E7q6IBg+ipAh+c+f4
Q9yssP4R5X1AcoxQ1pKKs3z7qW2nnnHy1Ud9knT6j6BLGOYX1lrwmPW4NlanVoDX
VPFWZR2LYYobmYjPqP2rMDJdiMvoqPy7Q2aH9TEeEjcOBrcUm7/1O3ZMzvZdYwNy
Xg2LcTWzN5Llg2Ww0hvt6f8aOUefnXQcBaCLqiv4oQKBgQDoSpKaupBe3nyxtiTt
Nb5EAzSR5kEMn9Bkl6exJH2Ju3iOrEu+sPHly6dPuXwspn2dsDvAepBPzHHpOT7W
YgAhrrXd19dCwzWiG9ZbIDEhg7LxSqV0EdYPEZwNE/osF9rzpeUD5dWq/cI69rIW
4Cesb7Gq80lQyLO4W2qtqE5uYQKBgQDdKCnpuLPv18pHGkKF8yj2DONaDYPxxdt5
wMwv8z4u5N5uaoMUR1ajGKU13v9SpzgF58sFDAd4y41TPsz5fa/N8N0VTAGM/lAn
W6uVpH4DaXiN9+j+6PJ9EnXh7vxS2oDofZpc7k0ocqSNSneYzao2T5O1azILaPps
WSwmjIdOywKBgDrWaLv4dYkSIdOBp2jOLBteFHrAL8na0RYps7gS3hl8+tRon+b1
OtBR/VccTG+i3D6M3RWr9dHAnznL3ja/K/lcH4TJnySx/WvKUUlTph4vFaw4lCAK
RIYcl8JYRQ3WHQeKBbAvDyf4jrIQuptAu8vZns8GQJPNwnf379V8xCEBAoGARJqy
9cfQObStEQV6YWce68Tvuf27UoLYJJrEPJOuVIm23nW4F9BRdeKtTVrRxWgOHvba
qcQjhTtPqeUvXK26nZ38VyDu0jgJ0UvEnHUcih5rwU6IPpswrc/ONboXF/SkTHq6
Kd3anZOCrDnPg9040gQ5g+uu6I82L+oxofux9aUCgYEA2WH1JLA87xeYBjuBNK8A
8Emx7GTVQJ3dwcHy3J/sno/2FXJl88Ks+qwNKYch+AMdl28+W8GeLCZ3L1V2DkFF
4m9d8fhKqg0H6cQxn8FWia0/aOQ0JmhSZgV9QT/K1Y6UOXHD4Mot7hDSyi+1tChc
Ef27WZpZZCd3XbqhCw6amhU=
-----END PRIVATE KEY-----
EOD;

if (!function_exists("generateCustomToken")) {
    function generateCustomToken($uid, $role) {
        global $serviceAccountEmail, $privateKey;

        Session::set('jwt_expired', Carbon::now()->addHour());
        $generator = CustomTokenGenerator::withClientEmailAndPrivateKey($serviceAccountEmail, $privateKey);
        $token = $generator->createCustomToken($uid, ['role' => $role]);
        return $token;
    }
}

if (!function_exists("tokenDecode")) {
    function tokenDecode($idToken) {
        global $projectId;
        $verifier = IdTokenVerifier::createWithProjectId($projectId);
        try {
            $token = $verifier->verifyIdToken($idToken);
            if ($token) {
                return $token;
            }
            return false;
        } catch (IdTokenVerificationFailed $e) {
            // return $e->getMessage();
            // Example Output:
            // The value 'eyJhb...' is not a verified ID token:
            // - The token is expired.
            return false;
        }

        /* try {
            $credentials = JWT::decode($token, $public_key, ["RS256"]);
            if ($credentials) {
                return true;
            }
            return false;
        } catch(ExpiredException $e) {
            return $e->getMessage();
            return false;
        } catch(\SignatureInvalidException $e) {
            return $e->getMessage();
            return false;
        } catch(\BeforeValidException $e) {
            return $e->getMessage();
            return false;
        } catch(\UnexpectedValueException $e) {
            return $e->getMessage();
            return false;
        } catch(Exception $e) {
            return $e->getMessage();
            return false;
        } */
    }
}

if (!function_exists("returnJSON")) {
    function returnJSON($data = [], $statusCode = 200) {
        header('Content-Type: application/json;charset=utf-8');
        $json = json_encode($data);
        if ($json === false) {
            // Avoid echo of empty string (which is invalid JSON), and
            // JSONify the error message instead:
            $json = json_encode(["jsonError" => json_last_error_msg()]);
            if ($json === false) {
                // This should not happen, but we go all the way now:
                $json = '{"jsonError":"unknown"}';
            }
            // Set HTTP response status code to: 500 - Internal Server Error
            http_response_code(500);
        }
        http_response_code($statusCode);
        echo $json;
        exit();
    }
}

if (!function_exists("cacheFile")) {
    function cacheFile($cache_file) {
        if (file_exists($cache_file) && (filemtime($cache_file) > (time() - 60 * 60 * 12 ))) {
            // Cache file is less than five minutes old. 
            // Don't bother refreshing, just use the file as-is.
            $file = file_get_contents($cache_file);
        } else {
            // Our cache is out-of-date, so load the data from our remote server,
            // and also save it over our cache for next time.
            $file = file_get_contents($url);
            file_put_contents($cache_file, $file, LOCK_EX);
        }
        return $file;
    }
}

if (!function_exists("contains")) {
    function contains($haystack, $needle, $caseSensitive = false) {
        return $caseSensitive ?
                (strpos($haystack, $needle) === FALSE ? FALSE : TRUE):
                (stripos($haystack, $needle) === FALSE ? FALSE : TRUE);
    }
}

if (!function_exists('numberShorten')) {
    function numberShorten($number, $precision = 3, $divisors = null) {

		// Setup default $divisors if not provided
		if (!isset($divisors)) {
			$divisors = array(
				pow(1000, 0) => '', // 1000^0 == 1
				pow(1000, 1) => 'K', // Thousand
				pow(1000, 2) => 'M', // Million
				pow(1000, 3) => 'B', // Billion
				pow(1000, 4) => 'T', // Trillion
				pow(1000, 5) => 'Qa', // Quadrillion
				pow(1000, 6) => 'Qi', // Quintillion
			);    
		}
	
		// Loop through each $divisor and find the
		// lowest amount that matches
		foreach ($divisors as $divisor => $shorthand) {
			if (abs($number) < ($divisor * 1000)) {
				// We found a match!
				break;
			}
		}
	
		// We found our match, or there were no matches.
		// Either way, use the last defined value for $divisor.
		if ($shorthand == '') {
			return number_format($number / $divisor, 0) . $shorthand;
		}
		return number_format($number / $divisor, $precision) . $shorthand;
	}
}
