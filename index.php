<?php
	if (empty($_SESSION['uid'])) {
		header('location: ./pages/login');
	}