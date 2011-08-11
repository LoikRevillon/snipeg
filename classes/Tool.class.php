<?php

class Tool {

	public static function appendSuccess($message) {

		if (!isset($_SESSION['success']))
			$_SESSION['success']= array();

		$_SESSION['success'][]= $message;

	}

	public static function appendInfo($message) {

		if (!isset($_SESSION['info']))
			$_SESSION['info']= array();

		$_SESSION['info'][]= $message;

	}

	public static function appendWarning($message) {

		if (!isset($_SESSION['warning']))
			$_SESSION['warning']= array();

		$_SESSION['warning'][]= $message;

	}

	public static function appendError($message) {

		if (!isset($_SESSION['error']))
			$_SESSION['error']= array();

		$_SESSION['error'][]= $message;

	}

	public static function readSuccess() {

		if (isset($_SESSION['success'])) {
			foreach($_SESSION['success'] as $message) {
				echo '<p class="success">'.$message.'</p>'."\n";
				unset($message);
			}
		}
	}

	public static function readInfo() {

		if (isset($_SESSION['info'])) {
			foreach($_SESSION['info'] as $message) {
				echo '<p class="info">'.$message.'</p>'."\n";
				unset($message);
			}
		}
	}

	public static function readWarning() {

		if(isset($_SESSION['warning'])) {
			foreach($_SESSION['warning'] as $message) {
				echo '<p class="warning">'.$message.'</p>'."\n";
				unset($message);
			}
		}
	}

	public static function readError() {

		if (isset($_SESSION['error'])) {
			foreach($_SESSION['error'] as $message) {
				echo '<p class="error">'.$message.'</p>'."\n";
				unset($message);
			}
		}
	}

}