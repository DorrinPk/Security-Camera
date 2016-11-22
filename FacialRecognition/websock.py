import requests
import base64
import cv2
import numpy
import os.path
from flask import Flask, render_template
from flask_socketio import SocketIO, emit

app = Flask(__name__)
app.config['SECRET_KEY'] = 'secret!'
socketio = SocketIO(app)
faceCascade = cv2.CascadeClassifier('haarcascade_frontalface_alt.xml')
model = cv2.createLBPHFaceRecognizer(threshold=50.0)
X,Y = [],[]
did_train = False

if(os.path.isfile('test.yml')):
	model.load('test.yml')
	did_train = True

@socketio.on('connect')
def test_connect():
	print('received connection: ')

@socketio.on('my event')
def test_event(message):
	print('received message: ' + message['data'])

@socketio.on('train')
def handle_train(train):
	global did_train
	did_train = True
	img,gray,faces = get_image_from_str(str(train['data']))
	for (x, y, w, h) in faces:
		train_img = numpy.asarray(gray, dtype= numpy.uint8)
		X.append(train_img[y: y + h, x: x +w])
		Y.append(train['id'])
		model.update(numpy.asarray(X), numpy.asarray(Y))
		img_str = cv2.imencode('.jpg', img)[1].tostring()
		img_str = base64.b64encode(img_str)
		emit('image', {'test':img_str})
		del X[:]
		del Y[:]
	model.save("test.yml")

@socketio.on('recognition')
def handle_blob(blob):
	label = -2
	img,gray,faces = get_image_from_str(str(blob['data']))
	predict_img = numpy.asarray(gray, dtype= numpy.uint8)
        #try to do facial recon here
	for(x, y, w, h) in faces:
		if did_train:
			[p_label, p_confidence] = model.predict(predict_img[y: y + h, x: x + w])
			dictToSend = {'label':p_label}
			requests.post('http://localhost:8000/log', json=dictToSend)
			print "Predicted label = %d (confidence=%.2f)" % (p_label, p_confidence)
			cv2.putText(img, str(p_label),(x,y),cv2.FONT_HERSHEY_SIMPLEX, 2,255)
		cv2.rectangle(img, (x,y) , (x+w, y+h), (0, 255, 0), 2)
	img_str = cv2.imencode('.jpg', img)[1].tostring()
	img_str = base64.b64encode(img_str)
	emit('image', {'test': img_str})

def get_image_from_str(string):
	imdata = base64.b64decode(string)
	nparr = numpy.fromstring(imdata, numpy.uint8)
	img = cv2.imdecode(nparr,1)
	gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
	#faces = faceCascade.detectMultiScale(gray)
	faces = faceCascade.detectMultiScale(
		gray,
		scaleFactor=1.1,
		minNeighbors=4,
		minSize=(30,30),
		#flags=cv2.CV_HAAR_SCALE_IMAGE
                flags = 0
	)
	return img,gray,faces

if __name__ == '__main__':
	socketio.run(app)
