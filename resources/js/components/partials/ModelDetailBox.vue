<template>
  <div class="container-fluid mt-5">
    <div class="row">
      <div class="col-md-3 mb-3">
        <button type="button" class="btn btn-lg fw-bold border-white mb-2 w-100" @click="currentPage('info')" :class="info?'btn-light text-dark':'btn-dark text-white'">Info</button>
        <button type="button" class="btn btn-lg fw-bold border-white mb-2 w-100" @click="currentPage('update')" :class="update?'btn-light text-dark':'btn-dark text-white'">Update</button>
<!--        <button type="button" class="btn btn-primary mb-2 w-100" @click="currentPage('usage')" :class="usage?'btn-dark':'btn-primary'">Usage</button>-->
        <button type="button" class="btn btn-lg fw-bold border-white mb-2 w-100"  @click="currentPage('validate')" :class="validate?'btn-light text-dark':'btn-dark text-white'" v-if="showValidate"> Validate Model</button>
        <button type="button" class="btn btn-lg fw-bold border-white mb-2 w-100" @click="currentPage('fineTune')" :class="fineTune?'btn-light text-dark':'btn-dark text-white'" v-if="showFineTune">Fine Tune</button>
          <router-link :to="`/app/models/${getSelectedModel.id}/test`" class="btn btn-lg fw-bold border-white mb-2 w-100 btn-secondary"><i class="bi-airplane"></i>Test Model</router-link>
      </div>
      <div class="col-md-9">
        <div class="card p-2">
          <model-info v-if="info"></model-info>
          <model-usage v-if="usage"></model-usage>
          <validate-modal-data v-if="validate"></validate-modal-data>
          <model-update v-if="update"></model-update>
          <fine-tune-modal v-if="fineTune"></fine-tune-modal>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import ModelInfo from "@/components/partials/Model/ModelInfo.vue";
import ModelUsage from "@/components/partials/Model/ModalUsage.vue";
import ValidateModalData from "@/components/partials/Model/ValidateModal.vue";
import ModelUpdate from "@/components/partials/Model/UpdateModal.vue";
import FineTuneModal from "@/components/partials/Model/FineTuneModal.vue";

export default {
  name: 'ModelDetailBox',
  components: {FineTuneModal, ModelUpdate, ValidateModalData, ModelUsage, ModelInfo},
  data() {
    return {
      info:true,
      update:false,
      fineTune:false,
      usage:false,
      validate:false,
      showValidate:false,
      showFineTune:false,
    };
  },
  computed: {
    ...mapGetters('model', ['getSelectedModel', 'getDetailPageName']),
  },
  created() {
    this.currentPage(this.getDetailPageName)
      this.showValidate = this.getSelectedModel.model_type === 'fine-tune'
      // this.showFineTune = this.getSelectedModel.model_type === 'fine-tune'
  },
  methods: {
    ...mapActions('model', ['setDetailPageName']),
    formatDate(datetime) {
      return moment(datetime).format('DD-MM-YYYY HH:mm a');
    },
    currentPage(page){
      this.info = false;
      this.update = false;
      this.fineTune = false;
      this.usage = false;
      this.validate = false;
      switch (page){
        case 'update':
          this.update= true;
          break;
        case 'info':
          this.info= true;
          break;
        case 'fineTune':
          this.fineTune= true;
          break;
        case 'usage':
          this.usage= true;
          break;
        case 'validate':
          this.validate= true;
          break;
      }
      this.setDetailPageName(page)
      return true
    }
  },
  beforeUnmount() {
    this.setDetailPageName('info')
  },


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
