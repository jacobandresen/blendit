<?php
$lines     = file("kvinde.txt");
$length   = sizeof($lines);
$pos      = rand(0, $length);
$l=$lines[$pos];
$l= substr($l, 12, strlen($l));
$l= substr($l, 0, strpos($l, "  "));

print $l;


?>
