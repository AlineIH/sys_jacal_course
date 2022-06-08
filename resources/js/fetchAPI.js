"use strict";

const getConcierge = new Promise((resolve, reject) => {
    fetch(`${ ws }/readConcierge/0`).then( resp => resp.json() )
        .then( resolve ).catch( reject );
});

function request( endpoint , configuration, data = {} ){
    return new Promise((resolve, reject) =>{
        fetch('/services/'+endpoint , getConfig(configuration, data))
            .then( response => response.json() )
            .then( resolve )
            .catch( reject );
    });
}

const getConfig = (config , data = {}) => {
    switch (config) {
        case 1:
            return ({
                method: "POST",
                body: JSON.stringify(data),
                headers: {
                    "Content-Type": "application/json",
                }
            });        
        break;
        case 2:
            return ({
                method: "POST",
                body: data
            });     
        break;
        case 3:
            return ({
                method: "GET"
            });   
        break;
    }
}