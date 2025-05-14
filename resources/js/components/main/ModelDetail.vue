<template>
  <main class="col-lg-8 offset-lg-2 mt-4 mb-4">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <router-link to="/app/models" class="navbar-brand">Models</router-link>
      </div>
    </nav>
    <model-detail-box></model-detail-box>
    <support-data-list :model_uuid="model_id"></support-data-list>
  </main>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import ModelDetailBox from "@/components/partials/ModelDetailBox.vue";
import SupportDataList from "@/components/partials/SupportData.vue";

export default {
  name: 'ModelDetail',
  components: {SupportDataList, ModelDetailBox},
  data() {
    return {
      model_id: null
    };
  },
  computed: {
    ...mapGetters('model', ['getSelectedModel']),
  },
  created() {
    this.model_id = this.$route.params.uuid;
    this.fetchModalDetail()
    this.fetchSupportData()
  },
  methods: {
    ...mapActions('model', ['httpGetModelDetail', 'unsetSelectedModel']),
    ...mapActions('supportdata', ['httpGetSupportData',]),
    async fetchModalDetail() {
      try {
        await this.httpGetModelDetail(this.model_id)
      } catch (error) {
        this.$router.push('/404')
      }
    },
    fetchSupportData() {
      try {
        this.httpGetSupportData({uuid: this.model_id, props: ''})
      } catch (error) {
        this.$router.push('/404')
      }
    },
    formatDate(datetime) {
      return moment(datetime).format('DD-MM-YYYY HH:mm a');
    }
  },
  beforeUnmount() {
    this.unsetSelectedModel()
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.lead-uuid {
  color: var(--bs-primary);
  padding: 10px;
  font-size: 12px;
  font-weight: bold;
  font-style: italic;
}
</style>
