<template>
  <div>
    <button class="btn btn-primary" @click="addButton()" style="margin-bottom:1rem">Add</button>
    <button class="btn btn-primary" @click="joinButton()" style="margin-bottom:1rem">Join</button>
    <div class="alert alert-success" v-if="saved">
      <strong>Success!</strong> My league has been added.
    </div>

    <div v-if="showModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="well well-sm" id="league-form">
                  <form class="form-horizontal" method="post" v-on:keyup.enter="console.log('heybud')">
                    <fieldset>
                      <div class="modal-header">
                        <legend v-if="adding" class="text-center">Add a League</legend>
                        <legend v-if="joining" class="text-center">Join a League</legend>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" @click="closeModal()">&times;</span>
                        </button>
                      </div>
                    </fieldset>
                  </form>

                      <div class="form-group">
                        <label class="col-md-3 control-label" for="name">Name</label>
                        <div class="col-md-9" :class="{'has-error': errors.name}">
                          <input id="name"
                               v-model="league.name"
                               type="text"
                               v-focus
                               v-on:keyup.enter="findLeague(league.name)"
                               placeholder="League name"
                               class="form-control">
                          <span v-if="errors.name" class="help-block text-danger">{{ errors.name[0] }}</span>
                        </div>
                      </div>
                      <div v-if="searching" class="form-group col-md-9">
                        Searching...
                      </div>
                      <div v-else>
                        <div class="form-group col-md-9"
                          v-for="(league, index) in foundLeagues"
                          :key="league.id">
                          <button v-if="index != 5" class ="btn" @click="joinLeague(league.id)">{{league.name}}</button>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                        <button v-if="joining" :disabled="!league.name" type="button" class="btn btn-primary" id="find-button" @click="findLeague(league.name)">Find League</button>
                        <button v-if="adding" :disabled="!league.name" type="button" class="btn btn-primary" id="create-button" @click="createLeague(league.name)">Add</button>
                      </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
  export default {

    data() {
      return {
        saved: false,
        errors: [],
        league: {
          name: null,
        },
        showModal: false,
        foundLeagues: [],
        searching: false,
        exceeded: false,
        adding: false,
        joining: false
      };
    },

    methods: {
      addButton() {
        this.adding = true;
        this.showModal = true;
        this.saved = false;
      },

      joinButton() {
        this.joining = true;
        this.showModal = true;
        this.saved = false;
      },

      joinLeague(id){
        axios.post('leagues/join-league', {'id': id})
          .then(({data}) => {
            this.setSuccessMessage();
            this.$emit('added');
          })
          .catch(({response}) => this.setErrors(response));
      },

      createLeague(league) {
        axios.post('leagues', {'name': league})
          .then(({data}) => {
            this.setSuccessMessage();
            this.$emit('added');
          })
          .catch(({response}) => this.setErrors(response));
      },

      onSubmit() {
        this.findLeague(league.target.name.value);
        return false;
      },

      setErrors(response) {
        this.errors = response.data.errors;
      },

      setSuccessMessage() {
        this.reset();
        this.saved = true;
        this.showModal = false;
      },

      closeModal() {
        this.showModal = false;
        this.reset();
      },

      reset() {
        this.errors = [];
        this.foundLeagues = [];
        this.league = {name: null};
        this.adding = false;
        this.joining = false;
      },

      findLeague($leagueName) {
        if ($leagueName == null || $leagueName.trim().length == 0) {
          return false;
        }
        if(document.getElementById("create-button")){
          return this.createLeague($leagueName);
        }
        this.searching = true;
        this.errors = [];
        axios.get('leagues/find-leagues?name='+$leagueName).then(({data}) => {
          this.searching = false;
          this.foundLeagues = data;
          if (this.foundLeagues.length == 6) {
            this.errors = {
              'name' : ['The number of results is more than the number displayed.'],
              'id' : ['The number of results is more than the number displayed.']
            };
          } else if (this.foundLeagues.length == 0) {
            this.errors = {
              'name' : ['No results were found.'],
              'id' : ['No results were found.']
            };
          }
        });
      }
    }
  }
</script>