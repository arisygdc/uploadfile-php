<?php
    class FileUploader
    {
        private $file;
        private $targetDir;
        private $error = false;
        private $errTrace = "";

        // Input $_FILES['var']
        public function set_file($uploadedFile) {
            foreach ($uploadedFile as $key => $val) {
                $this->file[$key] = $val;
            }
            return $this;
        }

        // Fill this param with : dir/subdir
        public function set_dir($targetDir = "images/") {
            $targetDir = $targetDir;
            $targetDir = basename(str_replace("//", "/", $targetDir));
            if (!is_dir($targetDir)) {
                if (!mkdir($targetDir, 0777,  true)) {
                    $this->set_err("Can\'t run make directory");
                }
            }
            $this->targetDir = $targetDir;
            return $this;
        }

        // input param with "ext1/ext2" or array with no uppercase
        public function allowed_ext($allow_ext = "") {
            $fileExt = $this->get_extension();
            if (!is_array($allow_ext)) {
                $allow_ext = explode("/", $allow_ext);
            }
            
            $this->error = true;
            foreach ($allow_ext as $key) {
                if ($key == $fileExt) {
                    $this->error = false;
                    return $this;
                }
            }
            $this->set_err('Not allowed Extension');
            return $this;
        }
        
        // If upload success will return true
        public function upload() {
            if ($this->error) {
                $this->set_err("Can\'t start upload");
                return false;
                
            }

            $targetFile = $this->get_dir()."/"
                .$this->get_tmpName()
                .random_int(1,500)
                .$this->get_name();

            if (!move_uploaded_file($this->get_tmpName(false), $targetFile)) {
                $this->set_err("Failed to upload");
                return false;
            }
            return true;
        }

        private function set_err($msg) {
            $this->error = true;
            $this->errTrace = $msg . ", ";
        }

        public function get_errMsg() {
            return rtrim($this->errTrace, ", ");
        }

        public function get_dir() {
            return $this->targetDir;
        }

        public function get_name() {
            return $this->file['name'];
        }

        public function get_extension() {
            $ext = str_replace("image/", "", $this->file['type']);
            return strtolower($ext);
        }

        public function get_size() {
            return $this->file['size'];
        }

        // true for get name only
        // false for get name with directory
        public function get_tmpName($tmp = true) {
            if (!$tmp) {
                return $this->file['tmp_name'];
            }
            $tmp = str_replace("/tmp/", "", $this->file['tmp_name']);
            return $tmp;
        }
    }
