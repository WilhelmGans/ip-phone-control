let windowPhone;
let valueNumber;
let valueip;
let valueLine;


function getData(callParam, keyParam) {
    valueNumber = document.getElementById('numberInput').value;
    valueip = document.getElementById("ipInput").value;
    valueLine = document.getElementById("lineInput").value;
    if (callParam == '1') {
        if (valueip === "" || valueLine === "" || valueNumber === "") {
            alert("Заполните все поля");
        }else{
            let num = valueNumber;
            let digits = num.toString().split('');
            let joinedNumber = digits.join(';');
            phoneOperation(callParam, valueip, user, password, joinedNumber, valueLine, keyParam);
        }
    }else{
        if (valueip === "") {
            alert("Заполните поле IP адресса")
        }else{
            phoneOperation(callParam, valueip, user, password, valueNumber, valueLine, keyParam);
        }
    }
}

async function phoneOperation(params, ip, user, password, number, line, keyButton) {
    switch (params) {

        case '1':
            link = protocol + user + ":" + password + "@" + ip + url + keyButton + ";" + number +";@"+ line + ";" + key.keyCall;
            windowPhone = window.open(link,"телефон","width=500,height=350");
            await sleep(2000);
            windowPhone.close();
        break;
        default:
            link = protocol + user + ":" + password + "@" + ip + url + keyButton;
            windowPhone = window.open(link,"телефон","width=500,height=350");
	        await sleep(2000);
            windowPhone.close();
        break;
    }
}
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}