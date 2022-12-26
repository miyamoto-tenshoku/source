import streamlit as st
from streamlit_webrtc import webrtc_streamer
import cv2
import av

st.title("リアルタイム顔認識アプリ")

# 顔検出用の学習ファイルの取得
cascade = cv2.CascadeClassifier('haarcascade_frontalface_alt.xml')

def callback(frame):
    img = frame.to_ndarray(format="bgr24")
    facerect = cascade.detectMultiScale(img)

    if len(facerect) > 0:
    #　顔の位置に長方形を描画
        for rect in facerect:
            cv2.rectangle(img, tuple(rect[0:2]),
                            tuple(rect[0:2]+rect[2:4]), (0, 0, 255),
                            thickness=2)

    return av.VideoFrame.from_ndarray(img, format="bgr24")


webrtc_streamer(
    key="stream",
    video_frame_callback=callback,
    rtc_configuration={
        "iceServers": [{"urls": ["stun:stun.l.google.com:19302"]}]
    }
)
