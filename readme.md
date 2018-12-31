<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>


## About the project
Skeleton Laravel 5.6 with ACL and Permissions read by Annotations


### To initialize the project, clone the repository:
```sh 
    git clone https://github.com/luisconcha/skeleton_laravel_acl.git
```

### Configuring and initializing the project

##### Copy file env_example
 ```sh 
    Copy file .env_example and change the database settings.
```

##### Run on terminal

```sh 
    cd skeleton_laravel_acl
    composer intall
    php artisan key:generate
    php artisan migrate
    php artisan db:seed 
```

### Default users to access the system
```sh
   email: administrator@user.com
   password: 123456
   
   email: manager@user.com
   password: 123456 
   
   email: visitor@user.com
   password: 123456 
```
### Screenshots
![1_admin](https://user-images.githubusercontent.com/5189618/50554272-ce7a5300-0c9e-11e9-91ef-2c61b758ae93.png)

###Roles
![2_roles](https://user-images.githubusercontent.com/5189618/50554291-1ac59300-0c9f-11e9-8c2f-53f775aa6339.png)

###Permissions
![3_permissions](https://user-images.githubusercontent.com/5189618/50554306-4e082200-0c9f-11e9-90a7-276f1c084479.png)

###Menu by role
![4_menu_by_role](https://user-images.githubusercontent.com/5189618/50554340-e3a3b180-0c9f-11e9-9e60-be980ba23c4e.png)

###Not Authorized 
![5_not_authorized](https://user-images.githubusercontent.com/5189618/50554369-35e4d280-0ca0-11e9-98af-46653241193d.png)




##### Developer
<p>Luis Alberto Concha Curay - luisconchacuray@gmail.com</p>
