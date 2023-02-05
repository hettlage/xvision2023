<?php

	add_action( 'wp_enqueue_scripts', 'xvision2023_child_enqueue_parent_styles' );

	function xvision2023_child_enqueue_parent_styles() {
	   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
	}


    function xvision2023_random_string($n) {
      // Taken from https://www.geeksforgeeks.org/generating-random-string-using-php/
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $randomString = '';
 
      for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
      }
 
      return $randomString;
    }

    add_filter("sanitize_file_name", "xvision2023_sanitize_filename", 10, 1);

    function xvision2023_sanitize_filename($filename) {
      // Adapted from https://gravitywp.com/tutorial/clean-uploaded-filenames-by-replacing-chars-with-accents-and-other-special-chararacters/
      // Remove chars with accents etc, also replaces € with E.
	  $sanitized_filename = remove_accents( $filename );

	  // Remove every character except A-Z a-z 0-9 . - _ and spaces.
	  $sanitized_filename = preg_replace( '/[^A-Za-z0-9-_\.[:blank:]]/', '', $sanitized_filename );

	  // Replace spaces (blanks) with a dash.
	  $sanitized_filename = preg_replace( '/[[:blank:]]+/', '-', $sanitized_filename );

      // Add a random string so that the filename cannot be guessed.
      return xvision2023_random_string(16) . "-" . $sanitized_filename;
    }
