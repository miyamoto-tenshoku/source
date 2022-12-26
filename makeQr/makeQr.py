from flask import Flask, render_template, request
from io import BytesIO
import base64
import qrcode

app = Flask(__name__)

@app.route("/", methods=['GET', 'POST'])
def makeQr():
    qr_str = request.form.get("qr_str", '')

    qr_img = qrcode.make(qr_str)

    # バッファへ画像データ書き込む
    buf = BytesIO()
    qr_img.save(buf,format="png")

    # バイナリデータをbase64でエンコードし、それをさらにutf-8でデコードしておく
    qr_b64str = base64.b64encode(buf.getvalue()).decode("utf-8")

    # image要素のsrc属性に埋め込めこむために、適切に付帯情報を付与する
    qr_b64data = "data:image/png;base64,{}".format(qr_b64str)

    return render_template("makeQr.html", qr_str=qr_str, qr_b64data=qr_b64data)


if __name__ == "__main__":
    app.run()
