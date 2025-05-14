<template>
    <main class="col-lg-8 offset-lg-2 mt-4">
        <div class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <h3 class="navbar-brand">Add Tokens</h3>
            </div>
        </div>
        <div class="card text-start">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
                        <div class="mb-3">
                            <label class="form-label d-block">Quantity: </label>
                            <template v-for="option in quantityOptions" :key="option.value">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" v-model="selectedQuantity"
                                           :value="option.value"
                                           :id="'flexRadioDefault'+ option.value">
                                    <label class="form-check-label"
                                           :for="'flexRadioDefault'+ option.value">{{ option.label }}</label>
                                </div>
                            </template>
                            <div v-if="selectedQuantity === 'custom'" class="mt-3">
                                <label class="form-label">Custom Quantity:</label>
                                <input type="number" class="form-control" v-model="customQuantity" min="1"
                                       :disabled="!isCustomQuantityValid">
                            </div>
                        </div>

                        <button class="btn btn-primary" @click="processTokenAdd">Proceed to Add</button>

                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: 'ManageToken',
    data() {
        return {
            quantityOptions: [
                {label: '1000', value: 1000, price: 0},
                {label: '5000', value: 5000, price: 0},
                {label: '10000', value: 10000, price: 0},
                {label: '15000', value: 15000, price: 0},
                {label: '25000', value: 25000, price: 0},
                {label: '50000', value: 50000, price: 0},
                {label: 'Custom', value: 'custom'},
            ],
            selectedQuantity: 10000,
            customQuantity: 80000,
            price: 0,
            selectedPaymentType: 'stripe',
        };
    },
    computed: {
        isCustomQuantityValid() {
            return this.customQuantity > 50000;
        },
    },
    created() {
    },
    methods: {
        processTokenAdd() {
            // Implement your payment processing logic here
            console.log('Token Add processed!');
        },
    },

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
