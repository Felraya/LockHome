import io
import json
from os import listdir, remove
from os.path import isfile, join
import os
import picamera
import logging
import socketserver
from threading import Condition
from http import server
import datetime
import time
import ffmpeg
import socket

PAGE="""\
<html>
<head>
<title>Camera de surveillance</title>
</head>
<body>
<center><h1>Camera de surveillance</h1></center>
<center><img src="stream.mjpg" style="width:50%" ></center>
</body>
</html>
"""

STREAMING="""\
<html>
<head>
<title>Camera de surveillance</title>
</head>
<body>
<video controls src="__URL__" style="width:50%" autoplay ></video>
</body>
</html>
"""

RECORDING = False

s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
s.connect(("8.8.8.8", 80))

print("L'IP de cette camera est : " + s.getsockname()[0])

print("Démarrage de la caméra")
s.close()

class StreamingOutput(object):
    def __init__(self):
        self.frame = None
        self.buffer = io.BytesIO()
        self.condition = Condition()

    def write(self, buf):
        if buf.startswith(b'\xff\xd8'):
            self.buffer.truncate()
            with self.condition:
                self.frame = self.buffer.getvalue()
                self.condition.notify_all()
            self.buffer.seek(0)
        return self.buffer.write(buf)

class StreamingHandler(server.BaseHTTPRequestHandler):
    def do_GET(self):
        if self.path == '/':
            self.send_response(301)
            self.send_header('Location', '/index.html')
            self.end_headers()
        elif self.path == '/index.html':
            content = PAGE.encode('utf-8')
            self.send_response(200)
            self.send_header('Content-Type', 'text/html')
            self.send_header('Content-Length', len(content))
            self.end_headers()
            self.wfile.write(content)
        elif "files" in self.path :
            onlyfiles = [f for f in listdir("./RECORD") if isfile(join("./RECORD", f))]
            content = json.dumps(onlyfiles).encode('utf-8')
            self.send_response(200)
            self.send_header('Content-Type', 'text/html')
            self.send_header('Content-Length', len(content))
            self.end_headers()
            self.wfile.write(content)
        elif "download-file" in self.path:
            file = self.path.split("/")[2].replace("/", "")
            self.send_response(200)
            self.send_header('Content-Disposition', 'attachment')
            self.end_headers()
            with open("./RECORD/" + file, 'rb') as file: 
                self.wfile.write(file.read())
        elif "delete-file" in self.path:
            file = self.path.split("/")[2].replace("/", "")
            remove("./RECORD/" + file)
            self.send_response(200)
            self.send_header('Content-Type', 'text/html')
            self.end_headers()
            self.wfile.write("Fichier supprimé".encode('utf-8'))
        elif "stream-file" in self.path:
            file = self.path.split("/")[2].replace("/", "")
            content = STREAMING.replace("__URL__", "../download-file/"+file).encode('utf-8')
            self.send_response(200)
            self.send_header('Content-Type', 'text/html')
            self.send_header('Content-Length', len(content))
            self.end_headers()
            self.wfile.write(content)
        elif "record" in self.path :
            min = self.path.split("/")[2].replace("/", "")
            self.send_response(200)
            self.end_headers()
            self.wfile.write("ok".encode('utf-8'))
            
            global RECORDING
            if RECORDING == False :
                RECORDING = True
                today = datetime.datetime.today()
                name = today.strftime("%d-%m-%Y_%Hh%M") #on met comme nom de fichier l'heure et la date de l'enregistrement (hh:mm:ss-JJ-MM-YY)
                camera.start_recording("./RECORD_RAW/" + name + ".h264", format="h264", splitter_port=1) #début du record avec nom du fichier
                print ("Enregistrement démarré : "+ name)
                time.sleep(int(min))
                camera.stop_recording()
                print ("Fin enregistrement")

                ffmpeg.input("./RECORD_RAW/" + name + ".h264").output("./RECORD/" + name + '.mp4').overwrite_output().run()
                remove("./RECORD_RAW/" + name + ".h264")
                RECORDING = False

        elif "stream.mjpg" in self.path :
            self.send_response(200)
            self.send_header('Age', 0)
            self.send_header('Cache-Control', 'no-cache, private')
            self.send_header('Pragma', 'no-cache')
            self.send_header('Content-Type', 'multipart/x-mixed-replace; boundary=FRAME')
            self.end_headers()
            try:
                while True:
                    with output.condition:
                        output.condition.wait()
                        frame = output.frame
                    self.wfile.write(b'--FRAME\r\n')
                    self.send_header('Content-Type', 'image/jpeg')
                    self.send_header('Content-Length', len(frame))
                    self.end_headers()
                    self.wfile.write(frame)
                    self.wfile.write(b'\r\n')
            except Exception as e:
                logging.warning('Removed streaming client %s: %s', self.client_address, str(e))
        else:
            self.send_error(404)
            self.end_headers()

class StreamingServer(socketserver.ThreadingMixIn, server.HTTPServer):
    allow_reuse_address = True
    daemon_threads = True

with picamera.PiCamera(resolution='1296x730', framerate=30) as camera:
    
    if not os.path.exists("./RECORD_RAW/"):
        os.makedirs("./RECORD_RAW/")
    if not os.path.exists("./RECORD/"):
        os.makedirs("./RECORD/")
    
    output = StreamingOutput()
    camera.start_recording(output, format='mjpeg', splitter_port=0)
    try:
        address = ('', 8080)
        server = StreamingServer(address, StreamingHandler)
        server.serve_forever()
    finally:
        camera.stop_recording()
