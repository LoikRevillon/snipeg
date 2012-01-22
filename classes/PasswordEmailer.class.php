<?php

class PasswordEmailer
{
	private $__lang;

	private $_content;
	private $_receiver;
	private $_subject;
	private $_sender;
	private $_userName;

	public function __construct ( $receiver = false )
	{
		$this->__lang = Tool::loadLanguage();

		if ( ! defined( 'EMAIL_SENDER' ) )
			throw new PasswordEmailerException( $this->__lang->error_email_sender );

		if ( ! defined( 'EMAIL_SUBJECT' ) )
		{
			throw new PasswordEmailerException( $this->__lang->error_email_subject );
		}

		if ( ! defined( 'EMAIL_CONTENT' ) )
			throw new PasswordEmailerException( $this->__lang->error_email_content );

		$this->_sender = EMAIL_SENDER;
		$this->_subject = EMAIL_SUBJECT;
		$this->_content = EMAIL_CONTENT;

		if ( !empty( $receiver ) )
		{
			if ( filter_var( $receiver, FILTER_VALIDATE_EMAIL ) )
				$this->_receiver = $receiver;

			else
				throw new PasswordEmailerException( $this->__lang->error_email_receiver );
		}
	}

	public function setReceiver ( $receiver )
	{
		if ( filter_var( $receiver, FILTER_VALIDATE_EMAIL ) )
			$this->_receiver = $receiver;

		else
			throw new PasswordEmailerException( $this->__lang->error_email_receiver );
	}

	public function setUser ( $userName )
	{
		if ( !empty ( $userName ) )
		{
			if ( 0 !== strpos( '__USERNAME__', $this->_content ) )
				$this->_content = str_replace( '__USERNAME__', ucfirst( $userName ), $this->_content );

			else
				throw new PasswordEmailerException( $this->__lang->error_email_content );
		}
	}

	public function setNewPassord( $newPassword )
	{
		if ( !empty ( $newPassword ) )
		{
			if ( 0 !== strpos( '__NEWPASSWORD__', $this->_content ) )
				$this->_content = str_replace( '__NEWPASSWORD__', $newPassword, $this->_content );

			else
				throw new PasswordEmailerException( $this->__lang->error_email_content );
		}
	}

	public function send ()
	{
		if ( !empty( $this->_receiver ) AND !empty( $this->_content ) )
		{
			$headers = 'MIME-Version: 1.0' . "\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\n";
			if ( !empty ( $this->_sender ) )
				$headers .= 'From: ' . $this->_sender . "\n";

			if ( defined( 'EMAIL_SIGNATURE' ) )
				$this->_content .= EMAIL_SIGNATURE;

			$this->_content = wordwrap( $this->_content, 70 );

			if ( ! mail( $this->_receiver, $this->_subject, $this->_content, $headers ) )
				throw new PasswordEmailerException( $this->__lang->error_email_sending );
		}
		else
		{
			throw new PasswordEmailerException( "Email building is invalid. You shall contact your admin to fix it." );
		}
	}
}

class PasswordEmailerException extends Exception {}
