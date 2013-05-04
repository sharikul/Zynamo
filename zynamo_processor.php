<?php

	class zynamo {
		
		private $file, $contents;


		function process($file) {

			/**
			 * Process file content and replace the keys with values in real time.
			 * @param path to file
			 */

			$this->file = trim($file);

			$this->contents = file_get_contents($this->file);

			if(preg_match_all("/\{\{([A-Za-z0-9_\s+\-]+)\}\}/i", $this->contents, $g)) {

				global $items;
				$arr = $g[1];

				foreach($arr as $item) {
				$this->contents = preg_replace("/\{\{$item+\}\}/i", $items[$item], $this->contents);
				}

				file_put_contents($this->file, $this->contents);
			} else {
				return;
			}
		}

		function process_file($file) {

			/**
			 * Process a Zynamo intended file and replace its keys with values, then create a valid version of the file. So index.zynamo.php becomes index.php.
			 * @param path to Zynamo intended file.
			 */

			$this->file = trim($file);
			$directory = dirname($this->file)."/";

			$this->contents = file_get_contents($this->file);

			if(preg_match_all("/\{\{([A-Za-z0-9_\s+\-]+)\}\}/i", $this->contents, $g)) {

				global $items;
				$arr = $g[1];

				foreach($arr as $item) {
				$this->contents = preg_replace("/\{\{$item+\}\}/i", $items[$item], $this->contents);
				}

				$this->file = (str_replace(dirname($file), "", $this->file));
				$this->file = preg_replace("/\/+/", "", $this->file);

				$this->file = str_replace(".zynamo", "", $this->file);

				$open_file = fopen($directory."/".$this->file, "w");

				$write = fwrite($open_file, $this->contents);

				fclose($open_file);
				
			} else {
				return;
			} 
	

		}

		public function process_files($files) {
			// Process an array of files.
			
			if(is_array($files)) {
				// Cool, an array has been provided. Loop through it.
			
				foreach($files as $file) {

					$file = trim($file); 

					if(file_exists($file)) {
						
						// File exists, now check the file name. If filename has ".zynamo", use the process_file() method, else use the process() method.
						
						// Remove the directory path from the filename and leave it bare.
						$file_name_modified = str_replace(dirname(dirname($file)), "", $file);
						$file_name_modified = str_replace(dirname($file), "", $file);

						// Remove slashes from the filename
						$file_name_modified  = preg_replace("/\/+/", "", $file_name_modified);
						
						if(strpos($file_name_modified,".zynamo")) {
							self::process_file($file);
						} else {
							self::process($file);
						}
					}
				}
			} else {

				// The input is not an array but probably a comma seperated list of files. Process it here.
				
				$files_list = explode(",", $files);
				
				// Now loop through the $files_list array
				foreach($files_list as $files) {

					$files = trim($files);
					if(file_exists($files)) {

						// Remove the directory path from the filename and leave it bare.
						$file_name_modified = str_replace(dirname(dirname($files)), "", $files);
						$file_name_modified = str_replace(dirname($files), "", $files);

						// Remove slashes from the filename
						$file_name_modified  = preg_replace("/\/+/", "", $file_name_modified);


						if(strpos($file_name_modified,".zynamo")) {
							self::process_file($files);
						} else {
							self::process($files);
						}
					}
				}
			}
		}
	}
?>