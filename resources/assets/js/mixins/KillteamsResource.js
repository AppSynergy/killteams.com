export default {
    data() {
        return {
            saved: false,
        }
    },
    computed: {
        killteams: {
            get() {
                return this.$store.getters.getKillteams
            },
            set(value) {
                this.$store.commit('setKillteams', value)
            }
        }
    },
    mounted() {
        console.log("mounted a ktsr")
        this.ajaxFetchKillteams()
    },
    methods: {
        ajaxFetchKillteams() {
            axios.get(API_URL + '/killteams').then(response => {
                this.killteams = response.data.data
            })
        },
        ajaxSaveKillteam(killteam, then = false) {
            axios.post(API_URL + '/killteam', killteam)
                .then(response => {
                    this.saved = true
                    if (then) {
                        then()
                    }
                })
        }
    }
}
