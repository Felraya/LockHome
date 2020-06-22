import requests
import socket
import datetime
import RPi.GPIO as GPIO
import picamera
import time
import sys

#Récupération de l'ip de la raspberry
try:
	s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
	s.connect(("8.8.8.8", 80))
	ip = s.getsockname()[0]
	s.close()
	print("Votre ip est : " + ip + "\n")
except:
	print("Connexion internet non trouvé !")
	sys.exit(0) #quitte le programme si pas de connexion internet


#détection intrusion

buzzerPin = 11    #Pin correspond au buzzer
buttonPin = 12    #Pin correspondant au Button
biip = False #True pour activer l'alarme du buzzer, False pour la désactiver
camera = picamera.PiCamera()

#Fonction qui initialise les Pins 
def setup(): 
	print ('Sécurisation de la maison lancé')
	GPIO.setmode(GPIO.BOARD)								# Permet de gérer les Pins par leurs location physique
	GPIO.setup(buzzerPin, GPIO.OUT)   						# Met le buzzerPin mode sur output
	GPIO.setup(buttonPin, GPIO.IN, pull_up_down=GPIO.PUD_UP)# Met le buttonPin mode sur input met à la tension max (3.3V)

#Fonction pour vérifier en continue l'état des capteurs 
def loop():
	while True:
		if GPIO.input(buttonPin)==GPIO.LOW:
			if biip == True :
				GPIO.output(buzzerPin,GPIO.HIGH)
			print ('Un capteur a été enclenché')
			#envoyer une requete get au serveur web
			adresse = "http://" + ip + "/api/" + ip + "/intrusion" #serveur théorique local, c'est la requete get à cette adresse qui seras récupérer par le serveur web en cas d'intrusion
			adresse = "http://lockhome.nrocher.fr/api/" + ip + "/intrusion" #serveur d'un ami
			res = requests.get(addresse) #envoi la requete et res prend la réponse
			print("Requete envoyé au serveur")
			print(res)
			record() #on lance la fonction record
		else :
			GPIO.output(buzzerPin,GPIO.LOW)

#a effectuer en cas de fin de programme (Ctrl-C)
def destroy():
	GPIO.output(buzzerPin, GPIO.LOW)    # Met le Buzzer off
	GPIO.cleanup()                     	# Relache les ressources



#lance un l'enregistrement (appeler en cas d'intrusion)
def record():
	today = datetime.datetime.today()
	name = today.strftime("%H:%M:%S-%d-%m-%Y") #on met comme nom de fichier l'heure et la date de l'enregistrement (hh:mm:ss-JJ-MM-YY)
	camera.start_recording("Record/" + name + ".h264") #début du record avec nom du fichier
	print ("Enregistrement effectuer à : "+ name)
	time.sleep(5) #temps du record
	camera.stop_recording()
	print ("Fin enregistrement")
		

if __name__ == '__main__':     # Démarrage Programme principale (éxécute la boucle)
	setup()
	try:
		loop()
	except KeyboardInterrupt:  # Arrèter le programme quand 'Ctrl+C' est pressé
		destroy()
		


