#!/usr/bin/python3
import sys
import os

try:
	app = sys.argv[1]
	print(f"Using {app} player")
except:
	print("Using standard player")
	app = "play"
	
intro_audio_path = app + " Music/intro"

while True:
	dir = os.listdir("Music/")
	if "intro1" in dir:
		os.system(intro_audio_path + "1.mp3")
	if "intro3"in dir:
		os.system(intro_audio_path + "3.mp3")
	if "intro4"in dir:
		os.system(intro_audio_path + "4.mp3")
