<?php

if(!empty($_GET['q']))
	echo json_encode(array('title' => uniqid(), 'post' => uniqid()));