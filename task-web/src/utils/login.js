const request = require('request')

const login = function(formData, callback){
    const url = 'http://190.146.247.240:3000/users/login'   
    try{
    request({
        url: url,
        method: "POST",
        headers: { "content-type": "application/json",},
        json: formData
        }, function (error, resp, body) {
            if( error ){ throw new Error('Something went wrong ', error)}
            if(resp.statusCode == 200){
                callback('', body)
            }else{
                callback({status:resp.statusCode,message:"login UnSuccesful"}, false)
            }
        })
    }catch(e){
        callback(e,'')
    }
  } 

module.exports = login