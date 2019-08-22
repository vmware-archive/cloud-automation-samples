# Tito DB Script
shell script to crearte and configure Vince's Tito DB

Just pull this shell script and run it. It requires the followings:
 - centos that can access MySQL db on port 3306;
 - mysql client installed
 - .my.cnf file configured and stored in user home directory. See this example:

 
\[mysql\]

user = 'your-username'

password = 'your-password'

In a Cloud Assembly Blueprint run it as follows :

runcmd:
- cd /tmp
- git clone https://github.com/paoloromagnoli/titodb.git
- git checkout ${input.titoVersion}
./tito_db.sh ${resource.<your_EC2>.endpoint}
