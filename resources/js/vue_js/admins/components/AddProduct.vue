<template>
    <div class="content-wrapper pt-3">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form @submit.prevent="submitForm">
                            <input v-if="product.id" type="hidden" class="d-none" v-model="form.product_id" name="product_id" />
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <div class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <a href="#" class="nav-item nav-link" v-for="(tab, index) in tabs" :key="index" :href="tab.route">
                                            <i :class="tab.icon"></i> {{ tab.name }}
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body mt-4">
                                    <ul class="nav nav-tabs" id="tablist" role="tablist">
                                        <li class="nav-item" v-for="(step, index) in steps" :key="index">
                                            <a class="nav-link" :class="{ active: currentStep === step.number }" :href="step.route">
                                                {{ step.name }}
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-sm-2 p-lg-3 border-right border-left border-bottom" id="tabListContent">
                                        <div class="tab-pane fade active show" id="product-details" role="tabpanel" aria-labelledby="product-details-tab">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" v-model="form.name" id="name" placeholder="Enter name">
                                                <span class="error text-danger" v-if="errors.name">{{ errors.name }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea v-model="form.description" class="form-control" id="description"></textarea>
                                                <span class="error text-danger" v-if="errors.description">{{ errors.description }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select class="form-control" v-model="form.category_id" id="category">
                                                    <option value="">Select Category</option>
                                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                                        {{ category.name }}
                                                    </option>
                                                </select>
                                                <span class="error text-danger" v-if="errors.category_id">{{ errors.category_id }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="brand">Brand</label>
                                                <select class="form-control" v-model="form.brand_id" id="brand">
                                                    <option value="">Select Brand</option>
                                                    <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                                        {{ brand.name }}
                                                    </option>
                                                </select>
                                                <span class="error text-danger" v-if="errors.brand_id">{{ errors.brand_id }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="gender">Gender</label>
                                                <select class="form-control" v-model="form.gender" id="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="female">Female</option>
                                                    <option value="male">Male</option>
                                                </select>
                                                <span class="error text-danger" v-if="errors.gender">{{ errors.gender }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="feature">Feature</label>
                                                <input type="text" class="form-control" v-model="form.feature" id="feature">
                                                <span class="error text-danger" v-if="errors.feature">{{ errors.feature }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="is_active">Status</label><br>
                                                <input type="checkbox" v-model="form.is_active" id="is_active">
                                                <span class="error text-danger" v-if="errors.is_active">{{ errors.is_active }}</span>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Save & Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: '',
                description: '',
                category_id: '',
                brand_id: '',
                gender: '',
                feature: '',
                is_active: false,
                product_id: ''
            },
            errors: {},
            categories: [],
            brands: [],
            tabs: [
                { route: '/products', icon: 'fas fa-list-alt', name: 'Product List' },
                { route: '/products/create', icon: 'fas fa-plus-square', name: 'Add Product' },
                { route: '/products/trash', icon: 'fas fa-trash', name: 'Trash List' }
            ],
            steps: [
                { number: 1, route: '/products/create?step=1', name: 'Product Details' },
                { number: 2, route: '/products/create?step=2', name: 'Variants' },
                { number: 3, route: '/products/create?step=3', name: 'Stock' }
            ],
            currentStep: 1,
            product: {}
        }
    },
    mounted() {
        this.loadCategories();
        this.loadBrands();
        // Load the product if it exists
        if (this.product.id) {
            this.form = { ...this.product };
        }
    },
    methods: {
        loadCategories() {
            axios.post('/categories.json')
                .then(response => {
                    this.categories = response.data.data;
                });
        },
        loadBrands() {
            axios.post('/brands.json')
                .then(response => {
                    this.brands = response.data.data;
                });
        },
        submitForm() {
            axios.post('/products/store/stepOne', this.form)
                .then(response => {
                    // Handle success
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        }
    }
}
</script>

<style scoped>


.error {
    color: red;
}
</style>
