<style scoped>

</style>

<template>
    <div>
        <div class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <router-link to="/app/models" class="navbar-brand">Clients</router-link>
                <button class="btn btn-lg btn-light fw-bold border-white" @click="showAddClient()"><i
                    class="bi-plus"></i>
                    Add Client
                </button>
            </div>
        </div>

        <div class="card card-default mb-30">
            <div class="card-body">
                <!-- Current Clients -->
                <p class="mb-0 fs14" v-if="clients.length === 0">
                    You have not created any OAuth clients.
                </p>
                <div class="table-responsive">
                    <table class="table table-md" v-if="clients.length > 0">
                        <thead class="bg-light">
                        <tr class="text-uppercase text-primary">
                            <th>#</th>
                            <th>Name</th>
                            <th>Client ID</th>
                            <th>Secret</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="client in clients">
                            <!-- ID -->
                            <td class="fs14">
                                #
                            </td>

                            <!-- Name -->
                            <td class="fs14">
                                {{ client.name }}
                            </td>
                            <!-- ID -->
                            <td class="fs14">
                                {{ client.id }}
                            </td>

                            <!-- Secret -->
                            <td class="fs14">
                                <code class="text-info bg-light">{{ client.secret ? client.secret : '-' }}</code>
                            </td>

                            <!-- Edit Button -->
                            <td class="text-right">
                                <a class="action-link text-primary" tabindex="-1" @click="edit(client)">
                                    <i class="bi-pencil"></i>
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td class="text-right">
                                <a class="action-link text-danger" @click="destroy(client)">
                                    <i class="bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create Client Modal -->
        <div v-if="openModalCreateClient" class="modal" id="modal-create-client" tabindex="-1"
             aria-labelledby="CreateClientStaticBackdropLabel" aria-hidden="true"
             :style="{ display: openModalCreateClient ? 'block' : 'none' }">
            <div class="modal-dialog">
                <div class="modal-content rounded">
                    <div class="modal-header bg-light-active">
                        <h4 class="modal-title" id="CreateClientStaticBackdropLabel">
                            Create Client
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Client Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label fs14">Name</label>
                                <div class="col-md-9">
                                    <input id="create-client-name" type="text" class="form-control"
                                           @keyup.enter="store" v-model="createForm.name">

                                    <span class="form-text text-muted fs14">
                                        Something your users will recognize and trust.
                                    </span>
                                </div>
                            </div>

                            <!-- Redirect URL -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label fs14">Redirect URL</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="redirect"
                                           @keyup.enter="store" v-model="createForm.redirect">

                                    <span class="form-text text-muted fs14">
                                        Your application's authorization callback URL.
                                    </span>
                                </div>
                            </div>

                            <!-- Confidential -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label fs14">Confidential</label>

                                <div class="col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="createForm.confidential">
                                        </label>
                                    </div>

                                    <span class="form-text text-muted fs14">
                                        Require the client to authenticate with a secret. Confidential clients can hold credentials in a secure way without exposing them to unauthorized parties. Public applications, such as native desktop or JavaScript SPA applications, are unable to hold secrets securely.
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" @click="openModalCreateClient = false">Close
                        </button>

                        <button type="button" class="btn btn-primary" @click="store">
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Client Modal -->
        <div v-if="openModalEditClient" class="modal" id="modal-edit-client" tabindex="-2"
             :style="{ display: openModalEditClient ? 'block' : 'none' }">
            <div class="modal-dialog">
                <div class="modal-content rounded">
                    <div class="modal-header  bg-light-active">
                        <h4 class="modal-title">
                            Edit Client
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p class="mb-0"><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Client Form -->
                        <form role="form">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label fs14">Name</label>

                                <div class="col-md-9">
                                    <input id="edit-client-name" type="text" class="form-control"
                                           @keyup.enter="update" v-model="editForm.name">

                                    <span class="form-text text-muted fs14">
                                        Something your users will recognize and trust.
                                    </span>
                                </div>
                            </div>

                            <!-- Redirect URL -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label fs14">Redirect URL</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="redirect"
                                           @keyup.enter="update" v-model="editForm.redirect">

                                    <span class="form-text text-muted fs14">
                                        Your application's authorization callback URL.
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" @click="openModalEditClient = false">Close</button>

                        <button type="button" class="btn btn-primary" @click="update">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Client Secret Modal -->
        <div class="modal fade" v-if="openModalClientSecret" id="modal-client-secret" tabindex="-3"
             data-bs-backdrop="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Client Secret
                        </h4>

                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <p class="fs14">
                            Here is your new client secret. This is the only time it will be shown so don't lose it!
                            You may now use this secret to make API requests.
                        </p>

                        <input type="text" class="form-control" v-model="clientSecret">
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            clients: [],

            clientSecret: null,

            createForm: {
                errors: [],
                name: '',
                redirect: '',
                confidential: true
            },

            editForm: {
                errors: [],
                name: '',
                redirect: ''
            },

            openModalCreateClient: false,
            openModalEditClient: false,
            openModalClientSecret: false,
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
        showAddClient() {
            this.openModalCreateClient = true
        },
        showListClient() {
            this.listClient = true
            this.addClient = false
        },
        /**
         * Prepare the component.
         */
        prepareComponent() {
            this.getClients();

            // $('#modal-create-client').on('shown.bs.modal', () => {
            //   $('#create-client-name').focus();
            // });
            //
            // $('#modal-edit-client').on('shown.bs.modal', () => {
            //   $('#edit-client-name').focus();
            // });
        },

        /**
         * Get all of the OAuth clients for the user.
         */
        getClients() {
            axios.get('/oauth/clients')
                .then(response => {
                    this.clients = response.data;
                });
        },

        /**
         * Show the form for creating new clients.
         */
        showCreateClientForm() {
            console.log('SHOW')
            this.openModalCreateClient = true;
            console.log(this.openModalCreateClient)
            // $('#modal-create-client').modal('show');
        },

        /**
         * Create a new OAuth client for the user.
         */
        store() {
            this.persistClient(
                'post',
                '/oauth/clients',
                this.createForm,
            );
            this.openModalCreateClient = false
        },

        /**
         * Edit the given client.
         */
        edit(client) {
            console.log(client)
            this.editForm.id = client.id;
            this.editForm.name = client.name;
            this.editForm.redirect = client.redirect;
            this.openModalEditClient = true
        },

        /**
         * Update the client being edited.
         */
        update() {
            this.persistClient(
                'put',
                '/oauth/clients/' + this.editForm.id,
                this.editForm
            );
            this.openModalEditClient = false
        },

        /**
         * Persist the client to storage using the given form.
         */
        persistClient(method, uri, form) {
            form.errors = [];

            axios[method](uri, form)
                .then(response => {
                    this.getClients();

                    form.name = '';
                    form.redirect = '';
                    form.errors = [];

                    $(modal).modal('hide');

                    if (response.data.plainSecret) {
                        this.showClientSecret(response.data.plainSecret);
                    }
                })
                .catch(error => {
                    if (typeof error.response.data === 'object') {
                        form.errors = _.flatten(_.toArray(error.response.data.errors));
                    } else {
                        form.errors = ['Something went wrong. Please try again.'];
                    }
                });
        },

        /**
         * Show the given client secret to the user.
         */
        showClientSecret(clientSecret) {
            this.clientSecret = clientSecret;

            // $('#modal-client-secret').modal('show');
        },

        /**
         * Destroy the given client.
         */
        destroy(client) {
            axios.delete('/oauth/clients/' + client.id)
                .then(response => {
                    this.getClients();
                });
        }
    }
}
</script>
