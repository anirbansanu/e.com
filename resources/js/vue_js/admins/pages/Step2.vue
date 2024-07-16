<!-- PATH = resources/js/vue_js/admins/pages/Step2.vue -->
<template>
    <div class="container p-2">
        <form @submit.prevent="submitData" class="card">
            <div class="card-header">
                <h2 class="card-title">Step 2</h2>
            </div>
            <div class="card-body">
                <div class="form-group mb-2">
                    <label for="field2">Field 2</label>
                    <input type="text" id="field2" v-model="step2.field2" class="form-control"
                        placeholder="Enter Field 2" autofocus>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-secondary" @click="prevStep">Back</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { mapActions,mapState } from 'vuex';
import { fetchProductData, submitProductData } from '../services/api.js';

export default {
    name: 'Step2',
    data() {
        return {
            step2: {
                field2: '',
            },
        };
    },
    computed: {
        ...mapState(['formData']), // Access formData from Vuex store
    },
    methods: {
        ...mapActions(['nextStep', 'prevStep', 'saveFormData']),
        async loadData() {
            try {
                const response = await fetchProductData(2);
                if (response && response.data) {
                    if(this.formData.step2.field2){
                        this.step2.field2 = this.formData.step2.field2;
                    }
                    else{
                        this.step2.field2 = response.data.field2;
                    } // Update formData with fetched data
                } else {
                    console.error('Invalid response or data format:', response);
                }
            } catch (error) {
                console.error('Failed to load data', error);
            }
        },
        async submitData() {
            try {
                const response = await submitProductData(2, this.step2);
                if (response && response.success) {
                    this.saveFormData({ step: 2, data: this.step2 });
                    this.$store.dispatch('nextStep');
                    this.$router.push({ name: 'step3' });
                } else {
                    console.error('Invalid response or data format:', response);
                }
            } catch (error) {
                console.error('Failed to submit data', error);
            }
        },
        prevStep() {
            this.$store.dispatch('prevStep');
            this.$router.push({ name: 'step1' });
        },
    },
    created() {
        this.loadData();
    },
    mounted() {
        console.log('Step2 component mounted.');
    }
};
</script>
