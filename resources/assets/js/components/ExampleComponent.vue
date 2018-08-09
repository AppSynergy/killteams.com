<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        <h3 class="h3">Testy button:</h3>
                        <form class="mb-2">
                            <input class="form-control" type="text" v-model="name">
                        </form>
                        <a class="btn btn-primary text-white"
                            v-on:click="addKillTeam">
                            Create a killteam
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: 'My kill team'
            };
        },
        methods: {
            addKillTeam() {
                this.submitHttp('post', 'http://localhost/Dev/killteams.com/public/api/killteam', {
                    name: this.name
                })
            },
            submitHttp(requestType, url, data = {}) {
                return new Promise((resolve, reject) => {
                    axios[requestType](url, data).then(response => {
                        console.log(response);
                    }).catch(error => {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx
                        if (error.response) {
                            console.warn("error response", error.response)

                        // The request was made but no response was received
                        // `error.request` is an instance of XMLHttpRequest
                        } else if (error.request) {
                            console.warn("error request", error.request)

                        } else {
                            console.warn("error other", error)
                        }
                        reject(error);
                    });
                });
            }
        }
    }
</script>
