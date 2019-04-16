#sf4-test-survey
Don't forget to load questions from the fixture: 
bin/console doctrine:fixtures:load

To make admin user: bin/console fos:user:promote <username> ROLE_ADMIN
  admin user at demo site is l:a1, p:11

We suppose that Survey questions data is quite static and immutable (!important) 
while users taking to take survey, otherwise we need to add published property 
and/or add additional checking for quetion number in form. 

It is a short, two-page survey with five questions per page, and each 
question weighed from zero to five that a user can fill out and see a 
statistics summary of the average answers per question for all users.

The user should go to the app, register with either email/password, 
Google, or Facebook (you may implement whichever of the 3 methods you 
are most comfortable with), fill out the 2-page questionnaire, and see 
a statistics breakdown of values per question of all entries filled in the form of a chart of your choice.

In addition to normal users, there should also be administrator 
users who can complete the survey but also see an additional page 
that contains the list of users that registered but did not fill 
out the survey. This page is hidden for non-administrator users and 
they may never access it.
