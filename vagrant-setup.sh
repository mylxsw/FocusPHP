#!/usr/bin/env bash

#####################       安装常用软件       #####################

sudo yum install epel-release -y

# 安装相关的依赖

sudo yum install gcc -y
sudo yum install libxml2-devel -y
sudo yum install openssl-devel -y
sudo yum install libcurl-devel -y
sudo yum install libjpeg libjpeg-devel -y
sudo yum install libpng libpng-devel -y
sudo yum install freetype freetype-devel -y
sudo yum install pcre-devel -y

cd ~
wget ftp://mcrypt.hellug.gr/pub/crypto/mcrypt/libmcrypt/libmcrypt-2.5.7.tar.gz
tar -zxvf libmcrypt-2.5.7.tar.gz
cd libmcrypt-2.5.7
./configure
make
sudo make install

#####################       安装配置nginx       #####################

sudo yum install nginx -y
sudo rm /etc/nginx/nginx.conf
sudo ln -s /app/nginx.conf /etc/nginx/nginx.conf

sudo systemctl enable nginx.service

#####################       安装配置PHP         #####################

# 修正php启用opcache失败问题

sudo sh -c 'echo /usr/local/lib > /etc/ld.so.conf.d/local.conf'
sudo ldconfig -v

# 下载PHP源码并执行编译安装

cd ~
wget http://cn2.php.net/distributions/php-5.6.4.tar.gz
tar -zxvf php-5.6.4.tar.gz

cd php-5.6.4

./configure --prefix=/usr/local/php --with-config-file-path=/usr/local/php/etc --with-iconv-dir --with-freetype-dir --with-jpeg-dir --with-png-dir --with-zlib --with-libxml-dir=/usr --enable-xml --disable-rpath --enable-bcmath --enable-shmop --enable-sysvsem --enable-inline-optimization --with-curl --enable-mbregex --enable-fpm --enable-mbstring --with-mcrypt --enable-ftp --with-gd --enable-gd-native-ttf --with-openssl --with-mhash --enable-pcntl --enable-sockets --with-xmlrpc --enable-zip --enable-soap --with-gettext --with-mysql=mysqlnd --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd --enable-opcache

make
sudo make install
sudo cp php.ini-development  /usr/local/php/etc/php.ini
#sudo mv /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf
sudo cp sapi/fpm/init.d.php-fpm /etc/init.d/php-fpm
sudo chmod u+x /etc/init.d/php-fpm
sudo chkconfig --add php-fpm

# PHP环境变量

cd ~
echo 'if [ -d "/usr/local/php/bin" ] ; then
    PATH=$PATH:/usr/local/php/bin
    export PATH
fi' > env_php.sh

sudo mv env_php.sh /etc/profile.d/env_php.sh

# php-fpm配置

sudo sh -c "echo '127.0.0.1    phpfpm' >> /etc/hosts"

cd ~
echo '[global]
daemonize = yes
events.mechanism = epoll
[www]
user = vagrant
group = vagrant
listen = 127.0.0.1:9000
listen.allowed_clients = 127.0.0.1
pm = dynamic
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3' > php-fpm.conf

sudo mv php-fpm.conf /usr/local/php/etc/php-fpm.conf

# 配置文件链接，方便操作

sudo ln -s /usr/local/php/etc/php-fpm.conf /etc/php-fpm.conf
sudo ln -s /usr/local/php/etc/php.ini /etc/php.ini

# 修改配置，设定时区

cd ~
echo "date.timezone='Asia/Shanghai'" > php.ini.tmp
sudo sh -c 'cat php.ini.tmp >> /etc/php.ini'
rm -f php.ini.tmp


#####################       安装配置MySQL         #####################

cd ~
wget http://dev.mysql.com/get/mysql-community-release-el7-5.noarch.rpm
sudo rpm -Uvh mysql-community-release-el7-5.noarch.rpm
sudo yum update -y
sudo yum install mysql-community-server -y
sudo systemctl start mysql

cat /app/focusphp.sql | mysql -uroot



#####################      启动          #######################

sudo nginx
sudo /etc/init.d/php-fpm start