<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jacal</title>

    <link href="/resources/bootstrap-5.1.3-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="/resources/bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="/resources/bootstrap-5.1.3-dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="/resources/js/fetchAPI.js"></script>
    <script src="/resources/vue3/vue.global.js"></script>
</head>

<body>
    <div class="container" id="app">
        <div class="row">

            <div class="col-12 d-flex justify-content-center">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <h3>El Jacal Course</h3>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Usuario</label>
                                        <input type="text" class="form-control" v-model="txtUserName">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary" @click="validateUser">Ingresar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    const {
        createApp
    } = Vue

    createApp({
        data() {
            return {
                ws: '/services/',
                txtUserName: "",
                isSuccess: false,
                isProcess: false,
                isFail: false
            }
        },
        mounted() {

        },
        methods: {
            process() {
                this.isProcess ? (this.isProcess = false) : (this.isProcess = true);
            },
            validateUser() {
                this.isSuccess = false;
                this.process();
                this.isProcess = true;
                fetch(this.ws + 'userLogin', getConfig(1, {
                        "userName": this.txtUserName
                    }))
                    .then(response => response.json())
                    .then(({error, count, response}) => {
                        console.log(response);
                        if(count > 0){
                            window.location.href = "/course/myCourses/";
                        }
                    });
            }
        },

    }).mount('#app')
</script>

</html>