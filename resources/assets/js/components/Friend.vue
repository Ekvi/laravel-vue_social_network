<template>

    <div>
        <p class="text-center" v-if="loading">
            Loading...
        </p>
        <p class="text-center" v-if="!loading">
            <button class="btn btn-success" v-if="status == 0" @click="addFriend">Add Friend</button>
            <button class="btn btn-success" v-if="status == 'pending'" @click="acceptFriend">Accept Friend</button>
            <span class="text-success" v-if="status == 'waiting'">Waiting for response</span>
            <span class="text-success" v-if="status == 'friends'">Friends</span>
        </p>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.$http.get('/check-relationship-status/' + this.profileUserId)
                    .then( (resp) => {
                        this.status = resp.body.status;
                        this.loading = false;
                    })
        },
        props: ['profileUserId'],
        data() {
            return {
                status: "",
                loading: true
            }
        },
        methods: {
            addFriend() {
                this.loading = true;
                this.$http.get('/add-friend/' + this.profileUserId)
                        .then((r) => {
                            if(r.body) {
                                this.status = 'waiting';
                                this.loading = false;
                            }
                        })
            },
            acceptFriend() {
                this.loading = true;
                this.$http.get('/accept-friend/' + this.profileUserId)
                        .then((r) => {
                            if(r.body) {
                                this.status = 'friends';
                                this.loading = false;
                            }
                        })
            }
        }
    }
</script>
