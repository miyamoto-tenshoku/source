let id_start = null     //クリックされたセルで一番早い日付のidを保存する
let id_end = null       //クリックされたセルで一番遅い日付のidを保存する

window.addEventListener("load",function() {
    const SELECT_COL = '#8FCCA5'    //選択時のセルの色
    const HOVER_COL = '#BCEACD'     //mouseover時のセルの色

    for (const class_name of ['emp_00', 'emp_30']) {
        elems = document.getElementsByClassName(class_name)

        for( let i = 0; i < elems.length; i++ ) {

            elems[i].addEventListener('mouseover', function() {
                if (this.dataset.selected === 'false'){
                    this.style.backgroundColor = HOVER_COL
                }
            })

            elems[i].addEventListener('mouseleave', function() {
                if (this.dataset.selected === 'false'){
                    this.style.backgroundColor = 'initial'
                }
            })

            elems[i].onclick = function () {
                //セルがひとつも選択されていない際のの処理
                if(
                    id_start === null
                    && id_end === null
                ){
                    id_start = this.id
                    id_end = this.id
                } else {
                    let date_start = new Date(id_start)
                    let date_end = new Date(id_end)
                    let date_this = new Date(this.id)

                    //すでに選択されているセルと異なる列のセルをクリックした際の処理
                    if(date_this.getDate() !== date_start.getDate()){
                        id_start = this.id
                        id_end = this.id

                    //選択されているセルがひとつだった際の処理
                    } else if(id_start === id_end){
                        if(this.id === id_start){
                            id_start = null
                            id_end = null
                        } else {
                            if(date_start < date_this){
                                id_end = this.id
                            } else {
                                id_start = this.id
                            }
                        }

                    } else {
                        if(date_this < date_start){
                            id_start = this.id
                        } else if(this.id === id_start){
                            date_start.setMinutes(date_start.getMinutes() + 30)
                            id_start = makeId(date_start)
                        } else if(this.id === id_end){
                            date_end.setMinutes(date_end.getMinutes() - 30)
                            id_end = makeId(date_end)
                        } else if(date_this > date_end){
                            id_end = this.id
                        }
                    }
                }

                //予定ないの背景色をリセット
                changeBgcIni('emp_00')
                changeBgcIni('emp_30')

                let register_btn = document.getElementById('register')

                if(
                    id_start !== null
                    && id_end !== null
                ){
                    let date_start = new Date(id_start)
                    let date_end = new Date(id_end)

                    //id_startとid_endの間を着色する
                    do{
                        let ele = document.getElementById(makeId(date_start))

                        //選択されたスケジュール間に
                        //予約済みのスケジュールがあった場合の処理
                        if(
                            ele.className !== 'cell emp_00'
                            && ele.className !== 'cell emp_30'
                        ){
                            changeBgcIni('emp_00')
                            changeBgcIni('emp_30')
                            this.style.backgroundColor = SELECT_COL
                            this.dataset.selected = 'true'
                            id_start = this.id
                            id_end = this.id
                            break
                        }

                        ele.style.backgroundColor = SELECT_COL
                        ele.dataset.selected = 'true'
                        date_start.setMinutes(date_start.getMinutes() + 30)

                    }while(date_start<=date_end)

                    register_btn.disabled = false

                } else {
                    register_btn.disabled = true
                }
            }
        }
    }
})



//Dateオブジェクトの引数から
//yyyy-mm-ddThh:ii::ss形式の文字列を出力する関数
function makeId(date){
    let str = date.getFullYear().toString()
    str += '-'
    str += (date.getMonth()+1).toString().padStart(2, "0")
    str += '-'
    str += date.getDate().toString().padStart(2, "0")
    str += 'T'
    str += date.getHours().toString().padStart(2, "0")
    str += ':'
    str += date.getMinutes().toString().padStart(2, "0")
    str += ':'
    str += date.getSeconds().toString().padStart(2, "0")
    return str
}

//引数のクラスを持つ要素の背景色をinitialに変更し
//要素のdataset.selectedをfalseにする関数
function changeBgcIni(class_name){
    elems = document.getElementsByClassName(class_name)

    for( let i = 0; i < elems.length; i++ ) {
        elems[i].style.backgroundColor = 'initial'
        elems[i].dataset.selected = 'false'
    }
}

//スケジュール登録フォームの表示・非表示を切り替える処理
function displayForm(){
    let ele = document.getElementById('reserve_form')

    if(
        ele.hidden
        && id_start !== null
        && id_end !== null
    ){

        let buf_end = new Date(id_end)
        buf_end.setMinutes(buf_end.getMinutes() + 30)

        let div_start = id_start
        let div_end = makeId(buf_end)

        div_start = div_start.replace('T', ' ')
        div_start = div_start.replace(/:00$/, '')
        div_end = div_end.replace('T', ' ')
        div_end = div_end.replace(/:00$/, '')

        ele.hidden = false
        document.getElementById('form_bg').hidden = false
        document.getElementById('div_date').textContent = div_start.substr( 0, 10 )
        document.getElementById('div_time').textContent = div_start.substr( 11, 5 )+'~'+makeId(buf_end).substr( 11, 5 )
        document.getElementById('start').value = id_start
        document.getElementById('end').value = makeId(buf_end)
    } else {
        ele.hidden = true
    }

}

//セルの選択をすべてリセットする関数
function reset(){
    id_start = null
    id_end = null
    changeBgcIni('emp_00')
    changeBgcIni('emp_30')
}

//全てのフォームを非表示にする関数
function closeForm(){
    let forms = document.forms

    for(const index in forms){
        forms[index].hidden = true
    }
    document.getElementById('form_bg').hidden = true
}

//引数idに対応するフォームを表示する関数
function openForm(id){
    let ele = document.getElementById(id)

    if(ele.hidden){
        ele.hidden = false
        document.getElementById('form_bg').hidden = false
    }
}