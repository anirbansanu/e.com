<!-- PATH = resources/js/vue_js/admins/pages/Step3.vue -->

<template>
    <div class="container p-2">

        <form @submit.prevent="submitData" class="card">
            <div class="card-header">
                <h2 class="card-title">Step 3</h2>
            </div>
            <div class="card-body">
                <div class="form-group mb-2">
                    <label for="field3">Field 3</label>
                    <input type="text" id="field3" v-model="step3.field3" class="form-control"
                        placeholder="Enter Field 3" autofocus>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-secondary" @click="prevStep">Back</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { mapActions,mapState } from 'vuex';
import { fetchProductData, submitProductData } from '../services/api';

export default {
    name: 'Step3',
    data() {
        return {
            step3: {
                field3: '',
            },
        };
    },
    computed: {
        ...mapState(['formData']), // Access formData from Vuex store
    },
    methods: {
        ...mapActions(['prevStep','saveFormData']),
        async loadData() {
            try {
                const response = await fetchProductData(3);
                if (response && response.data) {
                    if(this.formData.step3.field3){
                        this.step3.field3 = this.formData.step3.field3;
                    }
                    else{
                        this.step3.field3 = response.data.field3;
                    }// Update step3 with fetched data
                } else {
                    console.error('Invalid response or data format:', response);
                }
            } catch (error) {
                console.error('Failed to load data', error);
            }
        },
        async submitData() {
            try {
                const response = await submitProductData(3, this.step3);
                if (response && response.success) {
                    this.saveFormData({ step: 3, data: this.step3 });
                    this.$router.push({ name: 'step3' });
                } else {
                    console.error('Invalid response or data format:', response);
                }
                console.log('Form submitted');
                // Add any additional actions on form submission
            } catch (error) {
                console.error('Failed to submit data', error);
            }
        },
        prevStep() {
            this.$store.dispatch('prevStep');
            this.$router.push({ name: 'step2' });
        },
    },
    created() {
        this.loadData();
    },
    mounted() {
        console.log('Step3 component mounted.');
    }
};
</script>
