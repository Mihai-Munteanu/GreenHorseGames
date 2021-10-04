# PROJHECT_NAME

This project's name is: GreenHorseGames - assignment

## Install

```
git clone https://github.com/Mihai-Munteanu/GreenHorseGames.git
composer install
npm install
```

Create a DB named `greenhorsegames`.

No authentication is needed as we consider player just entered a username and joined the selected competition.

Then by accessing the following routes you may use the app as follows:
 - POST request on "/competitions" -> create a new competition;
 - POST request on "/competitions/{competition}/players" -> add a new player in competition; 
 - POST request on "/competitions/{competition}/players/{player}" -> increment a player's score;
 - GET request on "/competitions/{competition}/players" -> return competition name and players ranking;
 