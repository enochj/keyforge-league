<template>
  <div>
    <button class="btn btn-primary" @click="addButton()" style="margin-bottom:1rem">Add Decks</button>
    <div class="alert alert-success" v-if="saved">
      <strong>Success!</strong> My deck has been added.
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
                        <legend class="text-center">Add a Deck</legend>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" @click="closeModal()">&times;</span>
                        </button>
                      </div>
                    </fieldset>

                    <div class="form-group">
                      <label class="col-md-3 control-label" for="name">Name</label>
                      <div class="col-md-9" :class="{'has-error': errors.name}">
                        <select id="name"
                             type="text"
                             v-focus
                             v-model="deck"
                             v-on:change="onChange"
                             class="form-control">
                         <option disabled value="">Select...</option>
                         <option v-for="(deck, name) in my_decks" :value="deck">{{deck.name}}</option>
                        </select>
                        <span v-if="errors.name" class="help-block text-danger">{{ errors.name[0] }}</span>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                      <button :disabled="!deck.name" type="button" class="btn btn-primary" id="create-button" @click="addDeck()">Add</button>
                    </div>
                  </form>
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
      props: ['my_decks', 'league'],

      data() {
          return {
              saved: false,
              showModal: false,
              adding: false,
              errors: [],
              deck: "",
              decks: []
          };
      },

      methods: {
        addButton() {
          this.showModal = true;
          this.saved = false;
        },

        addDeck() {
          axios.put(this.league.id, this.deck)
            .then(({data}) => {
              this.$emit('added', JSON.stringify(this.deck));
              this.setSuccessMessage();
            })
            .catch(({response}) => this.setErrors(response));
        },

        onChange() {
          console.log(this.deck);
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
          this.deck = "";
        },
      }
    }
</script>