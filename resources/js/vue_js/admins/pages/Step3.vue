<!-- PATH = resources/js/vue_js/admins/pages/Step3.vue -->

<template>
    <div class="container">
        <h1>Step 3</h1>
        <form @submit.prevent="submitData" class="card-body p-4">
            <div class="form-group mb-2">
                <label for="field3">Field 3</label>
                <input type="text" id="field3" v-model="formData.field3" class="form-control"
                    placeholder="Enter Field 3">
            </div>
            <button type="button" class="btn btn-secondary" @click="prevStep">Back</button>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import { fetchProductData, submitProductData } from '../services/api';

export default {
    name: 'Step3',
    data() {
        return {
            formData: {
                field3: '',
                // Add other fields as needed
            },
        };
    },
    methods: {
        ...mapActions(['prevStep']),
        async loadData() {
            try {
                const response = await fetchProductData(3);
                if (response && response.data) {
                    this.formData.field3 = response.data.field3; // Update formData with fetched data
                } else {
                    console.error('Invalid response or data format:', response);
                }
            } catch (error) {
                console.error('Failed to load data', error);
            }
        },
        async submitData() {
            try {
                await submitProductData(3, this.formData);
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
