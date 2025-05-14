<template>
  <div class="container-fluid mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow-lg text-start">
          <div class="card-header bg-white text-dark p-3 fs-5 fw-bold">
            Add New Modal
          </div>
          <div class="card-body">
            <div class="alert p-2" v-if="message || error" :class="message?'alert-success':'alert-danger'">
              <i class="bi-check-circle"></i> {{ message || error }}
            </div>
            <form @submit.prevent="saveModel">
              <div class="mb-3">
                <label for="modelName" class="form-label">Model Name</label>
                <input type="text" id="modelName" class="form-control" v-model="modelName" required/>
              </div>
              <div class="mb-3">
                <label for="modelDescription" class="form-label">Model Description</label>
                <textarea id="modelDescription" class="form-control" v-model="modelDescription" required></textarea>
              </div>
              <div class="btn-group">
                <button type="submit" class="btn btn-lg btn-light fw-bold border-white bg-secondary text-white">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import {mapActions, mapGetters} from "vuex";

export default {
  name: 'AddModels',
  data() {
    return {
      modelName: '',
      modelDescription: '',
      message: false,
      error: false,
    };
  },
  computed: {
    ...mapGetters('model', ['getCreate']),
  },
  methods: {
    ...mapActions('model', ['httpCreateModel']),
    async saveModel() {
      if (this.modelName.trim() === '' || this.modelDescription.trim() === '') {
        alert('Please fill in both Model Name and Model Description.');
        return;
      }
      const newModel = {
        name: this.modelName,
        description: this.modelDescription,
      };
      await this.httpCreateModel(newModel)
      const createResponse = this.getCreate
      if (createResponse.status) {
        this.message = createResponse.message
      } else {
        this.error = createResponse.message
      }
      this.modelName = '';
      this.modelDescription = '';
    },
  },

}
</script>

<style scoped>

</style>
