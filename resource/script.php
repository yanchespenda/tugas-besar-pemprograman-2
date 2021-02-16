<?php
defined('ISLOADPAGE') OR exit('No direct script access allowed');

$baseScript = [];
$baseScript[] = [
    'url' => (string) '/app.js?5',
    // 'url' => 'https://res.cloudinary.com/dslncjjz1/raw/upload/v1585003875/cdn/streaming/js/app.js',
    'options' => [
        'async' => true,
        'defer' => true
    ]
];
echo '<div id="base-scripts" data-scripts="' . htmlspecialchars(json_encode($baseScript)) . '"></div>';
$extraScript = [];
echo '<div id="extra-scripts" data-scripts="' . htmlspecialchars(json_encode($extraScript)) . '"></div>';
?>
<script type="text/javascript">
    var base_scripts = document.querySelector("#base-scripts").getAttribute('data-scripts');
    base_scripts = JSON.parse(base_scripts);
    var extra_scripts = document.querySelector("#extra-scripts").getAttribute('data-scripts');
    if (extra_scripts) {
        extra_scripts = JSON.parse(extra_scripts);
    } else {
        extra_scripts = [];
    }
    var scripts = base_scripts.concat(extra_scripts);
    scripts.forEach(function(scriptObj) {
        var s = document.createElement('script');
        s.async = scriptObj.options.async;
        s.defer = scriptObj.options.defer;
        s.src = scriptObj.url;
        document.head.appendChild(s);
    });
</script>
<noscript>Please enable JavaScript to continue using this application.</noscript>
