/* Property object hasil request:
{ responseText, responseJSON, status, statusText }
getAllResponseHeaders() => string all response header, separated by new line
getResponseHeader(headerName) => string nilai dari header
*/

async function request(url, method, body, headers){
    return new Promise((resolve, reject) => {
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function(){
            if(this.readyState == 4){
                if(this.getResponseHeader('Content-type') == 'application/json'){
                    try{
                        this.responseJSON = JSON.parse(this.response);
                    } catch(e){}
                }
                resolve(this);
            }
        }

        xhttp.open(method, url, true);

        for(let key in headers){
            xhttp.setRequestHeader(key, headers[key]);
        }

        if(method == "GET"){
            xhttp.send();
        } else{
            xhttp.send(body);
        }
    });
}

async function requestGet(url, headers){
    return request(url, "GET", null, headers);
}

async function requestPost(url, body, headers){
    return request(url, "POST", new URLSearchParams(body).toString(), headers);
}
