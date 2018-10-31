<template>
    <div class="vue-partial-save-buttons my-3 d-flex justify-content-end">

        <button class="btn btn-primary ml-3"
            v-on:click="saveKillteam">
            Save Kill Team
        </button>

        <button class="btn btn-warning ml-3"
            data-toggle="modal" data-target="#clearModal">
            Clear All Models
        </button>

        <button class="btn btn-danger ml-3"
            data-toggle="modal" data-target="#deleteModal">
            Delete Kill Team
        </button>

        <div class="modal fade"
            v-for="modal, modalName in modals" :id="modalName"
            role="dialog" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ modal.title }}</h5>
                        <button type="button" class="close"
                            data-dismiss="modal" aria-label="Cancel">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ modal.description }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary"
                            data-dismiss="modal"
                            v-on:click="modal.onOk">
                            {{ modal.okMessage}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import KillteamResource from '../../mixins/KillteamResource.js'
import KillteamsResource from '../../mixins/KillteamsResource.js'
export default {
    mixins: [
        KillteamResource,
        KillteamsResource,
    ],
    data() {
        return {
            latestKillteamId: null,
            modals: {
                clearModal: {
                    title: 'Clear All Members?',
                    description: 'This will remove all members from your kill team.',
                    okMessage: 'Clear all kill team members',
                    onOk: this.clearKillTeam,
                },
                deleteModal: {
                    title: 'Delete Kill Team?',
                    description: 'This will completely delete your kill team.',
                    okMessage: 'Delete kill team',
                    onOk: this.deleteKillTeam,
                }
            }
        }
    },
    methods: {
        saveKillteam() {
            this.ajaxSaveKillteam(this.killteam, this.refetchKillteams)
        },
        clearKillTeam() {
            this.$store.dispatch('clearKillTeam')
        },
        deleteKillTeam() {
            this.ajaxDeleteKillteam(this.killteam, this.exit)
        },
        refetchKillteams(killteamId) {
            this.latestKillteamId = killteamId
            this.ajaxFetchKillteams(this.reloadKillteams)
        },
        reloadKillteams() {
            const killteam = _.find(this.killteams, { id: this.latestKillteamId })
            this.$store.dispatch('loadKillteam', killteam)
        },
        exit() {
            this.$router.push({ name: 'intro'})
        }
    }
}
</script>
