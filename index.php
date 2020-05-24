<?php
	require_once 'config/default.php';
	require_once 'helpers/auth.php';
	is_login($base_url);
	header('location: ./pages/dashboard');