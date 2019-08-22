#!/bin/bash
#This script install all the packages needed for the Tito Front End (Apache, git)
#It also configure the necessary files
#it download the necessary sources from  Git
#and it start the service
exec &> tito_as.log

#### Variables
HTMLPATH=/var/www/html
GITREPO=https://github.com/vmeoc/Tito/
HTTPDCONF=/etc/httpd/conf/httpd.conf
SQLSERVER=$1
CODEVERSRION=V1.5

#### disable SE Linux
sed -i --follow-symlinks 's/^SELINUX=.*/SELINUX=disabled/g' /etc/sysconfig/selinux && cat /etc/sysconfig/selinux
setenforce 0

#### Disable firewall 
#echo -e "Open Firewall port 80\n"

#firewall-cmd --zone=public --add-port=80/tcp --permanent
#firewall-cmd --reload

#### Install and configire HTTPD
echo
echo -e "Install Apache HTTPD & PHP\n"

#yum update -y
yum install httpd -y
/usr/sbin/service httpd start
yum install php -y
yum install php-mysql -y
/usr/sbin/chkconfig httpd on

#### Install Git
echo
echo -e "install Git\n"

yum install git -y

echo
echo -e "Install Tito sources \n"

#### Download Tito code and configure HTTPD
cd $HTMLPATH
git clone $GITREPO .
git checkout tags/$CodeVersion

echo
echo -e "conf httpd.conf to include PHP and set MySQL server\n"

echo
echo -e "modify SQLSERVER variable to remove not needed characters"
SQLSERVER=$(tr -d []\' <<< $SQLSERVER)

echo
echo "LoadModule php5_module modules/libphp5.so" >> $HTTPDCONF
cat <<EOF >> $HTTPDCONF
<IfModule env_module>
    SetEnv TITODBSERVER "$SQLSERVER"
</IfModule>
EOF

echo
echo -e "conf php.ini Timezone \n"

echo "date.timezone = \"Europe/Rome\"" >> /etc/php.ini

#### Start HTTPD
echo
echo -e "Restart Apache HTTPD"

/usr/sbin/service httpd restart
