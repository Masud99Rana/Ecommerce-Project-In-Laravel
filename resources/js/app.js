/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.axios = require('axios');
window.swal = require('sweetalert');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        cart: [],
        total: 0
    },
    created: function () {
        this.getCart();
    },
    methods: {
        addToCart: function (productId) {
            axios.post('/api/v1/cart', {
                product_id: productId
            })
                .then(function (response) {
                    swal({
                        title: "Success!",
                        text: response.data.message,
                        icon: "success"
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        removeFromCart: function (productId) {
            axios.post('/api/v1/cart/remove', {
                product_id: productId
            })
                .then((response) => {
                    swal({
                        title: "Success!",
                        text: response.data.message,
                        icon: "success"
                    });
                    this.getCart();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getCart: function () {
            axios.get('/api/v1/cart')
                .then((response) => {
                    this.cart = response.data.data.cart;
                    this.total = response.data.data.total;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        clearCart: function () {
            axios.post('/api/v1/cart/clear')
                .then((response) => {
                    swal({
                        title: "Success!",
                        text: response.data.message,
                        icon: "success"
                    });
                    this.getCart();
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
});
