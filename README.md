You can use this code for upload files
Using php 7.3
difeerent version php may not work

To prevent not uploaded in your localhost
i suggest, Change the value php.ini with this value
file_uploads = On
post_max_size = 100M
upload_max_filesize = 100M

Write file permission linux
chmod -R 777 /var/www/html # html or your directory name

How to change php.ini
linux : /ect/php/7.3/apache2 # 7.3 is my php version
xampp windows : on conf button of apache, its bring dropdown with php.ini 