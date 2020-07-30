# C:\Users\dell\AppData\Local\Programs\Python\Python37
import sys
import os

import matplotlib
import numpy as np
import matplotlib.pyplot as plt
import copy
import cv2
from io import StringIO,BytesIO
from PIL import Image
import base64

# Disable tensorflow compilation warnings
os.environ['TF_CPP_MIN_LOG_LEVEL']='2'
import tensorflow as tf

from flask import Flask, render_template
from flask_socketio import SocketIO, emit
def predict(image_data):
    predictions = sess.run(softmax_tensor, \
    {'DecodeJpeg/contents:0': image_data})

    # Sort to show labels of first prediction in order of confidence
    top_k = predictions[0].argsort()[-len(predictions[0]):][::-1]

    max_score = 0.0
    res = ''
    for node_id in top_k:
        human_string = label_lines[node_id]
        score = predictions[0][node_id]
        if score > max_score:
            max_score = score
            res = human_string
    return res, max_score

    # Loads label file, strips off carriage return
label_lines = [line.rstrip() for line
                       in tf.io.gfile.GFile("silent/logs/output_labels.txt")]

# Unpersists graph from file
with tf.compat.v1.gfile.FastGFile("silent/logs/trained_graph.pb", 'rb') as f:
    graph_def = tf.compat.v1.GraphDef()
    graph_def.ParseFromString(f.read())
    _ = tf.import_graph_def(graph_def, name='')

with tf.compat.v1.Session() as sess:
    # Feed the image_data as input to the graph and get first prediction
    softmax_tensor = sess.graph.get_tensor_by_name('final_result:0')

app = Flask(__name__)
socketio = SocketIO(app)

@app.route('/front.html', methods=['POST', 'GET'])
    # def index():
    #     return render_template('front.html')

@socketio.on('image')
def image(data_image):
    
    sbuf = StringIO()
    sbuf.write(data_image)
    # decode and convert into image
    frame= BytesIO(base64.b64decode(data_image))
    frame= Image.open(frame)
    # frame=np.copy(frame)
    frame=np.array(frame)
    # cv2.imshow('frame', frame)
    c = 0

    # cap = cv2.VideoCapture(0)

    res, score = '', 0.0
    i = 0
    mem = ''
    consecutive = 0
    sequence = ''
    x1, y1, x2, y2 = 100, 100, 300, 300
    # Process the image frame


    # frame = imutils.resize(frame, width=700)
    frame = cv2.flip(frame, 1)
    img_cropped = frame[y1:y2, x1:x2]

    c += 1
    image_data = cv2.imencode('.jpg', img_cropped)[1].tostring()
    a = cv2.waitKey(1) # waits to see if `esc` is pressed
    if i == 4:
        res_tmp, score = predict(image_data)
        res = res_tmp
        i = 0
        if mem == res:
            consecutive += 1
        else:
            consecutive = 0
        if consecutive == 2 and res not in ['nothing']:
            if res == 'space':
                sequence += ' '
            elif res == 'del':
                sequence = sequence[:-1]
            else:
                sequence += res
            consecutive = 0
    i += 1
    cv2.putText(frame, '%s' % (res.upper()), (100,400), cv2.FONT_HERSHEY_SIMPLEX, 4, (255,255,255), 4)
    cv2.putText(frame, '(score = %.5f)' % (float(score)), (100,450), cv2.FONT_HERSHEY_SIMPLEX, 1, (255,255,255))
    mem = res
    cv2.rectangle(frame, (x1, y1), (x2, y2), (255,0,0), 2)
    imgencode = cv2.imencode('.jpg',frame)[1]
    stringData = base64.b64encode(imgencode).decode('utf-8')
    # stringData = base64.b64encode(imgencode).decode('utf-8')
    b64_src = 'data:image/jpg;base64,'
    stringData = b64_src + stringData

    # emit the frame back
    emit('response_back', stringData)
    # img_sequence = np.zeros((200,1200,3), np.uint8)
    # cv2.putText(img_sequence, '%s' % (sequence.upper()), (30,30), cv2.FONT_HERSHEY_SIMPLEX, 1, (255,255,255), 2)
    # cv2.imshow('sequence', img_sequence)
    # if a == 27: # when `esc` is pressed
   	#  break

	# Following line should... <-- This should work fine now
cv2.destroyAllWindows() 
	# cv2.VideoCapture(0).release()


if __name__ == '__main__':
    socketio.run(app, host='192.168.43.12',port=7000)