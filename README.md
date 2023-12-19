# Fazbear Ent.

## Description
Backend project for school, with as theme *Five Nights at Freddy's*.


## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
  - [How to](#how-to)
  - [Tests](#tests)


## Installation

1. Clone the repository:
- `git clone git@git.nexed.com:eabe2084-29d7-11ed-81f7-4213e7ee7fac/4a344ac8-886d-4dc6-abf2-a59e00af3159/Almost-there-018b4253-018b4253.git`

2. Install:

- [Xampp](https://www.apachefriends.org/index.html)

ps: you can install phpmyadmin and apache seperately.

3. Start the server and import the database:

- Locate the database file in the folder *database* and import it in phpMyAdmin. `cd your/path/to/fazbear/database`

- Open Xampp and start Apache and MySQL.

Now you should be able to run the project on your localhost.

**NOTE**: If you prefer using anything else than Xampp, you could do that as well. I have used Xampp for this project, so I reccomend using that.


## Usage

### How to
To run the project, you need to start the server and import the database. You can do this by following the steps in the [Installation](#installation) section.

When you have done that, you can run the project on your localhost.
From this point, you can run tests to see if everything is working properly. You can find the tests in the [Tests](#tests) section.

You can also use the project as a template for your own website. You can do this by cloning the repository and editing the files to your liking.

### Tests
The tests are mainly to check if the database is working properly.
You can test several things, like:

- Contacting "Fazbear Ent." through the contact form.
![Filling in form](website/images/contact_web.png)
![Check in database](website/images/contact_db.png)

- Applying for a job at "Fazbear Ent." through the job application form.
![All the jobs](website/images/vacancies.png)
![Applying for job](website/Images/vacancy_apply.png)
![Check in database](website/images/application_db.png)

- Logging in as an admin.
![Wrong login details](website/images/wrong_login.png)
![Wrong login test](website/images/wrong_login_test.png)
![Correct login details](website/images/correct_login.png)
![Correct login test](website/images/logged_in.png)

- Adding an event.
  ![Adding event](website/images/test_event.png)
  ![Adding event test](website/images/event_added.png)

- Editing an event.
  ![Editing event](website/images/edit_event.png)
  ![Editing event test](website/images/event_edited.png)

- Deleting an event.
  ![Deleting event](website/images/delete_event.png)
  ![Deleting event test](website/images/event_deleted.png)

- Deleting job applications.
  ![All the job applications](website/images/applications.png)
  ![Deleting job application](website/images/delete_application.png)
  ![Deleting job application test](website/images/application_deleted.png)

  