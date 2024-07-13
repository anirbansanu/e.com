// PATH = resources/js/vue_js/services/api.js
import axios from 'axios';

const api = axios.create({
    baseURL: '/api', // adjust the base URL as needed
    headers: {
        'Content-Type': 'application/json',
    },
});

// export const fetchProductData = (step) => {
//     return step;
//     return api.get(`/product/step${step}`);
// };

// export const submitProductData = (step, data) => {
//     return api.post(`/product/step${step}`, data);
// };
const sampleData = {
    field1: 'Sample Field 1 Data',
    field2: 'Sample Field 2 Data',
    field3: 'Sample Field 3 Data',
};

export const fetchProductData = (step) => {
    // Simulate fetching data asynchronously
    return new Promise((resolve, reject) => {
        // Simulate API call delay
        setTimeout(() => {
            resolve({ data: sampleData }); // Return sample data
        }, 1000); // Simulate 1 second delay (adjust as needed)
    });
};

export const submitProductData = (step, data) => {
    // Simulate submitting data asynchronously
    return new Promise((resolve, reject) => {
        // Simulate API call delay
        setTimeout(() => {
            resolve({ success: true }); // Simulate successful submission
            // In a real scenario, you would handle errors and response based on API behavior
        }, 1000); // Simulate 1 second delay (adjust as needed)
    });
};
export default api;
