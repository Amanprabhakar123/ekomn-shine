
/** Set Base url */
const baseURL = 'http://65.0.18.91:8081/api/';

/** Set Header Values */
const makeHeader = () => {
    const token = sessionStorage.getItem('token') ? sessionStorage.getItem('token') : null;
    const header = {
        "Content-Type" : "application/json",
        "X-Requested-With" : "XMLHttpRequest",
        "Accept" : "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
            dataType: 'json',
            data: body ? JSON.stringify(body) : undefined,
            success: function(response) {
                // console.log('Response:', response);
                if(response.data && (response.data.statusCode === "200" || response.data.statusCode === "400" || response.data.statusCode === "201" || response.data.statusCode === "422")){
                    resolve(response);
                }else if(response.data && response.meta){
                    resolve(response);
                }else {
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
