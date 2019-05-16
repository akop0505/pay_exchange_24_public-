# installation instructions
#### Prerequisites
- you need installed web-server, mysql-server and php7.1

1. clone the repo using your credentials
    ```
    git clone url
    ```

1. install composer packages
    ```
    composer install
    ```

1. create an empty database (change db name in environment config)

1. run ```php init``` to deploy needed environment

1. run ```php yii migrate 1``` to init project db

1. run ```php yii migrate --migrationPath=@yii/rbac/migrations``` to init rbac db tables

1. restore dump, placed in ... to your project db (!!!)

1. run ```php yii migrate``` to init whole project db

1. navigate to ```<project_root>/frontend/web```

1. create the symlink named ```sacretroom``` and linked to the folder ```<project_root>/backend/web```

### Only for dev environment
#### Prerequisites
- you need installed nodejs and npm
- you need installed npm packages gulp and bower globally

1. navigate to ```<project_root>/frontend/frontend```

1. run ```npm i```

1. run ```bower i```

1. to build and watch frontend components run ```gulp default```
