#!/bin/bash

export BIND_IP
export DB_PORT=3306
export DB_ROOT_USERNAME=root
export DB_ROOT_PASSWORD=Tito2016
export MYSQL_DOWNLOAD_URL=http://repo.mysql.com/mysql-community-release-el7-5.noarch.rpm

##### Variables from Script properties ####
db_root_username=${DB_ROOT_USERNAME}
db_root_password=${DB_ROOT_PASSWORD}
mysql_download_url=${MYSQL_DOWNLOAD_URL}
bind_ip=${BIND_IP}
db_port=${DB_PORT}
#####

##### Dsiable SE Linux
sed -i --follow-symlinks 's/^SELINUX=.*/SELINUX=disabled/g' /etc/sysconfig/selinux && cat /etc/sysconfig/selinux

# Set global variables
export PATH=$PATH:/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:$JAVA_HOME/bin

# FUNTION TO CHECK ERROR
function check_error()
{
    if [ ! "$?" = "0" ]; then
        error_display "$1";
    fi
}

# FUNCTION TO DISPLAY ERROR
function error_display()
{
    echo "${PROGNAME}: ${1:-"Unknown Error"}" 1>&2
}

# FUNCTION TO DISPLAY ERROR AND EXIT
function error_exit()
{
    echo "${PROGNAME}: ${1:-"Unknown Error"}" 1>&2
    exit 1
}

# FUNCTION TO VALIDATE THE INTEGER
function valid_int()
{
    local  data=$1
    if [[ $data =~ ^[0-9]{1,9}$ ]]; then
        return 0;
    else
        return 1
    fi
}

# FUNCTION TO VALIDATE NAME STRING
function valid_string()
{
    local  data=$1
    if [[ $data =~ ^[A-Za-z]{1,}[A-Za-z0-9_-]{1,}$ ]]; then
        return 0;
    else
        return 1;
    fi
}

# FUNCTION TO VALIDATE PASSWORD
function valid_password()
{
    local  data=$1
    length=${#data}
    if [ $length -le 5 ]; then
        check_error "PASSWORD MUST BE OF AT LEAST 5 CHARACTERS"
    else
        if [[ $data =~ ^[A-Za-z]{1,}[0-9_@!$%^+=]{0,}[A-Za-z0-9]{0,}$ ]]; then
           return 0;
        else
           return 1;
        fi
    fi
}

# PARAMETER VALIDATION
echo "VALIDATING PARAMETERS..."
if [ "x${db_root_username}" = "x" ]; then
    error_exit "DB_ROOT_USERNAME NOT SET."
else
    if ! valid_string ${db_root_username}; then
        error_exit "INVALID PARAMETER DB_ROOT_USERNAME"
    fi
fi
if [ "x${db_root_password}" = "x" ]; then
    error_exit "DB_ROOT_PASSWORD NOT SET."
else
    if ! valid_password ${db_root_password}; then
        error_exit "INVALID PARAMETER DB_ROOT_PASSWORD"
    fi
fi
echo "PARAMTER VALIDATION -- DONE"

# INSTALLATION OF MySQL -- START
echo "Install yum"
yum install -y yum

echo "Installation of MYSQL..."
if [ -f /etc/redhat-release ] ; then
    REV=`cat /etc/redhat-release | sed s/.*release\ // | sed s/\ .*//`
    DIST=`cat /etc/redhat-release |sed s/\ release.*//`
    ARCH=`uname -p`
    if [ $ARCH == "i686" ] ; then
        echo "$DIST 32 BIT MACHINE - v$REV"
        echo "ERROR: This script only works on RHEL 7 x64."
        exit 1
	else
        echo "$DIST 64 BIT MACHINE - v$REV"
        yum --nogpgcheck --noplugins -y clean all
        # INSTALLATION OF MySQl
        rpm -ivh $mysql_download_url
            check_error "ERROR WHILE INSTALLING MYSQL REPOSITORY"

        yum install -y mysql-server
        check_error "ERROR WHILE INSTALLING MYSQL"
    fi
else
	echo "ERROR: This script only works on RHEL 7 x64."
	exit 1
fi

echo "DONE - INSTALL script of MYSQL Database"
# INSTALLATION OF MySQl -- END

# Start MySql configuration
echo "Start mysqld"
systemctl start mysqld

# Start MySql Script
echo "Configuration of MYSQL"

# CONFIGURE MYSQL TO HANDLE BIG PACKETS
sed -ie "s/\[mysqld\]/\[mysqld\]\n\max_allowed_packet=1024M/g" /etc/my.cnf

# CONFIGURE MYSQL TO LISTEN ON PARTICULAR PORT
sed -ie "s/\[mysqld\]/\[mysqld\]\n\port=$db_port/g" /etc/my.cnf

# CONFIGURE MYSQL TO LISTEN ON PARTICULAR IP
sed -i 's/bind-address.*/bind-address            = $bind_ip/' /etc/my.cnf

# ASSIGN A PASSWORD FOR MYSQL ADMIN ROOT USER
mysqladmin -u $db_root_username password $db_root_password

# If firewall is on, open the db_port 
if [ $(firewall-cmd --state) = "running" ]; then
    echo "Firewall is on, open the db_port $db_port in iptables..."
    VAR=$(firewall-cmd --zone=public --add-port=$db_port/tcp --permanent);
    if [ "$VAR"=“success” ] ; then
        echo "Port $db_port added on Firewall permanently."
    else
        echo "Add port $db_port on Firewall manually."
    fi

    VAR1=$(firewall-cmd --reload);
    if [ "$VAR1"=“success” ] ; then
        echo 'Firewall restarted successfully.'
    else
        echo 'Firewall restart failed.'
    fi
else
    echo "Firewall status: $(firewall-cmd --state)"
    echo "Firewall is off, the db_port $db_port is open to accept connections."
fi

echo "DONE - CONFIGURE script for MYSQL Database"

echo "Starting MYSQL"
echo "Granting privileges for remote access."
mysql -u $db_root_username -p$db_root_password <<!
grant all privileges on *.* to '$db_root_username'@'%' identified by '$db_root_password' with grant option;
!
echo "Done - START script of MYSQL Database"
