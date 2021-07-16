<?php

$test = 0714556260;

if (preg_match('/^0\d{9}$/', $test) ) {
  echo 'valid';
} else {
   echo 'not valid';
}

?>