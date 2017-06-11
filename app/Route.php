<?php
/*Principal Controller (Could be use for non secure reasons*/
$this->get('principal');
/*Error Controler (Could be use for customs errors pages*/
$this->get('error');
$this->get('error/error403');
$this->get('error/error404');
?>