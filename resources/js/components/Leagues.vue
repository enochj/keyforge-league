<template>
    <div>
        <div class="alert alert-warning" v-if="alert.length > 0">
            {{alert}}
        </div>
        <div class="panel panel-default" v-for="league in leagues">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <button class="btn btn-secondary" @click="navLeague(league.id)">{{league.name }}</button> | <a href="javascript:void(0);" id="remove" @click="removeLeague(league.id)">Remove</a>
                </div>
            </div>
            <div class="panel-footer">
            </div>
        </div>
        <!--paginate
                :page-count="pageCount"
                :click-handler="fetch"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'">
        </paginate-->
        <league-form v-on:added="added" ></league-form>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                alert: 'Loading',
                leagues: [],
                pageCount: 1,
                endpoint: 'leagues',
            };
        },

        watch: {
            leagues: function (val, oldval) {
                if (val.length == 0) {
                    this.alert = "I have no leagues. The 'Create' or 'Join' buttons will begin the process";
                } else {
                    this.alert = '';
                }
            },
        },

        created() {
            this.fetch();
        },


        methods: {
            fetch(page = 1) {
                axios.get(this.endpoint +'?page='+ page)
                    .then(({data}) => {
                        this.leagues = data;
                        //this.pageCount = data.meta.last_page;
                    });
            },

            added() {
                this.saved = true;
                this.fetch();
            },

            removeLeague(id) {
                if(confirm('Are you sure you want to remove this league?')) {
                    axios.delete(this.endpoint+'/'+id)
                        .then(({data}) => {
                            if (data) {
                                this.saved = false;
                                this.leagues = _.remove(this.leagues, function (league) {
                                    return league.id !== id;
                                });
                            }
                        });
                }
            },

            navLeague(id) {
                window.location.href = '/leagues/'+id;
            }
        }
    }
</script>