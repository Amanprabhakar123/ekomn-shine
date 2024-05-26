
/** Set Base url */
const baseURL = 'http://127.0.0.1:8083/api/';

/** Set Header Values */
const makeHeader = () => {
    const token = sessionStorage.getItem('token') ? sessionStorage.getItem('token') : null;
    const header = {
        "Content-Type" : "application/json",
        "X-Requested-With" : "XMLHttpRequest",
        "Accept" : "application/json",
    }
    if(token){
        header['Authorization'] = 'Bearer '+token; 
    }
    return header;
}

/** Create Common method for hit GET and POST API */
const ApiRequest = (url, method="GET", body = undefined) => {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: baseURL + url,
            type: method,
            headers: makeHeader(),
            data: body ? JSON.stringify(body) : undefined,
            success: function(response) {
                console.log('API Hit', response);
                if(response.data && response.data.statusCode === "200"){
                    resolve(response);
                } else {
                    reject('API Error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                reject(error);
            }
        });
    });
}