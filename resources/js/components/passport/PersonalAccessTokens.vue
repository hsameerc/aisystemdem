<style scoped>
.action-link {
  cursor: pointer;
}
</style>

<template>
  <div class="mb-30">
    <div>
      <div class="card card-default">
        <div class="card-header">
          <div class="w100">
            <div class="card-title">
              <span class="mt-10 d-inline-block">Personal Access Token</span>
              <div class="d-inline float-right">
                <a class="btn btn-primary text-right action-link" tabindex="-1"
                   @click="showCreateTokenForm">
                  Create New Token
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <!-- No Tokens Notice -->
          <p class="mb-0 fs14" v-if="tokens.length === 0">
            You have not created any personal access tokens.
          </p>
          <div class="table-responsive">
            <!-- Personal Access Tokens -->
            <table class="table table-md mb-0" v-if="tokens.length > 0">
              <thead class="bg-light">
              <tr class="text-uppercase  text-primary">
                <th>Name</th>
                <th></th>
              </tr>
              </thead>

              <tbody>
              <tr v-for="token in tokens">
                <!-- Client Name -->
                <td style="vertical-align: middle;">
                  {{ token.name }}
                </td>

                <!-- Delete Button -->
                <td class="text-right">
                  <a class="action-link text-danger" @click="revoke(token)">
                    <i class="icon-trash"></i>
                  </a>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Create Token Modal -->
    <div class="modal fade" id="modal-create-token" tabindex="-1" data-bs-backdrop="false" data-bs-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content rounded">
          <div class="modal-header bg-light-active">
            <h4 class="modal-title">
              Create Token
            </h4>

            <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true"><i
                class="text-light fs-2x icon icon-cross-circle"></i></button>
          </div>

          <div class="modal-body">
            <!-- Form Errors -->
            <div class="alert alert-danger" v-if="form.errors.length > 0">
              <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
              <br>
              <ul>
                <li v-for="error in form.errors">
                  {{ error }}
                </li>
              </ul>
            </div>

            <!-- Create Token Form -->
            <form role="form" @submit.prevent="store">
              <!-- Name -->
              <div class="form-group row">
                <label class="col-md-4 col-form-label fs14">Name</label>

                <div class="col-md-8">
                  <input id="create-token-name" type="text" class="form-control" name="name"
                         v-model="form.name">
                </div>
              </div>

              <!-- Scopes -->
              <div class="form-group row" v-if="scopes.length > 0">
                <label class="col-md-4 col-form-label">Scopes</label>

                <div class="col-md-6">
                  <div v-for="scope in scopes">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox"
                               @click="toggleScope(scope.id)"
                               :checked="scopeIsAssigned(scope.id)">

                        {{ scope.id }}
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal Actions -->
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>

            <button type="button" class="btn btn-primary" @click="store">
              Create
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Access Token Modal -->
    <div class="modal fade" id="modal-access-token" tabindex="-1" data-bs-backdrop="false" data-bs-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content rounded">
          <div class="modal-header bg-light-active">
            <h4 class="modal-title">
              Personal Access Token
            </h4>

            <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
          </div>

          <div class="modal-body">
            <p class="fs14">
              Here is your new personal access token. This is the only time it will be shown so don't lose
              it!
              You may now use this token to make API requests.
            </p>

            <textarea class="form-control" rows="10">{{ accessToken }}</textarea>
          </div>

          <!-- Modal Actions -->
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  /*
   * The component's data.
   */
  data() {
    return {
      accessToken: null,

      tokens: [],
      scopes: [],

      form: {
        name: '',
        scopes: [],
        errors: []
      }
    };
  },

  /**
   * Prepare the component (Vue 1.x).
   */
  ready() {
    this.prepareComponent();
  },

  /**
   * Prepare the component (Vue 2.x).
   */
  mounted() {
    this.prepareComponent();
  },

  methods: {
    /**
     * Prepare the component.
     */
    prepareComponent() {
      this.getTokens();
      this.getScopes();

      // $('#modal-create-token').on('shown.bs.modal', () => {
      //   $('#create-token-name').focus();
      // });
    },

    /**
     * Get all of the personal access tokens for the user.
     */
    getTokens() {
      axios.get('/oauth/personal-access-tokens')
          .then(response => {
            this.tokens = response.data;
          });
    },

    /**
     * Get all of the available scopes.
     */
    getScopes() {
      axios.get('/oauth/scopes')
          .then(response => {
            this.scopes = response.data;
          });
    },

    /**
     * Show the form for creating new tokens.
     */
    showCreateTokenForm() {
      // $('#modal-create-token').modal('show');
    },

    /**
     * Create a new personal access token.
     */
    store() {
      this.accessToken = null;

      this.form.errors = [];

      axios.post('/oauth/personal-access-tokens', this.form)
          .then(response => {
            this.form.name = '';
            this.form.scopes = [];
            this.form.errors = [];

            this.tokens.push(response.data.token);

            this.showAccessToken(response.data.accessToken);
          })
          .catch(error => {
            if (typeof error.response.data === 'object') {
              this.form.errors = _.flatten(_.toArray(error.response.data.errors));
            } else {
              this.form.errors = ['Something went wrong. Please try again.'];
            }
          });
    },

    /**
     * Toggle the given scope in the list of assigned scopes.
     */
    toggleScope(scope) {
      if (this.scopeIsAssigned(scope)) {
        this.form.scopes = _.reject(this.form.scopes, s => s == scope);
      } else {
        this.form.scopes.push(scope);
      }
    },

    /**
     * Determine if the given scope has been assigned to the token.
     */
    scopeIsAssigned(scope) {
      return _.indexOf(this.form.scopes, scope) >= 0;
    },

    /**
     * Show the given access token to the user.
     */
    showAccessToken(accessToken) {
      // $('#modal-create-token').modal('hide');

      this.accessToken = accessToken;

      // $('#modal-access-token').modal('show');
    },

    /**
     * Revoke the given token.
     */
    revoke(token) {
      axios.delete('/oauth/personal-access-tokens/' + token.id)
          .then(response => {
            this.getTokens();
          });
    }
  }
}
</script>
