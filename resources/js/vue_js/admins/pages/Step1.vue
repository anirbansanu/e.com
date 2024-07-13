<!-- PATH = resources/js/vue_js/admins/pages/Step1.vue -->
<template>
    <div class="container p-2">

        <form @submit.prevent="submitData" class="card">
            <div class="card-header">
                <h2 class="card-title">Step 1</h2>
            </div>
            <div class="card-body">
                <div class="form-group mb-2">
                    <label for="field1">Field 1</label>
                    <input type="text" id="field1" v-model="formData.field1" class="form-control"
                        placeholder="Enter Field 1">
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>

            </div>
        </form>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import { fetchProductData, submitProductData } from '../services/api';

export default {
    name: 'Step1',
    data() {
        return {
            formData: {
                field1: '', // Initialize fields with default values
            },
        };
    },
    methods: {
        ...mapActions(['nextStep']),
        async loadData() {
            try {
                const response = await fetchProductData(1);
                if (response && response.data) {
                    this.formData.field1 = response.data.field1; // Update formData with fetched data
                } else {
                    console.error('Invalid response or data format:', response);
                }
            } catch (error) {
                console.error('Failed to load data', error);
            }
        },
        async submitData() {
            try {
                await submitProductData(1, this.formData);
                this.$store.dispatch('nextStep');
                this.$router.push({ name: 'step2' });
            } catch (error) {
                console.error('Failed to submit data', error);
            }
        },
    },
    created() {
        this.loadData(); // Load data when component is created
    },
    mounted() {
        console.log('Step1 component mounted.');
    }
};
</script>

<style scoped>
/* Add scoped styles if necessary */
</style>
