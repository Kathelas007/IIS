p_path=$1;

sudo usermod -a -G www-data awesome
sudo find $p_path -type f -exec chmod 644 {} \;
sudo find $p_path -type d -exec chmod 755 {} \;

sudo chown -R awesome:www-data  $p_path 

sudo find $p_path -type f -exec chmod 664 {} \;
sudo find $p_path -type d -exec chmod 775 {} \;

cd $p_path
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache

cd ..

