const {
    createApp
} = Vue

createApp({
    data() {
        return {
            ws: '/services/',
            globalData: [],
            txtName: "",
            isSuccess: false,
            isProcess: false,
            isFail: false
        }
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        getUsers() {
            fetch(this.ws + 'userRead', getConfig(3))
                .then(response => response.json())
                .then(response => {
                    this.globalData = response.response;
                });
        },
        showModal( e ){
            let myModal = new bootstrap.Modal(document.getElementById(e), {
                keyboard: false
              });
          myModal.show();
        },
        process(){
            this.isProcess ? (this.isProcess = false) : (this.isProcess = true);
        },
        saveNew(){
            this.isSuccess = false;
            this.process();
            this.isProcess = true;
            fetch(this.ws + 'userCreate', getConfig(1, {
                "idUser" : 0,
                "txtName" : this.txtName, 
                "password" : "",
                "image" : ""
            }))
                .then(response => response.json())
                .then(response => {
                    response.response.length > 0 ? (this.isSuccess = true) : (this.isFail = true);
                    console.log(response.response.length > 0);
                    this.process();
                    this.getUsers();
                });
        }
    },

}).mount('#app')
