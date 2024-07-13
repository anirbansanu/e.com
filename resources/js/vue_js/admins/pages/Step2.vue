<!-- PATH = resources/js/vue_js/admins/pages/Step2.vue -->
<template>
    <div class="container">
        <h1>Step 2</h1>
        <form @submit.prevent="submitData" class="card-body p-4">
            <div class="form-group mb-2">
                <label for="field2">Field 2</label>
                <input type="text" id="field2" v-model="formData.field2" class="form-control"
                    placeholder="Enter Field 2">
            </div>
            <button type="button" class="btn btn-secondary" @click="prevStep">Back</button>
            <button type="submit" class="btn btn-primary">Next</button>
        </form>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import { fetchProductData, submitProductData } from '../services/api';

export default {
    name: 'Step2',
    data() {
        return {
            formData: {
                field2: '',
                // Add other fields as needed
            },
        };
    },
    methods: {
        ...mapActions(['nextStep', 'prevStep']),
        async loadData() {
            try {
                const response = await fetchProductData(2);
                if (response && response.data) {
                    this.formData.field2 = response.data.field2; // Update formData with fetched data
                } else {
                    console.error('Invalid response or data format:', response);
                }
            } catch (error) {
                console.error('Failed to load data', error);
            }
        },
        async submitData() {
            try {
                await submitProductData(2, this.formData);
                this.$store.dispatch('nextStep');
                this.$router.push({ name: 'step3' });
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
