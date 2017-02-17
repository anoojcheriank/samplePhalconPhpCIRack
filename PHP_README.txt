Enable PCNTL 
============
http://www.crimulus.com/2010/07/30/howto-enable-pcntl-in-ubuntu-php-installations/

First, in your home directory:

mkdir php
cd php
apt-get source php5
cd php5-(WHATEVER_RELEASE)/ext/pcntl
phpize
./configure
make
Then:

cp modules/pcntl.so /usr/lib/php5/WHEVER_YOUR_SO_FILES_ARE/
echo "extension=pcntl.so" > /etc/php5/conf.d/pcntl.ini

function call backs with arguments
==================================
http://php.net/manual/en/function.call-user-func-array.php


change maximum-execution-time in php.ini
=========================================
http://stackoverflow.com/questions/5164930/fatal-error-maximum-execution-time-of-30-seconds-exceeded


http://www.writephponline.com/

