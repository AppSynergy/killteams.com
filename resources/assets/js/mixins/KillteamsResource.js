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
        },
        killteamsLoaded: {
            get() {
                return this.$store.getters.getKillteamsLoaded
            },
            set(value) {
                this.$store.commit('setKillteamsLoaded', value)
            }
        }
    },
    mounted() {
        if (!this.killteamsLoaded) {
            this.ajaxFetchKillteams()
            this.killteamsLoaded = true
        }
    },
    methods: {
        ajaxFetchKillteams(then = false) {
            axios.get(API_URL + '/killteams').then(response => {
                this.killteams = response.data.data
                if (then) {
                    then()
                }
            })
        },
        ajaxSaveKillteam(killteam, then = false) {
            axios.post(API_URL + '/killteam', killteam)
                .then(response => {
                    this.saved = true
                    if (then) {
                        then(response.data)
                    }
                })
        }
    }
}
