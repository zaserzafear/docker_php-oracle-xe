--------------------sqldeveloper-----------

-- USER SQL
CREATE USER "LEARN" IDENTIFIED BY "LEARN"  
DEFAULT TABLESPACE "SYSTEM"
TEMPORARY TABLESPACE "TEMP";

-- QUOTAS
ALTER USER "LEARN" QUOTA UNLIMITED ON "SYSTEM";

-- ROLES
GRANT "CONNECT" TO "LEARN" ;
GRANT "RESOURCE" TO "LEARN" ;

-- SYSTEM PRIVILEGES
GRANT CREATE SESSION TO "LEARN" ;
GRANT GRANT ANY PRIVILEGE TO "LEARN" ;


------------------//sqldeveloper-----------

--------------------import cmd--------------------

docker exec -ti oracle_db bin/bash

cd u01/app/oracle/admin/XE/dpdump/

imp LEARN/LEARN@//localhost:1521/XE

--------------------//import cmd--------------------

--------------------export cmd--------------------

docker exec -ti oracle_db bin/bash

cd u01/app/oracle/admin/XE/dpdump/

exp LEARN/LEARN@//localhost:1521/XE

--------------------//export cmd--------------------