<?php
function cmp($a, $b) {
  return version_compare($a[1], $b[1], '<');
}

header("Content-Type: text/plain");
$url =  (isset($_SERVER['HTTPS']) ? "https" : "http") . "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$ask_version = $_GET['v'] ?? 'latest';

$flist = scandir(dirname(__FILE__,1));
$fw = array();
foreach ($flist as $newfile) {
  if (substr($newfile, -4)=='.bin') {
//    echo "{$newfile}\n";
    $vers = preg_match('/\d+(\.\d+)+/', $newfile, $matches);
    if ($vers>0) {
      $fw[] = [$newfile, $matches[0]];
//      echo $matches[0] . "\n";
    } else {
      $result = preg_match('/firmware-(.*).bin/', $newfile, $matches2);
      if ($result>0) {
        $fw[] = [$newfile, $matches2[1]];
      }
    }
  }
}
$latestver = null;
usort($fw, "cmp");
$fw = array_merge([[$fw[0][0], 'latest']], $fw);
$firmwares = array_column($fw, 0, 1);

if (array_key_exists($ask_version, $firmwares)) {
  $name = dirname(__FILE__,1) . "/" . $firmwares[$ask_version];
  $fp = fopen($name, 'rb');
  header("Content-Type: application/octet-stream");
  header("Content-Length: " . filesize($name));
  fpassthru($fp);
  fclose($fp);
} else {
  http_response_code(404);
}

?>
