# Green horse games assignment
## Install

```bash
git clone https://github.com/Mihai-Munteanu/GreenHorseGames.git
composer install
npm install
```

Create a DB named `greenhorsegames` and add it to `.env`. Then run `php artisan migrate`

No authentication is needed as we consider player just entered a username and joined the selected competition.

Then by accessing the following routes you may use the app as follows:
 - POST request on `/competitions` -> create a new competition;
 - POST request on `/competitions/{competition}/players` -> add a new player in competition; 
 - PUT request on `/competitions/{competition}/players/{player}/increment` -> increment a player's score;
 - GET request on `/competitions/{competition}` -> return competition name and players ranking;
 