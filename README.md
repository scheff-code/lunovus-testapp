# Lunovus Code Assessment

## Standing up a local instance
This assumes you have local hosting in place, with a LAMP stack (or similar), as well as Composer and the latest stable Node/npm. 

1. Clone the code repository from https://github.com/scheff-code/lunovus-testapp. 
2. When the repo has been cloned, enter its root directory and run `composer install`.
3. Create a MySQL database for the application, as well as a user for it.
4. Add an .env file to the project root copying the .env.example file included in the repo, and then simply update the database parameters based on the database/user created in the prior step.  
5. Run `php artisan config:clear` at the project root 
6. Run `php artisan migrate` at the project root
7. Run `npm install` at the project root
8. Run `npm run build` or `npm run dev` at the project root

If all went well, you should be able to view the site. 

There are a variety of ways to serve the site locally. The simplest is to run `php artisan serve` which will provide a link to then view the site, or use your IDE's configuration to set up a server for the site.

## Testing/Using the Application

The home page of the application makes clear that you must first log in to use the app, and offers a means to create an account using the 'Register' button.

Once you've created your account, you will be redirected to the Dashboard. Since this is simply a test application, there is little to do or see here, but you will notice a 'Tasks' link at the top of the page. Click that.

The Tasks page is a grid view, displaying all tasks that YOU have created. As requested, you cannot see other user's tasks. Since you just registered, there won't be any listed.

To create a task, click the "New Task" button at the top right. Create your task by populating all fields, and clicking 'Update Task'. 

You will be redirected to the Tasks grid view, where you will see your task listed.

Notice the row just below the headers with empty text or dropdown fields. Those can be used to filter the data in the grid.

You can toggle the status of a task simply by clicking the 'switch' icon in the status column for each task. Keep in mind that, if you have filtered the status column and change the status of a given task, it will no longer appear in the list until you remove the filter, or change it to match the status to which you just changed that task.

You can filter on multiple columns at a time. To reset the grid and remove all filtering, click the 'Clear Filters' button at the top right.

The last column of the grid shows three icons:
1. An eye: click the eye icon to view that task.
2. A pencil: click the pencil to edit that task.
3. A trashcan: click the trash icon to delete the task.

