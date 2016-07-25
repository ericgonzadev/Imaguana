<?php
mysql_connect(getenv('OPENSHIFT_MYSQL_DB_HOST'), getenv('OPENSHIFT_MYSQL_DB_USERNAME'), getenv('OPENSHIFT_MYSQL_DB_PASSWORD')) or die(mysql_error());
mysql_select_db(getenv('OPENSHIFT_GEAR_NAME')) or die(mysql_error());
?>
