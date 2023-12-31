### PmpMongoAdmin Setup Scripts

### All Setup Files
- apache/        
  - <b>Directory containing Apache server configurations</b>
    - global/      (global: server wide nested apache configurations)
      - phpMongoAdmin.conf
        - configured for localhost and private directory access
      - phpMongoAdminPublic.php
        - configured for public access - requires security enhancements
    - virtualHost/ (vhost configuration for public and private access)
      - vhost_phpMongoAdmin.conf
        - configured for localhost and private directory access
      - vhost_phpMongoAdminPublic.conf
        - configured for public access - requires security enhancements
        - includes an SSL <VirtualHost> specification
- nginx/
  - <b>Directory containing Nginx server configurations</b>
    - global/      (global: server wide nested apache configurations)
      - phpMongoAdminPublic.php
        - configured for localhost and private directory access
    - serverBlock/ (Nginx version of VirtualHost)
      - server_phpMongoAdmin.com
        - configured as an Nginx server: equivalent to Apache's virtualhost
- remote-scripts/
  - <b>These scripts are meant for use on Linux (all) or Windows (docker only)</b>
  - custom.sh
    - wget https://phpmongoadmin.com/install/custom.sh -O - | bash
    - installs the application into the current working directory
      - provides multiple options for installing phpMongoAdmin including:
        - install the application for (global) nested access
        - http://localhost/phpmongoadmin
        - http://your-domains.co/phpmongoadmin
        - VirtualHost for Apache or ServerBlock for Nginx
        - Automatic self signed SSL certificate generation
  - default.sh
    - wget https://phpmongoadmin.com/install/default.sh -O - | bash
    - installs the application to the default location
      - (on linux distros) /usr/share/phpMongoAdmin
      - all setup options as listed for custom install
  - docker-all.sh
    - wget https://phpmongoadmin.com/install/docker-all.sh -O - | bash
    - installs the docker-compose-full repository to the current working directory
    - sets up Apache2, MongoDB and PhpMongoAdmin
    - provides initialisation of the docker setup script
  - docker-app.sh
    - wget https://phpmongoadmin.com/install/docker-app.sh -O - | bash
    - installs the docker-compose-app repository to the current working directory
    - sets up Apache2 and PhpMongoAdmin only
    - provides initialisation of the docker setup script
- Local Installation 
  - <b>Use these scripts if you have downloaded or cloned the application</b>
    - pmadefault.sh 
    - <b>shell script - handles the default application installation</b>
      - @deprecated
        - to use:
          - source setup/pmadefault.sh
          - forhelp:
            - pmainstall (without any options)
    - pmainstall.sh 
    - <b>shell script - provides alternative installation options</b>
      - to use:
        - source setup/pmainstall.sh
        - for help:
          - pmainstall (without any options)
- 
- [App readme file](../README.md)
