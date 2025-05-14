<template>
  <div class="card-body">
    Modal Usage
  </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
  name: 'ModelUsage',
  data() {
    return {

    };
  },
  computed: {
    ...mapGetters('model', ['getSelectedModel']),
  },
  created() {

  },
  methods: {
  },
  beforeUnmount() {

  },


}
</script>

<style scoped>
.lead-uuid {
  color: var(--bs-primary);
  padding: 10px;
  font-size: 12px;
  font-weight: bold;
  font-style: italic;
}
</style>