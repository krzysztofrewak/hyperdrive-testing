## Installation
To install all dependencies, run:
```bash
docker-compose run --rm composer install
```

To run application itself, run:
```bash
docker-compose run --rm php php index.php
```

## Running soundtrack player ##
For obvious reasons we can't force an independent docker container to use host's soundcard and host's commands.
In order to play the sound files python 3.x must be installed on the host machine. 
It is recommended that *sox* packaged is installed:  
```bash
sudo apt-get install sox
```
and then mp3 decoder: 
```bash
sudo apt-get install libsox-fmt-mp3
```
To run the player run the script provided in the Music folder in a **new window** or a **tab**.
That means that two terminals are needed: one to play the an actual game and another to play the soundtrack.
```bash
python3 Music/soundtrack_player.py
```
Different music player can also be used but it is not recommended. Just provide an argument which points to the binary of the player:
```bash
python3 Music/soundtrack_player.py /bin/rhythmbox
```
***NOTE***
***This script is a loop which doesn't end. Sound files are only played in the intro mission. After that mission the script should be 
terminated with CTRL-C***

## Overview
This project is an attempt to create an extensible command line based game engine. As of now it provides a stable framework which allows to create new missions, play soundtrack, save and load the game and easily add new modules, which contain new game elements.
## Hyperdrive
Currently simple game is implemented to show all capabilities of the engine, which are described above.
## The reason behind
It is a fork of the https://github.com/krzysztofrewak/hyperdrive-testing, which is *A draft for simple cli-based game*.
## Adding content
All new mission must be added to the *missions.yaml* file.
### Game elements ###
New game element can be used either as a trait or a new class and then it should be added in a mission handler which will utilize it. 
For example look at the __Combat.php trait__.

### Story related elements (missions) ###
It basically comes down to the creating *name*.yaml file and *name*.php class which extends __BaseDecisionHandler.php__.
Yaml file consists of the stage name, *linesCount* which defines number of printed out lines of text, 
before controls are passed to the user and lastly *options* and *decisions* headers, which must contain at least "Continue"
and "proceed" respectively. It is very important because these headers push the story forward and also they provide
controls for the user. Last decision should be named *endMission*, it will tell the engine that the current mission is over
and after that new will be initialized. 

### Unique mission handlers ###
These handlers just handle user decisions, *which should be provided in yaml.file in a similar manner*. Every new handler 
should be at least a copy of the __Intro.php__. That file has a decision which *pauses* the game, a decision 
that toggles progress in a story and allows it to go forward, and a decision that ends the mission.
__Mission1.php__ and __Mission2.php__ show an example of handling decisions and using new game modules/elements.