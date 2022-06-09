const getUsers = () => {
    fetch('/services/userRead' , getConfig(3))
        .then( response => response.json() )
        .then( response => {
            console.log(response);
        });

    let resolve = request('userRead', 3);
    console.log(resolve);
}

getUsers();

const { createApp } = Vue

createApp({
    data() {
        return {
            message: 'Hello Vue!'
        }
    }
}).mount('#app')