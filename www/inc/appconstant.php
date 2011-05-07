<?php
  if (!function_exists('zyDefIf')) { function zyDefIf($const, $value) { if (!defined($const)) define($const, $value); } }
  
  zyDefIf('DM_BASE_URL','http://localhost/PHPTest/DedicateMusic/');
